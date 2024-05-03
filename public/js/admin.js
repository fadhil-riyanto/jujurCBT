function populate_data_siswa_list(index, name, identity, blokir)
{
    var str = 
    "<tr class=\"siswa-data-table\">" + 
        "<td>" + index + "</td>" + 
        "<td>" + name + "</td>" + 
        "<td>" + identity + "</td>" + 
        "<td>" + blokir + "</td>"  + 
        "<td>"  + 
            "<button type=\"button\" class=\"btn-danger\">blokir</button>"  + 
            "<button type=\"button\" class=\"btn-primary\">hapus</button>"  + 
            "<button type=\"button\" class=\"btn-danger\">ubah password</button>"  + 
        "</td>"  + 
    "</tr>"; 

    $("#tabel_siswa").append(str);
}

function populate_kelas_list(data_kelas, view_string) {
    let html = "<div class=\"classlist-list\" data-kelas=\"" + data_kelas + "\"><a href=\"#\">" + view_string + "</a></div>"
    $("#classlist").append(html);
}

function inspect_api_result(data) {
    if (data["log2user_session_state"] == "expired") {
        show_modal("perhatian", "Sesi telah berakhir, silahkan refresh halaman untuk login ulang")
    }
}