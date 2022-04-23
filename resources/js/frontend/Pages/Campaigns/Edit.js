import DeleteButton from "@/Shared/DeleteButton";
import Layout from "@/Shared/Layout";
import LoadingButton from "@/Shared/LoadingButton";
import { toFormData } from "@/utils";
import { Inertia } from "@inertiajs/inertia";
import { InertiaLink, usePage } from "@inertiajs/inertia-react";
import React, { useState } from "react";
import Helmet from "react-helmet";
import Form from "./Form";

const Edit = () => {
	const { item, errors, modelName = "", modelNamePlural = "", routeName = "", modelDisplayName = "" } = usePage().props;
	const [sending, setSending] = useState(false);
	const [values, setValues] = useState({
		name: item.name || "",
		total_budget: item.total_budget || "",
		daily_budget: item.daily_budget || "",
		start_date: item.start_date || "",
		end_date: item.end_date || "",
		images: item.images || "",
		order_index: item.order_index || "",
	});

	function handleChange(e) {
		const key = e.target.name;
		const value = e.target.value;
		setValues((values) => ({
			...values,
			[key]: value,
		}));
	}

	function handleFileChange(file, name = "image") {
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

		// NOTE: When working with Laravel PUT/PATCH requests and FormData
		// you SHOULD send POST request and fake the PUT request like this.
		// For more info check utils.jf file
		const formData = toFormData(values, "PUT", true);

		Inertia.post(route(`${routeName}.update`, item.id), formData, {
			onFinish: () => {
				setSending(false);
			},
		});
	}

	function destroy() {
		if (confirm("Are you sure you want to delete this item?")) {
			Inertia.delete(route(`${routeName}.destroy`, item.id));
		}
	}

	return (
		<div>
			<Helmet title={values.name} />
			<div className="mb-8 flex justify-start w-full">
				<h1 className="font-bold text-3xl">
					<InertiaLink href={route(routeName)} className="text-primary hover:text-secondary">
						{modelDisplayName}
					</InertiaLink>
					<span className="text-primary font-medium mx-2">/</span>
					{values.name}
				</h1>
				{item.images && <img className="block h-8 ml-4" src={item.images} />}
			</div>

			<div className="bg-white rounded shadow max-w-3xl">
				<form onSubmit={handleSubmit}>
					<Form values={values} errors={errors} handleSubmit={handleSubmit} handleChange={handleChange} handleFileChange={handleFileChange} />
					<div className="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
						{!item.deleted_at && <DeleteButton onDelete={destroy}>Delete</DeleteButton>}
						<LoadingButton loading={sending} type="submit" className="btn-primary ml-auto">
							Update
						</LoadingButton>
					</div>
				</form>
			</div>
		</div>
	);
};

// Persisten layout
// Docs: https://inertiajs.com/pages#persistent-layouts
Edit.layout = (page) => <Layout children={page} />;

export default Edit;
