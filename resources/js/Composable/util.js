export const nl2br = (str) => {
    if (str === null) return "";
    let res = str.replace(/\r\n/g, "<br>");
    res = res.replace(/(\n|\r)/g, "<br>");
    return res;
};

const options = {
    timeZone: "Asia/Tokyo",
    year: "numeric",
    month: "2-digit",
    day: "2-digit",
    hour: "2-digit",
    minute: "2-digit",
    second: "2-digit",
};
const dateTimeToJaFormatter = new Intl.DateTimeFormat("ja-JP", options);
export const formatToDateTimeJa = (dateTime) => {
    return dateTimeToJaFormatter.format(dateTime);
};

export const formatElapsedTime = (seconds) => {
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const remainingSeconds = seconds % 60;

    return `${hours.toString().padStart(2, "0")}:${minutes
        .toString()
        .padStart(2, "0")}:${remainingSeconds.toString().padStart(2, "0")}`;
};

export const formatTargetTimeToSeconds = (hours, minutes) => {
    return hours * 3600 + minutes + 60;
};

export const splitTargetTimeIntoHoursAndMinutes = (targetTime) => {
    if (typeof targetTime !== "number") return [0, 0];

    const hours = Math.floor(targetTime / 3600);
    const remainingSeconds = targetTime % 3600;
    const minutes = Math.floor(remainingSeconds / 60);
    return [hours, minutes];
};
