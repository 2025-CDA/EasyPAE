import React, { useState } from 'react'
import Container from '../ui/Container'

function EditerProfile() {
    const [form, setForm] = useState({
        nom: 'Martin',
        prenom: 'Jean',
        email: 'jeanmartin@gmail.com',
        telephone: '0770707070',
        lieu: '31 rue du poulet 33600 Pessac',
        naissance: '1995-01-20',
    });

    const handleChange = (e) => {
        setForm({ ...form, [e.target.name]: e.target.value });
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        // TODO: Envoyer les données au backend ou les traiter ici
        alert('Informations enregistrées !');
    };

    return (
        <Container className="flex-col w-full max-w-xl mb-5">
            <h4 className='text-primary font-semibold text-lg mb-4 text-center'>Changer vos informations</h4>
            <form className="flex flex-col gap-4" onSubmit={handleSubmit}>
                <div className="flex gap-4">
                    <div className="flex-1">
                        <label className="block text-sm font-medium mb-1" htmlFor="prenom">Prénom</label>
                        <input
                            type="text"
                            id="prenom"
                            name="prenom"
                            value={form.prenom}
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
                            value={form.nom}
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
                        value={form.email}
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
                        value={form.telephone}
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
                        value={form.lieu}
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
                        value={form.naissance}
                        onChange={handleChange}
                        className="w-full border border-gray-300 rounded px-3 py-2"
                        required
                    />
                </div>
                <button
                    type="submit"
                    className="mt-2 px-4 py-2 border-primary border justify-center text-primary rounded hover:bg-blue-700 hover:text-white transition"
                >
                    Enregistrer les modifications
                </button>
            </form>
        </Container>
    )
}

export default EditerProfile
