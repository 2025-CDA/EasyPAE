import { User, Folder, Bell, Lightbulb } from "lucide-react";
import Button from "../ui/Button";

export default function Footer() {
    return (
        <footer className="md:flex flex-col hidden gap-4 justify-center border-t border-gray-200 items-center bottom-0 h-[140px] w-full">
            <h5 className="text-secondary-text">© 2025 EasyPAE</h5>
            <div className="flex flex-row justify-center items-center gap-10">
                <a href="" className="text-base font-semibold underline">
                    Mentions légales
                </a>
                <a href="" className="text-base font-semibold underline">
                    Politique de confidentialité
                </a>
            </div>
        </footer>
    );
}
