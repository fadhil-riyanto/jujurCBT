@extends("layout._layout_admin")

@section("content")

<div class="modal" id="modaldeleteconfirm" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="confirm_delete_mapel">
                <div class="modal-header">
                    <h5 class="modal-title">Apakah anda yakin </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>menghapus mata pelajaran maka <b>DATA TIDAK BISA DIKEMBALIKAN</b> sebagaimana sebelumnya, data yang hilang adalah</p>
                    <ul>
                        <li>
                            soal
                        </li>
                        <li>
                            nilai
                        </li>
                        <li>
                            soal essay
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">YAKIN HAPUS!</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="addmatapelajaranmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah mata pelajaran</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="mapelform">
                    <div class="">
                        <label for="recipient-name" class="col-form-label">mata pelajaran:</label>
                        <input type="text" name="mata_pelajaran" class="form-control" id="recipient-name">
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addmatapelajaranmodal">Tambahkan mata pelajaran</button>
<hr>
<table id="daftar_mapel">
    <thead>
        <tr>
            <th>
                Kode pelajaran
            </th>
            <th>Mata pelajaran</th>
            <th>pengampu</th>
            <th>aksi</th>
        </tr>
    </thead>
</table>
@endsection

@section("script")
<script>
    global_selected_mapel = null
    // change state
    sidebar_change_state("#sidebar-soal-assesmen")

    $(document).ready(function() {
        let table = new DataTable("#daftar_mapel", {
            ajax: '/api/admin/getall_mapel',
            processing: true,
            serverSide: true,
            searching: false,
            columns: [{
                    data: "kode_mata_pelajaran",
                },
                {
                    data: "nama_mata_pelajaran",
                },
                {
                    data: "pengampu",
                    render: function(data, type, row, meta) {
                        // console.log(data)
                        // var pengampujoined = data.join(", ")
                        // if (pengampujoined == undefined) {
                        //     return "kosong"
                        // } else {
                        //     return pengampujoined
                        // }
                        console.log(data)
                        return Array.isArray(data) ? data.join(", ") : "kosong";
                    },
                },
                {
                    data: "kode_mata_pelajaran",
                    render: function(data, type, row, meta) {
                        return "<button class='btn btn-danger me-2 btnremoveclick' data-kode-matapelajaran=" + data + ">hapus</button>" +
                            "<button class='btn btn-primary btnedit' data-kode-matapelajaran=" + data + ">edit soal</button>";
                        // return data
                    }
                }
            ]
        });


        $("#mapelform").submit(function(obj) {
            obj.preventDefault();

            console.log($("#mapelform").serialize())
            $.ajax({
                url: "/api/admin/create_mapel",
                data: $("#mapelform").serialize(),
                method: "post",
                success: function(data) {
                    // alert(data)
                    table.draw()
                }
            })
        })

        $("table tbody").on("click", ".btnremoveclick", function(obj) {
            // console.log()
            global_selected_mapel = $(this).data("kode-matapelajaran")
            $("#modaldeleteconfirm").modal("show")
        })

        $("table tbody").on("click", ".btnedit", function(obj) {
            // console.log()
            global_selected_mapel = $(this).data("kode-matapelajaran")
            window.location.href = "/admin/edit_soal?selected=" + global_selected_mapel
        })

        $("#confirm_delete_mapel").submit(function(obj) {
            obj.preventDefault();
            console.log(new URLSearchParams())

            $.ajax({
                url: "/api/admin/remove_mapel",
                data: {
                    "kode_mata_pelajaran": global_selected_mapel,
                    "_token": "{{ csrf_token() }}"
                },
                // processData: true,

                method: "post",
                success: function() {
                    table.draw()
                }
            })
        })
    })
</script>
@endsection