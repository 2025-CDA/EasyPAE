import React from "react"
import TableCellData from "./TableCellData"
import TableCellAction from "./TableCellAction"

function TableRow({ trData, trColumns, onEdit, onDelete }) {
  const hasActionColumn = trColumns.some((col) => col.key === "action")

  return (
    <>
      {trData.map((row, index) => (
        <tr key={index}>
          <TableCellData tdData={row} tdColumns={trColumns.filter((col) => col.key !== "action")} />
          {hasActionColumn && (
            <td className="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
              <TableCellAction keyAction={row.id} onEdit={onEdit} onDelete={onDelete} />
            </td>
          )}
        </tr>
      ))}
    </>
  )
}

export default TableRow
