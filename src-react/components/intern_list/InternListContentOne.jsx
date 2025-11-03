import React from 'react'
import HeaderInternList from './HeaderInternList'
import AppTable from '../ui/Table/AppTable'
import CalendarSimpleGET from '../calendar/CalendarSimpleGET'
import { useState } from 'react'
import FormAddIntern from './FormAddIntern'
import { Edit } from "lucide-react";

function InternListContentOne() {

  // Constante concernant les titres des colonnes du tableau
  const columns = [ 
    { key: "first_name", label: "PRENOM STAGIAIRE" },
    { key: "last_name", label: "NOM STAGIAIRE" },
    { key: "email", label: "EMAIL" },
    { key: "intern_member_id", label: "IDENTIFIANT" },
    { key: "status", label: "AVANCÉE DU DOSSIER" },
    { key: "action", label: "MODIFIER" },
  ]

  // Constante concernant les données des stagiaires dans le tableau
  const [data, setData] = useState([
    { first_name: "Saria", last_name: "Chabanais", email: "abc@gmail.com", intern_member_id: 125242, status: "Aucune demande" },
   

  ])
  console.log(data)
  // const data = [

  //   { first_name: "Jeremie Chabanais", intern_member_id: 125242, status: "Aucune demande" },
  //   { first_name: "Saria Chabanais", intern_member_id: 125242, status: "Aucune demande" },
  //   { first_name: "Aziza Chabanais", intern_member_id: 125242, status: "Aucune demande" },
  //   { first_name: "Margot Chabanais", intern_member_id: 125242, status: "Aucune demande" },
  //   { first_name: "Mounir Chabanais", intern_member_id: 125242, status: "Aucune demande" },
  //   { first_name: "Amine Chabanais", intern_member_id: 125242, status: "Aucune demande" },
  //   { first_name: "Karim Chabanais", intern_member_id: 125242, status: "Aucune demande" },
  //   { first_name: "Koribirama Chabanais", intern_member_id: 125242, status: "Aucune demande" },

  //   // { id: 2, first_name: "Saria", last_name: "Chabanais", intern_member_id: 125242, status: "Stagiaire a initié la demande" },
  //   // { id: 3, first_name: "Aziza", last_name: "Chabanais", intern_member_id: 125242, status: "Transmis à l'administration" },
  //   // { id: 4, first_name: "Margot", last_name: "Chabanais", intern_member_id: 125242, status: "Aucune demande" },
  //   // { id: 5, first_name: "Arnaud", last_name: "Chabanais", intern_member_id: 125242, status: "Terminé" },
  //   // { id: 6, first_name: "Yves", last_name: "Dupont", intern_member_id: 125243, status: "En attente de validation" },
  //   // { id: 7, first_name: "Camille", last_name: "Durand", intern_member_id: 125244, status: "Terminé" },
  //   // { id: 8, first_name: "Paul", last_name: "Martin", intern_member_id: 125245, status: "Transmis à l'administration" },
  // ]

  // Constante concernant la gestion du composant calendar sur les dates de formation
  const [currentFormation, ] = useState({
      periodStart: new Date(2026, 0, 5),  // 5 janvier 2026
      periodEnd: new Date(2026, 2, 27),   // 27 mars 2026
  });

  // état pour contrôler la visibilité du formulaire au niveau du bouton du composant AppTable (au click il le change il le met en true) et du composant FormAddIntern au click du bouton de AppTable, FormAdd le perçois dans showForm et active la visibilité du formulaire
  const [showForm, setShowForm] = useState(false)
  // console.log(showForm)
  
  // Fonction déclenchée depuis le bouton du tableau
  const handleAddInternClick = () => {
    setShowForm(!showForm) // alterne visible (true) / caché (false)
  }
 
  const addIntern = (keyAction) => {
    console.log(`Ajout du stagiaire l'élément ID : ${keyAction}`)
  }
  // console.log(keyAction)
  
  // La constante pour le bouton du composant tableau qui est dans la colonne action
  const divAction = 
  (
    <div className="flex gap-3 justify-start">
    <button 
      className="p-2 bg-secondary text-white rounded-lg hover:bg-secondary/90"
      onClick={addIntern}
    >
      <Edit className="w-4 h-4" />
    </button>
    </div>
  ) 

  // Fonction appelée quand le formulaire est soumis
  const handleAddIntern = (newIntern) => {
    // On ajoute le nouveau stagiaire dans le tableau existant
    setData(prev => [...prev, newIntern])
    setShowForm(false)
  }
  
  return (
    
    <div className="ml-4">
      {/* Composant contenant le titre de la page et la barre de progression */}
      <HeaderInternList/>

      <div className="flex flex-row items-start gap-4">

        {/* Composant contenant le tableau et personnalisé pour cette page */}
        <AppTable
          classNameTableTitle={"hidden"}  
          columns = {columns}
          data =  {data}
          numberItemsPerPage ={7} 
          classNameAppTable={"w-full"}
          divAction={divAction}
          onClickButtonHeaderOne={handleAddInternClick}
        />

        <div className="flex flex-col items-start gap-4 mr-8">  
          
          <FormAddIntern
            // visibilityAddForm= {visibilityAddForm}
            visibilityAddForm={showForm ? "visible w-full" : "hidden"}
            onAddIntern={handleAddIntern}
          />

          {/* --- Transition douce du formulaire --- */}
          {/* <div
            className={`w-full transition-all duration-1000 ease-in-out ${
              showForm
                ? "max-h-[700px] opacity-100 translate-y-0"
                : "max-h-0 opacity-0 -translate-y-5"
            }`}
          >
            <FormAddIntern />
          </div> */}

          <CalendarSimpleGET
            dates={currentFormation}
            shrinkable={true}         
          />
        </div>
      </div>
    </div>
  )
}

export default InternListContentOne