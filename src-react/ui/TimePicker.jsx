function TimePicker({ value, onChange, disabled = false }) {
    return (
        <div className="max-w-32">
            <input
                type="time"
                className="py-2.5 sm:py-3 px-4 block w-full border disabled:border-0 border-gray-200 rounded-lg sm:text-sm focus:border-primary  disabled:opacity-50 disabled:pointer-events-none"
                placeholder="Basic time picker"
                onChange={onChange}
                value={value}
                disabled={disabled}
            />
        </div>
    );
}

export default TimePicker;
