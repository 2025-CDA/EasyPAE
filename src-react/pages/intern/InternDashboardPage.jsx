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

function InternDashboardPage() {
    const [companyDetails, setCompanyDetails] = useState({});
    const [currentFormation, setCurrentFormation] = useState({});

    const { fetchData } = useAxios();
    const { userData } = useAuthContext();
    const { infoFormId } = useParams();
    const navigate = useNavigate();

    useEffect(() => {
        const getData = async () => {
            const res = await fetchData(
                "GET",
                `resume-card/${infoFormId}/company`
            );
            setCompanyDetails(res.data);
        };

        const getDataDates = async () => {
            const res = await fetchData(
                "GET",
                `intern/infoForm/${infoFormId}/infoFormIntern`
            );
            setCurrentFormation(res.data);
        };
        infoFormId && getData();
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

    const [finishedStep] = useState([]);

    return (
        <MainLayout withSearchbar={false}>
            <h2 className="ml-5 font-semibold">Dashboard</h2>

            <div className="grid grid-cols-3 gap-4 m-5">
                <Container
                    className={` ${
                        infoFormId ? "col-span-2" : "col-span-3"
                    } flex flex-col gap-4 font-semibold justify-center`}
                >
                    <h4 className="mb-5">Statuts de la demande </h4>
                    <StepperNavbar
                        content={steps}
                        currentStep={0}
                        finishedStep={finishedStep ? finishedStep : []}
                    />
                    <Button onClick={() => navigate("/paeApplication")}>
                        Inciter une demande de PEA
                    </Button>
                </Container>

                {infoFormId && (
                    <>
                        {" "}
                        <CardCompany
                            avatar={companyDetails.companyUserAvatar}
                            tutorEmail={companyDetails.companyContactEmail}
                            companyName={companyDetails.companyName}
                            adresse={companyDetails.companyAddress}
                            tel={companyDetails.companyPhoneNumber}
                            tutorName={companyDetails.tutorName}
                        />
                        <div className="col-span-2">
                            <Container>
                                <TimeLine />
                            </Container>
                        </div>
                        <CalendarSimpleGET
                            dates={{
                                periodStart: new Date(
                                    currentFormation.internshipStartDate
                                ),
                                periodEnd: currentFormation.internshipEndDate,
                            }}
                        />
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
