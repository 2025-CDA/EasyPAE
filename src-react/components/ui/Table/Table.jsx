import React, { useState } from "react"
import TableHead from "./TableHead"
import TableBody from "./TableBody"
import PaginationTable from "./PaginationTable"
import SearchBarTable from "./SearchBarTable"

function Table(
    {
      columns, 
      data, 
      currentItems, 
      handleEdit,  
      handleDelete,
      // currentPage, 
      // itemsPerPage, 
      // searchTerm, 
      // filteredData, 
      // indexOfLastItem, 
    }
  ) {
// console.log(indexOfLastItem)
  return (
    
    <div className="overflow-hidden">
      <table className="min-w-full divide-y divide-gray-200">
        <TableHead columnsThead={columns} />
        <TableBody
          dataInTbody={currentItems}
          columnsTbody={columns}
          onEdit={handleEdit}
          onDelete={handleDelete}
        />
      </table>
    </div>
  )
}

export default Table
