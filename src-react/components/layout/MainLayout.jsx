import React, { Children } from "react";
import DesktopSidebar from "./DesktopSidebar";
import MobileNavbar from "./MobileNavbar";

function MainLayout({ children }) {
    return (
        <div className="flex flex-col md:flex-row flex-grow w-screen h-full">
            <DesktopSidebar></DesktopSidebar>
            <div className="flex flex-col md:flex-row flex-grow w-full h-full p-4">
                {children}
            </div>
            <MobileNavbar></MobileNavbar>
        </div>
    );
}

export default MainLayout;
