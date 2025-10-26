import { useEffect, useState } from "react";
import axios from "axios";
import AppTable from './components/ui/Table/AppTable'
import Select from './components/ui/Select'

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


    return (
        <div>
            {/* <SuperAdminPage></SuperAdminPage> */}
            <AppTable
                // visibilitySearchBar={"hidden"}
                // visibilityPagination={"hidden"}
                // columns={columns}
                // data={data}
                // divAction={divAction}
                // editProps={editProps}
                // numberItemsPerPage={2}
                // classNameThead = {"bg-red-100 px-6 py-4 whitespace-nowrap text-sm font-medium text-red-800 dark:text-neutral-800"}
                // classNameTbody = {"divide-y divide-red-500 dark:divide-neutral-700"}
                // classNameTable = {"min-w-full divide-y divide-red-300"}
                // classNameTableTitle ={"text-lg text-red-500 font-extrabold mb-6 mt-4"}
                // textTableTitle = {"Les stagiaires et leurs informations"}
                // divButtonHeaderClassName= {"hidden flex flex-row justify-between items-center gap-4 mr-3"}
                // textButtonOneHeader={"EasyPae"}
                // textButtonTwoHeader={"NotEasyPae"}
                // buttonHeaderOneClassName={"py-1 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-red-600 text-red-600 hover:border-blue-500 hover:text-blue-500 focus:outline-hidden focus:border-blue-500 focus:text-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:border-blue-500 dark:text-blue-500 dark:hover:text-blue-400 dark:hover:border-blue-400"}

                // buttonHeaderTwoClassName ={"py-1 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"}

                // visibilityButtonOneHeader = {"hidden"}
                // visibilityButtonTwoHeader ={"hidden"}
                // placeholderTextSearchBar= {"Chercher formateur"}
                // classNameTdataBody ={"bg-red-100 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-800"}
                // classNameTdataHead ={"bg-blue-600 px-6 py-2 whitespace-nowrap text-sm font-medium text-white dark:text-neutral-800"}
                // classNameTdataAction={"bg-red-100 px-6 py-4 whitespace-nowrap text-sm font-medium text-red-800 dark:text-neutral-800"}

            />

        </div>
    );
}
