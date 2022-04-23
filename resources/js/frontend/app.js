import React from "react";
import { render } from "react-dom";
import { InertiaApp } from "@inertiajs/inertia-react";
import { Inertia } from "@inertiajs/inertia";
import NProgress from "nprogress";

Inertia.on("navigate", (event) => {
	// console.log(`Navigated to page: ${event.detail.page.url}`);
	gtag("event", "page_view", {
		page_location: event.detail.page.url,
	});
});

Inertia.on("start", ({ detail: { visit } }) => {
	// console.log(visit, window.location.href);
	if (visit.hasOwnProperty("only") && visit.only.includes("noProgress")) {
	} else {
		NProgress.start();
	}
});

Inertia.on("finish", (event) => {
	if (event.detail.visit.completed) {
		NProgress.done();
	} else if (event.detail.visit.interrupted) {
		NProgress.set(0);
	} else if (event.detail.visit.cancelled) {
		NProgress.done();
		NProgress.remove();
	}
});

const app = document.getElementById("app");

if (process.env.NODE_ENV !== "development") {
	// disable react-dev-tools for this project
	if (typeof window.__REACT_DEVTOOLS_GLOBAL_HOOK__ === "object") {
		for (let [key, value] of Object.entries(window.__REACT_DEVTOOLS_GLOBAL_HOOK__)) {
			window.__REACT_DEVTOOLS_GLOBAL_HOOK__[key] = typeof value == "function" ? () => {} : null;
		}
	}
}

render(
	<InertiaApp
		initialPage={JSON.parse(app.dataset.page)} //
		resolveComponent={(name) => import(`./Pages/${name}`).then((module) => module.default)}
	/>,
	app
);
