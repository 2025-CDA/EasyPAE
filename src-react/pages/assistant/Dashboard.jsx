import { useState } from "react";
import CardFormation from "../../components/ui/CardFormation";
import Select from "../../components/ui/Select";
import CalendarSimpleGet from "../../components/calendar/CalendarSimpleGET";
import Button from "../../components/ui/Button";
import Input from "../../components/ui/Input"
import MainLayout from "../../components/layout/MainLayout";




function Dashboard({
   selectDiv=true, // props pour gérer l'affichage du select dans le header
   calendarDiv=true, // props pour gérer l'affichage du calendrier dans la grille principale
}) {

 const [selected, setSelected] = useState(""); // État pour la formation sélectionnée dans le select
 const [showForm, setShowForm] = useState(false); // État pour contrôler l'affichage du formulaire

// ----------------------------- Options pour le composant Select-----------------------------
 const options = [
   { value: "formation1", label: "Formation 1" },
   { value: "formation2", label: "Formation 2" },
   { value: "formation3", label: "Formation 3" },
 ];
// ----------------------------- Données des formations -----------------------------
 const formations = [
   {
     value: "formation1",
     trainingTitle: "Nom de la formation 1",
     nbOffer: "xxxxxx",
     trainerName: "Nom du formateur",
     startDateInternship: "00/00/0000",
     endDateInternship: "00/00/0000",
   },
   {
     value: "formation2",
     trainingTitle: "Nom de la formation 2",
     nbOffer: "xxxxxx",
     trainerName: "Nom du formateur",
     startDateInternship: "00/00/0000",
     endDateInternship: "00/00/0000",
   },
   {
     value: "formation3",
     trainingTitle: "Nom de la formation 3",
     nbOffer: "xxxxxx",
     trainerName: "Nom du formateur",
     startDateInternship: "00/00/0000",
     endDateInternship: "00/00/0000",
   }
 ];
// ------------------ Filtrer les formations en fonction de la sélection-------------------------
 const formationsFiltered = selected
   ? formations.filter(f => f.value === selected)
   : formations; //

// ---------------------Fonction pour basculer l'affichage du formulaire--------------------------
const toggleForm = () => {
  console.log("showForm")
  setShowForm(!showForm);
};
console.log(selectDiv)



return (
   <MainLayout>
{/* -------------------------------------------------Header--------------------------------------- */}
      <div className="w-full flex flex-row justify-between items-center px-6">
          <h1 className="text-2xl font-bold">Dashboard</h1>
          {selectDiv && (
           <div >
              <Select options={options} value={selected} onChange={setSelected} />
           </div>
          )}
      </div>


{/* --------------------Grille principale: cartes à gauche, calendrier à droite --------------------*/}
      <div className="flex flex-col flex-1 w-full p-6">
          <h1 className="text-2xl font-semibold mb-6">Informatique - Numérique</h1>


          <div className="flex flex-col lg:flex-row gap-6 w-full">
            {/* ------Cartes de formations (2/3 sur desktop) ------ */}
            <div className={`w-full ${calendarDiv ? 'lg:w-2/3' : 'lg:w-full'} flex flex-col`}>


              <div className={`grid grid-cols-1  gap-6 ${calendarDiv ? 'md:grid-cols-2' : 'md:grid-cols-3'}`}>
              {/* <div className={`w-full ${calendarDiv ? 'lg:w-2/3' : 'lg:w-full'} flex flex-col`}> */}
                {formationsFiltered.map(formation => (
                  <CardFormation
                    key={formation.value}
                    trainingTitle={formation.trainingTitle}
                    nbOffer={formation.nbOffer}
                    trainerName={formation.trainerName}
                    startDateInternship={formation.startDateInternship}
                    endDateInternship={formation.endDateInternship}
                  />
                ))}
                <div className="h-88">
                  <CardFormation onClick={toggleForm}>
                    {showForm ? "Masquer le formulaire" : "Ajouter un stagiaire"}
                  </CardFormation>
                </div>
              </div>
            </div>


            {/* Calendrier (1/3 sur desktop) */}
            
              <div className="w-full lg:w-1/3 flex flex-col gap-2">
              {calendarDiv && ( 
                <div className={"border-1 border-gray-200 flex flex-col shadow-xl rounded-2xl overflow-hidden h-110 bg-white"}>
                      <CalendarSimpleGet justToday={true} />
                  <div className="border-t border-gray-200 py-3 flex items-center justify-center">
                    <Button>
                        Accéder aux calendriers des formations
                    </Button>
                  </div>
                </div>
              )} 
                <div className={`transition-all duration-300 ${showForm ? 'max-h-full' : 'max-h-0 overflow-hidden'}`}>
                  {showForm && (
                  <div className="p-5 border-1 border-gray-200 flex flex-col shadow-xl rounded-2xl overflow-hidden h-auto bg-white mb-6">
                      <h3 className="mb-4">Nouveau stagiaire</h3>
                      <Input type="text" label="Nom" withCopy={false} className="mb-5" placeholder="" />
                      <Input type="text" label="Prénom" withCopy={false} className="mb-5" placeholder="" />
                      <Input type="text" label="Adresse email" withCopy={false} className="mb-5" placeholder="" />
                      <Input type="text" label="N° de stagiaire" withCopy={false} className="mb-5" placeholder="" />
                      <Button>Envoyer l'invitation</Button>
                  </div>
                  )}
                </div>
              </div>
          
          </div>
      </div>
   </MainLayout>
);
}




export default Dashboard;
