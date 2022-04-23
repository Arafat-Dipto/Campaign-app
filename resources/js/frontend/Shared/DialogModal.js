import React, { useState } from "react";

export default ({ buttonComponent = null, buttonLabel = "", children = null, modalTitle = "" }) => {
	const [menuOpened, setMenuOpened] = useState(false);
	return (
		<div className="">
			<div className="flex items-center cursor-pointer select-none group" onClick={() => setMenuOpened(true)}>
				{buttonComponent ? (
					buttonComponent
				) : (
					<span className="btn-indigo">
						<span>{buttonLabel}</span>
					</span>
				)}
			</div>
			{/* <div className={menuOpened ? "" : "hidden"}>
                <div className="h-screen flex items-center justify-center">
                    <div className="w-3/4 whitespace-nowrap fixed shadow-xl bg-white rounded text-sm">
                        {children}
                    </div>
                    <div
                        onClick={() => {
                            setMenuOpened(false);
                        }}
                        className="bg-black opacity-25 fixed inset-0 z-10"
                    ></div>
                </div>
            </div> */}
			{/* overlay */}
			<div className={menuOpened ? "absolute inset-0 z-20 flex items-start justify-center" : "hidden"}>
				<div className="bg-white shadow-2xl m-4 sm:m-8">
					<div className="flex justify-between items-center border-b p-2">
						<span className="font-bold">{modalTitle}</span>
						<button
							type="button"
							onClick={() => {
								setMenuOpened(false);
							}}
						>
							<span className="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">×</span>
						</button>
					</div>
					{children}
				</div>
			</div>
			<div
				onClick={() => {
					setMenuOpened(false);
				}}
				className={menuOpened ? "bg-black opacity-25 fixed inset-0 z-10" : "hidden"}
			></div>
		</div>
	);
};
