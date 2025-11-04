import HeaderInternList from "./HeaderInternList";
import AppTable from "../ui/Table/AppTable";
import CalendarSimpleGET from "../calendar/CalendarSimpleGET";
import { useEffect, useState } from "react";
import FormAddIntern from "./FormAddIntern";
import { Edit } from "lucide-react";
import MainLayout from "../layout/MainLayout";
import { useParams } from "react-router";
import useAxios from "../../hooks/useAxios";

export default function InternListPage() {
    const { id } = useParams();

    // Constante concernant les données des stagiaires dans le tableau
    const [data, setData] = useState([]);
    const [stageDates, setStageDates] = useState({
        startDate: "",
        endDate: "",
    });
    const { fetchData } = useAxios();

    // Constante concernant les titres des colonnes du tableau
    const columns = [
        { key: "internFirstName", label: "PRENOM STAGIAIRE" },
        { key: "internLastName", label: "NOM STAGIAIRE" },
        { key: "internLogin", label: "IDENTIFIANT" },
        { key: "status", label: "AVANCÉE DU DOSSIER" },
        { key: "action", label: "MODIFIER" },
    ];

    useEffect(() => {
        const getInternsList = async () => {
            const res = await fetchData(
                "GET",
                `organization/session/${id}/interns`
            );
            setData(res.data.member);
        };

        const getSessionDetails = async () => {
            const res = await fetchData("GET", `organization/session/${id}`);
            setStageDates({
                startDate: new Date(res.data.internshipStart)
                    .toISOString()
                    .split("T")[0],
                endDate: new Date(res.data.internshipEnd)
                    .toISOString()
                    .split("T")[0],
            });
        };

        getSessionDetails();
        getInternsList();
    }, []);

    // Constante concernant la gestion du composant calendar sur les dates de formation
    const [currentFormation] = useState({
        periodStart: new Date(2026, 0, 5), // 5 janvier 2026
        periodEnd: new Date(2026, 2, 27), // 27 mars 2026
    });

    // état pour contrôler la visibilité du formulaire au niveau du bouton du composant AppTable (au click il le change il le met en true) et du composant FormAddIntern au click du bouton de AppTable, FormAdd le perçois dans showForm et active la visibilité du formulaire
    const [showForm, setShowForm] = useState(false);
    // console.log(showForm)

    // Fonction déclenchée depuis le bouton du tableau
    const handleAddInternClick = () => {
        setShowForm(!showForm); // alterne visible (true) / caché (false)
    };

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

    // Fonction appelée quand le formulaire est soumis
    const handleAddIntern = (newIntern) => {
        // On ajoute le nouveau stagiaire dans le tableau existant
        setData((prev) => [...prev, newIntern]);
        setShowForm(false);
    };

    return (
        <MainLayout>
            <div className="ml-4">
                {/* Composant contenant le titre de la page et la barre de progression */}
                <HeaderInternList />

                <div className="flex flex-row items-start gap-4">
                    {/* Composant contenant le tableau et personnalisé pour cette page */}
                    <AppTable
                        classNameTableTitle={"hidden"}
                        columns={columns}
                        data={data}
                        numberItemsPerPage={7}
                        classNameAppTable={"w-full w-2/3"}
                        divAction={divAction}
                        onClickButtonHeaderOne={handleAddInternClick}
                    />

                    <div className="flex flex-col items-start gap-4 mr-8 min-w-1/4">
                        <FormAddIntern
                            // visibilityAddForm= {visibilityAddForm}
                            visibilityAddForm={
                                showForm ? "visible w-full" : "hidden"
                            }
                            onAddIntern={handleAddIntern}
                        />
                        <div className="w-full">
                            <CalendarSimpleGET
                                dates={currentFormation}
                                shrinkable={true}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
