import React from 'react'
import TableRow from './TableRow'

function TableBody({columnsTbody, dataInTbody, onEdit, onDelete}) {
  // console.log(columnsTbody) 
  // console.log(dataInTbody) 
  return ( 
    <tbody className="divide-y divide-gray-200">
        <TableRow
          trData={dataInTbody} 
          trColumns={columnsTbody}
          onEdit={onEdit}
          onDelete={onDelete}
        />
    </tbody>    
  )
}
export default TableBody
