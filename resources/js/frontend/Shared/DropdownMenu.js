import React, { useState, useRef, useEffect } from "react";
import { InertiaLink, usePage } from "@inertiajs/inertia-react";
import Icon from "@/Shared/Icon";

/**
 * Hook that alerts clicks outside of the passed ref
 */
function useOutsideAlerter(ref, menuOpened, callback = null) {
	useEffect(() => {
		/**
		 * Alert if clicked on outside of element
		 */
		function handleClickOutside(event) {
			if (ref.current && !ref.current.contains(event.target) && menuOpened) {
				// alert("You clicked outside of me!");
				callback();
			}
		}

		// Bind the event listener
		document.addEventListener("mousedown", handleClickOutside);
		return () => {
			// Unbind the event listener on clean up
			document.removeEventListener("mousedown", handleClickOutside);
		};
	}, [ref, menuOpened]);
}

export default ({ label = "", labelComponent = null, menuItems = [], wrapperClassName = "relative", overlay = true }) => {
	const { auth } = usePage();
	const [menuOpened, setMenuOpened] = useState(false);
	const dropDownRef = useRef(null);

	useOutsideAlerter(dropDownRef, menuOpened, () => {
		handleMenuOpen(false);
	});

	function handleMenuOpen(bool) {
		// if (window.innerWidth > 1080) {
		// 	let closestTable = dropDownRef.current.closest("table");
		// 	if (closestTable && closestTable.parentElement) {
		// 		let parent = closestTable.parentElement;
		// 		if (bool === true) {
		// 			parent.classList.remove("overflow-x-auto");
		// 		} else {
		// 			parent.classList.add("overflow-x-auto");
		// 		}
		// 	}
		// }

		setMenuOpened(bool);
	}

	return (
		<div ref={dropDownRef} className={wrapperClassName}>
			<div className="flex items-center cursor-pointer select-none group" onClick={() => handleMenuOpen(!menuOpened)}>
				<div className="text-gray-800 group-hover:text-indigo-600 focus:text-indigo-600 mr-1 whitespace-nowrap">
					{labelComponent ? labelComponent : <span>{label}</span>}
				</div>
				<Icon
					className="w-5 h-5 fill-current text-gray-800 group-hover:text-indigo-600 focus:text-indigo-600"
					name={menuOpened ? "cheveron-up" : "cheveron-down"}
				/>
			</div>
			<div className={menuOpened ? "" : "hidden"}>
				<div className="whitespace-nowrap absolute z-20 mt-8 left-auto top-0 right-0 py-2 shadow-xl bg-white rounded text-sm">
					{menuItems.map((i, k) => {
						return i.target && i.target == "_blank" ? (
							<a key={k} href={i.href} className="block px-6 py-2 hover:bg-primary hover:text-white" target={i.target || "_self"}>
								{i.label}
							</a>
						) : (
							<InertiaLink key={k} href={i.href} className="block px-6 py-2 hover:bg-primary hover:text-white" target={i.target || "_self"}>
								{i.label}
							</InertiaLink>
						);
					})}
				</div>
				{overlay && (
					<div
						onClick={() => {
							handleMenuOpen(!menuOpened);
						}}
						className="bg-black opacity-25 fixed inset-0 z-10"
					></div>
				)}
			</div>
		</div>
	);
};
