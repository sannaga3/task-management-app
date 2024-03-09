export const nl2br = (str) => {
    if (str === null) return "";
    let res = str.replace(/\r\n/g, "<br>");
    res = res.replace(/(\n|\r)/g, "<br>");
    return res;
};
