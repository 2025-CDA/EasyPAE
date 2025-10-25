import { useEffect, useState } from "react";
import axios from "axios";
import Stepper from "./components/ui/stepper/Stepper";
import FicheStagiaire from "./pages/support_service/FicheStagiaire";

import AppTable from './components/ui/Table/AppTable'
import Table from './components/ui/Table/Table'

export default function App() {
    // const [showAlert, setShowAlert] = useState(true);

    useEffect(() => {
        // const fetchData = async () => {
        //     try {
        //         // Await the response from the GET request
        //         const response = await axios.get("http://127.0.0.1:8000/");
        //         // Access the data directly from response.data
        //         setData(response.data);
        //     } catch (error) {
        //         // This single block catches both network errors and bad HTTP statuses (like 404 or 500)
        //         console.error("Failed to fetch data:", error);
        //     }
        // };
        // fetchData();
    }, []);

    // console.log(data[0])

    const columns = [
    { key: "id", label: "IDENTIFIANT" },
    { key: "first_name", label: "PRÉNOM" },
    { key: "last_name", label: "NOM" },
    { key: "intern_member_id", label: "ID STAGIAIRE" },
    { key: "status", label: "AVANCÉE DU DOSSIER" },
    { key: "action", label: "ACTION" },
  ] 

  // Ce tableau correspond 
  const [data, setData] = useState([
    { id: 1, first_name: "Jeremie", last_name: "Chabanais", intern_member_id: 125242, status: "Aucune demande" },
    { id: 2, first_name: "Saria", last_name: "Dupont", intern_member_id: 125243, status: "Demande initiée" },
    { id: 3, first_name: "Aziza", last_name: "Martin", intern_member_id: 125244, status: "Transmis à l'administration" },
    { id: 4, first_name: "Margot", last_name: "Legrand", intern_member_id: 125245, status: "Aucune demande" },
    { id: 5, first_name: "Arnaud", last_name: "Petit", intern_member_id: 125246, status: "Terminé" },
  ])

  const editProps = (id) => alert(`Modifier l'élément ID : ${id}`)
   
  const divAction = (<p>Action</p>)
  const visibilitySearchBar = "visible"
  const visibilityPagination = "visible "
    return (
        <div>
            <SuperAdminPage></SuperAdminPage>
            <AppTable
                
                visibilitySearchBar={visibilitySearchBar}
                visibilityPagination={visibilityPagination}
                // columns={columns}
                // data={data}
                // divAction={divAction}
                // editProps={editProps}
                // classNameThead = {"bg-blue-100"}
                // classNameTbody = {"divide-y divide-red-500 dark:divide-neutral-700"}
                // classNameTable = {"min-w-full divide-y divide-red-300"}
                // classNameTdataBody ={"bg-red-100 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-800"}
                // classNameTdataHead ={"bg-red-100 px-6 py-4 whitespace-nowrap text-sm font-medium text-red-800 dark:text-neutral-800"}
                // classNameTdataAction={"bg-red-100 px-6 py-4 whitespace-nowrap text-sm font-medium text-red-800 dark:text-neutral-800"}

            />

            {/* <Table
                data={data}
                columns={columns}
            /> */}
        </div>
    );
}
