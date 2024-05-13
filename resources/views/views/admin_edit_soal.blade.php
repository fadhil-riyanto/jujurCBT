@extends("layout._layout_admin")

@section("content")
<div class="d-flex mb-3">
    <a href="#" class="text-decoration-none px-3 m-1 me-3 custom-link-active">Soal</a>
    <a href="#" class="text-decoration-none px-3 m-1">Pengaturan</a>
    <button class="ms-auto btn btn-secondary m-1" id="addsoal">
        tambah soal
    </button>
</div>
<div class="row">
    <div class="col-10">
        <!-- <div id="input-soal" class="custom-soal-on-edit p-3 rounded">
            <form id="input_soal_form">
                <div class="input-group input-group-sm mb-3">
                    <input type="text" class="form-control" id="input-title">
                </div>

            </form>
        </div> -->
        <div class="card" id="soal1">
            <h5 class="card-header">Soal nomor 1</h5>
            <div class="card-body">
                <div class="input-group">
                    <textarea class="form-control" placeholder="tulis text soal disini" id="floatingTextarea"></textarea>
                    <label class="input-group-text" for="inputGroupFile02">Upload gambar</label>
                    <button type="button" class="btn btn-outline-secondary">Tipe soal</button>
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Soal pilihan ganda</a></li>
                        <li><a class="dropdown-item" href="#">Soal essay</a></li>
                    </ul>
                </div>

                <div class="input-group my-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Default</span>
                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>

                <div class="d-flex">
                    <button type="button" class="ms-auto btn btn-secondary">Tambah opsi</button>
                    <button type="button" class="ms-1 btn btn-secondary">Simpan</button>
                    <button type="button" class="ms-1 btn btn-danger">hapus soal ini</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="d-flex flex-column" id="soal-selector">
            <button type="button" class="btn btn-primary mb-1 change_edit_soal_num" data-nomor-soal="1">1</button>
        </div>
    </div>
</div>
@endsection
@section("script")
<script>
    global_selected_mapel = null
    global_highest_soal_reached_index = 0

    var struct_data2sent = {
        soal: null,
        imglink: null,
        soal_type: null, // 2 value, essay or selection
        selection_options: [
            // represents a,b,c etc
        ],


    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    })

    $(document).ready(function() {
        sidebar_change_state("#sidebar-soal-assesmen")
        let selected_mapel = new URLSearchParams(window.location.search)
        global_selected_mapel = selected_mapel.get("selected")

        $("#addsoal").click(function(opt) {
            // global_highest_soal_reached_index = global_highest_soal_reached_index + 1;
            // $("#soal-selector").append("<button type='button' class='btn btn-primary mb-1 change_edit_soal_num' data-nomor-soal=" + (global_highest_soal_reached_index + 1) + ">" +
            //     (global_highest_soal_reached_index + 1) + "</button>")
            $.ajax({
                url: "/api/admin/soal/create/" + global_selected_mapel,
                method: "POST",
                success: function(data) {
                    console.log(data)
                }
            })
        })

        $(".change_edit_soal_num").click(function(opt) {
            alert($(this).data("nomor-soal"))
        })

    })
</script>
@endsection