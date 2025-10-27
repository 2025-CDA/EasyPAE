import React from 'react'
import Container from '../../components/ui/Container'
import Label from '../../components/ui/Label'
import CardSuperAdmin from './CardSuperAdmin'
import CheckboxSuperAdmin from './CheckboxSuperAdmin'

function SuperAdminContent() {
  
  return (
    <div>
      {/* Titre */}
      <div className="titlePage">     
        <Label
            text="Attribution des droits aux rôles"
            size="3xl"
            weight="bold"
            color ="primary-text"
        />
      </div> 

      {/* Carte des roles */}
      <div className="RoleCardSuperAdmin">
        <Container>
            <CardSuperAdmin
              cardRole={"Formateur"}
            />
            <CheckboxSuperAdmin
              cardRole={"Formateur"}
            />
        </Container>

        <Container>
            <CardSuperAdmin
              cardRole={"Responsable de formation"}
            />
            <CheckboxSuperAdmin/>
        </Container>

        <Container>
            <CardSuperAdmin
              cardRole={"Direction"}
            />
            <CheckboxSuperAdmin/>
        </Container>
    </div>
            
            
    </div>
  )
}

export default SuperAdminContent
