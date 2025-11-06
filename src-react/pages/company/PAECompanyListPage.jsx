import { useEffect, useState } from "react";

import HeaderInternList from "../../components/intern_list/HeaderInternList";
import { useParams } from "react-router";
import useAxios from "../../hooks/useAxios";
import MainLayout from "../../components/layout/MainLayout";
import AppTable from "../../components/ui/Table/AppTable";
import FormAddIntern from "../../components/intern_list/FormAddIntern";
import { Edit } from "lucide-react";
import { useAuthContext } from "../../store/auth_context/authContext";

export default function PAECompanyListPage() {
    // Constante concernant les données des stagiaires dans le tableau
    const [files, setFiles] = useState([]);
    const { userData } = useAuthContext();

    const { fetchData } = useAxios();

    // Constante concernant les titres des colonnes du tableau
    const columns = [
        { key: "internFirstName", label: "PRENOM STAGIAIRE" },
        { key: "internLastName", label: "NOM STAGIAIRE" },
        { key: "internEmail", label: "EMAIL" },
        { key: "infoFormId", label: "FILE N" },
        { key: "companyStatus", label: "FILE STATUS" },
    ];

    useEffect(() => {
        const getFilesList = async () => {
            const res = await fetchData(
                "GET",
                `company/companyMember/${userData?.companyMemberId}/infoForms`
            );
            setFiles(res.data.member);
        };
        getFilesList();
    }, []);

    // // Constante concernant la gestion du composant calendar sur les dates de formation
    // const [currentFormation] = useState({
    //     periodStart: new Date(2026, 0, 5), // 5 janvier 2026
    //     periodEnd: new Date(2026, 2, 27), // 27 mars 2026
    // });

    const [showForm, setShowForm] = useState(false);

    const addIntern = (keyAction) => {
        console.log(`Ajout du stagiaire l'élément ID : ${keyAction}`);
    };
    // console.log(keyAction)

    // La constante pour le bouton du composant tableau qui est dans la colonne action
    const divAction = (
        <div className="flex gap-3 justify-start">
            <button
                className="p-2 bg-secondary text-white rounded-lg hover:bg-secondary/90"
                onClick={addIntern}
            >
                <Edit className="w-4 h-4" />
            </button>
        </div>
    );

    return (
        <MainLayout>
            <div className="p-4">
                {/* <HeaderInternList /> */}
                <h2 className="text-2xl font-bold my-4">
                    List des PAE de votre Entreprise{" "}
                </h2>

                <div className="flex flex-row items-start gap-4">
                    <AppTable
                        classNameTableTitle={"hidden"}
                        columns={columns}
                        data={files}
                        numberItemsPerPage={7}
                        classNameAppTable={"w-full w-2/3"}
                        divAction={divAction}
                        divButtonHeaderClassName={"hidden"}
                    />
                </div>
            </div>
        </MainLayout>
    );
}
