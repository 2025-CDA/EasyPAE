import { useEffect, useState } from "react";
import axios from "axios";
import Label from "./ui/Label";
import { LogIn , Mail, LockKeyhole, MoveRight } from "lucide-react";
import LoginForm from './ui/LoginForm';

export default function App() {
    const [showAlert, setShowAlert] = useState(true);

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

    return <div>
        <LoginForm initialStep='login'/>
    </div>;
}

