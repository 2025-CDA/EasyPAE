import React from "react";
import errorLogo from "../../assets/404error.png";

export default function ErrorPage() {
    return (
        <div className="w-full h-screen flex flex-col gap-2 justify-center items-center">
            <img src={errorLogo} className={"w-[30%]"} />
            <h2 className="text-primary-text font-semibold">
                <div className="text-4xl font-extrabold">404 </div>Page Not
                Found
            </h2>
        </div>
    );
}
