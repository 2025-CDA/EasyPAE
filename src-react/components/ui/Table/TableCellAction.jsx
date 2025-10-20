import React from 'react'

function TableCellAction({ keyAction, onEdit, onDelete}) {
  return (
    <div className="flex gap-3 justify-end">
      <button
        type="button"
        className="text-blue-600 hover:text-blue-800 font-semibold"
        onClick={() => onEdit(keyAction)}
      >
        Modifier
      </button>

      <button
        type="button"
        className="text-red-600 hover:text-red-800 font-semibold"
        onClick={() => onDelete(keyAction)}
      >
        Supprimer
      </button>
    </div>
  )
}

export default TableCellAction
