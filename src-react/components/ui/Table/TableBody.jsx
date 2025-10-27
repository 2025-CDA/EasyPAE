import React from "react"
import TableRow from "./TableRow"

function TableBody({columnsTbody, dataInTbody, onEdit, onDelete, classNameTbody, classNameTdataBody, classNameTdataAction, divAction }) {
   
  return ( 
    <tbody className = {classNameTbody || "divide-y divide-gray-200"}>
        <TableRow
          trData={dataInTbody} 
          trColumns={columnsTbody}
          onEdit={onEdit}
          onDelete={onDelete}
          divAction={divAction}
          classNameTdataBody={classNameTdataBody}
          classNameTdataAction={classNameTdataAction}
        />
    </tbody>    
  )
}

export default TableBody
