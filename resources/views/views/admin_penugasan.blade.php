@extends("layout._layout_admin")

@section("custom_import")
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/css/bootstrap-datepicker3.min.css">
<script src="https://cdn.jsdelivr.net/gh/datejs/Datejs@master/build/date-id-ID.js"></script>
@endsection

@section("content") 
<div class="alert alert-primary mt-1" role="alert">
    Penugasan adalah halaman dimana anda dapat melakukan penjadwalan tes terhadap kelas tertentu, klik tombol dibawah ini untuk menugaskan suatu tes kepada suatu kelas.
</div>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Tambah penugasan
</button>
  
  <!-- Modal -->
  <div class="modal fade modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Isi data dibawah untuk mengatur ujian</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group row mb-1">
                  <label for="inputEmail3" class="col-sm-3 col-form-label">Kelas : </label>
                  <div class="col-sm-9">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          Pilih kelas
                        </button>
                        <ul class="dropdown-menu" id="dropdown_kelas">
                          <!-- <li><a class="dropdown-item" href="#">Action</a></li>
                          <li><a class="dropdown-item" href="#">Another action</a></li>
                          <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                        </ul>
                      </div>
                  </div>
                </div>

                <div class="form-group row mb-1">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Mata pelajaran : </label>
                    <div class="col-sm-9">
                      <div class="dropdown">
                          <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Pilih mata pelajaran yang akan diujikan
                          </button>
                          <ul class="dropdown-menu" id="dropdown_mapel">
                          </ul>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-1">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Pilih tanggal mulai : </label>
                    <div class="col-sm-9">
                        <input data-provide="datepicker" id="date_mulai">
                    </div>
                </div>

                <div class="form-group row mb-1">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Pilih waktu mulai : </label>
                    <div class="col-sm-9">
                        <input type="time" name="" id="time_mulai">
                    </div>
                </div>

                <div class="form-group row mb-1">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Lamanya ujian : </label>
                    <div class="col-sm-9">
                      <div class="dropdown">
                          <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Pilih durasi
                          </button>
                          <ul class="dropdown-menu" id="select_duration_time">
                            <li><a class="dropdown-item select_duration" data-minute="10" href="#">10 menit</a></li>
                            <li><a class="dropdown-item select_duration" data-minute="20" href="#">20 menit</a></li>
                            <li><a class="dropdown-item select_duration" data-minute="30" href="#">30 menit</a></li>
                            <li><a class="dropdown-item select_duration" data-minute="60" href="#">60 menit</a></li>
                            <li><a class="dropdown-item select_duration" data-minute="90" href="#">90 menit</a></li>
                            <li><a class="dropdown-item select_duration" data-minute="120" href="#">120 menit</a></li>
                            <li><a class="dropdown-item select_duration" data-minute="180" href="#">180 menit</a></li>
                            <li><a class="dropdown-item select_duration" data-minute="240" href="#">240 menit</a></li>
                            <li><a class="dropdown-item select_duration" data-minute="300" href="#">300 menit</a></li>
                          </ul>
                        </div>
                    </div>
                </div>
                <br>
                <p>catatan: dengan mengklik simpan, siswa hanya akan dapat melihat soal diwaktu yang telah ditentukan</p>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="savebutton" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <table id="myTable" class="display">
    <thead>
        <tr>
            <th>Kelas</th>
            <th>kode mata pelajaran</th>
            <th>tanggal mulai</th>
            <th>waktu mulai</th>
            <th>Lamanya ujian (menit)</th>
            <th>aksi</th>
        </tr>
    </thead>
</table>
  

@endsection

