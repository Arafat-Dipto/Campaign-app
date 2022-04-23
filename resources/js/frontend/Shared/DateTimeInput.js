import React from "react";
import DatePicker from "react-datepicker";
import { formatDateTime } from "@/Shared/Helpers";

export default ({
	label,
	name,
	className,
	errors = [], //
	showTimeSelect = true,
	showingDateFormat = "MMMM d, yyyy",
	dateFormat = "yyyy-MM-dd",
	showTimeSelectOnly = false,
	isClearable = true,
	minDate = null,
	maxDate = null,
	minTime = null,
	maxTime = null,
	timeIntervals = 15,
	...props
}) => {
	return (
		<div className={className}>
			{label && (
				<label className="form-label" htmlFor={name}>
					{label}:
				</label>
			)}
			{/* <input
                id={name}
                name={name}
                {...props}
                className={`form-input ${errors.length ? "error" : ""}`}
            /> */}
			{showTimeSelectOnly ? (
				<DatePicker
					selected={props.value ? new Date(props.value) : ""}
					onChange={(date) => {
						props.onChange({
							target: {
								name: name,
								value: formatDateTime(date, "yyyy-MM-dd HH:mm:ss"),
							},
						});
					}}
					className={`form-input ${errors.length ? "error" : ""}`}
					showTimeSelect={showTimeSelect}
					showTimeSelectOnly={showTimeSelectOnly}
					timeIntervals={timeIntervals}
					timeCaption="Time"
					// dateFormat="h:mm aa"
					dateFormat={showingDateFormat}
					isClearable={isClearable}
					withPortal
				/>
			) : (
				<DatePicker
					selected={props.value ? new Date(props.value) : ""}
					onChange={(date) => {
						// console.log(
						//     date,
						//     formatDateTime(date, "YYYY-MM-DD HH:mm:ss")
						// );
						// console.log(formatDateTime(date, "yyyy-MM-dd HH:mm:ss"));
						props.onChange({
							target: {
								name: name,
								value: formatDateTime(date, dateFormat),
							},
						});
					}}
					className={`form-input ${errors.length ? "error" : ""}`}
					dateFormat={showingDateFormat}
					// minDate={new Date()}
					timeIntervals={timeIntervals}
					showTimeSelect={showTimeSelect}
					peekNextMonth
					showMonthDropdown
					showYearDropdown
					dropdownMode="select"
					isClearable={isClearable}
					minDate={minDate}
					maxDate={maxDate}
					minTime={minTime}
					maxTime={maxTime}
					withPortal
				/>
			)}

			{errors && <div className="form-error text-danger">{errors}</div>}
		</div>
	);
};
