import React, { useState } from "react"
import TableHead from "./TableHead"
import TableBody from "./TableBody"
import PaginationTable from "./PaginationTable"
import SearchBarTable from "./SearchBarTable"
import Table from "./Table"

function AppTable({
  visibilitySearchBar, 
  visibilityPagination,
  columns = [
    { key: "id", label: "IDENTIFIANT" },
    { key: "first_name", label: "PRÉNOM" },
    { key: "last_name", label: "NOM" },
    { key: "intern_member_id", label: "ID STAGIAIRE" },
    { key: "status", label: "AVANCÉE DU DOSSIER" },
    { key: "action", label: "ACTION" },
  ], 
  data = [
    { id: 1, first_name: "Jeremie", last_name: "Chabanais", intern_member_id: 125242, status: "Aucune demande" },
    { id: 2, first_name: "Saria", last_name: "Chabanais", intern_member_id: 125242, status: "Stagiaire a initié la demande" },
    { id: 3, first_name: "Aziza", last_name: "Chabanais", intern_member_id: 125242, status: "Transmis à l'administration" },
    { id: 4, first_name: "Margot", last_name: "Chabanais", intern_member_id: 125242, status: "Aucune demande" },
    { id: 5, first_name: "Arnaud", last_name: "Chabanais", intern_member_id: 125242, status: "Terminé" },
    { id: 6, first_name: "Yves", last_name: "Dupont", intern_member_id: 125243, status: "En attente de validation" },
    { id: 7, first_name: "Camille", last_name: "Durand", intern_member_id: 125244, status: "Terminé" },
    { id: 8, first_name: "Paul", last_name: "Martin", intern_member_id: 125245, status: "Transmis à l'administration" },
  ],
  
}) 

{

  const [currentPage, setCurrentPage] = useState(1)
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

  const handleEdit = (id) => console.log(`Modifier l'élément ID : ${id}`)
  const handleDelete = (id) => console.log(`Supprimer l'élément ID : ${id}`)
  // const visibility = "visible"
  return (
    <div className="flex flex-col">
      <h3 className="text-lg font-semibold mb-4">Tableau avec recherche et pagination</h3>

      <div className="-m-1.5 overflow-x-auto">
        <div className="p-1.5 min-w-full inline-block align-middle">
          <div className="border border-gray-200 rounded-lg divide-y divide-gray-200 shadow-sm">

            <div className= {visibilitySearchBar}>
            {/* SearchBar */}
              <SearchBarTable 
                value={searchTerm} 
                onChange={setSearchTerm} 
                placeholder="Rechercher un stagiaire..." 
              />
            </div>


            {/* Table */}
            <Table
                data={data}
                columns={columns}
                currentPage={currentPage}
                itemsPerPage={itemsPerPage} 
                searchTerm={searchTerm}
                filteredData={filteredData}
                indexOfLastItem ={indexOfLastItem}
                currentItems={currentItems}
                handleEdit={handleEdit}
                handleDelete={handleDelete}
            />

            {/* Pagination */}
            <div className= {visibilityPagination}>  
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
    </div>
  )
}

export default AppTable
