import placeholder from "../../assets/profile.jpg";

function Avatar({ url = placeholder, size = "xl", color = "red", className }) {
    const sizeClasses = {
        sm: "w-14 h-14",
        md: "w-20 h-20",
        xl: "w-24 h-24",
    };

    return (
        <img
            className={`my-3 inline-block ${sizeClasses[size]} rounded-full outline-3 ${className}`}
            style={{ outlineColor: color }}
            src={url}
            alt="Avatar"
        />
    );
}

export default Avatar;
