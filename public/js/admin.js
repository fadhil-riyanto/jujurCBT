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