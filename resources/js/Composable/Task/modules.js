import { publishedMap, statusMap } from "./constants";

export const convertStatus = (num) => {
    return statusMap[num] || "Unknown status";
};

export const convertPublished = (num) => {
    return publishedMap[num] || "Unknown value";
};
