export default function Button({
    variant = "solid",
    icon,
    color = "blue",
    children,
    onClick,
    shape = "standard",
    className,
    ...props
}) {
    console.log(variant)
    // Définition des variantes et des couleurs
    const colorVariants = {
        blue: {
            solid: "bg-primary text-white hover:bg-blue-700",
            outline:
                "border border-blue-600 bg-white text-blue-500 hover:bg-blue-600 hover:text-white",
        },
        red: {
            solid: "bg-red-600 text-white hover:bg-red-700",
            outline:
                "border border-red-600 text-red-600 hover:bg-red-600 hover:text-white",
        },
        green: {
            solid: "bg-green-600 text-white hover:bg-green-700",
            outline:
                "border border-green-600 text-green-600 hover:bg-green-600 hover:text-white",
        },
        white: {
            solid: "bg-background text-primary-text",
            outline: "border border-black-600 text-primary-text",

            
        },
    };

    const shapes = {
        standard: "rounded-lg", // bouton standard
        rounded: "rounded-xl", // arrondi (login / register)
        square: "rounded-none", // angles droits
        circle: "rounded-full p-2", // pour icônes
    };
    const baseButton =
        "inline-flex items-center justify-center gap-2 font-medium transition duration-200 focus:outline-none p-2 text-blue-600";

    const colorVariantClass =
        colorVariants[color] && colorVariants[color][variant]
            ? colorVariants[color][variant]
            : "";

    const shapeClass = shapes[shape] || "";

    return (
            <button
                type="button"
                className={`
        ${baseButton}
        ${colorVariantClass} ${shapeClass}
        ${className}
      `}
                {...props}
                onClick={onClick}
            >
                {icon}
                {children}
            </button>
    );
}
