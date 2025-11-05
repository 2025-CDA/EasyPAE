import React from "react";
import { useState } from "react";
import Label from "../ui/Label";
import Container from "../ui/Container";
import Input from "../ui/Input";
import Button from "../ui/Button";
import { toast } from "react-toastify";
import useAxios from "../../hooks/useAxios";
import { useParams } from "react-router";


function FormAddIntern({ visibilityAddForm, onAddIntern }) {
    const { fetchData } = useAxios();
    const [formData, setFormData] = useState({
        internFirstName: "",
        internLastName: "",
        internEmail: "",
        internLogin: "",
    });

    const {id} = useParams();

        const handleChange = (e) => {
            
            setFormData({ ...formData, [e.target.id]: e.target.value });
        };
    
        const handleSubmit = async (e) => {
            e.preventDefault();
            console.log("test", formData);
            try {
                const res = await fetchData(
                    "POST",
                    `organization/session/${id}/intern`,
                    formData
                );
                console.log("🚀 ~ handleSubmit ~ res:", res)
                if (res.success == true) {
                    toast.success("Stagiaire ajouté avec succès !");
                } else {
                    toast.error("Erreur dans l'ajout du stagiaire");
                }
            } catch (err) {
                console.log("🚀 ~ handleSubmit ~ err:", err);
            }
        };

    return (
        <Container
            className={
                visibilityAddForm ||
                "w-full transition-all duration-1000 ease-in-out max-h-[700px] opacity-100 translate-y-0"
            }
        >
            <form
                onSubmit={handleSubmit}
                className=" flex flex-col w-full gap-4 p-2"
            >
                {/* Titre formulaire Ajout */}
                <Label
                    text={"Nouveau stagiaire"}
                    weight={"semibold"}
                    size={"2xl"}
                    color={"primary-text"}
                />

                <Input id="internLastName"
                    type="text"
                    placeholder="Nom"
                    label="Nom"
                    required
                    name="internLastName"
                    onChange={handleChange}
                />
                <Input
                    id="internFirstName"
                    type="text"
                    placeholder="Prénom"
                    label="Prénom"
                    required
                    name="internFirstName"
                    onChange={handleChange}
                />
                <Input
                    id="internEmail"
                    type="text"
                    placeholder="Email"
                    label="Email"
                    required
                    name="internEmail"
                    onChange={handleChange}
                />
                <Input
                    id="internLogin"
                    type="text"
                    placeholder="ID"
                    label="ID"
                    required
                    name="internLogin"
                    onChange={handleChange}
                />
                <div className="space-y-3 w-full ">
                    <Label
                        text={"Status de la demande"}
                        weight={"semibold"}
                        size={"sm"}
                        color={"primary-text"}
                        labelFor={"status"}
                    />
                    <select
                        className="w-full"
                        id="hs-select-label"
                        name="status"
                        value={formData.status}
                        onChange={handleChange}
                    >
                        {/* <option selected="">Avancée du dossier </option> */}
                        <option defaultValue>Aucune demande</option>
                        <option>Stagiaire a initié la demande</option>
                        <option>Transmis à l'administration</option>
                        <option>En attente de validation</option>
                        <option>Terminé</option>
                    </select>
                </div>

                {/* Bouton de soumission */}
                <Button type="submit">Envoyer l'invitation</Button>
            </form>
        </Container>
    );
}

export default FormAddIntern;
