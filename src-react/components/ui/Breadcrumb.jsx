import React from "react";

function Breadcrumb({
    content = [
        { title: "Home", link: "#", isFinal: false, current: false },
        { title: "Application", link: "#", isFinal: true, current: true },
    ],
}) {
    return (
        <ol className="flex items-center whitespace-nowrap">
<<<<<<< HEAD
            {content.map((item, i) => (
                <BreadcrumbItem key={i} item={item}></BreadcrumbItem>
            ))}
=======
            {content.map((item,i)=> <BreadcrumbItem key={i} item={item} ></BreadcrumbItem>)}
>>>>>>> origin/dev
        </ol>
    );
}

export default Breadcrumb;

<<<<<<< HEAD
function BreadcrumbItem({ item }) {
    return (
        <li className="inline-flex items-center">
=======
function BreadcrumbItem({item}) {
    return (
        <li  className="inline-flex items-center">
>>>>>>> origin/dev
            <a
                className={`flex items-center text-sm ${
                    item.current
                        ? "text-gray-900 font-semibold"
                        : "text-gray-400"
                } hover:text-primary focus:outline-hidden focus:text-primary dark:text-neutral-500 dark:hover:text-primary dark:focus:text-primary`}
                href={item.link}
            >
                {item.title}
            </a>
            {!item.isFinal && (
                <svg
                    className="shrink-0 mx-2 size-4 text-gray-400 dark:text-neutral-600"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="2"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                >
                    <path d="m9 18 6-6-6-6"></path>
                </svg>
            )}
        </li>
    );
}
