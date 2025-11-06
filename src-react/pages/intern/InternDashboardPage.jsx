import React, { useState } from "react";
import MainLayout from "../../components/layout/MainLayout";
import CardCompany from "../../components/ui/CardCompany";
import TimeLine from "../../components/ui/TimeLine/TimeLine";
import CalendarSimpleGET from "../../components/calendar/CalendarSimpleGET";
import Container from "../../components/ui/Container";
import Buisinessman from "../../assets/Business-man.png";
import StepperNavbar from "../../components/ui/stepper/StepperNavbar";
import useAxios from "../../hooks/useAxios";
import { useEffect } from "react";
import { useNavigate, useParams } from "react-router";
import { useAuthContext } from "../../store/auth_context/authContext";
import Button from "../../components/ui/Button";
import { CircleAlert, CircleCheck } from "lucide-react";

function InternDashboardPage() {
    const [companyDetails, setCompanyDetails] = useState({});
    const [internDetails, setInternDetails] = useState({});
    const [currentFormation, setCurrentFormation] = useState({});

    const [finishedStep] = useState();

    const { fetchData } = useAxios();
    const { userData } = useAuthContext();
    const { infoFormId } = useParams();
    const navigate = useNavigate();

    useEffect(() => {
        const getCompanyData = async () => {
            const res = await fetchData(
                "GET",
                // `resume-card/${infoFormId}/company`
                `intern/infoForm/${infoFormId}/infoFormInternCompany`
            );

            setCompanyDetails(res.data);
        };

        const getDataDates = async () => {
            const res = await fetchData(
                "GET",
                `intern/infoForm/${infoFormId}/infoFormIntern`
            );
            const dates = {
                periodStart: new Date(res.data.internshipStart),
                periodEnd: new Date(res.data.internshipEnd),
            };
            setCurrentFormation(dates);
            setInternDetails(res.data);
        };
        infoFormId && getCompanyData();
        infoFormId && getDataDates();
    }, []);

    const steps = [
        {
            title: "Vous",
            description: "Vous avez transmis votre demande le 04/11/2025",
        },
        {
            title: "Entreprise",
            description: "Formulaire transmis à l'entreprise",
        },

        {
            title: "Administration",
            description: "Validation",
        },
    ];

    async function handleCreatePAE() {
        const res = await fetchData("POST", "intern/infoForm", {
            internId: userData?.internId,
        });
        navigate(`/paeApplication/${res.data.infoFormId}`);
    }

    return (
        <MainLayout withSearchbar={false}>
            <h2 className="ml-5 font-semibold">Dashboard</h2>

            <div className="grid grid-cols-3 gap-4 m-5">
                <Container
                    className={` ${
                        infoFormId ? "col-span-2" : "col-span-3"
                    } flex flex-col gap-4 font-semibold justify-center p-5`}
                >
                    <h4 className="mb-5">Statuts de la demande </h4>
                    <StepperNavbar
                        content={steps}
                        currentStep={infoFormId ? 1 : 0}
                        finishedStep={infoFormId ? [0] : []}
                    />
                    {!infoFormId && (
                        <Button onClick={handleCreatePAE}>
                            Inciter une demande de PEA
                        </Button>
                    )}
                </Container>

                {infoFormId && (
                    <>
                        {" "}
                        <CardCompany
                            avatar={companyDetails.companyUserAvatar}
                            tutorEmail={
                                companyDetails.infoFormInternCompanyLegalRepresentativeEmail
                            }
                            companyName={
                                companyDetails.infoFormInternCompanyName
                            }
                            adresse={
                                companyDetails.infoFormInternCompanyAddress
                            }
                            tel={companyDetails.companyPhoneNumber}
                            tutorName={
                                companyDetails.infoFormInternCompanyLegalRepresentativeFirstName
                            }
                        />
                        <div className="col-span-2">
                            <Container>
                                <TimeLine
                                    content={[
                                        {
                                            date: "1 Aug, 2023",
                                            icon: (
                                                <CircleCheck className="text-green-500"></CircleCheck>
                                            ),
                                            title: "Demande de PAE effectuée",
                                            description:
                                                "La partie “Stagiaire” de la fiche de renseignement a bien été complétée.",
                                            avatarUrl: userData?.avatar,
                                            userName: userData.firstName,
                                        },
                                    ]}
                                />
                            </Container>
                        </div>
                        <CalendarSimpleGET dates={currentFormation} />
                    </>
                )}
            </div>

            <div className="grid place-items-end ">
                <img
                    className="w-1/5 transform -scale-x-100"
                    src={Buisinessman}
                    alt=""
                />
            </div>
        </MainLayout>
    );
}

export default InternDashboardPage;
