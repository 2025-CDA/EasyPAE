import React, {useEffect, useState} from "react";
import MainLayout from "../../components/layout/MainLayout";
import StepperNavbar from "../../components/ui/stepper/StepperNavbar";
import Breadcrumb from "../../components/ui/Breadcrumb";
import CardCompany from "../../components/ui/CardCompany";
import CardIntern from "../../components/ui/CardIntern";
import Stepper from "../../components/ui/stepper/Stepper";
import CalendarSimpleGET from "../../components/calendar/CalendarSimpleGET";
import BusinessMan from "../../assets/Business-man.png";
import Container from "../../components/ui/container";
import { useParams } from "react-router";
import useAxios from "../../hooks/useAxios";

// import Container from "../../components/ui/Container";

function FicheStagiaire({className}) {

    const { fetchData } = useAxios();

    const [internCardInfo, setInternCardInfo] = useState({

        internAvatar: "",
        internFirstName: "",
        internLastName: "",
        internLogin: "",
        internEmail: "",
        trainingTitle: "",
        offerNumber: "",
        organizationUserFirstName: "",
        organizationUserLastName: "",
        internshipStartDate: "",
        internshipEndDate: "",

    });

    const [companyCardInfo, setCompanyCardInfo] = useState({

        companyUserAvatar: "",
        companyName: "",
        companyAddress: "",
        companyContactEmail: "",
        companyPhoneNumber: "",
        tutorName: ""
    });
    
    const {id} = useParams();

    const [finishedStep] = useState([0]);

    const steps = [
    { title: "Stagiaire", description: `${internCardInfo.internFirstName} a transmis sa  demande le 04/11/2025`, finishedStep: 1 },
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
    { title: `${internCardInfo.internFirstName} ${internCardInfo.internLastName}`, link: "#", isFinal: true, current: true },
    ];


    const [currentFormation, setCurrentFormation] = useState({});

    useEffect(() => {

        const internData = async () => {

            try { 
                const res = await fetchData( "GET", `resume-card/${id}/intern`)
                setInternCardInfo(res.data)
                
            } catch {
                console.log("error")
            }

        };

        const companyData = async () => {

            try {
                const res = await fetchData("GET", `resume-card/${id}/company`)
                setCompanyCardInfo(res.data)
                
            } catch {
                console.log("error")  
            }
        };

        const getDates = async () => {
            const res = await fetchData('GET', `resume-card/${id}/intern`);
            const dates = {
                periodStart: new Date(res.data.internshipStartDate),
                periodEnd: new Date(res.data.internshipEndDate),
            };
            setCurrentFormation(dates);
            console.log('dates envoyées au calendrier : ', dates);
        };

        getDates();
        internData();
        companyData();

    }, [] );

    console.log(internCardInfo);

    

    console.log(internCardInfo.internAvatar)

    return (
        <MainLayout>
            <Container
                className={'flex flex-col border-none p-5 min-h-screen'}>
                <h2 className="font-semibold">{internCardInfo.internFirstName} {internCardInfo.internLastName}</h2>
                <div className="w-full">
                    <Breadcrumb content={breadcrumbContent} 
                    />
                </div>
                <Container className="grid md:grid-cols-3 grid-cols-1 space-y-4 md:gap-4 px-3 py-4 border-0">
                    {/* Colonne principale */}
                    <div className="col-span-2 space-y-4">
                        <CardIntern
                            avatarUrl={internCardInfo.internAvatar}
                            name={`${internCardInfo.internFirstName} ${internCardInfo.internLastName}`} 
                            internNumber={internCardInfo.internLogin}
                            email={internCardInfo.internEmail}
                            courseName={internCardInfo.trainingTitle} 
                            courseNumber={internCardInfo.offerNumber} 
                            trainerName={`${internCardInfo.organizationUserFirstName} ${internCardInfo.internLastName}`} 
                            startDateInternship={new Date (internCardInfo.internshipStartDate).toLocaleDateString("fr-FR")} 
                            endDateInternship={new Date (internCardInfo.internshipEndDate).toLocaleDateString("fr-FR")} 
                            className={className}
                            showButton={false}
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
                            companyName={companyCardInfo.companyName}
                            adresse={companyCardInfo.companyAddress}
                            tutorEmail={companyCardInfo.companyContactEmail}
                            tel={companyCardInfo.companyPhoneNumber}
                            tutorName={companyCardInfo.tutorName}
                            avatar={companyCardInfo.companyUserAvatar}
                        />
                        <CalendarSimpleGET
                        dates={currentFormation}
                        />

      
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
