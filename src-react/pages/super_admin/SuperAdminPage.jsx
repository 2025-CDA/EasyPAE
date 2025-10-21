import React from 'react'
import MainLayout from '../../components/layout/MainLayout'
import Avatar from '../../components/ui/Avatar'
import Badge from '../../components/ui/Badge'
import Checkbox from '../../components/ui/Checkbox' 
import Container from '../../components/ui/Container'
import Label from '../../components/ui/Label'

function SuperAdminPage() {
    const data = [
    { id: 1, first_name: "Jeremie", last_name: "Chabanais", intern_member_id: 125242, status: "Aucune demande" },
    { id: 2, first_name: "Saria", last_name: "Chabanais", intern_member_id: 125242, status: "Stagiaire a initié la demande" },
    { id: 3, first_name: "Aziza", last_name: "Chabanais", intern_member_id: 125242, status: "Transmis à l'administration" },
    
  ]
  return (
    <div className="flex flex-col">
        <MainLayout>
            <div className="flex flex-col">
            <Label
                text="Bonjour "
                
            />
            
            <Label
                text="Attribution des droits aux rôles"
            />
            <Container>
                <Avatar
                    size= "5"
                />
                <Label
                    text="Je suis un label"
                />
                <Label
                    text="Je suis un label"
                />
                <Checkbox></Checkbox>
                <Label
                    text="Je suis un label"
                />
            </Container>
            
            </div>
            
        </MainLayout>
    </div>
  )
}

export default SuperAdminPage
