import React, { useState, useEffect } from "react";

const Modal = ({ onRequestClose, children = null }) => {
	const [preventScroll, setPreventScroll] = useState(true);

	// Use useEffect to add an event listener to the document
	useEffect(() => {
		function onKeyDown(event) {
			if (event.keyCode === 27) {
				// Close the modal when the Escape key is pressed
				onRequestClose();
			}
		}

		// Prevent scolling
		if (document.body.style.overflow != "hidden") {
			document.body.style.overflow = "hidden";
		} else {
			setPreventScroll(false);
		}

		document.addEventListener("keydown", onKeyDown);

		// Clear things up when unmounting this component
		return () => {
			if (preventScroll) {
				document.body.style.overflow = "visible";
			}
			document.removeEventListener("keydown", onKeyDown);
		};
	});

	return (
		<div className="modal__backdrop">
			<div className="modal__container">
				<div className="modal_box">
					<div className="modal_boxWrap">
						<div className="modal_box_close">
							<button type="button" className="btn_close" onClick={onRequestClose}>
								<svg xmlns="http://www.w3.org/2000/svg" width="18.075" height="18.798" viewBox="0 0 18.075 18.798">
									<g id="close" transform="translate(-325.531 -637.672)">
										<g id="close-2" data-name="close" transform="translate(325.531 637.672)">
											<path
												id="Path_43"
												data-name="Path 43"
												d="M15.945,0,9.038,7.184,2.13,0,0,2.215,6.908,9.4,0,16.583,2.13,18.8l6.908-7.184L15.945,18.8l2.13-2.215L11.167,9.4l6.908-7.184h0Z"
												fill="#000"
											/>
										</g>
										<path
											id="Color_Overlay"
											data-name="Color Overlay"
											d="M334.568,649.286l-6.908,7.184-2.129-2.215,6.908-7.184-6.908-7.185,2.129-2.215,6.908,7.184,6.908-7.184,2.13,2.215-6.908,7.185,6.908,7.184-2.13,2.215Z"
											fill="#000"
										/>
									</g>
								</svg>
							</button>
						</div>
						<div className="modal_body">{children}</div>
					</div>
				</div>
			</div>
			{/* <button className="modal__closeButton" type="button" onClick={onRequestClose}>
				<svg style={{ width: 30, height: 30 }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" enableBackground="new 0 0 40 40">
					<line x1={15} y1={15} x2={25} y2={25} stroke="#fff" strokeWidth="2.5" strokeLinecap="round" strokeMiterlimit={10} />
					<line x1={25} y1={15} x2={15} y2={25} stroke="#fff" strokeWidth="2.5" strokeLinecap="round" strokeMiterlimit={10} />
					<circle
						className="circle"
						cx={20}
						cy={20}
						r={19}
						opacity={0}
						stroke="#000"
						strokeWidth="2.5"
						strokeLinecap="round"
						strokeMiterlimit={10}
						fill="none"
					/>
					<path
						d="M20 1c10.45 0 19 8.55 19 19s-8.55 19-19 19-19-8.55-19-19 8.55-19 19-19z"
						className="progress"
						stroke="#fff"
						strokeWidth="2.5"
						strokeLinecap="round"
						strokeMiterlimit={10}
						fill="none"
					/>
				</svg>
			</button> */}
		</div>
	);
};

export default Modal;
