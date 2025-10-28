import {useState} from "react";
import MainLayout from "../../components/layout/MainLayout";
import Breadcrumb from "../../components/ui/Breadcrumb";
import Stepper from "../../components/ui/stepper/Stepper";
import InfoFormInternPae from "../../components/intern/InfoFormInternPae";
import InfoFormCompanyPae from "../../components/intern/InfoFormCompanyPae";
import Container from "../../components/ui/Container";
import FicheRenseignStagaire from "../assistant/FicheRenseignStagiaire";

function FormInternPage() {

const [internInfo, setInternInfo] = useState({
    firstNameIntern: "Amine",
    lastNameIntern: "Amine",
    mailIntern: "test@test.com",
    nameCourse: "CDUI",
    nbCourse: "24758",
    startDateInternship: "10 Novembre",
    endDateInternship: "24 Décembre 2025",
  });

   const [companyInfo, setCompanyInfo] = useState({
    companyName: "",
    companyAddress: "",
    companyMail: "",
    tutorName: "",
  });

  const handleValidateEvent = () => {
        // Ici, tu peux envoyer les données à une API, valider, ou naviguer
        console.log("Données soumises :", { internInfo, companyInfo });
        
        // Exemple : Validation simple (ajoute ta logique réelle)
        if (!companyInfo.companyName || !companyInfo.companyAddress) {
            alert("Veuillez remplir tous les champs obligatoires.");
            return;
        }
        
        // Soumission réussie : par exemple, naviguer ou afficher un message
        // Ou : navigate("/confirmation"); si tu utilises React Router
    };

    return (
        <MainLayout withSearchbar={false}>
            <div className="mx-10 overflow-hidden">
                {" "}
                {/* Ici : overflow-hidden pour masquer les scrollbars seulement sur cette page */}
                <Breadcrumb
                    content={[
                        {
                            title: "Dashboard",
                            link: "#",
                            isFinal: false,
                            current: false,
                        },
                        {
                            title: "Demande de PAE",
                            link: "#",
                            isFinal: true,
                            current: true,
                        },
                    ]}
                    className="self-center"
                />
                <Stepper
                    content={[
                        {
                            title: "Mes infos",

                            stepContent: (
                                <Container>
                                    <InfoFormInternPae
                                        data={internInfo}
                                        onChange={setInternInfo}

                                    />{" "}
                                </Container>
                            ),
                        },
                        {
                            title: "L'Entreprise",
                            stepContent: (
                                <Container>
                                    <InfoFormCompanyPae
                                    data={companyInfo}
                                    onChange={setCompanyInfo}
                                    />{" "}
                                </Container>
                            ),
                        },
                        {
                            title: "Valider",
                            stepContent: (<Container >
                                    <FicheRenseignStagaire withCopy={true} data={{ ...internInfo, ...companyInfo }} />
                                </Container>)
                        },
                    ]}
                    isHorizontal={true}
                    handleValidateEvent={handleValidateEvent}
                    lastEventButtonTitle = {false}

                />
            </div>
        </MainLayout>
    );
}

export default FormInternPage;
