@extends("layout._layout_admin")

@section("content")
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mt-2" id="addbtnevent">
    Tambah pengajar
</button>

<!-- modal  -->
<div class="modal fade" id="modal-data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal-title"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalform">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">nama:</label>
                        <input type="text" name="nama" class="form-control" required />
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">username:</label>
                        <input type="text" name="username" class="form-control" required />
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">password:</label>
                        <input type="text" name="password" class="form-control" required>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="clicksave">simpan!</button>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<table id="daftar_pengajar">
    <thead>
        <tr>
            <th></th>
            <th>nama</th>
            <th>username</th>
            <th>aksi</th>
        </tr>
    </thead>
</table>

@endsection

@section("script")
<script>
    let global_id_var = null;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });

    // change state
    sidebar_change_state("#sidebar-atur-pengajar")

    $(document).ready(function() {
        let table = new DataTable('#daftar_pengajar', {
            serverSide: true,
            ajax: '{{ route("pengajar.index") }}',
            columns: [{

                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": "nama"
                }, {
                    "data": "username"
                }, {
                    "data": "aksi"
                }
            ],
            order: [
                [1, 'asc']
            ]
        });

        $("#addbtnevent").click(function(obj) {
            $('#modalform').trigger("reset");
            $("#modal-title").html("Tambahkan pengajar");
            $("input[name='password']").attr("placeholder", "isi password disini");
            $("#clicksave").val("create-data")
            $("#modal-data").modal("show")
        })

        $("#modalform").submit(function(obj) {
            obj.preventDefault()
            isvalid = $("#modalform").validate()

            if ($("#clicksave").val() == "create-data") {
                $.ajax({
                    data: $("#modalform").serialize(),
                    url: "{{ route('pengajar.store') }}",
                    type: 'POST',
                    success: function() {
                        table.draw()
                        $("#modal-data").modal("hide")
                    }
                })
                // console.log($("#modalform"))
            } else if ($("#clicksave").val() == "edit-data") {
                $.ajax({
                    data: $("#modalform").serialize(),
                    url: "{{ route('pengajar.index') }}/" + global_id_var,
                    type: 'PUT',
                    success: function() {
                        table.draw()
                        $("#modal-data").modal("hide")
                    }
                })
            }
        })

        $('#daftar_pengajar tbody').on("click", '.btnedit', function(obj) {
            // console.log("clicked") 
            let id2edit = $(this).data("id")
            global_id_var = id2edit
            $.ajax({
                url: "{{ route('pengajar.index') }}" + "/" + id2edit + "/edit",
                method: "get",
                success: function(data) {
                    $('#modalform').trigger("reset");
                    $("#modal-title").html("Edit pengajar");
                    $("input[name='nama']").val(data["nama"])
                    $("input[name='username']").val(data["username"])
                    $("input[name='password']").attr("placeholder", "ubah password disini");
                    $("#clicksave").val("edit-data")
                    $("#modal-data").modal("show")
                }
            })

        })

        $('#daftar_pengajar tbody').on("click", '.btndelete', function(obj) {
            let id = $(this).data("id")
            // console.log("delere req " + id)
            $.ajax({
                url: "{{ route('pengajar.index') }}/" + id,
                method: "DELETE",
                success: function() {
                    table.draw()
                }
            })
        })






    })
</script>
@endsection