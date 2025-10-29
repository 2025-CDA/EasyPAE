import React from "react";
import TimeLine from "../ui/TimeLine/TimeLine";
import Container from "../ui/Container";
import Badge from "../ui/Badge";
import { CircleAlert, CircleCheck } from "lucide-react";

function GlobalStateHistory() {
    return (
        <Container className={"flex flex-col gap-5 p-5"}>
            <div className={"flex items-center gap-4"}>
                <h3 className={"font-semibold"}>Status Global:</h3>
                <Badge label={"Incomplet"} color="red"></Badge>
            </div>
            <TimeLine
                content={[
                    {
                        icon: (
                            <CircleCheck className="text-green-500"></CircleCheck>
                        ),
                        title: "STAGIAIRE : ",
                        description: "Find more detailed insctructions here.",
                        userName: "James Collins",
                    },
                    {
                        icon: (
                            <CircleAlert className="text-yellow-400"></CircleAlert>
                        ),
                        title: "ENTREPRISE :",
                        description: "Find more detailed insctructions here.",
                        userName: "James Collins",
                    },
                    {
                        icon: (
                            <CircleAlert className="text-red-400"></CircleAlert>
                        ),
                        title: "FORMATEUR : ",
                        description: "Find more detailed insctructions here.",
                        userName: "James Collins",
                    },
                ]}
            ></TimeLine>
        </Container>
    );
}

export default GlobalStateHistory;
