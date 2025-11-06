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
import { toast } from "react-toastify";
import { useNavigate } from "react-router";

export default function Dashboard({
    selectDiv = true, // props pour gérer l'affichage du select dans le header
    calendarDiv = true, // props pour gérer l'affichage du calendrier dans la grille principale
}) {
    const [selectedCat, setSelectedCat] = useState(); // État pour la formation sélectionnée dans le select
    const [showForm, setShowForm] = useState(false); // État pour contrôler l'affichage du formulaire
    const [formations, setFormation] = useState([]); // État pour contrôler l'affichage du formulaire
    const [trainingNames, setTrainingNames] = useState([]); // État pour contrôler l'affichage du formulaire
    const [formationsFiltered, setFormationsFiltered] = useState(formations); // État pour contrôler l'affichage du formulaire
    const [trainingForm, setTrainingForm] = useState({
        trainerId: "",
        trainingName: "",
        offerNumber: "",
        internshipStart: "",
        internshipEnd: "",
        trainingStart: "",
        trainingEnd: "",
    });

    const { fetchData } = useAxios();
    const { userData } = useAuthContext();
    const navigate = useNavigate();

    // ------------------ Filtrer les formations en fonction de la sélection-------------------------
    useEffect(() => {
        const getData = async () => {
            const res = await fetchData("GET", "organization/sessions");
            setFormation(res.data.member);
            setFormationsFiltered(res.data.member);
        };

        const getTrainingsNames = async () => {
            const res = await fetchData("GET", "organization/training-names");
            setTrainingNames(res.data.member);
        };
        getTrainingsNames();
        getData();
    }, []);

    // ---------------------Fonction pour basculer l'affichage du formulaire--------------------------
    const toggleForm = () => {
        setShowForm(!showForm);
    };

    function handleSelectCat(e) {
        console.log("🚀 ~ handleSelectCat ~ e:", e);

        if (e != "Tout" || e == "") {
            const filtered = formations.filter((f) => f.trainingId == e);
            console.log("🚀 ~ handleSelectCat ~ filtered:", filtered);
            setFormationsFiltered(filtered);
            setSelectedCat(e);
        } else {
            setSelectedCat("Tout");
            setFormationsFiltered(formations);
        }
    }

    function updateTrainingForm(key, value) {
        setTrainingForm({ ...trainingForm, [key]: value });
    }
    async function handleNewTrainingSubmit(e) {
        e.preventDefault();
        const res = await fetchData("POST", "organization/session", {
            trainerId: parseInt(userData.id),
            trainingName: trainingForm.trainingName,
            offerNumber: trainingForm.offerNumber,
            internshipStart: trainingForm.internshipStart,
            internshipEnd: trainingForm.internshipEnd,
            trainingPeriodStart: trainingForm.trainingStart,
            trainingPeriodEnd: trainingForm.trainingEnd,
        });
        if (res.success == true) {
            // setFormation({...formations,{}})
            setTrainingForm({
                trainerId: "",
                trainingName: "",
                offerNumber: "",
                internshipStart: "",
                internshipEnd: "",
                trainingStart: "",
                trainingEnd: "",
            });
            toast.success("Session a ete ajoute!");
        } else {
            toast.error("Error!");
        }
    }
    return (
        <MainLayout avatarColor="#c1459e">
            {/* -------------------------------------------------Header--------------------------------------- */}
            <div className="w-full flex flex-row justify-between items-center px-6">
                <h3 className="text-2xl font-bold">Dashboard</h3>
                {selectDiv && (
                    <div>
                        <Select
                            options={trainingNames}
                            onChange={(e) => handleSelectCat(e.target.value)}
                        />
                    </div>
                )}
            </div>

            {/* --------------------Grille principale: cartes à gauche, calendrier à droite --------------------*/}
            <div className="flex flex-col flex-1 w-full p-6">
                <h3 className="text-2xl font-semibold mb-6">
                    {selectedCat !== "Tout" &&
                        trainingNames[selectedCat - 1]?.name}
                </h3>

                <div className="flex flex-col lg:flex-row gap-6 w-full">
                    {/* ------Cartes de formations (2/3 sur desktop) ------ */}
                    <div
                        className={`w-full ${
                            calendarDiv ? "lg:w-2/3" : "lg:w-full"
                        } flex flex-col`}
                    >
                        <div
                            className={`grid grid-cols-1 gap-6 ${
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
                                    startDateTraining={new Date(
                                        formation.trainingPeriodStart
                                    ).toLocaleDateString("fr-FR")}
                                    endDateTraining={new Date(
                                        formation.trainingPeriodEnd
                                    ).toLocaleDateString("fr-FR")}
                                />
                            ))}
                            <CardFormation onClick={toggleForm}>
                                {showForm
                                    ? "Masquer le formulaire"
                                    : "Ajouter un stagiaire"}
                            </CardFormation>
                        </div>
                    </div>

                    {/* Calendrier (1/3 sur desktop) */}

                    <div className="w-full lg:w-1/3 flex flex-col gap-2">
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
                                    <h3 className="mb-4 font-semibold">
                                        Nouveau Formation Session
                                    </h3>
                                    <Input
                                        type="text"
                                        label="Nom de formation"
                                        withCopy={false}
                                        className="mb-5"
                                        placeholder="Nom de formation"
                                        required
                                        value={trainingForm.trainingName}
                                        onChange={(e) =>
                                            updateTrainingForm(
                                                "trainingName",
                                                e.target.value
                                            )
                                        }
                                    />
                                    {/* <div className="py-4">
                                        <label htmlFor="">
                                            Nom de formation{" "}
                                            <span className="text-red-500">
                                                *
                                            </span>{" "}
                                        </label>
                                        <Select
                                            options={trainingNames}
                                            onChange={(e) => {
                                                updateTrainingForm(
                                                    "trainingName",
                                                    e.target.value
                                                );
                                                console.log(e.target.label);
                                            }}
                                        />
                                    </div> */}
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
                                        label="Date de debut de formation"
                                        withCopy={false}
                                        className="mb-5"
                                        placeholder="Date de debut de formation"
                                        required
                                        value={trainingForm.trainingStart}
                                        onChange={(e) =>
                                            updateTrainingForm(
                                                "trainingStart",
                                                e.target.value
                                            )
                                        }
                                    />
                                    <Input
                                        type="date"
                                        label="Date de fin de formation"
                                        withCopy={false}
                                        className="mb-5"
                                        placeholder="Date de fin de formation"
                                        required
                                        value={trainingForm.trainingEnd}
                                        onChange={(e) =>
                                            updateTrainingForm(
                                                "trainingEnd",
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
                        {calendarDiv && (
                            <div
                                className={
                                    "border-1 border-gray-200 flex flex-col shadow-xl rounded-2xl overflow-hidden h-110 bg-white"
                                }
                            >
                                <CalendarSimpleGet justToday={true} />
                                <div className="border-t border-gray-200 py-3 flex items-center justify-center">
                                    <Button
                                        onClick={() => navigate(`/paeCalendar`)}
                                    >
                                        Accéder aux calendriers des formations
                                    </Button>
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
