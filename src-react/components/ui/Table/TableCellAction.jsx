import React from 'react'

function TableCellAction({ keyAction, divAction, onEdit, onDelete}) {
 const divActionDefault = ( <div className="flex gap-3 justify-start">
      <button
        type="button"
        className="text-blue-600 hover:text-blue-800 font-semibold"
        onClick={() => onEdit && onEdit(keyAction)}
      >
        Modifier
      </button>

      <button
        type="button"
        className="text-red-600 hover:text-red-800 font-semibold"
        onClick={() => onDelete && onDelete(keyAction)}
      >
        Supprimer
      </button>
    </div>)

    // S'il y a un props divAction dans App, on l'affiche sinon on affiche divActiondefault
    const displayAction =  divAction !== undefined ? divAction : divActionDefault
    // console.log(onDelete)
  return (
    displayAction
  )
}

export default TableCellAction
