import React from "react";
import Table from "./ui/Table/Table";
export default function App() {
  const columns = [
    { header: "Nom", accessor: "name" },
    { header: "Âge", accessor: "age" },
    { header: "Adresse", accessor: "address" },
  ];

  const data = [
    { name: "Edward King", age: 16, address: "LA No. 1 Lake Park" },
    { name: "Jim Red", age: 45, address: "Melbourne No. 1 Lake Park" },
    { name: "Marie Dupont", age: 32, address: "Paris 7e" },
    { name: "Paul Laurent", age: 29, address: "Lyon" },
    { name: "Sophie Legrand", age: 40, address: "Toulouse" },
  ];

  const actions = [
    {
      label: "Modifier",
      color: "green",
      onClick: (row) => console.log("Modifier :", row),
    },
    {
      label: "Supprimer",
      color: "red",
      onClick: (row) => console.log("Supprimer :", row),
    },
  ];

  return (
    <div className="p-6">  
      <Table></Table>  
    </div>
  );
}
