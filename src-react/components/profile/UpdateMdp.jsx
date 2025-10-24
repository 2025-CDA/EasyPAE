import React, { useState } from 'react'
import Container from '../ui/Container'

function UpdateMdp() {
    const [form, setForm] = useState({
        current: '',
        new: '',
        confirm: '',
    });

    const handleChange = (e) => {
        setForm({ ...form, [e.target.name]: e.target.value });
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        if (form.new !== form.confirm) {
            alert("Les nouveaux mots de passe ne correspondent pas !");
            return;
        }
        // TODO: Envoyer les données au backend ou les traiter ici
        alert('Mot de passe modifié !');
    };

    return (
        <Container className="flex-col w-full max-w-xl mb-5">
            <h4 className='text-primary font-semibold text-lg mb-4 text-center'>Modifier votre mot de passe</h4>
            <form className="flex flex-col gap-4" onSubmit={handleSubmit}>
                <div>
                    <label className="block text-sm font-medium mb-1" htmlFor="current">Mot de passe actuel</label>
                    <input
                        type="password"
                        id="current"
                        name="current"
                        value={form.current}
                        onChange={handleChange}
                        className="w-full border border-gray-300 rounded px-3 py-2"
                        required
                    />
                </div>
                <div>
                    <label className="block text-sm font-medium mb-1" htmlFor="new">Nouveau mot de passe</label>
                    <input
                        type="password"
                        id="new"
                        name="new"
                        value={form.new}
                        onChange={handleChange}
                        className="w-full border border-gray-300 rounded px-3 py-2"
                        required
                    />
                </div>
                <div>
                    <label className="block text-sm font-medium mb-1" htmlFor="confirm">Confirmer le nouveau mot de passe</label>
                    <input
                        type="password"
                        id="confirm"
                        name="confirm"
                        value={form.confirm}
                        onChange={handleChange}
                        className="w-full border border-gray-300 rounded px-3 py-2"
                        required
                    />
                </div>
                <button
                    type="submit"
                    className="mt-2 px-4 py-2 text-primary border border-primary rounded hover:bg-blue-700 hover:text-white transition"
                >
                    Enregistrer le nouveau mot de passe
                </button>
            </form>
        </Container>
    )
}

export default UpdateMdp
