import { useState } from "react";
import MainLayout from "../../components/layout/MainLayout";
import Breadcrumb from "../../components/ui/Breadcrumb";
import Container from "../../components/ui/Container";
import Stepper from "../../components/ui/stepper/Stepper";
import { TrainerForm } from "./information_sheet/TrainerForm";
import { LegalRepresentativeForm } from "./information_sheet/LegalRepresentativeForm";
import CompanyForm from "./information_sheet/CompanyForm";

function InformationSheet() {
    const [formState, setFormState] = useState({
        company: {
            companyName: "",
            companyAddress: "",
            companyActivities: "",
            companyPhone: "",
            companyEmail: "",
            companyFax: "",
            companyNumber: "",
        },
        legalRep: {
            legalRepName: "",
            legalRepLastName: "",
            legalRepEmail: "",
        },
        trainer: {
            isTrainerSame: false,
            trainerName: "",
            trainerLastName: "",
            trainerEmail: "",
            trainerPhone: "",
        },
    });

    function updateSection(section, key, value) {
        setFormState((prev) => ({
            ...prev,
            [section]: {
                ...prev[section],
                [key]: value,
            },
        }));
    }

    function CompanyDetails() {
        return (
            <form
                className={"flex flex-col md:flex-row border-0 gap-5"}
                action=""
            >
                <CompanyForm
                    companyDetails={formState.company}
                    handleCompanyDetailsChange={(key, value) =>
                        updateSection("company", key, value)
                    }
                />
                <div className="flex flex-col gap-5 md:w-[35%]">
                    <LegalRepresentativeForm
                        legalRep={formState.legalRep}
                        handleLegalRepChange={(key, value) =>
                            updateSection("legalRep", key, value)
                        }
                    />
                    <TrainerForm
                        trainerDetails={formState.trainer}
                        handleTrainerDetailsChange={(key, value) =>
                            updateSection("trainer", key, value)
                        }
                    />
                </div>
            </form>
        );
    }

    return (
        <MainLayout>
            <div className="flex flex-col mx-5 gap-5">
                <div className="">
                    <h2 className="font-semibold">Fiche de renseignement</h2>
                    <Breadcrumb
                        content={[
                            {
                                title: "Dashboard",
                                link: "#",
                                isFinal: false,
                                current: false,
                            },
                            {
                                title: "Fiche de renseignement",
                                link: "#",
                                isFinal: true,
                                current: true,
                            },
                        ]}
                    ></Breadcrumb>
                </div>
                <Container className={""}>
                    <Stepper
                        className={"border-0 w-full"}
                        content={[
                            {
                                title: "Entreprise",
                                description:
                                    "Informations sur l’entreprise,  l’identité du responsable légale et du tuteur de stage.",
                                stepContent: <CompanyDetails></CompanyDetails>,
                            },
                            {
                                title: "Horaires",
                                description:
                                    "Horaires et conditions d’accueil.",
                                stepContent: <h1>Test2</h1>,
                            },
                            {
                                title: "Modalités",
                                description:
                                    "Objectifs du stages et activités confiéesau stagiaire",
                                stepContent: <h1>Test3</h1>,
                            },
                            {
                                title: "Récapitulatif et validation",

                                stepContent: <h1>Test4</h1>,
                            },
                        ]}
                        withBack
                    ></Stepper>
                </Container>
            </div>
        </MainLayout>
    );
}

export default InformationSheet;
