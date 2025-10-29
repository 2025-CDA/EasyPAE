import React from 'react'
import HeaderInternList from './HeaderInternList'
import AppTable from '../ui/Table/AppTable'

function InternListContentOne() {

  const columns = [ 
    { key: "first_name", label: "STAGIAIRE" },
    { key: "intern_member_id", label: "IDENTIFIANT" },
    { key: "status", label: "AVANCÉE DU DOSSIER" },
    { key: "action", label: "ACTION" },
  ]
  const data = [

    { first_name: "Jeremie Chabanais", intern_member_id: 125242, status: "Aucune demande" },
    { first_name: "Saria Chabanais", intern_member_id: 125242, status: "Aucune demande" },
    { first_name: "Aziza Chabanais", intern_member_id: 125242, status: "Aucune demande" },
    { first_name: "Margot Chabanais", intern_member_id: 125242, status: "Aucune demande" },
    { first_name: "Mounir Chabanais", intern_member_id: 125242, status: "Aucune demande" },
    { first_name: "Amine Chabanais", intern_member_id: 125242, status: "Aucune demande" },
    { first_name: "Karim Chabanais", intern_member_id: 125242, status: "Aucune demande" },
    { first_name: "Koribirama Chabanais", intern_member_id: 125242, status: "Aucune demande" },

    // { id: 2, first_name: "Saria", last_name: "Chabanais", intern_member_id: 125242, status: "Stagiaire a initié la demande" },
    // { id: 3, first_name: "Aziza", last_name: "Chabanais", intern_member_id: 125242, status: "Transmis à l'administration" },
    // { id: 4, first_name: "Margot", last_name: "Chabanais", intern_member_id: 125242, status: "Aucune demande" },
    // { id: 5, first_name: "Arnaud", last_name: "Chabanais", intern_member_id: 125242, status: "Terminé" },
    // { id: 6, first_name: "Yves", last_name: "Dupont", intern_member_id: 125243, status: "En attente de validation" },
    // { id: 7, first_name: "Camille", last_name: "Durand", intern_member_id: 125244, status: "Terminé" },
    // { id: 8, first_name: "Paul", last_name: "Martin", intern_member_id: 125245, status: "Transmis à l'administration" },
  ]
  return (
    <div className="ml-4 w-5xl">
        <HeaderInternList/>
        <AppTable
          classNameTableTitle={"hidden"}  
          columns = {columns}
          data =  {data}
          numberItemsPerPage ={7}
        />
    </div>
  )
}

export default InternListContentOne