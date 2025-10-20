import { CircleAlert, CircleCheck } from "lucide-react";
import TimeLineItem from "./TimeLineItem";

export default function TimeLine({
    content = [
        {
            date: "1 Aug, 2023",
            icon: <CircleAlert className="text-yellow-400"></CircleAlert>,
            title: "Created Preline in React task",
            description: "Find more detailed insctructions here.",
            avatarUrl:
                "https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8auto=format&fit=facearea&facepad=3&w=320&h=320&q=80",
            userName: "James Collins",
        },
        {
            date: "1 May, 2023",
            icon: <CircleCheck className="text-green-500"></CircleCheck>,
            title: "Created Preline in React task",
            description: "Find more detailed insctructions here.",
            avatarUrl:
                "https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8auto=format&fit=facearea&facepad=3&w=320&h=320&q=80",
            userName: "James Collins",
        },
    ],
}) {
    return (
        <div>
            {content.map((item, i) => (
                <TimeLineItem key={i} content={item} />
            ))}
        </div>
    );
}
