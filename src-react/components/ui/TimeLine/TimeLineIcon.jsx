
export default function TimeLineIcon({ icon }) {
    return (
        <div className="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200">
            <div className="relative z-10 size-7 flex justify-center items-center">
                {icon}
            </div>
        </div>
    );
}
  