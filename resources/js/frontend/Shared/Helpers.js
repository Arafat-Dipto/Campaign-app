import { format } from "date-fns";

export const formatDateTime = (dateTime = "", dateFormat = "dd/MM/yyyy, p") => {
	if (dateTime) {
		let date = format(new Date(dateTime), dateFormat);
		return date;
	} else {
		return "";
	}
};

export const findValue = (val = null, options = []) => {
	let obj = null;
	if (val && (val.constructor.name == "String" || val.constructor.name == "Number")) {
		options.map((i, k) => {
			if (i.value == val) {
				obj = i;
			}
		});
	} else if (val && val.constructor.name == "Array") {
		obj = [];
		val.map((j) => {
			obj.push(findValue(j, options));
		});
	}

	return obj;
};

export const makeRandomString = (n = 6) => {
	let text = "";
	let possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

	for (let i = 0; i < n; i++) text += possible.charAt(Math.floor(Math.random() * possible.length));
	return text.toUpperCase();
};
