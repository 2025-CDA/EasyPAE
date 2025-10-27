import React from 'react'
import MainLayout from '../../components/layout/MainLayout'
import Avatar from '../../components/ui/Avatar'
import Badge from '../../components/ui/Badge'
import Checkbox from '../../components/ui/Checkbox' 
import Container from '../../components/ui/Container'
import Label from '../../components/ui/Label'

function CardSuperAdmin({cardRole}) {
    
  return (
    <div className="CardSuperAdmin">
        <div className="AvatarSuperAdminPage">
            <Avatar
                size= ""
                color="#9055F5"
            />
        </div>

        <div className="TextCardSuperAdmin">
            <Label
                text="Prénom Nom"
                size="xl"
                weight="semibold"
                color ="primary-text"
            />
            <Label
                text={cardRole}
                size="base"
                color ="secondary-text"
            />
        </div>
    </div>
  )
}

export default CardSuperAdmin