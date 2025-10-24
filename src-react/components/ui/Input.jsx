import React, { useState } from "react";
import { Eye, EyeOff, User, Copy } from "lucide-react";

export default function Input({
    id,
    type = "text",
    placeholder = "you@site.com",
    required = false, // Pour ajouter l'etoile rouge si le champ est obligatoire
    label = "Email",
    icon, // Si avec icon  par example <User size={18}/>
    withShowPassword = false, // Si avec icon pour afficher le mot de passe
    withCopy = true, // Si avec icon pour afficher le mot de passe
    className,
    props,
}) {
    const [showPassword, setShowPassword] = useState(false);
    const [value, setValue] = useState("");
    return (
        <div className="">
            <label htmlFor={id} className="">
                {label} {required && <span className="text-red-500">*</span>}
            </label>
            <div className="relative">
                <input
                    type={
                        type == "password"
                            ? showPassword == false
                                ? "password"
                                : "text"
                            : type
                    }
                    id={id}
                    className={`py-2.5 sm:py-3 px-4 block w-full border-1 border-gray-200 outline-gray-200 rounded-lg sm:text-sm focus:border-secondary focus:ring-secondary disabled:opacity-50  ${
                        icon && "ps-11"
                    } ${withShowPassword && "pe-11"} ${className}`}
                    placeholder={placeholder}
                    onChange={(e) => setValue(e.target.value)}
                    required={required}
                    value={value}
                    {...props}
                />
                <div className="absolute inset-y-0 start-0 flex items-center ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                    <div className="text-gray-600">{icon && icon}</div>
                </div>
                {withShowPassword && (
                    <div className="absolute inset-y-0 end-0 flex items-center pe-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                        {!showPassword ? (
                            <Eye
                                className="text-secondary-text w-4"
                                onClick={() => setShowPassword(true)}
                            ></Eye>
                        ) : (
                            <EyeOff
                                className="text-secondary-text w-4"
                                onClick={() => setShowPassword(false)}
                            ></EyeOff>
                        )}
                    </div>
                )}
                {withCopy && (
                    <div className="absolute inset-y-0 end-0 flex items-center pe-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                        {
                            <Copy
                                className="text-secondary-text w-4"
                                onClick={() =>
                                    navigator.clipboard.writeText(value)
                                }
                            ></Copy>
                        }
                    </div>
                )}
            </div>
        </div>
    );
}
