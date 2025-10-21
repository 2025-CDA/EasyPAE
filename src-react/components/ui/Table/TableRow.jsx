import React from 'react'
import TableCellData from './TableCellData'
import TableCellAction from './TableCellAction'

function TableRow({ trData, trColumns, onEdit, onDelete}) {

  // Vérifier si la colonne ayant comme key action existe dans la constante des colonnes
  const hasActionColumn = trColumns.some(col => col.key === "action")

  return (
    <>
      {trData.map((row, index) => (
        <tr key={index}>

          {/* On affiche d'abord les colonnes sans la colonne Action*/}

          <TableCellData 
            tdData={row} 
            tdColumns={trColumns.filter(col => col.key !== "action")} 
          />

          {/* Ensuite, si une colonne "action" existe, on affiche la cellule des boutons */}

          {
            hasActionColumn && (
              <td className="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                <TableCellAction 
                  keyAction={row.id} 
                  onEdit={onEdit} 
                  onDelete={onDelete}
                />
              </td>
            )
          }
        </tr>
      ))}
    </>
  )
}

export default TableRow
