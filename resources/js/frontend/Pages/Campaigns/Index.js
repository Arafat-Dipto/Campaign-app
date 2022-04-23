import React from "react";
import Helmet from "react-helmet";
import { InertiaLink, usePage } from "@inertiajs/inertia-react";
import Layout from "@/Shared/Layout";
import DialogModal from "@/Shared/DialogModal";
import Icon from "@/Shared/Icon";
import Pagination from "@/Shared/Pagination";

const Index = () => {
	const { items, modelName = "", modelNamePlural = "", routeName = "", modelDisplayName = "" } = usePage().props;
	const { data, links } = items;
	return (
		<div className="max-w-3xl">
			<Helmet title={modelDisplayName} />
			<h1 className="mb-8 font-bold text-3xl">{modelDisplayName}</h1>
			<div className="mb-6 flex justify-between items-center">
				<InertiaLink className="btn-primary" href={route(`${routeName}.create`)}>
					<span>Create</span>
					<span className="hidden md:inline"> New</span>
				</InertiaLink>
			</div>
			<div className="bg-white rounded shadow overflow-x-auto">
				<table className="w-full whitespace-no-wrap">
					<thead>
						<tr className="text-left font-bold">
							<th className="px-6 pt-5 pb-4">Title</th>
							<th className="px-6 pt-5 pb-4">Total Budget</th>
							<th className="px-6 pt-5 pb-4">Daily Budget</th>
							<th className="px-6 pt-5 pb-4">Start date</th>
							<th className="px-6 pt-5 pb-4">End Date</th>
							<th className="px-6 pt-5 pb-4">Order</th>
							<th className="px-6 pt-5 pb-4">View</th>
						</tr>
					</thead>
					<tbody>
						{data.map(({ id, name, images, total_budget, daily_budget, start_date, end_date, order_index }, key) => {
							return (
								<React.Fragment key={id}>
									<tr className="hover:bg-gray-100 focus-within:bg-gray-100">
										<td className="border-t">
											<InertiaLink href={route(`${routeName}.edit`, id)} className="px-6 py-4 flex items-center focus:text-secondary">
												{images && <img src={images} className="block h-5 mr-2 -my-2" />}
												{name}
											</InertiaLink>
										</td>
										<td className="border-t">
											<InertiaLink href={route(`${routeName}.edit`, id)} className="px-6 py-4 flex items-center focus:text-secondary">
												{/* {image && <img src={image} className="block h-5 mr-2 -my-2" />} */}
												{total_budget}
											</InertiaLink>
										</td>
										<td className="border-t">
											<InertiaLink href={route(`${routeName}.edit`, id)} className="px-6 py-4 flex items-center focus:text-secondary">
												{/* {image && <img src={image} className="block h-5 mr-2 -my-2" />} */}
												{daily_budget}
											</InertiaLink>
										</td>
										<td className="border-t">
											<InertiaLink href={route(`${routeName}.edit`, id)} className="px-6 py-4 flex items-center focus:text-secondary">
												{/* {image && <img src={image} className="block h-5 mr-2 -my-2" />} */}
												{start_date}
											</InertiaLink>
										</td>
										<td className="border-t">
											<InertiaLink href={route(`${routeName}.edit`, id)} className="px-6 py-4 flex items-center focus:text-secondary">
												{/* {image && <img src={image} className="block h-5 mr-2 -my-2" />} */}
												{end_date}
											</InertiaLink>
										</td>
										<td className="border-t">
											<InertiaLink href={route(`${routeName}.edit`, id)} className="px-6 py-4 flex items-center focus:text-secondary">
												{order_index}
											</InertiaLink>
										</td>

										<td>
											<DialogModal
												buttonComponent={
													<span className="btn-primary flex justify-center items-center mx-2">
														<Icon name="wand" className="h-4 w-4 text-white mr-2" />
														<span>View</span>
													</span>
												}
												modalTitle="View Item"
											>
												<div className="p-5">
													<ul>
														<li className="py-2">{images && <img src={images} className="block h-5 mr-2 my-2" />}</li>
														<li className="py-2">Name : {name}</li>
														<li className="py-2">Total Budget : {total_budget}</li>
														<li className="py-2">Daily Budget : {daily_budget}</li>
														<li className="py-2">Start Date : {start_date}</li>
														<li className="py-2">End Date : {end_date}</li>
													</ul>
												</div>
											</DialogModal>
										</td>
										<td className="border-t w-px">
											<InertiaLink tabIndex="-1" href={route(`${routeName}.edit`, id)} className="px-4 flex items-center">
												<Icon name="cheveron-right" className="block w-6 h-6 text-gray-400 fill-current" />
											</InertiaLink>
										</td>
									</tr>
								</React.Fragment>
							);
						})}
						{data.length === 0 && (
							<tr>
								<td className="border-t px-6 py-4" colSpan="7">
									No items found.
								</td>
							</tr>
						)}
					</tbody>
				</table>
			</div>
			<Pagination links={links} />
		</div>
	);
};

// Persisten layout
// Docs: https://inertiajs.com/pages#persistent-layouts
Index.layout = (page) => <Layout children={page} />;
export default Index;
