@extends("layout._layout_admin")

@section("content") 

<!-- hidden by default  -->
<div class="modal fade" id="modal-confirm-delete" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modal-confirm-deleteLabel">Perhatian</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          apakah anda yakin ingin menghapus kelas? jika kelas dihapus, maka semua siwa yang terkait dengan kelas tersebut tidak akan muncul di dashboard peserta assesmen, dan tentunya siswa tidak akan bisa login lagi
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="button" id="btn-remove-confirmed" class="btn btn-primary" data-bs-dismiss="modal">Hapus!</button>
        </div>
      </div>
    </div>
  </div>

  
<div class="d-flex">
    <div class="col-4 mt-2">
        <p>form tambah kelas</p>
        <hr>
        <form method="post" action="/api/admin/add_kelas" id="form-tambah-kelas">
            <div class="mb-3">
              <label for="inputkelas" class="form-label">Nama kelas</label>
              <input type="text" name="kelas" class="form-control" id="inputkelas" aria-describedby="emailHelp">
              <div id="" class="form-text">masukkan nama kelas dengan jelas, contoh 12 TKJ 1, 10 TKJ industri, 9A, 3 Alpha, dst<br><br>Nama kelas yang sudah ada tidak akan bisa ditambahkan</div>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
           
            <button type="submit" class="btn btn-primary">Tambahkan!</button>
          </form>
    </div>
    <div class="col-8 mt-2 ms-5 me-5">
        <table id="table-kelas" style="width: 100%;">
            <thead>
                <tr>
                    <th>nomor</th>
                    <th>kelas</th>
                    <th>aksi</th>
                </tr>
            </thead>
            <tbody id="daftar-kelas-tersedia">
                
            </tbody>
        </table>
    </div>
</div>
@endsection

@section("script")
<script>

    adatatableajax = new datatables_ajax("/api/admin/get_all_available_kelas", "#daftar-kelas-tersedia", function(i, data){
        return "<tr>" +
            "<td>" + i + "</td>" +
            "<td>" + data["view"] + "</td>" +
            "<td><button type='button' class='btn btn-danger' onclick=\'btn_call_remove(\"" + data["data"] + "\")\' data-kelas='" + data["data"] + "'>hapus kelas</button></td>" +
            "</tr>";
    })

    function db_getupdates() {
        fetch()
    }

    function btn_call_remove(data) {
        console.log(data)
        // $("#modal-confirm-delete").show()
        const myModal = new bootstrap.Modal('#modal-confirm-delete', {
            backdrop: "static"
        }).show()

        $("#btn-remove-confirmed").click(function() {
            fetch("/api/admin/remove_kelas?" + new URLSearchParams({
                _token: "{{ csrf_token() }}",
                kelas: data,
            }), {method: "POST"})
            .then(() => adatatableajax.update())
        })

        // const myModalAlternative = new bootstrap.Modal('#modal-confirm-delete', Option: {bacld})
    }
    $(document).ready(function () {
        // $('#table-kelas').hide()
        
        adatatableajax.exec()
        
        // $('#table-kelas').show()

        $("#form-tambah-kelas").submit(function(e) {
            e.preventDefault()
            
            var form = $(this);
            var actionUrl = form.attr('action');

            
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                    adatatableajax.update()
                }
            });
        })

        $("#btn-remove-class").click(function() {
            console.log("ww")
        })
        
        
    })

    
    
    // change state
    sidebar_change_state("#sidebar-manajemen-kelas")
</script>
@endsection