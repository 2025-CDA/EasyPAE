export default function TimeLineHeader({ date }) {
    return (
        <div className="ps-2 my-2 mt-2">
            <p className="text-xs font-medium uppercase text-gray-500">
                {date}
            </p>
        </div>
    );
}
