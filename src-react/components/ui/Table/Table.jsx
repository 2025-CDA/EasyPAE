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

  console.log(data)
  const displayData = currentItems && currentItems.length > 0 ? currentItems : data
  
  return (
    
    <div className="overflow-hidden">
      <table className="min-w-full divide-y divide-gray-200">
        <TableHead columnsThead={columns} />
        <TableBody
          dataInTbody={displayData}
          columnsTbody={columns}
          onEdit={handleEdit}
          onDelete={handleDelete}
        />
      </table>
    </div>
  )
}

export default Table
