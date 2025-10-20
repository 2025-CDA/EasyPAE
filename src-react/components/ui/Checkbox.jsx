function Checkbox({
    id,
    label,
    description,
    disabled = false,
    value,
    onChange,
}) {
    //State pour utilisés dans la composante parent
    // const [checkValue, setCheckValue] = useState(false);
    //onChange = setCheckValue;
    // value = checkValue
    return (
        <div className="flex items-start">
            <input
                type="checkbox"
                className="shrink-0 mt-0.5 accent-primary  rounded-sm text-primary focus:ring-primary checked:border-primary disabled:opacity-50 disabled:pointer-events-none"
                id={id}
                disabled={disabled}
                onChange={onChange}
                checked={value}
            />
            <div className="flex flex-col">
                <label htmlFor="hs-default-checkbox" className="text-sm ms-3">
                    {label}
                </label>
                <p
                    htmlFor="hs-default-checkbox"
                    className="text-sm text-secondary-text ms-3"
                >
                    {description}
                </p>
            </div>
        </div>
    );
}

export default Checkbox;
