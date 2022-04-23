import React from "react";
import Helmet from "react-helmet";
import FlashMessages from "@/Shared/FlashMessages";
import { usePage } from "@inertiajs/inertia-react";

export default function Layout({ children }) {
	// const { user } = usePage().props.auth;
	return (
		<div>
			<Helmet titleTemplate="%s | Backend Dashboard" />
			<div className="flex flex-col">
				<div className="h-screen flex flex-col">
					<div className="md:flex"></div>

					<div className="flex flex-grow overflow-hidden">
						<div id="content" className="w-full overflow-hidden px-4 py-8 md:p-8 overflow-y-auto">
							<FlashMessages />
							{children}
						</div>
					</div>

					<div className="md:flex">
						<div className="w-full border-t">
							<div className="bg-lightBackground border-b w-full p-2 md:py-2 md:px-12 text-xs flex justify-between items-center"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	);
}
