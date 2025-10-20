import React from 'react'

function TableCellData({tdData, tdColumns}) {
    // console.log(tdData)
    // console.log(tdColumns)
  return (
    <>
      {tdColumns.map((col, index) => {
        return (
          <td   
            key={index} 
            className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
          >
            {tdData[col.key]}
          </td> 
        )
      })}
    </>

  )
}
export default TableCellData