import React, { useState } from "react";
import Container from "../ui/Container";
import useAxios from "../../hooks/useAxios";
import { useAuthContext } from "../../store/auth_context/authContext";
import { toast } from "react-toastify";
import Input from "../ui/Input";

function UpdateMdp() {
    const { userData } = useAuthContext();
    const { fetchData } = useAxios();
    const userId = userData.id;

    const [form, setForm] = useState({
        plainPassword: "",
        resetPassword: "",
        resetPasswordAgain: "",
    });
    const handleChange = (e) => {
        console.log("🚀 ~ handleChange ~ e:", e);

        setForm({ ...form, [e.target.id]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        console.log("test", form);
        try {
            const res = await fetchData(
                "PATCH",
                `account/${userId}/password`,
                form
            );
            if (res.success == true) {
                toast.success("Mot de passe modifié !");
            } else {
                toast.error("Mot de passe incorrect !");
            }
        } catch (err) {
            console.log("🚀 ~ handleSubmit ~ err:", err);
        }
    };

    return (
        <Container className="mb-5 flex flex-col border-transparent md:border-gray-200">
            <h4 className="text-primary font-semibold text-lg mb-4 text-center hidden md:flex">
                Modifier votre mot de passe
            </h4>
            <form
                className="flex flex-col gap-4 w-[80%] m-auto md:w-full"
                onSubmit={handleSubmit}
            >
                <Input
                    type="password"
                    id="plainPassword"
                    name="plainPassword"
                    label="Mot de passe actuel"
                    onChange={handleChange}
                    className="w-full border border-gray-300 rounded px-3 py-2"
                    required
                    placeholder={false}
                    withShowPassword
                />
                <Input
                    type="password"
                    id="resetPassword"
                    name="resetPassword"
                    label="Nouveau mot de passe"
                    onChange={handleChange}
                    className="w-full border border-gray-300 rounded px-3 py-2"
                    required
                    placeholder={false}
                    withShowPassword
                />
                <Input
                    type="password"
                    id="resetPasswordAgain"
                    name="resetPasswordAgain"
                    label="Confirmer le nouveau mot de passe"
                    onChange={handleChange}
                    className="w-full border border-gray-300 rounded px-3 py-2"
                    required
                    placeholder={false}
                    withShowPassword
                />
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
                    Enregistrer le nouveau mot de passe
                </button>
            </form>
        </Container>
    );
}

export default UpdateMdp;
