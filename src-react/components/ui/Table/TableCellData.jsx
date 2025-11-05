import React from "react"

function TableCellData({tdData, tdColumns, classNameTdataBody, ...props}) {

  return (
    <>
      {tdColumns.map((col, index) => {
        return (
          <td
            key={index}
            onClick={props.onClick}
            style={{ cursor: props.onClick ? "pointer" : "default" }}
            className={classNameTdataBody || "px-6 py-4 whitespace-nowrap text-sm text-gray-800"}
          >
            {tdData[col.key]}
          </td>
        )
      })}
    </>
  )
}

export default TableCellData
