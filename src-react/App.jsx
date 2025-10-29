import { useEffect, useState } from "react";
import axios from "axios";
<<<<<<< HEAD
=======
import AssistantPage from "./pages/assistant/AssistantPage";
import AssistantFicheRenseignement from "./pages/assistant/AssistantFicheRenseignement";
import DemandePae from "./pages/assistant/DemandePae";
import CalendarSimpleGet from "./components/calendar/CalendarSimpleGET";
>>>>>>> 9e07849b403416f6818bbacf8da95fb839c39785

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

    return <div className="w-full">
<<<<<<< HEAD
=======
        {/* <AssistantPage /> */}
        {/* <AssistantFicheRenseignement /> */}
        <DemandePae /> 
        {/* <CalendarSimpleGet justToday={true} /> */}
>>>>>>> 9e07849b403416f6818bbacf8da95fb839c39785
    </div>;
}
