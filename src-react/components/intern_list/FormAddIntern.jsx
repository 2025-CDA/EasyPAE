import React from 'react'
import Input from '../ui/Input'
import Label from '../ui/Label'
import Container from '../ui/Container'

function FormAddIntern({visibilityAddForm}) {
  return (
    <div className= {visibilityAddForm ||"w-full"}>
        <Container>
            <div className=" flex flex-col w-full items-start gap-4">

                {/* Titre formulaire Ajout */}
                <Label
                    text= {"Nouveau stagiaire"}
                    weight={"semibold"}
                    size={"2xl"}
                    color={"primary-text"}
                />

                {/* Input nom */}
                <div className="space-y-3 w-full ">
                    <Label
                        text= {"Nom"}
                        weight={"semibold"}
                        size={"sm"}
                        color={"primary-text"}
                        labelFor={"last_name"}
                    />
                    <input type="text" className="py-2.5 sm:py-3 px-4 block w-full border-1 border-gray-200 outline-gray-200 rounded-lg sm:text-sm focus:border-secondary focus:ring-secondary disabled:opacity-50 placeholder:text-lg placeholder:font-semibold placeholder:text-secondary-text" placeholder="Nom*" />
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
                    <input type="text" className="py-2.5 sm:py-3 px-4 block w-full border-1 border-gray-200 outline-gray-200 rounded-lg sm:text-sm focus:border-secondary focus:ring-secondary disabled:opacity-50 placeholder:text-lg placeholder:font-semibold placeholder:text-secondary-text" placeholder="Prenom*" />
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
                    <input type="text" className="py-2.5 sm:py-3 px-4 block w-full border-1 border-gray-200 outline-gray-200 rounded-lg sm:text-sm focus:border-secondary focus:ring-secondary disabled:opacity-50 placeholder:text-lg placeholder:font-semibold placeholder:text-secondary-text" placeholder="Mail*" />
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
                    <input type="text" className="py-2.5 sm:py-3 px-4 block w-full border-1 border-gray-200 outline-gray-200 rounded-lg sm:text-sm focus:border-secondary focus:ring-secondary disabled:opacity-50 placeholder:text-lg placeholder:font-semibold placeholder:text-secondary-text" placeholder="ID*" />
                </div>

                {/* Bouton de soumission */}
                <button type="button" className="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-lg font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    Envoyer l'invitation
                </button>
        
            </div>
            
        </Container>     
    </div>
  )
}

export default FormAddIntern