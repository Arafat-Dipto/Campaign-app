import React from "react";
import classNames from "classnames";
import axios from "axios";
import { usePage } from "@inertiajs/inertia-react";

const PageLink = ({ active, label, url, requestCallback, responseCallback }) => {
	const { formToken = null } = usePage().props;
	const handleClick = (e) => {
		e && e.preventDefault();
		requestCallback && requestCallback();

		let data = {};
		var settings = {
			headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": formToken },
		};

		axios
			.post(url, data, settings)
			.then((response) => {
				responseCallback && responseCallback(response.data);
			})
			.catch((error) => {
				responseCallback && responseCallback(null);
			});
	};

	const className = classNames(["mr-1 mb-1", "px-4 py-3", "border rounded", "text-sm", "hover:bg-white", "focus:border-secondary focus:text-secondary"], {
		"bg-white": active,
		"ml-auto": label === "Next",
	});
	return (
		<a
			onClick={handleClick}
			className={className}
			// href={url}
			href="#"
		>
			{label}
		</a>
	);
};

// Previous, if on first page
// Next, if on last page
// and dots, if exists (...)
const PageInactive = ({ label }) => {
	const className = classNames("mr-1 mb-1 px-4 py-3 text-sm border rounded text-gray", {
		"ml-auto": label === "Next",
	});
	return <div className={className}>{label}</div>;
};

export default ({ links = [], requestCallback = null, responseCallback = null }) => {
	// dont render, if there's only 1 page (previous, 1, next)
	if (links.length === 3) return null;
	return (
		<div className="mt-6 -mb-1 flex flex-wrap">
			{links.map(({ active, label, url }) => {
				return url === null ? (
					<PageInactive key={label} label={label} />
				) : (
					<PageLink key={label} label={label} active={active} url={url} requestCallback={requestCallback} responseCallback={responseCallback} />
				);
			})}
		</div>
	);
};
