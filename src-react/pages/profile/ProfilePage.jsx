import React, { useState } from 'react'
import DesktopSidebarProfile from '../../components/profile/DesktopSidebarProfile'
import MobileNavBar from '../../components/layout/MobileNavbar';
import AProposPAEeasy from '../../components/profile/AProposPAEeasy'
import Container from '../../components/ui/Container';
import ModifPictureProfile from '../../components/profile/ModifPictureProfile'
import Confidentialite from '../../components/profile/Confidentialite'
import EditerProfile from '../../components/profile/EditerProfile'
import UpdateMdp from '../../components/profile/UpdateMdp'
import Preferences from '../../components/profile/Preferences';
import Avatar from '../../components/ui/Avatar';
import Button from '../../components/ui/Button';
import { User, Lock, Heart } from 'lucide-react';

function ProfilePage() {
    // 0 = Informations personnelles, 1 = Préférences, 2 = Plus d'informations
    const [activeBox, setActiveBox] = useState(0);

    // Pour le titre dynamique
    const titles = [
        "Mon compte / Informations personnelles",
        "Mon compte / Préférences",
        "Mon compte / Plus d'informations"
    ];

    return (
        <div>
            <div className="hidden md:flex min-h-screen">
                {/* Sidebar fixée à gauche */}
                <DesktopSidebarProfile />
                {/* Contenu principal */}
                <div className="flex-1 pl-0 md:pl-0 ml-5 " >
                    <h1 className='font-semibold'>Mon compte</h1>
                    <p className='text-secondary-text mb-15'>{titles[activeBox]}</p>
                    <div className='flex gap-5 w-auto'>
                        <div style={{ width: "18rem", minWidth: "18rem", maxWidth: "18rem" }}>
                            <Container
                                className={`flex flex-col bg-[#f1eeee] mb-4 cursor-pointer ${activeBox === 0 ? "border-2 border-blue-600" : "border-none"}`}
                                onClick={() => setActiveBox(0)}
                            >
                                <h4 className='font-semibold'>Informations personnelles</h4>
                                <p className='text-secondary-text'>Détails à propos de vos infos</p>
                            </Container>
                            <Container
                                className={`flex flex-col bg-[#f1eeee] mb-4 cursor-pointer ${activeBox === 1 ? "border-2 border-blue-600" : "border-none"}`}
                                onClick={() => setActiveBox(1)}
                            >
                                <h4 className='font-semibold'>Préférences</h4>
                                <p className='text-secondary-text'>Personnalisez votre interface</p>
                            </Container>
                            <Container
                                className={`flex flex-col bg-[#f1eeee] cursor-pointer ${activeBox === 2 ? "border-2 border-blue-600" : "border-none"}`}
                                onClick={() => setActiveBox(2)}
                            >
                                <h4 className='font-semibold'>Plus d'informations</h4>
                                <p className='text-secondary-text'>Pour en savoir plus</p>
                            </Container>
                        </div>
                        <div className='mr-5 flex-1 min-w-0'>
                            {activeBox === 0 && (
                                <>
                                    <ModifPictureProfile/>
                                    <EditerProfile/>
                                    <UpdateMdp/>
                                </>
                            )}
                            {activeBox === 1 && (
                                <div className='h-full w-full'>
                                    <Preferences />
                                </div>
                            )}
                            {activeBox === 2 && (
                                <>
                                    <AProposPAEeasy/>
                                    <Confidentialite/>
                                </>
                            )}
                        </div>
                    </div>
                </div>
            </div>
            <div className="md:hidden flex flex-col ">
                <div>
                    <h4 className='font-semibold text-center mt-4 mb-2'>Mon compte</h4>
                    <div className="flex justify-center">
                        <Avatar size={20}/>
                    </div>
                </div>
                <div className='flex flex-col items-start'>
                    <h4 className='mt-5'>Informations personnelles</h4>
                    <Button color='#cfcfcf' icon={<User />} >Editer mon profil</Button>
                    <Button icon={<Lock />} >Changer de mot de passe</Button>
                    <h4>Préférences</h4>
                    <Button icon={<Heart />} >Personnaliser mon interface</Button>
                    <h4>Plus d'informations</h4>
                    <Button icon={<User />} >A propos d'easyPAE</Button>
                    <Button icon={<Lock />} >Politique de confidentialité</Button>
                </div>
                <MobileNavBar />
            </div>
        </div>
    )
}

export default ProfilePage
