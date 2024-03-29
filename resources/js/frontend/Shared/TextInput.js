import React from "react";

export default ({ multiline = false, label, name, className, errors = [], id = null, ...props }) => {
	return (
		<div className={className}>
			{label && (
				<label className="form-label" htmlFor={name}>
					{label}:
				</label>
			)}
			{multiline ? (
				<textarea id={id || name} name={name} {...props} className={`form-input ${errors.length ? "error" : ""}`} />
			) : (
				<input id={id || name} name={name} {...props} className={`form-input ${errors.length ? "error" : ""}`} />
			)}

			{errors && <div className="form-error">{errors}</div>}
		</div>
	);
};
