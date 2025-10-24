import React from 'react'
import Checkbox from '../../components/ui/Checkbox' 

function CheckboxSuperAdmin({cardRole}) {
    
  return (
    <div className="CheckboxSuperAdmin">
        <Checkbox
            label={"Ajouter, modifier ou supprimer un stagiaire"}
            sizeLabel={"base"}
        />
        <Checkbox
            label={"Ajouter, modifier ou supprimer une formation"}
            sizeLabel={"base"}
        />
        <Checkbox
            label={"Ajouter, modifier ou supprimer une période de stage"}
            sizeLabel={"base"}
        />
        <Checkbox
            label={"Mettre en stand-by une fiche de renseignement"}
            sizeLabel={"base"}
        />
        {
            cardRole && (
                <Checkbox
                    label={"Definir et modifier les missions de stage"}
                    sizeLabel={"base"}
                />
            )
        }   
    </div>
  )
}

export default CheckboxSuperAdmin