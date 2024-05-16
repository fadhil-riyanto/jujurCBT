@extends("layout._layout_admin")

@section("content")

<!-- Modal validation notice  -->
<div class="modal fade" id="validation_failure" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Perhatian</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            mohon pastikan bagian berikut terisi
            <ul>
                <li id="form_validation_soal">
                    Kotak soal
                </li>
                <li id="form_validation_soal_type">
                    Tipe soal
                </li>
                <li id="form_validation_pilihan_ganda_unfilled">
                    Opsi pilihan ganda (jika soal pilihan ganda, bukan essay)
                </li>
                <li id="form_validation_kunci_jawaban">
                    Kunci jawaban
                </li>
            </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  
<!-- Modal -->
<div class="modal fade" id="modal_delete_soal_confirmation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Perhatian</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Apakah anda yakin ingin menghapus soal ini?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-danger" id="soal_delete_confirmed" data-bs-dismiss="modal">YA!</button>
        </div>
      </div>
    </div>
  </div>
  

<div class="d-flex mb-3">
    <a href="#" id="going2soal" class="text-decoration-none px-3 m-1 me-3 custom-link-active">Soal</a>
    <a href="#" id="going2config" class="text-decoration-none px-3 m-1">Pengaturan</a>
    <button class="ms-auto btn btn-secondary m-1" id="addsoal">
        tambah soal
    </button>
</div>
<div class="alert alert-primary mt-2" role="alert">
    untuk melihat preview gambar dan juga memastikan soal tersimpan setelah menambah opsi, pastikan menekan tombol "simpan"
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
        <div class="card" id="soal_input_block">
            <div class="card-body">
                <h5 class="card-header" id="soal_index"></h5>
                <div class="input-group">
                    <textarea class="form-control" placeholder="tulis text soal disini" id="soal_value"></textarea>

                    <button type="button" class="btn btn-outline-secondary">Tipe soal</button>
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item soal_type_selector" href="#" data-tipe-soal="pilihan_ganda">Soal pilihan ganda</a></li>
                        <li><a class="dropdown-item soal_type_selector" href="#" data-tipe-soal="essay">Soal essay</a></li>
                    </ul>
                </div>

                <h5 class="card-header mt-2">Tambah gambar</h5>
                <div class="mb-3">
                    <input class="form-control" type="file" id="upload_file" name="form_file">
                </div>
                <div class="my-2" id="preview_picture">
                    <img src="" alt="preview gambar" class="img-fluid">
                        <div class="d-flex">
                            <button type="button" id="delete_attach" class="ms-auto mt-1 btn btn-secondary">hapus</button>
                        </div>
                    </img>
                    
                </div>

                <div id="pilihan_ganda_option">
                    <h5 class="card-header mt-2">Pilihan</h5>
                    <div id="input_option_list">

                    </div>
                    <div class="dropdown me-2">
                        <a class="btn btn-secondary dropdown-toggle mt-2" id="dropdown-pilih-kelas" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          kunci jawaban
                        </a>
                    
                        <ul class="dropdown-menu" > 
                            <li id="kunci_jawaban">
                                
                            </li>
                        </ul>
                        <b id="literal_kunci_jawaban"></b>
                    </div>
                </div>
                <div id="essay_option">
                    <div class="alert alert-primary" role="alert">
                        Soal ini dikerjakan sebagai isian / essay
                    </div>
                      
                </div>

                <div class="d-flex">
                    <button type="button" id="add_more_options" class="ms-auto btn btn-secondary">Tambah opsi</button>
                    <button type="button" id="dec_more_options" class="ms-1 btn btn-secondary">Kurangi opsi</button>
                    <button type="button" id="save_soal" class="ms-1 btn btn-secondary">Simpan</button>
                    <button type="button" id="hapus_soal" class="ms-1 btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal_delete_soal_confirmation">hapus soal ini</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="d-flex flex-column" id="soal-selector">
        </div>
    </div>
