@extends("layout._layout_admin")

@section("content")

<div class="d-flex mb-3">
    <a href="#" id="going2soal" class="text-decoration-none px-3 m-1 me-3">Soal</a>
    <a href="#" id="going2config" class="text-decoration-none px-3 m-1 custom-link-active">Pengaturan</a>
</div>

<div class="row">
    <div class="col-4">
        <h5>pengaturan soal</h5>
        <form id="settings">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="allow_copy" name="allow_copy">
                <label class="form-check-label" for="flexSwitchCheckDefault">Perbolehkan siswa menyalin soal</label>
            </div>
            
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="enable_right_click" name="enable_right_click">
                <label class="form-check-label" for="flexSwitchCheckDefault">Perbolehkan siswa mengklik kanan (komputer)</label>
            </div>
        </form>
    </div>
    <div class="col-4">
        <h5>daftar pengampu</h5>
        <div class="btn-group">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Daftar user
            </button>
            <ul class="dropdown-menu" id="data_pengampu">
                
            </ul>
            <button class="btn btn-secondary ms-1" id="pengampu_reset" type="button">
                Reset 
            </button>
          </div>
    </div>
    <div class="col-4">
        <ol id="pengampu_append">
            
        </ol>
    </div>
    
</div>
<button type="button" id="saveconf" class="btn btn-secondary">simpan</button>
@endsection

@section("script")
<script>
    let global_pengampulist = new Set();
    global_selected_mapel = null

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    })

    let structdata2sent = {
        allow_copy: null,
        enable_right_click: null,
        pengampu: null
    }

    function link_header_setup() {
        $("#going2soal").prop("href", "/admin/edit_soal?selected=" + global_selected_mapel)
        $("#going2config").prop("href", "/admin/edit_soal_setting?selected=" + global_selected_mapel)
    }

    function populate_pengampu_data() {
        $.ajax({
            url: "/api/admin/pengajar",
            success: function(data) {
                for(let i = 0; i < data["data"].length; i++) {
                    html = "<li><a class='dropdown-item select_pengampu' href='#' data-pengampu=" + data["data"][i]["id"] + ">" + data["data"][i]["nama"] + "</a></li>"
                    $("#data_pengampu").append(html)
                }
                
            }
        })
    }

    function load_data() {
        $.ajax({
            url: "/api/admin/get_mapel_info/" + global_selected_mapel,
            success: function(data) {
                console.log(data)
                $("#allow_copy").prop("checked", data["allow_copy"])
                $("#enable_right_click").prop("checked", data["enable_right_click"])

                $.ajax({
                    url: "/api/admin/pengajar",
                    success: function(datanew) {
                        for(let i = 0; i < datanew["data"].length; i++) {
                            if (data["pengampu"].includes(datanew["data"][i]["id"])) {
                                $("#pengampu_append").append("<li>" + datanew["data"][i]["nama"] + "</li>")
                                global_pengampulist.add(datanew["data"][i]["id"])
                            }
                        }
                        
                    }
                })
            }
        })
    }
    $(document).ready(function() {
        let selected_mapel = new URLSearchParams(window.location.search)
        global_selected_mapel = selected_mapel.get("selected")

        populate_pengampu_data()
        link_header_setup()
        load_data()

        $("#data_pengampu").on("click", ".select_pengampu", function() {
            console.log($(this).data("pengampu"))
            
            if (!global_pengampulist.has($(this).data("pengampu"))) {
                global_pengampulist.add($(this).data("pengampu"))
                $("#pengampu_append").append("<li>" + $(this).html() + "</li>")
            }
        })

        $("#pengampu_reset").click(function() {
            global_pengampulist.clear();
            $("#pengampu_append").empty()
        })

        $("#saveconf").click(function() {
            structdata2sent.allow_copy = $("#allow_copy").is(":checked")
            structdata2sent.enable_right_click = $("#enable_right_click").is(":checked")
            structdata2sent.pengampu = Array.from(global_pengampulist)
            // console.log(structdata2sent)
            $.ajax({
                url: "/api/admin/set_mapel_config/" + global_selected_mapel,
                data: structdata2sent,
                method: "post", 
                success: function(data) {
                    // console.log(data)
                    swal("sukses", "pengaturan disimpan!")
                }

            })
        })
    })
</script>
@endsection