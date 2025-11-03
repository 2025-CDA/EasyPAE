import React, { Children } from "react";
import DesktopSidebar from "./DesktopSidebar";
import MobileNavbar from "./MobileNavbar";
import Footer from "./Footer";
import Avatar from "../ui/Avatar";
import SearchBar from "../ui/SearchBar";
import { useAuthContext } from "../../store/auth_context/authContext";
import { rolesTranslation } from "../../helpers/roles";

function MainLayout({
    withMainHeader = true,
    withFooter = true,
    children,
    avatarColor = "#f31c1c",
    withSearchbar = true,
    withHeader = true,
}) {
    const { userData } = useAuthContext();

    return (
        <div className="flex flex-col md:flex-row flex-grow min-h-screen w-screen">
            <DesktopSidebar
                avatarColor={avatarColor}
                userName={userData?.firstName + " " + userData?.lastName}
                role={rolesTranslation[userData?.roles[0]]}
                avatarUrl={userData?.avatar}
            ></DesktopSidebar>
            <div className="flex flex-col justify-center items-center w-full">
                {withMainHeader && (
                    <div className="hidden md:flex m-4 w-full p-5 md:p2">
                        <Avatar
                            className={"md:hidden"}
                            size="sm"
                            color={"#eddf16"}
                            url={userData?.avatar}
                        />

                        <div className="w-full">
                            <h4 className="text-secondary-text">
                                Bonjour, {userData?.firstName}
                            </h4>
                        </div>
                        {withSearchbar && (
                            <div className="md:flex w-1/3 hidden">
                                <SearchBar></SearchBar>
                            </div>
                        )}
                    </div>
                )}

                <div className="flex flex-col justify-center md:hidden gap-2 mx-2 w-full p-5">
                    {withSearchbar && (
                        <div className="">
                            <SearchBar className={""}></SearchBar>
                        </div>
                    )}
                    {withHeader && (
                        <div className="flex justify-end gap-5 items-center">
                            <Avatar
                                className={"md:hidden"}
                                size="sm"
                                color={"#eddf16"}
                                url={userData?.avatar}
                            />
                            <div className="w-full">
                                <h4 className="font-medium">
                                    {userData?.lastName} {userData?.firstName}
                                </h4>
                                <span className="text-secondary-text">
                                    {rolesTranslation[userData?.roles[0]]}
                                </span>
                            </div>
                        </div>
                    )}
                </div>

                <div className="flex flex-col flex-grow w-full h-full">
                    {children}
                </div>
                {withFooter && <Footer></Footer>}
            </div>
            <MobileNavbar></MobileNavbar>
        </div>
    );
}

export default MainLayout;
