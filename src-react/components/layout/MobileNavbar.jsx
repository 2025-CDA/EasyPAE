import { User, Folder, Bell, Lightbulb } from "lucide-react";
import Button from "../../ui/Button";

export default function MobileNavbar() {
    const btnStyle =
        "flex-col items-center justify-center flex-1 text-[10px] sm:text-[12px] min-w-[60px] tracking-tight sm:tracking-wide";
    const iconStyle = "w-5 h-5";
    return (
        <nav className="flex fixed md:hidden justify-evenly items-center bottom-0 left-0 max-h-[15%] min-h-[8%] w-full z-50 rounded-t-lg bg-primary  overflow-hidden">
            <Button
                icon={<User className={iconStyle} />}
                className={btnStyle}
                onClick={() => ""}
            >
                Mon compte
            </Button>
            <Button
                icon={<Folder className={iconStyle} />}
                className={btnStyle}
                onClick={() => ""}
            >
                Mes documents
            </Button>
            <Button
                icon={<User className={iconStyle} />}
                className={btnStyle}
                onClick={() => ""}
            >
                Dashboard
            </Button>
            <Button
                icon={<Bell className={iconStyle} />}
                className={btnStyle}
                onClick={() => ""}
            >
                Notification
            </Button>
            <Button
                icon={<Lightbulb className={iconStyle} />}
                className={btnStyle}
                onClick={() => ""}
            >
                Aide
            </Button>
        </nav>
    );
}
