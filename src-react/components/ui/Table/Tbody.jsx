import React from 'react'
import Trow from './Trow'

function Tbody({columnsTbody, dataInTbody, onEdit, onDelete}) {
  // console.log(columnsTbody) 
  // console.log(dataInTbody) 
  return ( 
    <tbody className="divide-y divide-gray-200">
        <Trow 
          trData={dataInTbody} 
          trColumns={columnsTbody}
          onEdit={onEdit}
          onDelete={onDelete}
        />
    </tbody>    
  )
}
export default Tbody
