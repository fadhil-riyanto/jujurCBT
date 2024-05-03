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

function show_modal(title, text)
{
	document.getElementById("modal-text-txt").innerHTML = title;
	document.getElementById("modal-msg").innerHTML = text;

	show_display("modal-container-login-notify");
}

function show_modal_indenpendent(title, id)
{
	document.getElementById("modal-text-txt-idn").innerHTML = title;

	show_display(id);
}

function watch_element(ids, index, callback) {
	console.log("selected ")
	callback(index);
}

function refresh_siswa_table(selected_kelas, csrf_token) {
	$.ajax({
		url: "/api/admin/get_siswa_by_kelas",
		method: "POST",
		data: jQuery.param({
			"kelas": selected_kelas,
			"_token": csrf_token
		}),
		success: function (response) {
			console.log(response)
			inspect_api_result(response)
			if (response["data"].length == 0) {
				show_modal("perhatian", "data kosong")
				$(".siswa-data-table").remove()
				$(".user-table").hide()
			} else {
				$(".siswa-data-table").remove()
				for(i = 0; i < response["data"].length; i++) {
					populate_data_siswa_list(i + 1, response["data"][i]["nama"], response["data"][i]["nomor_ujian"], (response["data"][i]["nomor_ujian"] == 0 ? "tidak" : "ya"))
					console.log("loop")
				}
				// console.log(response["data"][0])
				
				$(".user-table").show()
			}
			
		}
	})
}