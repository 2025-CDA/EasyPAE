import React from 'react'
import { useState } from 'react'
import Label from '../ui/Label'
import Container from '../ui/Container'

function FormAddIntern({visibilityAddForm, onAddIntern}) {
    
    const [formData, setFormData] = useState({
        last_name: "",
        first_name: "",
        email:"",
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
      setFormData({ first_name: "", intern_member_id: "", status: "Aucune demande" }); // reset
    }
  };

  return (
    <div className= {visibilityAddForm ||"w-full w-full transition-all duration-1000 ease-in-out max-h-[700px] opacity-100 translate-y-0"}>
        {console.log(visibilityAddForm)}
        <Container>
            <form onSubmit={handleSubmit}  className=" flex flex-col w-full items-start gap-4">

                {/* Titre formulaire Ajout */}
                <Label
                    text= {"Nouveau stagiaire"}
                    weight={"semibold"}
                    size={"2xl"}
                    color={"primary-text"}
                />

                {/* Input et label pour nom */}
                <div className="space-y-3 w-full ">
                    <Label
                        text= {"Nom"}
                        weight={"semibold"}
                        size={"sm"}
                        color={"primary-text"}
                        labelFor={"last_name"}
                    />
                    <input type="text" 
                        className="py-2.5 sm:py-3 px-4 block w-full border-1 border-gray-200 outline-gray-200 rounded-lg sm:text-sm focus:border-secondary focus:ring-secondary disabled:opacity-50 placeholder:text-lg placeholder:font-semibold placeholder:text-secondary-text" placeholder="Nom*" 
                        name="last_name"
                        value = {formData.last_name}
                        onChange= {handleChange}
                    />
                    
                </div>

                {/* Input prenom */}
                 <div className="w-full space-y-3">
                    <Label
                        text= {"Prenom"}
                        weight={"semibold"}
                        size={"sm"}
                        color={"primary-text"}
                        labelFor={"first_name"}
                    />
                    <input 
                        type="text" 
                        className="py-2.5 sm:py-3 px-4 block w-full border-1 border-gray-200 outline-gray-200 rounded-lg sm:text-sm focus:border-secondary focus:ring-secondary disabled:opacity-50 placeholder:text-lg placeholder:font-semibold placeholder:text-secondary-text" placeholder="Prenom*" 
                        name="first_name"
                        value = {formData.first_name}
                        onChange= {handleChange}
                    />
                </div>
            
                {/* Input email */}
                 <div className="w-full space-y-3">
                    <Label
                        text= {"Adresse email"}
                        weight={"semibold"}
                        size={"sm"}
                        color={"primary-text"}
                        labelFor={"email"}
                    />
                    <input 
                        type="text" 
                        className="py-2.5 sm:py-3 px-4 block w-full border-1 border-gray-200 outline-gray-200 rounded-lg sm:text-sm focus:border-secondary focus:ring-secondary disabled:opacity-50 placeholder:text-lg placeholder:font-semibold placeholder:text-secondary-text" placeholder="Mail*"
                        name="email"
                        value = {formData.email}
                        onChange= {handleChange}
                    />
                </div>
                {/* Input N° de stagiaire */}

                <div className="w-full space-y-3">
                    <Label
                        text= {"N° de stagiaire"}
                        weight={"semibold"}
                        size={"sm"}
                        color={"primary-text"}
                        labelFor={"intern_member_id"}
                    />

                    <input 
                        type="text" 
                        className="py-2.5 sm:py-3 px-4 block w-full border-1 border-gray-200 outline-gray-200 rounded-lg sm:text-sm focus:border-secondary focus:ring-secondary disabled:opacity-50 placeholder:text-lg placeholder:font-semibold placeholder:text-secondary-text" placeholder="ID*" 
                        name="intern_member_id"
                        value = {formData.intern_member_id}
                        onChange= {handleChange}
                    />
                </div>
                <div className="space-y-3 w-full ">
                    <Label
                        text= {"Status de la demande"}
                        weight={"semibold"}
                        size={"sm"}
                        color={"primary-text"}
                        labelFor={"status"}
                    />
                    <select 
                        id="hs-select-label" 
                        className="py-2.5 sm:py-3 px-4 block w-full border-gray-200 outline-gray-200 rounded-lg sm:text-sm focus:border-secondary focus:ring-secondary disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        name="status"
                        value = {formData.status}
                        onChange= {handleChange}
                    >
                        {/* <option selected="">Avancée du dossier </option> */}
                        <option defaultValue >Aucune demande</option>
                        <option>Stagiaire a initié la demande</option>
                        <option>Transmis à l'administration</option>
                        <option>En attente de validation</option>
                        <option>Terminé</option>
                    </select>
                </div>

                {/* Bouton de soumission */}
                <button 
                    type="submit" 
                    className="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-lg font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                >
                    Envoyer l'invitation
                </button>
        
            </form>
        </Container>     
    </div>
  )
}

export default FormAddIntern