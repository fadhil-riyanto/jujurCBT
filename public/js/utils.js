function getTimeStr()
{
	let current = new Date();
	let sec = current.getSeconds()
	let minute = current.getMinutes()
	let hours = current.getHours()
	let format_str = hours + ":" + minute + ":" + sec
	// console.log(format_str);
	return format_str;
}

function setHtml(classname, value)
{
	document.getElementById(classname).innerHTML = value;
}

function close_display(selector)
{
	document.getElementById(selector).style.display = "none";
}

function show_display(selector)
{
	document.getElementById(selector).style.display = "initial";
}

function show_modal(title, text, selector)
{
	document.getElementById("modal-text-txt").innerHTML = title;
	document.getElementById("modal-msg").innerHTML = text;

	show_display(selector);
}