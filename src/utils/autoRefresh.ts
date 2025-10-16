export const autoRefresh = (targetID: string, url: string, interval = 1000) => {
	let intervalID: number | null = null;

	const checkElement = () => {
		const $el = $(`#${targetID}`);
		if ($el.length && !intervalID) {
			// start refreshing
			intervalID = window.setInterval(() => {
				if (document.body.contains($el[0])) {
					$el.load(`${url} #${targetID} > *`);
				} else {
					// element removed from DOM
					clearInterval(intervalID!);
					intervalID = null;
				}
			}, interval);
		} else if (!$el.length && intervalID) {
			// stop refreshing if it disappeared
			clearInterval(intervalID);
			intervalID = null;
		}
	};

	// run every half second to check element existence
	const observer = setInterval(checkElement, 500);

	// stop observer if the page unloads
	$(window).on("unload", () => clearInterval(observer));
};
