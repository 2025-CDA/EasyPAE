import React from "react";
import { BounceLoader } from "react-spinners";

export default function LoadingModal() {
    return (
        <div className="w-full h-screen flex flex-col gap-5 justify-center items-center">
            <BounceLoader size={50} color="#444666"></BounceLoader>
            <h2 className="animate-pulse text-primary font-semibold">
                Loading ...{" "}
            </h2>
        </div>
    );
}
