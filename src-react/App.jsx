import { useEffect, useState } from "react";
import axios from "axios";
import Stepper from "./components/ui/stepper/Stepper";
import FicheStagiaire from "./pages/support_service/FicheStagiaire";
import AppTable from "./components/ui/Table/AppTable";
import CardFormation from './components/ui/CardFormation'
import Select from "./components/ui/Select";

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

    return <div className="">
        {/* <AppTable/> */}
        {/* <CardFormation/> */}
        <Select
            classNameSelect ={"hidden py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"}
        />
    </div>;
}
