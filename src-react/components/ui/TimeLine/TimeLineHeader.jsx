export default function TimeLineHeader({ date }) {
    return (
        <div className="ps-2 my-2 first:mt-0">
            <h5 className="text-xs font-medium uppercase text-gray-500">
                {date}
            </h5>
        </div>
    );
}
