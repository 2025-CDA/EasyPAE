import placeholder from "../assets/profile.jpg";

function Avatar({ url = placeholder, size = 8, color = "red" }) {
    return (
        <img
            className={`my-3 inline-block w-${size} h-${size} rounded-full outline-3`}
            style={{ outlineColor: color }}
            src={url}
            alt="Avatar"
        />
    );
}

export default Avatar;
