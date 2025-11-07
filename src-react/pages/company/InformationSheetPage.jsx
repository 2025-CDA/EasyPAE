import { useState } from "react";
import MainLayout from "../../components/layout/MainLayout";
import Breadcrumb from "../../components/ui/Breadcrumb";
import Container from "../../components/ui/Container";
import Stepper from "../../components/ui/stepper/Stepper";
import { TrainerForm } from "./information_sheet/TrainerForm";
import { LegalRepresentativeForm } from "./information_sheet/LegalRepresentativeForm";
import CompanyForm from "./information_sheet/CompanyForm";
import useAxios from "../../hooks/useAxios";
import { useNavigate, useParams } from "react-router";
import { toast } from "react-toastify";
import CompanyDetails from "./information_sheet/CompanyDetails";

export default function InformationSheetPage() {
    const { fetchData } = useAxios();
    const { infoFormId } = useParams();
    const navigate = useNavigate();
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
            // isTrainerSame: false,
            trainerName: "",
            trainerLastName: "",
            trainerEmail: "",
            trainerPhone: "",
        },
    });

    function updateSection(section, key, value) {
        setFormState((prev) => {
            return {
                ...prev,
                [section]: {
                    ...prev[section],
                    [key]: value,
                },
            };
        });
    }

    async function submitCompanyDetails() {
        try {
            const res = await fetchData(
                "PATCH",
                `company/infoForm/${infoFormId}/infoFormCompany`,
                {
                    name: formState.company.companyName,
                    address: formState.company.companyAddress,
                    activity: formState.company.companyActivities,
                    phoneNumber: formState.company.companyPhone,
                    email: formState.company.companyEmail,
                    fax: formState.company.companyFax,
                    siret: formState.company.companyNumber,
                    legalRepresentativeFirstName:
                        formState.legalRep.legalRepName,
                    legalRepresentativeLastName:
                        formState.legalRep.legalRepLastName,
                    legalRepresentativeEmail: formState.legalRep.legalRepEmail,
                    tutorFirstName: formState.trainer.trainerName,
                    tutorLastName: formState.trainer.trainerLastName,
                    tutorEmail: formState.trainer.trainerEmail,
                    tutorPhoneNumber: formState.trainer.trainerPhone,
                }
            );
            console.log(res);
            toast.success("Fiche de renseignement mise à jour");
            navigate("/");
        } catch (error) {
            toast.error(error.message);
        }
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
                                stepContent: (
                                    <CompanyDetails
                                        formState={formState}
                                        updateSection={updateSection}
                                    />
                                ),
                            },
                        ]}
                        withBack
                        handleValidateEvent={submitCompanyDetails}
                        lastEventButtonTitle={"Soumettre"}
                        withNavbar={false}
                    ></Stepper>
                </Container>
            </div>
        </MainLayout>
    );
}
