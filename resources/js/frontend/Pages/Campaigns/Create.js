import Layout from "@/Shared/Layout";
import LoadingButton from "@/Shared/LoadingButton";
import { toFormData } from "@/utils";
import { Inertia } from "@inertiajs/inertia";
import { InertiaLink, usePage } from "@inertiajs/inertia-react";
import React, { useEffect, useRef, useState } from "react";
import Helmet from "react-helmet";
import Form from "./Form";

const Create = () => {
	const { errors, modelName = "", modelNamePlural = "", routeName = "", modelDisplayName = "" } = usePage().props;
	const [sending, setSending] = useState(false);

	const [values, setValues] = useState({
		name: "",
		total_budget: "",
		daily_budget: "",
		start_date: "",
		end_date: "",
		images: "",
		order_index: "",
	});

	// console.log(values.images);

	function handleChange(e) {
		const key = e.target.name;
		const value = e.target.value;
		setValues((values) => ({
			...values,
			[key]: value,
		}));
	}

	function handleFileChange(file, name = "images") {
		setValues((values) => ({
			...values,
			[name]: file,
		}));
	}

	function handleSubmit(e) {
		e.preventDefault();
		setSending(true);

		// since we are uploading an image
		// we need to use FormData object
		// for more info check utils.js
		const formData = toFormData(values, "POST", true);

		Inertia.post(route(`${routeName}.store`), formData, {
			onFinish: () => {
				setSending(false);
			},
		});
	}

	return (
		<div>
			<Helmet title={`Create ${modelDisplayName}`} />
			<div>
				<h1 className="mb-8 font-bold text-3xl">
					<InertiaLink href={route(routeName)} className="text-primary hover:text-secondary">
						{modelDisplayName}
					</InertiaLink>
					<span className="text-primary font-medium"> /</span> Create
				</h1>
			</div>
			<div className="bg-white rounded shadow max-w-3xl">
				<form name="createForm" onSubmit={handleSubmit}>
					<Form values={values} errors={errors} handleSubmit={handleSubmit} handleChange={handleChange} handleFileChange={handleFileChange} />
					<div className="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
						<LoadingButton loading={sending} type="submit" className="btn-primary">
							Create
						</LoadingButton>
					</div>
				</form>
			</div>
		</div>
	);
};

// Persisten layout
// Docs: https://inertiajs.com/pages#persistent-layouts
Create.layout = (page) => <Layout children={page} />;

export default Create;
