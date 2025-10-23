import React, { useState } from 'react'
import Table from './Table/Table';
import AppTable from './Table/AppTable'
import { CircleAlert } from 'lucide-react';


function TableHStage() {
// ------------ les columes de tableaux ------------------------
 const columns = [
   { label: "Jour", key: "jour" },
   { label: "Matin", key: "matin" },
   { label: "Après-midi", key: "apresMidi" },
   { label: "Conditions d’accueil", key: "conditions" },
   { label: "Copier", key: "action" }
 ]
// ------------ les deonner des tableau ------------------------
 const data = [
   {
     jour: "Lundi",
     matin: "09h00 à 12h00",
     apresMidi: "13h00 à 17h00",
     conditions: "Présentiel",
     copier: "" // afficher une icône ou bouton ici
   },
   {
     jour: "Mardi",
     matin: "09h00 à 12h00",
     apresMidi: "13h00 à 17h00",
     conditions: "Présentiel",
     copier: ""
   },
   {
     jour: "Mercredi",
     matin: "09h00 à 12h00",
     apresMidi: "13h00 à 17h00",
     conditions: "Présentiel",
     copier: ""
   },
   {
     jour: "Jeudi",
     matin: "09h00 à 12h00",
     apresMidi: "13h00 à 17h00",
     conditions: "Distanciel",
     copier: ""
   },
   {
     jour: "Vendredi",
     matin: "09h00 à 12h00",
     apresMidi: "13h00 à 17h00",
     conditions: "Distanciel",
     copier: ""
   }
 ]
 // ------------------------  Ici on affiche tout pour currentItems (pas de pagination dans cet exemple) ------------------------
 const currentItems = data


 return (
   <div className='border-2 border-gray-200 p-3 rounded-2xl' >
       <h3 className="text-xl font-bold text-blue-700 mb-2">Horaires de stage</h3>
       <div className="mb-2 flex items-center gap-2">
           {/* ----- Icône d'information possible ----- */}
           <CircleAlert className="text-white bg-blue-600 rounded-full"  strokeWidth={2}/>
           <span>
               La plage horaire <span className="font-bold text-black">ne doit pas excéder les 35h/semaine.</span>
               <br />
               Les stagiaires doivent obligatoirement effectuer <span className="font-bold text-black">un minimum d’heure en présentiel.</span>
           </span>
       </div>
       {/* ----- tableau il manque le rendre dynamique pour le className ----- */}
       <Table
           columns={columns}
           data={data}
           currentItems={data} // tout afficher si pas de pagination    
       />
   </div>
 )
}


export default TableHStage