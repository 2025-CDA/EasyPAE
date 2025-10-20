function Select(
    {
        options = [
            { value: 1, label: "test" },
            { value: 2, label: "2" },
            { value: 3, label: "3" },
        ],
    },
    onChange,
    value
) {
    //State pour utilisés dans la composante parent
    // const [selectedValue, setSelectedValue] = useState();
    //onChange = setSelectedValue;
    // value = selectedValue
    return (
        <select
            value={value}
            defaultValue="0"
            onChange={(e) => onChange && onchange(e.target.value)}
            className="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg
            text-sm focus:border-blue-500 focus:ring-blue-500
            disabled:opacity-50 disabled:pointer-events-none"
        >
            <option>Choisissez une valeur</option>
            {options.map((option) => (
                <option key={option.value} value={option.value}>
                    {option.label}
                </option>
            ))}
        </select>
    );
}

export default Select;
