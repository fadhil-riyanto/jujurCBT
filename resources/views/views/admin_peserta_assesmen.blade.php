@extends("layout._layout_admin")

@section("content") 

<div class="dropdown">
    <a class="btn btn-secondary dropdown-toggle mt-3" id="dropdown-pilih-kelas" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      Pilih kelas
    </a>
  
    <ul class="dropdown-menu" id="pilih-kelas"> 

    </ul>
</div>

<table id="datatable-kelas" class="table table-striped" style="width:100%;">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Nomor Ujian</th>
            <th>Blokir</th>
        </tr>
    </thead>

    <tbody id="data-siswa-body">
        
    </tbody>
</table>


@endsection

@section("script")
<script>
    // function list
    function populate_dropdown_choose_class_menu(data) {
        for(i = 0; i < data.length; i++) {
            let html = "<li><a class=\"dropdown-item\" href=\"#\" onclick=\"exec_ajax_table_siswa('" + data[i]["data"] + "')\">" + data[i]["view"] + "</a></li>";
            $("#pilih-kelas").append(html)
        }
        // console.log(data)
    }

    function populate_class_table(data) {
        $('#data-siswa-body').empty();
        for(i = 0; i < data["data"].length; i++) {
            let html = "<tr>" +
                            "<td>" + (i + 1) + "</td>" +
                            "<td>" + data["data"][i]["nama"] + "</td>" +
                            "<td>" + data["data"][i]["kelas"] + "</td>" +
                            "<td>" + data["data"][i]["nomor_ujian"] + "</td>" +
                            "<td>" + ((data["data"][i]["blokir"] == 1) ? "Ya" : "Tidak") + "</td>" +
                        "</tr>";
            console.log(html)
            $("#data-siswa-body").append(html)
            
        }
        // console.log(data)
    }


    function exec_ajax_table_siswa(selected_kelas) {
        console.log(selected_kelas)
        fetch("/api/admin/get_siswa_by_kelas?" + new URLSearchParams({
            kelas: selected_kelas
        })).then((response) => {
            return response.json()
        }).then((decoded) => {
            // remove old data
            
            console.log(decoded)
            populate_class_table(decoded)
            $("#datatable-kelas").show()
            $('#datatable-kelas').DataTable();
        })
    }

    $(document).ready(function () {
        // hide table first
        $("#datatable-kelas").hide()

        // change state
        sidebar_change_state("#sidebar-peserta-assesmen")

        // main
        // reg to get class list
        fetch("/api/admin/get_all_available_kelas").then((response) => response.json())
        .then((decoded) => {
            inspect_api_session(decoded)
            if (decoded.length == 0) {
                $("#dropdown-pilih-kelas").click(function() {
                    bs5_show_modal_alert("Perhatian", "tidak ada kelas untuk ditampilkan")
                })
            } else {
                populate_dropdown_choose_class_menu(decoded)
            }
        })

        
    });

    
</script>
@endsection