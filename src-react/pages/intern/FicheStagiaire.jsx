import React, { useState } from "react";
import MainLayout from "../../components/layout/MainLayout";
import StepperNavbar from "../../components/ui/stepper/StepperNavbar";
import Breadcrumb from "../../components/ui/Breadcrumb";
import CardCompany from "../../components/ui/CardCompany";
import CardIntern from "../../components/ui/CardIntern";
import Stepper from "../../components/ui/stepper/Stepper";
import CalendarSimpleGET from "../../components/calendar/CalendarSimpleGET";
import BusinessMan from "../../assets/Business-man.png";
import Container from "../../components/ui/container";
// import Container from "../../components/ui/Container";

const steps = [
    {
        title: "Stagiaire",
        description: "Attente d'envoi de la demande",
        finishedStep: 1,
    },
    { title: "Entreprise", description: "Formulaire transmis à l'entreprise" },
    { title: "Administration", description: "Validation" },
];

const breadcrumbContent = [
    { title: "Dashboard", link: "/dashboard", isFinal: false, current: false },
    {
        title: "Fiches stagiaires",
        link: "/fiches-stagiaires",
        isFinal: false,
        current: false,
    },
    { title: "Axel Érez", link: "#", isFinal: true, current: true },
];

function FicheStagiaire({
    name,
    internNumber,
    email,
    courseName,
    courseNumber,
    trainerName,
    startDateInternship,
    endDateInternship,
    className,
    companyName,
    adresse,
    tutorEmail,
    tel,
    tutorName,
}) {
    const [currentFormation] = useState({
        periodStart: new Date(2026, 0, 5), // 5 janvier 2026
        periodEnd: new Date(2026, 2, 27), // 27 mars 2026
    });

    const [finishedStep] = useState([0]);

    return (
        <MainLayout>
            <Container className={"flex flex-col border-none p-5 min-h-screen"}>
                <h2 className="font-semibold">Axel Erez</h2>
                <div className="w-full">
                    <Breadcrumb content={breadcrumbContent} />
                </div>
                <Container className="grid md:grid-cols-3 grid-cols-1 space-y-4 md:gap-4 px-3 py-4 border-0">
                    {/* Colonne principale */}
                    <div className="col-span-2 space-y-4">
                        <CardIntern
                            name={name}
                            internNumber={internNumber}
                            email={email}
                            courseName={courseName}
                            courseNumber={courseNumber}
                            trainerName={trainerName}
                            startDateInternship={startDateInternship}
                            endDateInternship={endDateInternship}
                            className={className}
                        />
                        <Container
                            className={" flex flex-col gap-4 p-4 font-semibold"}
                        >
                            <h2>Statut de la demande</h2>
                            <StepperNavbar
                                content={steps}
                                currentStep={1}
                                finishedStep={finishedStep}
                            />
                        </Container>
                    </div>

                    {/* Colonne droite */}
                    <div className="col-span-1 space-y-4 w-full font-semibold">
                        <CardCompany
                            companyName={companyName}
                            adresse={adresse}
                            tutorEmail={tutorEmail}
                            tel={tel}
                            tutorName={tutorName}
                        />
                        <CalendarSimpleGET dates={currentFormation} />
                    </div>
                </Container>
                <img
                    src={BusinessMan}
                    alt="Business-man.png"
                    className="w-[300px] scale-x-[-1] self-end mr-10 hidden md:block"
                />
                {/* <img className='w-1/5 transform -scale-x-100' src={BusinessMan} alt="" /> */}
            </Container>
        </MainLayout>
    );
}

export default FicheStagiaire;
