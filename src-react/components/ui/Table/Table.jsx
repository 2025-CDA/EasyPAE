import React from "react"
import TableHead from "./TableHead"
import TableBody from "./TableBody"

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
    <div className={classNames.wrapper || "overflow-hidden"}>
      <table className={classNames.table || "min-w-full divide-y divide-gray-200"}>
        <TableHead columnsThead={columns} classNameThead={classNames.thead} />
        <TableBody
          dataInTbody={displayData}
          columnsTbody={columns}
          onEdit={handleEdit}
          onDelete={handleDelete}
          classNameTbody={classNames.tbody}
        />
      </table>
    </div>
  )
}

export default Table