@section("script")
<script>
    // change state
    sidebar_change_state("#sidebar-penugasan")

    struct_data2sent = {
        kelas: null,
        kode_mapel: null,
        start_date: null,
        start_time: null,
        duration_time: null,

        // gen by system
        unix: null
    }

    function fill_all() {
        $.ajax({
            url: "/api/admin/get_all_available_kelas", 
            success: function(data) {
                for(i = 0; i < data.length; i++) {
                    
                    html = "<li><a class='dropdown-item select_kelas' data-kelas=" + data[i]["data"] + " href='#'>" + data[i]["view"] + "</a></li>";
                    $("#dropdown_kelas").append(html)
                }
            }
        })
        $.ajax({
            url: "/api/admin/getall_mapel", 
            success: function(data) {
                for(i = 0; i < data["data"].length; i++) {
                    html = "<li><a class='dropdown-item select_mapel' data-kode-mapel=" + data["data"][i]["kode_mata_pelajaran"] + " href='#'>" + data["data"][i]["nama_mata_pelajaran"] + "</a></li>";
                    $("#dropdown_mapel").append(html)
                }
            }
        })
    }

    function watcher() {
        $("#dropdown_kelas").on("click", ".select_kelas", function() {
            struct_data2sent.kelas = $(this).data("kelas")
            swal("Terpilih", "kelas : " + $(this).html())
        })

        $("#dropdown_mapel").on("click", ".select_mapel", function() {
            struct_data2sent.kode_mapel = $(this).data("kode-mapel")
            swal("Terpilih", "mata pelajaran : " + $(this).html())
        })

        $("#select_duration_time").on("click", ".select_duration", function() {
            struct_data2sent.duration_time = $(this).data("minute")
            swal("Terpilih", "lama durasi ujian adalah : " + $(this).html())
        })
    }

    function validate() {
        // struct_data2sent = {
        //     kelas: null,
        //     kode_mapel: null,
        //     start_date: null,
        //     start_time: null,
        //     duration_time: null
        // }
        errstr = ""

        if (struct_data2sent.kelas == null ) {
            errstr += "kelas belum diisi\n"
        }
        if (struct_data2sent.kode_mapel == null ) {
            errstr += "kode mata pelajaran belum diisi\n"
        }
        if (struct_data2sent.start_date == "" ) {
            errstr += "tanggal mulai belum diisi\n"
        }
        if (struct_data2sent.start_time == "" ) {
            errstr += "waktu mulai belum diisi\n"
        }
        if (struct_data2sent.duration_time == null ) {
            errstr += "Lamanya ujian belum diisi\n"
        }

        // if (errstr == )
        // console.log()
        if (errstr == "") {
            return 1;
        } else {
            swal("perhatian", errstr)
            return 0;
        }
        
        

    }

    $(function () { 
        $('.datepicker').datepicker();
        fill_all()
        watcher()

        table = new DataTable('#myTable', {
            ajax: '/api/admin/penugasan/getall',
            processing: true,
            serverSide: true,
            columns: [
                {
                    "data": "kelas_id"
                }, {
                    "data": "kode_mapel"
                }, {
                    "data": "start_date"
                }, {
                    "data": "start_time"
                }, {
                    "data": "duration_time"
                }, {
                    "data": "id",
                    render: function(data, type, row, meta) {
                        return "<button type='button' data-id=" + data + " class='btn btn-danger delete_req'>hapus</button>"
                    }

                }
            ]
            // ,
            // order: [
            //     [1, 'asc']
            // ]
        });

        $("#savebutton").click(function() {
            struct_data2sent.start_date = $("#date_mulai").val()
            struct_data2sent.start_time = $("#time_mulai").val()

            if (validate()) {
                struct_data2sent.unix = Date.parse(struct_data2sent.start_date + " " + struct_data2sent.start_time).getTime()/1000
                $.ajax({
                    url: "/api/admin/penugasan/store",
                    data: struct_data2sent,
                    success: function(data) {
                        console.log(data)
                        table.draw()
                    }
                })
            }
        })
        $("#myTable tbody").on("click", ".delete_req", function() {
            console.log($(this).data("id"))
            $.ajax({
                url: "/api/admin/penugasan/delete/" + $(this).data("id"),
                success: function() {
                    table.draw()
                }
            })
        })
    }); 
</script>
@endsection