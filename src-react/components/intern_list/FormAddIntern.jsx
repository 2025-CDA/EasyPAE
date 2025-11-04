import React from "react";
import { useState } from "react";
import Label from "../ui/Label";
import Container from "../ui/Container";
import Input from "../ui/Input";
import Button from "../ui/Button";

function FormAddIntern({ visibilityAddForm, onAddIntern }) {
    const [formData, setFormData] = useState({
        last_name: "",
        first_name: "",
        email: "",
        intern_member_id: "",
        status: "",
    });

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData((prev) => ({ ...prev, [name]: value }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        if (onAddIntern) {
            onAddIntern(formData);
            setFormData({
                first_name: "",
                intern_member_id: "",
                status: "Aucune demande",
            }); // reset
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

                <Input
                    type="text"
                    placeholder="Nom"
                    label="Nom"
                    required
                    name="last_name"
                    value={formData.last_name}
                    onChange={handleChange}
                />
                <Input
                    type="text"
                    placeholder="Prénom"
                    label="Prénom"
                    required
                    name="first_name"
                    value={formData.first_name}
                    onChange={handleChange}
                />
                <Input
                    type="text"
                    placeholder="Email"
                    label="Email"
                    required
                    name="email"
                    value={formData.email}
                    onChange={handleChange}
                />
                <Input
                    type="text"
                    placeholder="ID"
                    label="ID"
                    required
                    name="intern_member_id"
                    value={formData.intern_member_id}
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
