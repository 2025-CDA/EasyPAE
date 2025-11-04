import { useState } from "react";
import CardFormation from "../components/ui/CardFormation";
import Select from "../components/ui/Select";
import CalendarSimpleGet from "../components/calendar/CalendarSimpleGET";
import Button from "../components/ui/Button";
import Input from "../components/ui/Input";
import MainLayout from "../components/layout/MainLayout";
import useAxios from "../hooks/useAxios";
import { useEffect } from "react";
import { useAuthContext } from "../store/auth_context/authContext";
import { rolesTranslation } from "../helpers/roles";

function Dashboard({
    selectDiv = true, // props pour gérer l'affichage du select dans le header
    calendarDiv = true, // props pour gérer l'affichage du calendrier dans la grille principale
}) {
    const [selected, setSelected] = useState(""); // État pour la formation sélectionnée dans le select
    const [showForm, setShowForm] = useState(false); // État pour contrôler l'affichage du formulaire
    const [formations, setFormation] = useState([]); // État pour contrôler l'affichage du formulaire
    const [trainingForm, setTrainingForm] = useState({
        trainerId: "",
        trainingName: "",
        offerNumber: "",
        internshipStart: "",
        internshipEnd: "",
    });

    const { fetchData } = useAxios();
    const { userData } = useAuthContext();

    // Utilise la traduction du rôle si disponible
    const rawRole =
        Array.isArray(userData?.roles) && userData.roles.length > 0
            ? userData.roles[0]
            : userData?.role || "Stagiaire";
    const role = rolesTranslation[rawRole] || rawRole;

    useEffect(() => {
        const getData = async () => {
            try {
                const res = await fetchData("GET", "organization/sessions");
                // Vérifie que la réponse est bien structurée
                if (res && res.data && Array.isArray(res.data.member)) {
                    setFormation(res.data.member);
                } else {
                    setFormation([]); // fallback vide
                }
            } catch (err) {
                setFormation([]); // fallback vide en cas d'erreur
                // Optionnel : affiche une erreur ou log
                // console.error("Erreur lors du fetch des formations", err);
            }
        };
        // N'appelle getData que si fetchData est bien une fonction
        if (typeof fetchData === "function") {
            getData();
        }
    }, [fetchData]);

    // ----------------------------- Options pour le composant Select-----------------------------
    const options = [
        { value: "formation1", label: "Formation 1" },
        { value: "formation2", label: "Formation 2" },
        { value: "formation3", label: "Formation 3" },
    ];

    // ------------------ Filtrer les formations en fonction de la sélection-------------------------
    const formationsFiltered = selected
        ? formations.filter((f) => f.value === selected)
        : formations; //

    // ---------------------Fonction pour basculer l'affichage du formulaire--------------------------
    const toggleForm = () => {
        setShowForm(!showForm);
    };

    function updateTrainingForm(key, value) {
        setTrainingForm({ ...trainingForm, [key]: value });
    }
    async function handleNewTrainingSubmit(e) {
        e.preventDefault();
        await fetchData("POST", "organization/session", {
            trainerId: userData?.id,
            trainingName: trainingForm.trainingName,
            offerNumber: trainingForm.offerNumber,
            internshipStart: trainingForm.internshipStart,
            internshipEnd: trainingForm.internshipEnd,
        });
    }


    return (
        <MainLayout avatarColor="#c1459e" role={role}>
            {/* -------------------------------------------------Header--------------------------------------- */}
            <div className="w-full flex flex-row justify-between items-center px-6">
                <h3 className="text-2xl font-bold">Dashboard</h3>
                {selectDiv && (
                    <div>
                        <Select
                            options={options}
                            value={selected}
                            onChange={setSelected}
                        />
                    </div>
                )}
            </div>

            {/* --------------------Grille principale: cartes à gauche, calendrier à droite --------------------*/}
            <div className="flex flex-col flex-1 w-full p-6">
                <h3 className="text-2xl font-semibold mb-6">
                    Informatique - Numérique
                </h3>

                <div className="flex flex-col lg:flex-row gap-6 w-full">
                    {/* ------Cartes de formations (2/3 sur desktop) ------ */}
                    <div
                        className={`w-full ${
                            calendarDiv ? "lg:w-2/3" : "lg:w-full"
                        } flex flex-col`}
                    >
                        <div
                            className={`grid grid-cols-1  gap-6 ${
                                calendarDiv
                                    ? "md:grid-cols-2"
                                    : "md:grid-cols-3"
                            }`}
                        >
                            {/* <div className={`w-full ${calendarDiv ? 'lg:w-2/3' : 'lg:w-full'} flex flex-col`}> */}
                            {formationsFiltered.map((formation, i) => (
                                <CardFormation
                                    key={i}
                                    trainingTitle={formation.trainingName}
                                    nbOffer={formation.offerNumber}
                                    trainerName={
                                        formation.trainerFirstName +
                                        " " +
                                        formation.trainerLastName
                                    }
                                    startDateInternship={new Date(
                                        formation.internshipStart
                                    ).toLocaleDateString("fr-FR")}
                                    endDateInternship={new Date(
                                        formation.internshipEnd
                                    ).toLocaleDateString("fr-FR")}
                                    id={formation.sessionId}
                                />
                            ))}
                            <div className="h-88">
                                <CardFormation onClick={toggleForm}>
                                    {showForm
                                        ? "Masquer le formulaire"
                                        : "Ajouter un stagiaire"}
                                </CardFormation>
                            </div>
                        </div>
                    </div>

                    {/* Calendrier (1/3 sur desktop) */}

                    <div className="w-full lg:w-1/3 flex flex-col gap-2">
                        {calendarDiv && (
                            <div
                                className={
                                    "border-1 border-gray-200 flex flex-col shadow-xl rounded-2xl overflow-hidden h-110 bg-white"
                                }
                            >
                                <CalendarSimpleGet justToday={true} />
                                <div className="border-t border-gray-200 py-3 flex items-center justify-center">
                                    <Button>
                                        Accéder aux calendriers des formations
                                    </Button>
                                </div>
                            </div>
                        )}
                        <div
                            className={`transition-all duration-300 ${
                                showForm
                                    ? "max-h-full"
                                    : "max-h-0 overflow-hidden"
                            }`}
                        >
                            {showForm && (
                                <form
                                    onSubmit={handleNewTrainingSubmit}
                                    className="p-5 border-1 border-gray-200 flex flex-col shadow-xl rounded-2xl overflow-hidden h-auto bg-white mb-6"
                                >
                                    <h3 className="mb-4">Nouveau Formation</h3>
                                    <Input
                                        type="text"
                                        label="Offre n°"
                                        withCopy={false}
                                        className="mb-5"
                                        placeholder="Offre n°"
                                        required
                                        value={trainingForm.offerNumber}
                                        onChange={(e) =>
                                            updateTrainingForm(
                                                "offerNumber",
                                                e.target.value
                                            )
                                        }
                                    />
                                    <Input
                                        type="date"
                                        label="Date de debut de stage"
                                        withCopy={false}
                                        className="mb-5"
                                        placeholder=""
                                        required
                                        value={trainingForm.internshipStart}
                                        onChange={(e) =>
                                            updateTrainingForm(
                                                "internshipStart",
                                                e.target.value
                                            )
                                        }
                                    />
                                    <Input
                                        type="date"
                                        label="Date de fin de stage"
                                        withCopy={false}
                                        className="mb-5"
                                        placeholder=""
                                        required
                                        value={trainingForm.internshipEnd}
                                        onChange={(e) =>
                                            updateTrainingForm(
                                                "internshipEnd",
                                                e.target.value
                                            )
                                        }
                                    />
                                    <Button type={"submit"}>
                                        Envoyer l'invitation
                                    </Button>
                                </form>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}

export default Dashboard;
