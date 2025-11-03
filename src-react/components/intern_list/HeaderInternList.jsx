import React from 'react'
import Label from '../ui/Label'

function HeaderInternList() {
  return (
    <div className="flex flex-col gap-4 mb-4">
      {/* Titre de la page */}
      <Label
        text={"Liste stagiaire NOM FORMATION 1"}
        weight={"semibold"}
        size={"4xl"}
        color={"primary-text"}
      />

      {/* Barre d'évolution de la navigation */}
      <div className="flex flex-row gap-4">
        {/* <div className="flex flex-row justify-between items-center gap-4 mr-3"> */}
        <Label
        text={"Dashboard"}
        weight={"medium"}
        size={"sm"}
        color={"secondary-text"}
        />
        <Label
        text={">"}
        weight={"medium"}
        size={"sm"}
        color={"secondary-text"}
        />
        <Label
        text={"..."}
        weight={"medium"}
        size={"sm"}
        color={"secondary-text"}
        />
        <Label
        text={">"}
        weight={"medium"}
        size={"sm"}
        color={"secondary-text"}
        />
        <Label
        text={"Liste des stagiaires NOM FORMATION 1"}
        weight={"medium"}
        size={"sm"}
        color={"primary-text"}
        />
      </div>   
    </div>
  )
}

export default HeaderInternList