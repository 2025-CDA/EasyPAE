function Select({
    options = [
        { value: 1, label: "test" },
        { value: 2, label: "2" },
        { value: 3, label: "3" },
    ],
    onChange,
    value,
    classNameSelect,
}) {
    //State pour utilisés dans la composante parent
    // const [selectedValue, setSelectedValue] = useState();
    //onChange = setSelectedValue;
    // value = selectedValue
    return (
        <select
            value={value}
            defaultValue="0"
            onChange={onChange}
            className={
                classNameSelect ||
                "py-3 px-4 pe-9 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
            }
        >
            <option>Tout</option>
            {options.map((option) => (
                <option key={option.id} value={option.id}>
                    {option.name}
                </option>
            ))}
        </select>
    );
}

export default Select;
