import TimeLineHeader from "./TimeLineHeader";
import TimeLineIcon from "./TimeLineIcon";
import TimeLineRightContent from "./TImeLineRightComponent";

export default function TimeLineItem({ content }) {
    return (
        <>
            <TimeLineHeader date={content.date} />
            <div className="flex gap-x-3">
                <TimeLineIcon icon={content.icon} />
                <TimeLineRightContent
                    title={content.title}
                    description={content.description}
                    avatarUrl={content.avatarUrl}
                    userName={content.userName}
                />
            </div>
        </>
    );
}
