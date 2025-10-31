import { useState } from "react";
import {
    User,
    Folder,
    Bell,
    Lightbulb,
    ArrowRightFromLine,
    LogOut,
} from "lucide-react";
import Avatar from "../../components/ui/Avatar.jsx";
import logo from "../../assets/Logo-light.png";
import { useAuthContext } from "../../store/auth_context/authContext.js";
import { useNavigate } from "react-router";

export default function DesktopSidebar({
    avatarColor = "#ffe561",
    userName = "Axel Érez",
    role = "Stagiaire",
}) {
    const { signOut } = useAuthContext();
    const navigate = useNavigate();
    // ------------------------------------ Gérer l'affichache de la Sidbar etendu ou compact ------------------------------------
    const [collapsed, setCollapsed] = useState(false);

    // ------------------------------------ L'affichage ------------------------------------
    return (
        <div
            className={`hidden md:flex flex-col left-0 top-0  bg-primary text-white 
        ${
            collapsed ? "w-20" : "w-60"
        } transition-all duration-300 relative rounded-tr-xl`}
        >
            {/* ------Avatar + Infos utilisateur ----------- */}
            <div className="flex flex-col items-center py-10">
                {/* Avatar version icône */}
                <Avatar size={collapsed ? "sm" : "xl"} color={avatarColor} />

                {/* Quand la barre n’est pas réduite (collapsed = false), affiche le nom et le rôle en texte. */}
                {!collapsed && (
                    <>
                        <div className=" text-lg">{userName}</div>
                        <div className="text-gray-300 text-xs font-light">
                            {role}
                        </div>
                    </>
                )}
            </div>
            {/* ----------- Nav items -----------  */}
            <nav className="flex flex-col  items-center justify-center font-light py-12">
                <div
                    className={`flex flex-col justify-center items-center ${
                        collapsed ? "space-y-12" : "space-y-6"
                    }`}
                >
                    <SidebarItem
                        icon={<User size={20} strokeWidth={1} />}
                        label="Mon compte"
                        collapsed={collapsed}
                        onClick={() => navigate("/profile")}
                    />
                    <SidebarItem
                        icon={<Folder size={20} strokeWidth={1} />}
                        label="Mes documents"
                        collapsed={collapsed}
                        onClick={() => navigate("/help")}
                    />
                    <SidebarItem
                        icon={<Bell size={20} strokeWidth={1} />}
                        label="Notifications"
                        collapsed={collapsed}
                        onClick={() => navigate("/notifications")}
                    />
                    <SidebarItem
                        icon={<Lightbulb size={20} strokeWidth={1} />}
                        label="Aide / Astuces"
                        collapsed={collapsed}
                        onClick={() => navigate("/help")}
                    />
                    <SidebarItem
                        icon={<LogOut size={20} strokeWidth={1} />}
                        label="Déconnexion"
                        collapsed={collapsed}
                        onClick={() => signOut()}
                    />
                </div>
            </nav>

            {/* ----------- Logo custom bas ----------- */}
            <div
                className={`flex flex-1 flex-col justify-end items-center w-[80%] ${
                    collapsed ? "m-2" : "m-5"
                }`}
            >
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
function SidebarItem({ icon, label, collapsed, onClick }) {
    return (
        <div
            onClick={onClick}
            className="flex items-center gap-6 px-4 py-2 hover:bg-blue-700 rounded-lg cursor-pointer w-full"
        >
            <span>{icon}</span>
            {!collapsed && <span>{label}</span>}
        </div>
    );
}
