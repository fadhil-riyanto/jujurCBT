@extends("layout._layout_admin")

@section("content") 

<div class="modal fade" id="addSiswaModal" tabindex="-1" aria-labelledby="addSiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addSiswaModalLabel">Edit</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="add-siswa-form-input" action="/api/admin/add_siswa" method="post" >
            <div class="mb-3">
              <label for="nama-siswa" class="col-form-label">Nama lengkap:</label>
              <input type="text" name="nama" class="form-control" id="nama-siswa">
            </div>
            <div class="mb-3">
                <label for="nama-siswa" class="col-form-label">password:</label>
                <input type="text" name="password" class="form-control" id="nama-siswa">
                <div id="" class="form-text">penting, ingat password sebelum menutup halaman ini, jika lupa silahkan ubah password. password dienkripsi dengan algoritma yang sangat kuat bernama Argon2I</div>
              </div>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">tutup</button>
                <button type="submit" class="btn btn-primary">Tambahkan</button>
              </div>
          </form>
        </div>
        
      </div>
    </div>
  </div>

<div class="d-flex mt-3">
    <div class="dropdown me-2">
        <a class="btn btn-secondary dropdown-toggle " id="dropdown-pilih-kelas" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Pilih kelas
        </a>
      
        <ul class="dropdown-menu" id="pilih-kelas"> 
    
        </ul>
    </div>
    <button type="button" class="btn btn-primary" id="tambah-siswa-button">Tambah siswa</button>

</div>

<table id="datatable-kelas" class="table table-striped" style="width:100%;">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Nomor Ujian</th>
            <th>Blokir</th>
            <th>Opsi</th>
        </tr>
    </thead>

    <tbody id="data-siswa-body">
        
    </tbody>
</table>


@endsection

@section("script")
<script>
    var global_selected_class = null;
    // function list
    function populate_dropdown_choose_class_menu(data) {
        for(i = 0; i < data.length; i++) {
            let html = "<li><a class=\"dropdown-item\" href=\"#\" onclick=\"exec_ajax_table_siswa('" + data[i]["data"] + "')\">" + data[i]["view"] + "</a></li>";
            $("#pilih-kelas").append(html)
        }
        // console.log(data)
    }


    function block_student(nomor_ujian) {
        fetch("/api/admin/block_siswa?" + new URLSearchParams({
            nomor_ujian: nomor_ujian
        })).then(() => exec_ajax_table_siswa(global_selected_class))

    }

    function unblock_student(nomor_ujian) {
        fetch("/api/admin/unblock_siswa?" + new URLSearchParams({
            nomor_ujian: nomor_ujian
        })).then(() => exec_ajax_table_siswa(global_selected_class))
    }

    function populate_class_table(data) {
        console.log(data)
        $('#data-siswa-body').empty();
        for(i = 0; i < data["data"].length; i++) {
            let html = "<tr>" +
                            "<td>" + (i + 1) + "</td>" +
                            "<td>" + data["data"][i]["nama"] + "</td>" +
                            "<td>" + snake_case_tonormal(data["data"][i]["kelas"]) + "</td>" +
                            "<td>" + data["data"][i]["nomor_ujian"] + "</td>" +
                            "<td>" + ((data["data"][i]["blokir"] == 1) ? "Ya" : "Tidak") + "</td>" +
                            "<td>" + 
                                ((data["data"][i]["blokir"] == 1) ? "<button type='button' class='btn btn-secondary' onclick='unblock_student(" + data["data"][i]["nomor_ujian"] + ")'>Buka blokir</button>" : "<button type='button' class='btn btn-secondary' onclick='block_student(" + data["data"][i]["nomor_ujian"] + ")'>Blokir sekarang</button>") +
                        "</td>" +
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
            
            // console.log(selected_kelas)
            populate_class_table(decoded)
            $("#datatable-kelas").show()
            $('#datatable-kelas').DataTable();
            $("#tambah-siswa-button").show()
        })

        global_selected_class = selected_kelas

        $("#dropdown-pilih-kelas").html(snake_case_tonormal(global_selected_class))
    }

    $(document).ready(function () {
        // hide table first
        $("#datatable-kelas").hide()
        $("#tambah-siswa-button").hide()

        // change state
        sidebar_change_state("#sidebar-peserta-assesmen")

        // main
        // reg to get class list
        fetch("/api/admin/get_all_available_kelas").then((response) => response.json())
        .then((decoded) => {
            inspect_api_session(decoded)
            if (decoded.length == 0) {
                $("#dropdown-pilih-kelas").click(function() {
                    bs5_show_modal_alert("Perhatian", "tidak ada kelas untuk ditampilkan, silahkan klik bagian manajemen kelas")
                })
            } else {
                populate_dropdown_choose_class_menu(decoded)
            }
        })

        $("#tambah-siswa-button").click(() => {
            // alert("start add " + global_selected_class)
            const myModal = new bootstrap.Modal('#addSiswaModal', {
                backdrop: "static"
            }).show()

            
        })
        
        
        
    });
    $("#add-siswa-form-input").submit(function(e) {
            e.preventDefault()
            console.log("clicked")

            var form = $(this);
            var url = form.attr('action');


            // var form = $(this);
            // var url = form.attr('action');
            // console.log(form.serialize() + "&kelas=" + global_selected_class)
            $.ajax({
                type: "POST", 
                url: url,
                data: form.serialize() + "&kelas=" + global_selected_class,
                success: (data) => {
                    alert(data)
                    exec_ajax_table_siswa(global_selected_class)
                }
            })


            // alert("doing add " + global_selected_class)

        })

    
</script>
@endsection