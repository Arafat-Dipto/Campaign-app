import TextInput from "@/Shared/TextInput";
import DateTimeInput from "@/Shared/DateTimeInput";
import FileUpload from "@/Shared/FileUpload";
import React, { useRef } from "react";

export default (props) => {
	const { values, errors, handleChange, handleFileChange } = props;

	return (
		<div className="p-8 -mr-6 -mb-8 flex flex-wrap">
			<TextInput
				className="pr-6 pb-3 w-full lg:w-1/2" //
				label="Name"
				name="name"
				errors={errors.name}
				value={values.name}
				onChange={handleChange}
			/>
			<TextInput
				className="pr-6 pb-3 w-full lg:w-1/2"
				label="Total Budget"
				name="total_budget"
				errors={errors.total_budget}
				value={values.total_budget}
				onChange={handleChange}
				type="number"
			/>
			<TextInput
				className="pr-6 pb-3 w-full lg:w-1/2"
				label="Daily Budget"
				name="daily_budget"
				errors={errors.daily_budget}
				value={values.daily_budget}
				onChange={handleChange}
				type="number"
			/>
			<DateTimeInput
				className="pr-6 pb-8 w-full lg:w-1/2"
				label="Start date"
				name="start_date"
				errors={errors.start_date}
				value={values.start_date}
				onChange={handleChange}
				dateFormat="yyyy-MM-dd HH:mm:ss"
				showingDateFormat="MMMM d, yyyy h:mm aa"
			/>
			<DateTimeInput
				className="pr-6 pb-8 w-full lg:w-1/2"
				label="End date"
				name="end_date"
				errFileInputors={errors.end_date}
				value={values.end_date}
				onChange={handleChange}
				dateFormat="yyyy-MM-dd HH:mm:ss"
				showingDateFormat="MMMM d, yyyy h:mm aa"
			/>
			<FileUpload
				className="pr-6 pb-8 w-full lg:w-1/2"
				label="Image"
				name="images"
				accept="image/*"
				errors={errors.images}
				value={values.images}
				onChange={handleFileChange}
			/>
			<TextInput
				className="pr-6 pb-3 w-full lg:w-1/2"
				label="Order Index"
				name="order_index"
				errors={errors.order_index}
				value={values.order_index}
				onChange={handleChange}
				type="number"
			/>
		</div>
	);
};
