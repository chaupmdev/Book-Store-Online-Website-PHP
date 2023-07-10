const phones = document.querySelectorAll(".phone")
const numbers = document.querySelectorAll(".number")

phones.forEach(phone => phone.addEventListener("input", () => {
    if (phone.value != "") {
        var value = phone.value;
        var x = value.substr(0, value.length - 1);
        phone.value = isNaN(value) ? x : value;
    }
}))
numbers.forEach(num => num.addEventListener("input", () => {
	if(num.value!="")
		{
			var value = num.value;
			var x = value.substr(0, value.length - 1);
			num.value = isNaN(value) ? x : value == 0 ? 1 : value
		}
}))