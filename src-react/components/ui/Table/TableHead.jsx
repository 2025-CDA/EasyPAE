import React from 'react'

function TableHead({columnsThead}) {
  // console.log(columnsThead)
  return (
    <thead className="bg-gray-50">
        <tr>
          {
            columnsThead.map((col, index)=> {
              return(
                <th 
                  key={index}
                  scope="col" 
                  className="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                    {col.label}
                </th>
              )
            })  
          }
            
        </tr>
    </thead> 
  )
}
export default TableHead