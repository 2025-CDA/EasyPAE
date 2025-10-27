<<<<<<< HEAD
// import { useState } from "react";
// import CalendarSimpleGET from "./components/calendar/CalendarSimpleGET";
// import { useState } from 'react';

import Textarea from './components/ui/Textarea';
import Checkbox from './components/ui/RadioButtonsGroup';
import ProfilePage from './pages/profile/ProfilePage';
// import axios from "axios";
=======
import { useEffect, useState } from "react";
import axios from "axios";
import Stepper from "./components/ui/stepper/Stepper";
import FicheStagiaire from "./pages/support_service/FicheStagiaire";
>>>>>>> origin


export default function App() {
    // const [showAlert, setShowAlert] = useState(true);

    // const [currentFormation] = useState({
    //     periodStart: new Date(2026, 0, 5),  // 5 janvier 2026
    //     periodEnd: new Date(2026, 2, 27),   // 27 mars 2026
    // });
    // useEffect(() => {
    //     // const fetchData = async () => {
    //     //     try {
    //     //         // Await the response from the GET request
    //     //         const response = await axios.get("http://127.0.0.1:8000/");
    //     //         // Access the data directly from response.data
    //     //         setData(response.data);
    //     //     } catch (error) {
    //     //         // This single block catches both network errors and bad HTTP statuses (like 404 or 500)
    //     //         console.error("Failed to fetch data:", error);
    //     //     }
    //     // };
    //     // fetchData();
    // }, []);

    // console.log(data[0])

<<<<<<< HEAD
    // const [Choice, setChoice] = useState(0);

    return (
        <div>
            {/* <CalendarSimpleGET
                dates={currentFormation}
                shrinkable={true} // optionnel, si vous ne souhaitez pas qu'il ait l'option rétractable, supprimer la ligne, pas besoin de la mettre en false
            /> */}
            <ProfilePage></ProfilePage>
        </div>
    );
=======
    return <div className="w-full"></div>;
>>>>>>> origin
}
