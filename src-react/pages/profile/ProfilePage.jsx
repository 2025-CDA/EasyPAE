import React, { useState, useEffect } from "react";
import MainLayout from "../../components/layout/MainLayout";
import AProposPAEeasy from "../../components/profile/AProposPAEeasy";
import Container from "../../components/ui/Container";
import ModifPictureProfile from "../../components/profile/ModifPictureProfile";
import Confidentialite from "../../components/profile/Confidentialite";
import EditerProfile from "../../components/profile/EditerProfile";
import UpdateMdp from "../../components/profile/UpdateMdp";
import Preferences from "../../components/profile/Preferences";
import Avatar from "../../components/ui/Avatar";
import Button from "../../components/ui/Button";
import { User, Lock, Heart, DoorClosed, LogOut } from "lucide-react";
import useAxios from "../../hooks/useAxios";
import { useAuthContext } from "../../store/auth_context/authContext";
import { useNavigate } from "react-router";

function ProfilePage() {
    const { token, userData, getUser, loadingUser, signOut } = useAuthContext();
    const { fetchData } = useAxios();

    const [userInfo, setUserInfo] = useState(userData || {});
    const userId = userData.id;

    // 0 = Informations personnelles, 1 = Préférences, 2 = Plus d'informations
    const [activeBox, setActiveBox] = useState(0);

    // 0 = Menu, 1 = Editer le profil, 2 = Changer Mot de passe, 3 = Personnaliser Interface, 4 = A propos d'easyPAE, 5 = Politique de confidentialité
    const [mobileView, setMobileView] = useState(0);

    // Pour le titre dynamique
    const titles = [
        "Mon compte / Informations personnelles",
        "Mon compte / Préférences",
        "Mon compte / Plus d'informations",
    ];

    return (
        <MainLayout withSearchbar={false} withHeader={false}>
            <div className="hidden md:flex min-h-screen">
                {/* Contenu principal */}
                <div className="flex-1 pl-0 md:pl-0 ml-5 ">
                    <h1 className="font-semibold">Mon compte</h1>
                    <p className="text-secondary-text mb-15">
                        {titles[activeBox]}
                    </p>
                    <div className="flex gap-5 w-auto">
                        <div
                            style={{
                                width: "18rem",
                                minWidth: "18rem",
                                maxWidth: "18rem",
                            }}
                        >
                            <Container
                                className={`flex flex-col bg-[#f1eeee] mb-4 cursor-pointer ${
                                    activeBox === 0
                                        ? "border-2 border-blue-600"
                                        : "border-none"
                                }`}
                                onClick={() => setActiveBox(0)}
                            >
                                <h4 className="font-semibold">
                                    Informations personnelles
                                </h4>
                                <p className="text-secondary-text">
                                    Détails à propos de vos infos
                                </p>
                            </Container>
                            <Container
                                className={`flex flex-col bg-[#f1eeee] mb-4 cursor-pointer ${
                                    activeBox === 1
                                        ? "border-2 border-blue-600"
                                        : "border-none"
                                }`}
                                onClick={() => setActiveBox(1)}
                            >
                                <h4 className="font-semibold">Préférences</h4>
                                <p className="text-secondary-text">
                                    Personnalisez votre interface
                                </p>
                            </Container>
                            <Container
                                className={`flex flex-col bg-[#f1eeee] cursor-pointer ${
                                    activeBox === 2
                                        ? "border-2 border-blue-600"
                                        : "border-none"
                                }`}
                                onClick={() => setActiveBox(2)}
                            >
                                <h4 className="font-semibold">
                                    Plus d'informations
                                </h4>
                                <p className="text-secondary-text">
                                    Pour en savoir plus
                                </p>
                            </Container>
                        </div>
                        <div className="mr-5 flex-1 min-w-0">
                            {activeBox === 0 && (
                                <div className="h-full w-full">
                                    <ModifPictureProfile />
                                    <EditerProfile data={userInfo} />
                                    <UpdateMdp />
                                </div>
                            )}
                            {activeBox === 1 && (
                                <div className="h-full w-full">
                                    <Preferences />
                                </div>
                            )}
                            {activeBox === 2 && (
                                <>
                                    <AProposPAEeasy />
                                    <Confidentialite />
                                </>
                            )}
                        </div>
                    </div>
                </div>
            </div>
            <div className="md:hidden flex flex-col ">
                {mobileView === 0 && (
                    <>
                        <div className="flex flex-col items-center">
                            <h4 className="font-semibold mt-4 mb-2">
                                Mon compte
                            </h4>
                            <Avatar size={"md"} />
                            <p className="font-semibold text-sm">
                                {userInfo.FirstName}
                            </p>
                            <p className="text-secondary-text text-xs font-semibold">
                                {userInfo.email}
                            </p>
                        </div>
                        <div className="flex flex-col items-start">
                            <h4 className="mt-15 font-semibold ml-[12.5%]">
                                Informations personnelles
                            </h4>

                            <Button
                                onClick={() => setMobileView(1)}
                                className="w-[75%] bg-[#f2f2f2] border border-[#e0e0e0] px-4 py-2 text-primary-text ml-[12.5%] mt-2 mb-2"
                                color=""
                                icon={null}
                            >
                                <div className="flex w-full items-center justify-between">
                                    <span className="flex items-center gap-4">
                                        <User className="inline-block" />
                                        <span className="font-semibold">
                                            Editer mon profil
                                        </span>
                                    </span>
                                    <span>{">"}</span>
                                </div>
                            </Button>
                            <Button
                                onClick={() => setMobileView(2)}
                                className="w-[75%] bg-[#f2f2f2] border border-[#e0e0e0] px-4 py-2 text-primary-text ml-[12.5%] mt-2 mb-2"
                                color=""
                                icon={null}
                            >
                                <div className="flex w-full items-center justify-between">
                                    <span className="flex items-center gap-4">
                                        <Lock className="inline-block" />
                                        <span className="font-semibold">
                                            Changer de mot de passe
                                        </span>
                                    </span>
                                    <span>{">"}</span>
                                </div>
                            </Button>
                            <h4 className="mt-8 font-semibold ml-[12.5%]">
                                Préférences
                            </h4>
                            <Button
                                onClick={() => setMobileView(3)}
                                className="w-[75%] bg-[#f2f2f2] border border-[#e0e0e0] px-4 py-2 text-primary-text ml-[12.5%] mt-2 mb-2"
                                color=""
                                icon={null}
                            >
                                <div className="flex w-full items-center justify-between">
                                    <span className="flex items-center gap-4">
                                        <Heart className="inline-block" />
                                        <span className="font-semibold">
                                            Personnaliser mon interface
                                        </span>
                                    </span>
                                    <span>{">"}</span>
                                </div>
                            </Button>
                            <h4 className="mt-8 font-semibold ml-[12.5%]">
                                Plus d'informations
                            </h4>
                            <Button
                                onClick={() => setMobileView(4)}
                                className="w-[75%] bg-[#f2f2f2] border border-[#e0e0e0] px-4 py-2 text-primary-text ml-[12.5%] mt-2 mb-2"
                                color=""
                                icon={null}
                            >
                                <div className="flex w-full items-center justify-between">
                                    <span className="flex items-center gap-4">
                                        <User className="inline-block" />
                                        <span className="font-semibold">
                                            A propos d'easyPAE
                                        </span>
                                    </span>
                                    <span>{">"}</span>
                                </div>
                            </Button>
                            <Button
                                onClick={() => setMobileView(5)}
                                className="w-[75%] bg-[#f2f2f2] border border-[#e0e0e0] px-4 py-2 text-primary-text ml-[12.5%] mt-2 mb-2"
                                color=""
                                icon={null}
                            >
                                <div className="flex w-full items-center justify-between">
                                    <span className="flex items-center gap-4">
                                        <Lock className="inline-block" />
                                        <span className="font-semibold">
                                            Politique de confidentialité
                                        </span>
                                    </span>
                                    <span>{">"}</span>
                                </div>
                            </Button>

                            <Button
                                onClick={() => signOut()}
                                className="w-[75%] bg-red-400 border border-[#e0e0e0] px-4 py-2 text-primary-text ml-[12.5%] mt-20 mb-2"
                                color=""
                                icon={null}
                            >
                                <div className="flex w-full items-center justify-between">
                                    <span className="flex items-center gap-4">
                                        <LogOut className="inline-block" />
                                        <span className="font-semibold">
                                            Logout
                                        </span>
                                    </span>
                                    <span>{">"}</span>
                                </div>
                            </Button>
                        </div>
                    </>
                )}
                {mobileView === 1 && (
                    <>
                        <div className="flex items-center mb-20">
                            <Button
                                onClick={() => setMobileView(0)}
                                color=""
                                className={"text-primary-text"}
                            >
                                {"<"}
                            </Button>
                            <h4 className="font-semibold m-auto">
                                Informations personnelles
                            </h4>
                        </div>
                        <EditerProfile />
                    </>
                )}
                {mobileView === 2 && (
                    <>
                        <div className="flex items-center mb-20">
                            <Button
                                onClick={() => setMobileView(0)}
                                color=""
                                className={"text-primary-text"}
                            >
                                {"<"}
                            </Button>
                            <h4 className="font-semibold m-auto">
                                Changer de mot de passe
                            </h4>
                        </div>
                        <UpdateMdp />
                    </>
                )}
                {mobileView === 3 && (
                    <>
                        <div className="flex items-center mb-20">
                            <Button
                                onClick={() => setMobileView(0)}
                                color=""
                                className={"text-primary-text"}
                            >
                                {"<"}
                            </Button>
                            <h4 className="font-semibold m-auto">
                                Préférences
                            </h4>
                        </div>
                        <Preferences />
                    </>
                )}
                {mobileView === 4 && (
                    <>
                        <div className="flex items-center mb-20">
                            <Button
                                onClick={() => setMobileView(0)}
                                color=""
                                className={"text-primary-text"}
                            >
                                {"<"}
                            </Button>
                            <h4 className="font-semibold m-auto">
                                Plus d'infos
                            </h4>
                        </div>
                        <AProposPAEeasy />
                    </>
                )}
                {mobileView === 5 && (
                    <>
                        <div className="flex items-center mb-20">
                            <Button
                                onClick={() => setMobileView(0)}
                                color=""
                                className={"text-primary-text"}
                            >
                                {"<"}
                            </Button>
                            <h4 className="font-semibold m-auto">
                                Plus d'infos
                            </h4>
                        </div>
                        <Confidentialite />
                    </>
                )}
                {mobileView === 5 && (
                    <>
                        <div className="flex items-center mb-20">
                            <Button
                                onClick={() => setMobileView(0)}
                                color=""
                                className={"text-primary-text"}
                            >
                                {"<"}
                            </Button>
                            <h4 className="font-semibold m-auto">
                                Plus d'infos
                            </h4>
                        </div>
                        <Confidentialite />
                    </>
                )}
            </div>
        </MainLayout>
    );
}

export default ProfilePage;
