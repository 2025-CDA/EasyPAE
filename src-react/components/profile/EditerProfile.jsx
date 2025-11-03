import { useState, useEffect } from "react";
import Container from "../ui/Container";
import useAxios from "../../hooks/useAxios";
import { useAuthContext } from "../../store/auth_context/authContext";

function EditerProfile() {
    const { userData } = useAuthContext();
    const userId = userData.id;
    const { fetchData } = useAxios();

    const [form, setForm] = useState({});

    useEffect(() => {
        const getData = async () => {
            const res = await fetchData("GET", `account/${userId}/info`);
            setForm(res.data);
        };
        getData();
    }, []);

    const handleChange = (e) => {
        setForm({ ...form, [e.target.name]: e.target.value });
    };


    const handleSubmit = async (e) => {
        e.preventDefault();
        await fetchData("PATCH", `account/${userId}/info`, {
            firstName: form.firstName,
            lastName: form.lastName,
            avatar: form.avatar,
            email: form.email,
            phone: form.phone,
            address: form.address,
            birthday: form.birthday,
        });
        alert("Informations enregistrées !");
    };

    return (
        <Container className="mb-5 flex flex-col border-transparent md:border-gray-200">
            <h4 className="text-primary font-semibold text-lg mb-4 text-center hidden md:flex">
                Changer vos informations
            </h4>
            <form
                className="flex flex-col gap-4 w-[80%] m-auto md:w-full"
                onSubmit={handleSubmit}
            >
                <div className="flex gap-4">
                    <div className="flex-1">
                        <label
                            className="block text-sm font-medium mb-1"
                            htmlFor="firstName"
                        >
                            Prénom
                        </label>
                        <input
                            type="text"
                            id="firstName"
                            name="firstName"
                            value={form.firstName}
                            onChange={handleChange}
                            className="w-full border border-gray-300 rounded px-3 py-2"
                            required
                        />
                    </div>
                    <div className="flex-1">
                        <label
                            className="block text-sm font-medium mb-1"
                            htmlFor="lastName"
                        >
                            Nom de famille
                        </label>
                        <input
                            type="text"
                            id="lastName"
                            name="lastName"
                            value={form.lastName}
                            onChange={handleChange}
                            className="w-full border border-gray-300 rounded px-3 py-2"
                            required
                        />
                    </div>
                </div>
                <div>
                    <label
                        className="block text-sm font-medium mb-1"
                        htmlFor="email"
                    >
                        Adresse email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value={form.email}
                        onChange={handleChange}
                        className="w-full border border-gray-300 rounded px-3 py-2"
                        required
                    />
                </div>
                <div>
                    <label
                        className="block text-sm font-medium mb-1"
                        htmlFor="phone"
                    >
                        Téléphone
                    </label>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value={form.phone}
                        onChange={handleChange}
                        className="w-full border border-gray-300 rounded px-3 py-2"
                        required
                    />
                </div>
                <div>
                    <label
                        className="block text-sm font-medium mb-1"
                        htmlFor="address"
                    >
                        Adresse de résidence
                    </label>
                    <input
                        type="text"
                        id="address"
                        name="address"
                        value={form.address}
                        onChange={handleChange}
                        className="w-full border border-gray-300 rounded px-3 py-2"
                        required
                    />
                </div>
                <div>
                    <label
                        className="block text-sm font-medium mb-1"
                        htmlFor="birthday"
                    >
                        Date de naissance
                    </label>
                    <input
                        type="date"
                        id="birthday"
                        name="birthday"
                        value={form.birthday}
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
    );
}

export default EditerProfile;
