import React from "react";
import MainLayout from "../../components/layout/MainLayout";
import Breadcrumb from "../../components/ui/Breadcrumb";
import Stepper from "../../components/ui/stepper/Stepper";
import InfoFormInternPae from "../../components/intern/InfoFormInternPae";

function FormInternPage() {
    return (
        <MainLayout>
            <div className="ml-5 overflow-hidden"> {/* Ici : overflow-hidden pour masquer les scrollbars seulement sur cette page */}
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
                />
                <Stepper
                    content={[
                        {
                            title: "Mes infos",
                            stepContent: <InfoFormInternPae nbFormation='483285'/>,
                        },
                        {
                            title: "L'Entreprise",
                            stepContent: <h1>Test2</h1>,
                        },
                        {
                            title: "Valider",
                            stepContent: <h1>Test3</h1>,
                        },
                    ]}
                />
            </div>
        </MainLayout>
    );
}

export default FormInternPage;
