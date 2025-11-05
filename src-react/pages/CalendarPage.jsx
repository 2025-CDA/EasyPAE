import React, { useState, useEffect, useCallback } from 'react';
import CalendarDouble from '../components/calendar/CalendarDouble'
import CalendarSimplePUT from '../components/calendar/CalendarSimplePUT'
import MainLayout from '../components/layout/MainLayout'
import useAxios from '../hooks/useAxios';

function CalendarPage() {
    const { fetchData } = useAxios();

    const [formations, setFormation] = useState([]);
    const [trainingNames, setTrainingNames] = useState([]);
    const [multiCalendar, setMultiCalendar] = useState([]);

    // Fonction pour charger les données (sessions, trainings, pourcentages)
    const getData = useCallback(async () => {
        const resSessions = await fetchData("GET", "organization/sessions");
        const resTrainings = await fetchData("GET", "organization/training-names");

        const sessions = resSessions?.data?.member || [];
        const trainings = resTrainings?.data?.member || [];

        setFormation(sessions);
        setTrainingNames(trainings);

        // Pour chaque session, on va chercher le pourcentage individuellement
        const calendarData = await Promise.all(
            sessions.map(async (session) => {
                // Cherche le nom de la formation correspondant à l'id de la session
                const training = trainings.find(t => t.trainingId === session.trainingId);

                // Appel API pour récupérer le pourcentage de validation
                let statusPae = "0%";
                try {
                    const resProgress = await fetchData(
                        "GET",
                        `percentage-form-validation/${session.sessionId}`
                    );
                    if (resProgress && resProgress.data && typeof resProgress.data.validationPercentage === "number") {
                        const val = resProgress.data.validationPercentage;
                        const rounded = (parseInt(val / 10, 10) + 1) * 10;
                        statusPae = rounded + "%";
                    }
                } catch (e) {
                    // Si erreur, statusPae reste à "0%"
                }

                return {
                    id: session.sessionId,
                    title: training ? training.name : session.trainingName || "Formation",
                    periodStart: session.internshipStart ? new Date(session.internshipStart) : null,
                    periodEnd: session.internshipEnd ? new Date(session.internshipEnd) : null,
                    statusPae: statusPae,
                };
            })
        );
        setMultiCalendar(calendarData);
    }, [fetchData]);

    useEffect(() => {
        getData();
    }, [getData]);

    // Fonction pour sauvegarder les dates modifiées (PATCH)
    async function handleSaveMulti(id, newPeriodStart, newPeriodEnd) {
        const toBackendFormat = (date) =>
            date ? date.toISOString() : null;

        const body = {
            internshipStart: toBackendFormat(newPeriodStart),
            internshipEnd: toBackendFormat(newPeriodEnd),
        };

        console.log("PATCH body:", body);

        const res = await fetchData(
            "PATCH",
            `organization/session/${id}`,
            body
        );
        if (res && res.status && res.status < 400) {
            getData();
        }
    }

    return (
        <MainLayout>
            <div className={'hidden md:flex'}>
                <CalendarDouble
                    multi={multiCalendar}
                    onSaveMulti={handleSaveMulti}
                />
            </div>
            <div className='md:hidden w-[80%] m-auto'>
                <CalendarSimplePUT
                    multi={multiCalendar}
                    onSaveMulti={handleSaveMulti}
                />
            </div>
        </MainLayout>
    )
}

export default CalendarPage
