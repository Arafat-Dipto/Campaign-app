import React, { useState, useRef } from "react";
import { filesize } from "@/utils";

const Button = ({ text, onClick }) => (
	<button type="button" className="focus:outline-none px-4 py-1 bg-gray-600 hover:bg-gray-700 rounded-sm text-xs font-medium text-white" onClick={onClick}>
		{text}
	</button>
);

export default ({ className, name, label, accept, errors = [], onChange, currentFleUrl = null }) => {
	const fileInput = useRef();
	const [file, setFile] = useState(null);

	function browse() {
		fileInput.current.click();
	}

	function remove() {
		setFile(null);
		onChange(null);
		fileInput.current.value = null;
	}

	function handleFileChange(e) {
		const file = e.target.files[0];
		setFile(file);
		onChange(file, name);
	}

	return (
		<div className={className}>
			{label && (
				<div className="flex justify-between">
					<label className="form-label" htmlFor={name}>
						{label}:
					</label>
					{currentFleUrl ? (
						<span className="mb-2 text-right">
							<a href={currentFleUrl} target="_blank">
								Current File
							</a>
						</span>
					) : null}
				</div>
			)}
			<div className={`form-input p-0 ${errors.length && "error"}`}>
				<input id={name} ref={fileInput} accept={accept} type="file" className="hidden" onChange={handleFileChange} />
				{!file && (
					<div className="p-2">
						<Button text="Browse" onClick={browse} />
					</div>
				)}
				{file && (
					<div className="flex items-center justify-between p-2 flex-wrap">
						<div className="flex-1 pr-1">
							{file.name}
							<span className="text-gray-600 text-xs ml-1">({filesize(file.size)})</span>
						</div>
						<Button text="Remove" onClick={remove} />
					</div>
				)}
			</div>

			{errors.length > 0 && <div className="form-error">{errors}</div>}
		</div>
	);
};