</div>
@endsection
@section("script")
<script>
    global_selected_mapel = null
    global_highest_soal_reached_index = 0
    global_list_stack_literal_inc = 0;
    global_selected_id = 0;
    global_is_saved = 0;

    char_literals = [
        "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", 
        "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"
    ]

    var struct_data2sent = {
        soal: null,
        imglink: null,
        soal_type: "pilihan_ganda", // 2 value, essay or selection
        selection_options: [
            // represents a,b,c etc
        ],
        kunci_jawaban: null
    }

    function show_an_image(url) {
        $("#preview_picture img").prop("src", url)
        $("#preview_picture").show()
    }

    function link_header_setup() {
        $("#going2soal").prop("href", "/admin/edit_soal?selected=" + global_selected_mapel)
        $("#going2config").prop("href", "/admin/edit_soal_setting?selected=" + global_selected_mapel)
    }

    function do_upload() {
        if ($("#upload_file")[0].files.length == 1) {
            var file_data = $('#upload_file').prop('files')[0];
            var form_data = new FormData();                  
            form_data.append('file', file_data);
            $.ajax({
                url: "/api/admin/soal/store_upload_image/" + global_selected_mapel + "/" + global_selected_id,
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(php_script_response){
                    // console.log(php_script_response["errors"])
                    // if (php_script_response["errors"] != undefined) {
                    //     swal("Opps!", "data gagal diupload, pastikan format benar. ulangi dengan memilih gambar lagi");
                    // }
                    
                    show_an_image(php_script_response["image"])
                },
                error: function() {
                    swal("Opps!", "data gagal diupload, pastikan format benar. ulangi dengan memilih gambar lagi");
                }
            });

        }
        

    }

    function setJawabanFE(literal) {
        $("#literal_kunci_jawaban").html()
        if (literal != undefined)
            $("#literal_kunci_jawaban").html("Jawaban nya adalah " + literal)
    }

    function reset_validation_error() {
        $("#form_validation_soal").hide()
        $("#form_validation_soal_type").hide()
        $("#form_validation_pilihan_ganda_unfilled").hide()
        $("#form_validation_kunci_jawaban").hide()
    }

    function validate_form() {
        reset_validation_error()
        error_count = 0
        // make sure everything is filled
        if (struct_data2sent.soal == null || struct_data2sent.soal == "") {
            $("#form_validation_soal").show()
            error_count = error_count + 1
        }
        // if (struct_data2sent.soal_type == null) {
        //     $("#form_validation_soal_type").show()
        //     error_count = error_count + 1
        // }
        if (struct_data2sent.soal_type == "essay") {
            // do nothing
        } else {
            if (struct_data2sent.selection_options.length == 0) {
                $("#form_validation_pilihan_ganda_unfilled").show()
                error_count = error_count + 1
            }
            if (struct_data2sent.kunci_jawaban == null || struct_data2sent.kunci_jawaban == 0) {
                $("#form_validation_kunci_jawaban").show()
                error_count = error_count + 1
            }
        }
        return error_count
    }

    // run this operation only everything is saved
    function reset_everything() {

        struct_data2sent.selection_options = []
        struct_data2sent.imglink = null;
        struct_data2sent.soal = null
        struct_data2sent.kunci_jawaban = null
        global_list_stack_literal_inc = 0
        $("#input_option_list").empty()
        $("#kunci_jawaban").empty()
        $("#soal_value").val("")
        $("#literal_kunci_jawaban").html("")
        $("#preview_picture img").prop("src", "")
        $("#preview_picture").hide()
        $("#upload_file").val("")

    }

    function generate_new_options(literals) {
        var html =  "<div class='input-group my-3' id=" + "d_option_" + literals + ">" +
                        "<span class='input-group-text opsi_pilihan_select'>" + literals + "</span>" +
                        "<input type='text' class='form-control' id=" + "option_" +literals + ">" +
                    "</div>";

        var kunci_jawaban = "<a href='#' class='dropdown-item select-kunci-jawaban' data-kunci-literal=" + literals + ">" + literals + "</a>"

        $("#input_option_list").append(html)
        $("#kunci_jawaban").append(kunci_jawaban)
    }

    function generate_button_list_changer() { // return newest view id
        $("#soal-selector").empty()
        var data2return = {
            "view_id": 0,
            "server_id": 0
        }
        var htmlstr = (literate_int_view, id) => {
            data = "<button type='button' class='btn btn-primary mb-1 change_edit_soal_num' data-id-cureent-soal=" + id + " data-literate-id=" + literate_int_view + ">" + literate_int_view +
                "</button>"
            return data;

        }
        $.ajax({
            url: "/api/admin/soal/get_total_soal_with_ids/" + global_selected_mapel,
            success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    $("#soal-selector").append(htmlstr((i + 1), data[i]["id"]))
                    global_highest_soal_reached_index = i;
                }
            }
        })
    }

    function populate_option() {
        $("#input_option_list").empty()
        $.ajax({
            url: "/api/admin/soal/get_soal_options/" + global_selected_mapel + "/" + global_selected_id,
            success: function(data) {
                for(i = 0; i < data.length; i++) {
                    generate_new_options(char_literals[global_list_stack_literal_inc])
                    $("#option_" + char_literals[global_list_stack_literal_inc]).val(data[i]["pilihan_text"])
                    global_list_stack_literal_inc = global_list_stack_literal_inc + 1 // add +1
                }
            }
        })
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    })

    $(document).ready(function() {
        sidebar_change_state("#sidebar-soal-assesmen")
        $("#soal_input_block").hide()
        $("#preview_picture").hide()
        let selected_mapel = new URLSearchParams(window.location.search)
        global_selected_mapel = selected_mapel.get("selected")
        generate_button_list_changer()
        link_header_setup()

        $("#addsoal").click(function(opt) {
            $("#soal_input_block").show()
            $("#pilihan_ganda_option").show() // pilihan ganda as default
            $("#essay_option").hide()
            // global_highest_soal_reached_index = global_highest_soal_reached_index + 1;
            // $("#soal-selector").append("<button type='button' class='btn btn-primary mb-1 change_edit_soal_num' data-nomor-soal=" + (global_highest_soal_reached_index + 1) + ">" +
            //     (global_highest_soal_reached_index + 1) + "</button>")
            $.ajax({
                url: "/api/admin/soal/create/" + global_selected_mapel,
                method: "POST",
                success: function(data) {
                    // console.log(data)
                    reset_everything()
                    generate_button_list_changer()
                    $("#soal_index").html("Soal " + data["total_soal_len"])
                    global_selected_id = data["new_id"]
                }
            })
        })

        $("#delete_attach").click(function() {
            $("#preview_picture").hide()
            $.ajax({
                url: "/api/admin/soal/hapus_upload_image/" + global_selected_mapel + "/" + global_selected_id,
                method: "POST",
                success: function() {
                    swal("sukses", "gambar dihapus")
                }
            })
        })

        $("#soal_delete_confirmed").click(function() {
            $.ajax({
                url: "/api/admin/soal/delete_soal/" + global_selected_mapel + "/" + global_selected_id,
                success: function() {
                    console.log("berhasil dihapus")
                    $("#soal_input_block").hide()
                    generate_button_list_changer()
                }
            })
        })

        $("#add_more_options").click(function(obj) {
            if ($("#d_option_" + char_literals[global_list_stack_literal_inc]).length != 0) {
                $("#d_option_" + char_literals[global_list_stack_literal_inc]).show()
                
            } else {
                generate_new_options(char_literals[global_list_stack_literal_inc])
            }
            
            global_list_stack_literal_inc = global_list_stack_literal_inc + 1 // add +1
        })

        $("#dec_more_options").click(function() {
            $("#d_option_" + char_literals[global_list_stack_literal_inc - 1]).hide()
            global_list_stack_literal_inc = global_list_stack_literal_inc - 1 // dec stack by 1
        })

        $("#save_soal").click(function(obj) {
            // calculate data offset to insert
            struct_data2sent.soal = $("#soal_value").val()                    // reset soal_value
            if (global_list_stack_literal_inc > 0) {                          // stack >= than 0
                struct_data2sent.selection_options = []                       // reset 0
                for(var x = 0; x < global_list_stack_literal_inc; x++) {      // literate from x to stack
                    struct_data2sent.selection_options.push(                  // selection_options(x + 1) = val
                            $("#option_" + char_literals[x]).val()
                    )
                }
            }

            if (validate_form() == 0) {
                $.ajax({
                    url: "/api/admin/soal/store_soal_jawaban/" + global_selected_mapel + "/" + global_selected_id,
                    data: struct_data2sent,
                    success: function() {
                        global_is_saved = 1;
                        do_upload();
                        swal("Sukses!", "data berhasil disimpan");
                    }
                })
            } else {
                $("#validation_failure").modal("show")
            }
 
            
        })

        $("#soal-selector").on("click", ".change_edit_soal_num", function(opt) {
            
            select_id = $(this).data("id-cureent-soal");
            view_id = $(this).data("literate-id");

            global_selected_id = select_id;

            // get data from ajax
            $("#soal_index").html("Soal " + view_id)
            $.ajax({
                url: "/api/admin/soal/get_soal_details/" + global_selected_mapel + "/" + select_id,
                success: function(data) {
                    reset_everything()

                    // load s
                    $("#soal_value").val(data["text_soal"])
                    struct_data2sent.soal_type = data["tipe_soal"]
                    struct_data2sent.kunci_jawaban = char_literals[data["index_kunci_jawaban"]]
                    global_selected_id = data["id"]

                    
                    $("#soal_input_block").show()
                    
                    if (data["image_soal"] != null) {
                        show_an_image("/api/admin/soal/get_upload_image/" + data["image_soal"])
                    }
                    if (data["tipe_soal"] == "pilihan_ganda") {
                        setJawabanFE(char_literals[data["index_kunci_jawaban"]])
                        populate_option()
                        $("#pilihan_ganda_option").show()
                        $("#essay_option").hide()
                    } else {
                        $("#pilihan_ganda_option").hide()
                        $("#essay_option").show()
                    }
                }
            })

            $("#soal_input_block").show()
        })

        $(".soal_type_selector").click(function(obj) {
            struct_data2sent.soal_type = $(this).data("tipe-soal")
            console.log(struct_data2sent.soal_type)
            if ($(this).data("tipe-soal") == "pilihan_ganda") {
                populate_option()
                $("#pilihan_ganda_option").show()
                $("#essay_option").hide()
            } else {
                $("#pilihan_ganda_option").hide()
                $("#essay_option").show()
            }
        })

        $("#kunci_jawaban").on("click", ".select-kunci-jawaban", function() {
            struct_data2sent.kunci_jawaban = $(this).data("kunci-literal")
            setJawabanFE($(this).data("kunci-literal"))
        })

    })
</script>
@endsection