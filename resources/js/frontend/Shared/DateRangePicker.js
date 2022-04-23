import React, { useState, useEffect } from "react";
import { DateRangePicker } from "react-date-range";
import { addDays, format } from "date-fns";
import Modal from "@/Shared/Modal";

export default ({
	children = null,
	renderButton = null,
	buttonClassName = "btn-primary flex justify-center items-center",
	handleConfirm = null,
	label,
	name,
	className,
	errors = [], //
	...props
}) => {
	const [state, setState] = useState([
		{
			startDate: new Date(),
			endDate: addDays(new Date(), 7),
			key: "selection",
		},
	]);

	const [showModal, setShowModal] = useState(false);

	useEffect(() => {
		// console.log(props.value);
		if (props.value) {
			const vals = props.value.split("--");
			// console.log(vals);
			if (vals.length === 2) {
				setState([
					{
						startDate: new Date(vals[0]),
						endDate: new Date(vals[1]),
						key: "selection",
					},
				]);
			}
		}
	}, [props.value]);

	return (
		<div className={className}>
			{label && !renderButton && (
				<label className="form-label" htmlFor={name}>
					{label}:
				</label>
			)}
			<input
				id={name}
				name={name}
				// {...props}
				className={`form-input ${errors.length ? "error" : ""} ${renderButton ? "hidden" : ""}`}
				readOnly={true}
				onClick={() => setShowModal(true)}
				value={props.value || ""}
			/>
			{renderButton ? (
				<button onClick={() => setShowModal(true)} className={buttonClassName}>
					{renderButton}
				</button>
			) : null}
			{errors && !renderButton && <div className="form-error text-danger">{errors}</div>}
			{showModal ? (
				<Modal
					onRequestClose={() => {
						setShowModal(false);
					}}
				>
					<div className="flex flex-col bg-white rounded shadow">
						<div className="w-full">
							<DateRangePicker
								onChange={(item) => {
									// console.log(item);
									props.onChange({
										target: {
											name: name,
											value: `${format(item.selection.startDate, "yyyy-MM-dd")}--${format(item.selection.endDate, "yyyy-MM-dd")}`,
										},
									});
									setState([item.selection]);
								}}
								showSelectionPreview={true}
								moveRangeOnFirstSelection={false}
								months={2}
								ranges={state}
								direction="horizontal"
								weekStartsOn={6}
							/>
						</div>
						{children && <div className="w-full">{children}</div>}
						<div className="w-full px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
							<button
								onClick={() => {
									setShowModal(false);
									if (handleConfirm) {
										handleConfirm();
									}
								}}
								className="btn-primary"
							>
								Ok
							</button>
						</div>
					</div>
				</Modal>
			) : null}
		</div>
	);
};
