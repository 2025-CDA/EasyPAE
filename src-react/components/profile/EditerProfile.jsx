import React, { useEffect, useState } from 'react'
import Container from '../ui/Container'
import { useAuthContext } from '../../store/auth_context/authContext';
import useAxios from '../../hooks/useAxios';

function EditerProfile() {
    const { userData } = useAuthContext();
    const { fetchData } = useAxios();

    // Récupère l'id utilisateur depuis le contexte
    const userId = userData?.id;

    // State local pour l'édition du profil
    const [userInfo, setUserInfo] = useState({
        firstName: "",
        lastName: "",
        email: "",
        phone: "",
        address: "",
        birthday: "",
    });

    useEffect(() => {
        const getData = async () => {
            if (!userId) return;
            const res = await fetchData("GET", `account/${userId}/info`);
            if (res && res.data) {
                setUserInfo({
                    firstName: res.data.firstName ?? "",
                    lastName: res.data.lastName ?? "",
                    email: res.data.email ?? "",
                    phone: res.data.phone ?? "",
                    address: res.data.address ?? "",
                    birthday: res.data.birthday ?? "",
                });
            }
        };
        getData();
        // eslint-disable-next-line
    }, [userId]);

    const handleChange = (e) => {
        const { name, value } = e.target;
        let key = "";
        switch (name) {
            case "prenom":
                key = "firstName";
                break;
            case "nom":
                key = "lastName";
                break;
            case "email":
                key = "email";
                break;
            case "telephone":
                key = "phone";
                break;
            case "lieu":
                key = "address";
                break;
            case "naissance":
                key = "birthday";
                break;
            default:
                key = name;
        }
        setUserInfo({ ...userInfo, [key]: value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        if (!userId) return;
        // Envoie les données modifiées à l'API
        const res = await fetchData(
            "PATCH",
            `account/${userId}/info`,
            {
                firstName: userInfo.firstName,
                lastName: userInfo.lastName,
                email: userInfo.email,
                phone: userInfo.phone,
                address: userInfo.address,
                birthday: userInfo.birthday,
            }
        );
        if (res && res.status && res.status < 400) {
            alert('Informations enregistrées !');
        } else {
            alert('Erreur lors de la sauvegarde des informations.');
        }
    };

    return (
        <Container className="mb-5 flex flex-col border-transparent md:border-gray-200">
            <h4 className='text-primary font-semibold text-lg mb-4 text-center hidden md:flex'>Changer vos informations</h4>
            <form className="flex flex-col gap-4 w-[80%] m-auto md:w-full" onSubmit={handleSubmit}>
                <div className="flex gap-4">
                    <div className="flex-1">
                        <label className="block text-sm font-medium mb-1" htmlFor="prenom">Prénom</label>
                        <input
                            type="text"
                            id="prenom"
                            name="prenom"
                            value={userInfo.firstName}
                            onChange={handleChange}
                            className="w-full border border-gray-300 rounded px-3 py-2"
                            required
                        />
                    </div>
                    <div className="flex-1">
                        <label className="block text-sm font-medium mb-1" htmlFor="nom">Nom</label>
                        <input
                            type="text"
                            id="nom"
                            name="nom"
                            value={userInfo.lastName}
                            onChange={handleChange}
                            className="w-full border border-gray-300 rounded px-3 py-2"
                            required
                        />
                    </div>
                </div>
                <div>
                    <label className="block text-sm font-medium mb-1" htmlFor="email">Adresse mail</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value={userInfo.email}
                        onChange={handleChange}
                        className="w-full border border-gray-300 rounded px-3 py-2"
                        required
                    />
                </div>
                <div>
                    <label className="block text-sm font-medium mb-1" htmlFor="telephone">Téléphone</label>
                    <input
                        type="tel"
                        id="telephone"
                        name="telephone"
                        value={userInfo.phone}
                        onChange={handleChange}
                        className="w-full border border-gray-300 rounded px-3 py-2"
                        required
                    />
                </div>
                <div>
                    <label className="block text-sm font-medium mb-1" htmlFor="lieu">Lieu de résidence</label>
                    <input
                        type="text"
                        id="lieu"
                        name="lieu"
                        value={userInfo.address}
                        onChange={handleChange}
                        className="w-full border border-gray-300 rounded px-3 py-2"
                        required
                    />
                </div>
                <div>
                    <label className="block text-sm font-medium mb-1" htmlFor="naissance">Date de naissance</label>
                    <input
                        type="date"
                        id="naissance"
                        name="naissance"
                        value={
                            userInfo.birthday
                                ? userInfo.birthday.length === 10
                                    ? userInfo.birthday
                                    : userInfo.birthday.slice(0, 10)
                                : ""
                        }
                        onChange={handleChange}
                        className="w-full border border-gray-300 rounded px-3 py-2"
                        required
                    />
                </div>
                <button
                    type="submit"
                    className="
                        w-100 mx-auto
                        mt-2 px-4 py-2 rounded
                        md:text-primary md:border md:border-primary md:bg-transparent
                        md:hover:bg-blue-700 md:hover:text-white transition
                        text-white bg-blue-700
                        hover:bg-white hover:text-primary hover:border hover:border-primary"
                >
                    Enregistrer les modifications
                </button>
            </form>
        </Container>
    )
}

export default EditerProfile
