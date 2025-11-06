import { User, Folder, Bell, Lightbulb } from "lucide-react";
import Button from "../ui/Button";
import { useNavigate } from "react-router";
import logo from "../../assets/Logo-light.png";

export default function MobileNavbar() {
    const navigate = useNavigate();
    const btnStyle =
        "flex-col items-center justify-center flex-1 text-[10px] sm:text-[12px] min-w-[60px] tracking-tight sm:tracking-wide";
    const iconStyle = "w-5 h-5";
    return (
        <nav className="flex fixed md:hidden justify-evenly items-center bottom-0 left-0 max-h-[15%] min-h-[8%] w-full z-50 rounded-t-lg bg-primary  overflow-hidden">
            <Button
                icon={<User className={iconStyle} />}
                className={btnStyle}
                onClick={() => navigate("/profile")}
            >
                Mon compte
            </Button>
            <Button
                icon={<Folder className={iconStyle} />}
                className={btnStyle}
                onClick={() => navigate("/")}
            >
                Mes documents
            </Button>
            <Button
                icon={<img src={logo} className={iconStyle} />}
                className={btnStyle}
                onClick={() => navigate("/")}
            >
                Dashboard
            </Button>
            <Button
                icon={<Bell className={iconStyle} />}
                className={btnStyle}
                onClick={() => navigate("/notifications")}
            >
                Notification
            </Button>
            <Button
                icon={<Lightbulb className={iconStyle} />}
                className={btnStyle}
                onClick={() => navigate("/help")}
            >
                Aide
            </Button>
        </nav>
    );
}
