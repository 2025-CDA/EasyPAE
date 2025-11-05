import { useEffect, useState } from "react";
import MainLayout from "../../components/layout/MainLayout";
import Breadcrumb from "../../components/ui/Breadcrumb";
import Stepper from "../../components/ui/stepper/Stepper";
import InfoFormInternPae from "../../components/intern/InfoFormInternPae";
import InfoFormCompanyPae from "../../components/intern/InfoFormCompanyPae";
import Container from "../../components/ui/Container";
import FicheRenseignStagaire from "../assistant/FicheRenseignStagiaire";
import { useAuthContext } from "../../store/auth_context/authContext";
import { useParams } from "react-router";
import useAxios from "../../hooks/useAxios";

function FormInternPage() {
    const [internInfo, setInternInfo] = useState({
        firstNameIntern: "",
        lastNameIntern: "",
        mailIntern: "",
        nameCourse: "",
        nbCourse: "",
        startDateInternship: "",
        endDateInternship: "",
    });

    const [companyInfo, setCompanyInfo] = useState({
        companyName: "",
        companyAddress: "",
        companyMail: "",
        contactFirstName: "",
        contactLastName: "",
    });

    const { userData } = useAuthContext();
    const { infoFormId } = useParams();
    const { fetchData } = useAxios();

    useEffect(() => {
        const getInternInitialData = async () =>
            await fetchData(
                "GET",
                `intern/infoForm/${infoFormId}/infoFormIntern`
            );
        getInternInitialData().then((res) => {
            console.log(res);
            setInternInfo({
                firstNameIntern: res.data.internFirstName,
                lastNameIntern: res.data.internLastName,
                mailIntern: res.data.internEmail,
                nameCourse: res.data.trainingName,
                nbCourse: res.data.offerNumber,
                startDateInternship: new Date(
                    res.data.internshipStart
                ).toLocaleDateString("fr-FR"),
                endDateInternship: new Date(
                    res.data.internshipEnd
                ).toLocaleDateString("fr-FR"),
            });
        });
    }, []);

    const handleInternStateChange = (e) => {
        const { id, value } = e.target;
        setInternInfo((prev) => ({ ...prev, [id]: value }));
    };

    const handleCompanyStateChange = (e) => {
        const { id, value } = e.target;
        setCompanyInfo((prev) => ({ ...prev, [id]: value }));
    };

    async function handleUpdateCompanyDetails() {
        const res = await fetchData(
            "PATCH",
            `intern/infoForm/${infoFormId}/infoFormIntern/infoFormInternCompany`,
            {
                infoFormCompanyStatus: "validated",
                infoFormInternCompanyName: companyInfo.companyName,
                infoFormInternCompanyAddress: companyInfo.companyAddress,
                infoFormInternCompanyLegalRepresentativeFirstName:
                    companyInfo.contactFirstName,
                infoFormInternCompanyLegalRepresentativeLastName:
                    companyInfo.contactLastName,
                infoFormInternCompanyLegalRepresentativeEmail:
                    companyInfo.companyMail,
            }
        );
        console.log(res.data);
    }

    async function handlePAEValidation() {
        const res = await fetchData(
            "PATCH",
            `intern/infoForm/${infoFormId}/infoFormIntern/validation`,
            {
                infoFormStatus: "completed_intern",
                infoFormInternStatus: "validated",
                infoFormCompanyStatus: "validated",
            }
        );
        console.log(res.data);
    }

    return (
        <MainLayout withSearchbar={false}>
            <div className="mx-10 overflow-hidden">
                {" "}
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
                                        onChange={handleInternStateChange}
                                    />{" "}
                                </Container>
                            ),
                        },
                        {
                            title: "L'Entreprise",
                            stepAction: handleUpdateCompanyDetails,
                            stepContent: (
                                <Container>
                                    <InfoFormCompanyPae
                                        data={companyInfo}
                                        onChange={handleCompanyStateChange}
                                    />{" "}
                                </Container>
                            ),
                        },
                        {
                            title: "Valider",
                            stepAction: handlePAEValidation,
                            stepContent: (
                                <Container>
                                    <FicheRenseignStagaire
                                        withCopy={true}
                                        data={{ ...internInfo, ...companyInfo }}
                                    />
                                </Container>
                            ),
                        },
                    ]}
                    isHorizontal={true}
                    handleValidateEvent={handlePAEValidation}
                    lastEventButtonTitle={false}
                />
            </div>
        </MainLayout>
    );
}

export default FormInternPage;
