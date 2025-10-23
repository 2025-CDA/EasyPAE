import React, { useState } from "react"
import Table from "./Table"
import SearchBarTable from "./SearchBarTable"
import PaginationTable from "./PaginationTable"

// Vous appelez ce composant AppTable que si vous voulez utilisez à la fois la searchbar, la pagination et le tableau. si vous voulez juste utiliser le tableau appelez plutot que le composant Table seule
function AppTable() {

  // Le tableau columns correspond aux titres de vos colonnes (thead) vous pouvez le modifier à votre guise.

  // Vous n'ajouterez la dernière colonne action que si vous voulez utiliser une colonne d'action ou d'autres données de cellule qui ne sont pas dans la constante data juste en bas

  
  const columns = [
    { key: "id", label: "IDENTIFIANT" },
    { key: "first_name", label: "PRÉNOM" },
    { key: "last_name", label: "NOM" },
    { key: "intern_member_id", label: "ID STAGIAIRE" },
    { key: "status", label: "AVANCÉE DU DOSSIER" },
    { key: "action", label: "ACTION" },
  ]

  // Ce tableau correspond 
  const data = [
    { id: 1, first_name: "Jeremie", last_name: "Chabanais", intern_member_id: 125242, status: "Aucune demande" },
    { id: 2, first_name: "Saria", last_name: "Dupont", intern_member_id: 125243, status: "Demande initiée" },
    { id: 3, first_name: "Aziza", last_name: "Martin", intern_member_id: 125244, status: "Transmis à l'administration" },
    { id: 4, first_name: "Margot", last_name: "Legrand", intern_member_id: 125245, status: "Aucune demande" },
    { id: 5, first_name: "Arnaud", last_name: "Petit", intern_member_id: 125246, status: "Terminé" },
  ]

  const [currentPage, setCurrentPage] = useState(1)
  //Le chiffre qu'on met dans le useState correspond au nombre d'items par page
  const [itemsPerPage] = useState(3)
  const [searchTerm, setSearchTerm] = useState("")

  // Filtrage des données selon la recherche
  const filteredData = data.filter((item) =>
    Object.values(item)
      .join(" ")
      .toLowerCase()
      .includes(searchTerm.toLowerCase())
  )

  // Pagination après filtrage
  const indexOfLastItem = currentPage * itemsPerPage
  const indexOfFirstItem = indexOfLastItem - itemsPerPage
  const currentItems = filteredData.slice(indexOfFirstItem, indexOfLastItem)

  //Vous pouvez changer ici la logique qui sera appliquée dans vos bouttons d'action
  const handleEdit = (id) => console.log(`Modifier l'élément ID : ${id}`)
  const handleDelete = (id) => console.log(`Supprimer l'élément ID : ${id}`)

  return (
    <div className="flex flex-col">
      <div className="-m-1.5 overflow-x-auto">
        <div className="p-1.5 min-w-full inline-block align-middle">
          <div className="border border-gray-200 rounded-lg divide-y divide-gray-200 shadow-sm">
            <SearchBarTable
              value={searchTerm}
              onChange={setSearchTerm}
              placeholder="Rechercher un stagiaire..."
            />
            <Table
              columns={columns}
              data={data}
              currentItems={currentItems}
              handleEdit={handleEdit}
              handleDelete={handleDelete}
            />
            <PaginationTable
              totalItems={filteredData.length}
              itemsPerPage={itemsPerPage}
              currentPage={currentPage}
              onPageChange={setCurrentPage}
            />
          </div>
        </div>
      </div>
    </div>
  )
}

export default AppTable
