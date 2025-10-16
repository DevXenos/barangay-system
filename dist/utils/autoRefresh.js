export const autoRefresh = (targetID, url, interval = 1000) => {
    let intervalID = null;
    const checkElement = () => {
        const $el = $(`#${targetID}`);
        if ($el.length && !intervalID) {
            intervalID = window.setInterval(() => {
                if (document.body.contains($el[0])) {
                    $el.load(`${url} #${targetID} > *`);
                }
                else {
                    clearInterval(intervalID);
                    intervalID = null;
                }
            }, interval);
        }
        else if (!$el.length && intervalID) {
            clearInterval(intervalID);
            intervalID = null;
        }
    };
    const observer = setInterval(checkElement, 500);
    $(window).on("unload", () => clearInterval(observer));
};
