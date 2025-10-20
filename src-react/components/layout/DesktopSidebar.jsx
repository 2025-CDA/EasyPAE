import { useState } from "react";
import {
    User,
    Folder,
    Bell,
    Lightbulb,
    ArrowRightFromLine,
} from "lucide-react";
import Avatar from "../../ui/Avatar";
import logo from "../../assets/Logo-light.png";

export default function DesktopSidebar() {
    // ------------------------------------ Gérer l'affichache de la Sidbar etendu ou compact ------------------------------------
    const [collapsed, setCollapsed] = useState(false);

    // ------------------------------------ L'affichage ------------------------------------
    return (
        <div
            className={`hidden md:flex flex-col left-0 top-0 h-screen bg-primary text-white 
        ${
            collapsed ? "w-20" : "w-60"
        } transition-all duration-300 relative rounded-tr-xl`}
        >
            {/* ------Avatar + Infos utilisateur ----------- */}
            <div className="flex flex-col items-center py-10">
                {/* Avatar version icône */}
                <Avatar size={18} color={"yellow"} />

                {/* Quand la barre n’est pas réduite (collapsed = false), affiche le nom et le rôle en texte. */}
                {!collapsed && (
                    <>
                        <div className=" text-lg">Axel Érez</div>
                        <div className="text-gray-300 text-xs font-light">
                            Stagiaire
                        </div>
                    </>
                )}
            </div>
            {/* ----------- Nav items -----------  */}
            <nav className="flex-1 flex flex-col items-center justify-center font-light">
                <div
                    className={`flex flex-col justify-center items-center ${
                        collapsed ? "space-y-12" : "space-y-6"
                    }`}
                >
                    <SidebarItem
                        icon={<User size={20} strokeWidth={1} />}
                        label="Mon compte"
                        collapsed={collapsed}
                    />
                    <SidebarItem
                        icon={<Folder size={20} strokeWidth={1} />}
                        label="Mes documents"
                        collapsed={collapsed}
                    />
                    <SidebarItem
                        icon={<Bell size={20} strokeWidth={1} />}
                        label="Notifications"
                        collapsed={collapsed}
                    />
                    <SidebarItem
                        icon={<Lightbulb size={20} strokeWidth={1} />}
                        label="Aide / Astuces"
                        collapsed={collapsed}
                    />
                </div>
            </nav>

            {/* ----------- Logo custom bas ----------- */}
            <div className="flex justify-center items-center w-[80%] m-auto">
                <img src={logo} alt="logo" />
            </div>

            {/* ----------- Bouton collapse ----------- */}
            <button
                onClick={() => setCollapsed(!collapsed)}
                className="absolute top-2 right-2 bg-blue-700 rounded-full w-6 h-6 flex items-center justify-center"
            >
                {collapsed ? (
                    <ArrowRightFromLine size={10} />
                ) : (
                    <ArrowRightFromLine size={10} className="rotate-180" />
                )}
            </button>
        </div>
    );
}

// function qui permet de (Si la sidebar est étendue, affiche aussi le texte du label ; si elle est réduite, ne montre que l’icône.)
function SidebarItem({ icon, label, collapsed }) {
    return (
        <div className="flex items-center gap-6 px-4 py-2 hover:bg-blue-700 rounded-lg cursor-pointer w-full">
            <span>{icon}</span>
            {!collapsed && <span>{label}</span>}
        </div>
    );
}
