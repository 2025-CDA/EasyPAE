// import { useState } from "react";
// import CalendarSimpleGET from "./components/calendar/CalendarSimpleGET";
// import { useState } from 'react';
import DesktopSidebar from './components/layout/DesktopSidebar'
import MobileNavBar from './components/layout/MobileNavbar';
import AProposPAEeasy from './components/profile/AProposPAEeasy'
import Container from './components/ui/Container';
import Confidentialite from './components/profile/Confidentialite'
import Preferences from './components/profile/Preferences';
import Textarea from './components/ui/Textarea';
import Checkbox from './components/ui/RadioButtonsGroup';
// import axios from "axios";


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

    // const [Choice, setChoice] = useState(0);

    return (
        <div>
            {/* <CalendarSimpleGET
                dates={currentFormation}
                shrinkable={true} // optionnel, si vous ne souhaitez pas qu'il ait l'option rétractable, supprimer la ligne, pas besoin de la mettre en false
            /> */}
            <h1 className='font-semibold'>Mon compte</h1>
            <p className='text-secondary-text mb-15'>Mon compte / Informations personnelles</p>
            <div>
                <Container className={'flex flex-col bg-[#f1eeee]  border-none mb-4'}>
                    <h4 className='font-semibold'>Informations personnelles</h4>
                    <p className='text-secondary-text'>Détails à propos de vos infos</p>
                </Container>
                <Container className={'flex flex-col bg-[#f1eeee]  border-none mb-4'}>
                    <h4 className='font-semibold'>Préférences</h4>
                    <p className='text-secondary-text'>Personnalisez votre interface</p>
                </Container>
                <Container className={'flex flex-col bg-[#f1eeee]  border-none'}>
                    <h4 className='font-semibold'>Plus d'informations</h4>
                    <p className='text-secondary-text'>Pour en savoir plus</p>
                </Container>
            </div>
            <Preferences />
            <AProposPAEeasy/>
            <Confidentialite/>
            <DesktopSidebar></DesktopSidebar>
            <MobileNavBar></MobileNavBar>

        </div>
    );
}
