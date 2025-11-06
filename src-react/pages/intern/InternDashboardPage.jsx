import React, { useState } from "react";
import MainLayout from "../../components/layout/MainLayout";
import CardCompany from "../../components/ui/CardCompany";
import TimeLine from "../../components/ui/TimeLine/TimeLine";
import CalendarSimpleGET from "../../components/calendar/CalendarSimpleGET";
import Container from "../../components/ui/Container";
import Buisinessman from "../../assets/Business-man.png";
import ManWorkingComputer from "../../assets/Man-working-computer.png";
import StepperNavbar from "../../components/ui/stepper/StepperNavbar";
import useAxios from "../../hooks/useAxios";
import { useEffect } from "react";
import { useNavigate, useParams } from "react-router";
import { useAuthContext } from "../../store/auth_context/authContext";
import Button from "../../components/ui/Button";
import { CircleAlert, CircleCheck } from "lucide-react";
import CardIntern from "../../components/ui/CardIntern";

function InternDashboardPage() {
    const [companyDetails, setCompanyDetails] = useState({});
    const [internDetails, setInternDetails] = useState({});
    const [currentFormation, setCurrentFormation] = useState({});
    const [finishedStep] = useState();

    const { fetchData } = useAxios();
    const { userData } = useAuthContext();
    const { infoFormId } = useParams();
    const navigate = useNavigate();

    const role = userData.roles[1];

    useEffect(() => {
        const getCompanyData = async () => {
            const res = await fetchData(
                "GET",
                // `resume-card/${infoFormId}/company`
                `intern/infoForm/${infoFormId}/infoFormInternCompany`
            );

            setCompanyDetails(res.data);
        };
        const getInternData = async () => {
            const res = await fetchData(
                "GET",
                // `resume-card/${infoFormId}/company`
                `/api/resume-card/${infoFormId}/intern`
            );

            setInternDetails(res.data);
        };

        infoFormId && getCompanyData();
        infoFormId && getInternData();
    }, []);

    const internSteps = [
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
    const companySteps = [
        {
            title: "Entreprise",
            description:
                "Appuyer sur le bouton pour compléter la demande de PAE.",
        },
        {
            title: "Administration",
            description: "",
        },

        {
            title: "Envoi de la convention",
            description: "",
        },
    ];

    async function handleCreatePAE() {
        const res = await fetchData("POST", "intern/infoForm", {
            internId: userData?.internId,
        });
        navigate(`/paeApplication/${res.data.infoFormId}`);
    }
    async function handleCompletePAE() {
        // const res = await fetchData("POST", "intern/infoForm", {
        //     internId: userData?.internId,
        // });
        navigate(`/paeApplication/${res.data.infoFormId}`);
    }

    return (
        <MainLayout withSearchbar={false}>
            <h2 className="ml-5 font-semibold">Dashboard</h2>

            <div className="grid md:grid-cols-3 grid-cols-1 gap-4 m-5">
                <Container
                    className={`
                         col-span-2
                     flex flex-col gap-4 font-semibold justify-center p-5`}
                >
                    <h4 className="mb-5">Statuts de la demande </h4>
                    <StepperNavbar
                        content={role == "company" ? companySteps : internSteps}
                        currentStep={infoFormId ? 1 : 0}
                        finishedStep={infoFormId ? [0] : []}
                    />
                    {!infoFormId && role === "intern" && (
                        <Button onClick={handleCreatePAE}>
                            Inciter une demande de PEA
                        </Button>
                    )}
                    {!infoFormId && role === "company" && (
                        <Button onClick={handleCompletePAE}>
                            Compléter la demande de PAE
                        </Button>
                    )}
                </Container>
                {!infoFormId && role === "intern" && (
                    <CalendarSimpleGET dates={currentFormation} />
                )}

                {infoFormId && role === "intern" && (
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
                    </>
                )}
                <div className="col-span-2">
                    {infoFormId && role === "intern" && (
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
                            ></TimeLine>
                        </Container>
                    )}
                </div>
               {infoFormId && <CalendarSimpleGET dates={currentFormation} />}

                {infoFormId && role === "company" && (
                    <>
                        {" "}
                        <CardIntern
                            avatarUrl={internDetails.internAvatar}
                            name={
                                internDetails.internFirstName +
                                " " +
                                internDetails.internLastName
                            }
                            email={internDetails.internEmail}
                            courseName={
                                internDetails.trainingTitle +
                                " " +
                                internDetails.offerNumber
                            }
                            startDateInternship={
                                internDetails.internshipStartDate
                            }
                            endDateInternship={internDetails.internshipEndDate}
                            trainerName={
                                internDetails.organizationUserFirstName +
                                " " +
                                internDetails.organizationUserLastName
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
                                            avatarUrl:
                                                internDetails.internAvatar,
                                            userName:
                                                internDetails.internFirstName,
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
                    src={role === "intern" ? ManWorkingComputer : Buisinessman}
                    alt=""
                />
            </div>
        </MainLayout>
    );
}

export default InternDashboardPage;
