import React from "react"
import TableHead from "./TableHead"
import TableBody from "./TableBody"

// NB: Vous appelez ce composant Table que si vous voulez utiliser le tableau seule sans la pagination et la searchbar. Si vous voulez utiliser les trois fonctionnalités vous appelerez plutot le composant AppTable et ce composant Table sera utilisé automatiquement 
function Table({
  columns = [
    { key: "id", label: "ID" },
    { key: "name", label: "Nom" },
  ],
  data = [
    { id: 1, name: "Exemple 1" },
    { id: 2, name: "Exemple 2" },
    { id: 2, name: "Exemple 2" },
  ],
  currentItems,
  handleEdit,
  handleDelete,
  classNames = {},
}) {
  const displayData = currentItems && currentItems.length > 0 ? currentItems : data

  return (
    <div className={classNames.wrapper || "overflow-hidden"}>
      <table className={classNames.table || "min-w-full divide-y divide-gray-200"}>
        <TableHead columnsThead={columns} classNameThead={classNames.thead} />
        <TableBody
          dataInTbody={displayData}
          columnsTbody={columns}
          onEdit={handleEdit}
          onDelete={handleDelete}
          classNameTbody={classNames.tbody}
        />
      </table>
    </div>
  )
}

export default Table
