@extends("layout._layout_pengajar")

@section("content") 



<div class="modal fade" id="modalAskVal" tabindex="-1" aria-labelledby="modalAskValLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalAskValLabel">New message</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="dropdown-center">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Pilih proporsi penilaian essay
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item data-selected-bobot-hook" href="#" data-value="25">1 / 4</a></li>
                  <li><a class="dropdown-item data-selected-bobot-hook" href="#" data-value="50">1 / 2</a></li>
                  <li><a class="dropdown-item data-selected-bobot-hook" href="#" data-value="75">3 / 4</a></li>
                </ul>
            </div>
          </form>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="save">simpan</button>
          </div>
        </div>
        
      </div>
    </div>
  </div>

<div class="row">
    @foreach ($data as $data_s)
    <div class="col-6">
        <div class="card">
            <h5 class="card-header">{{ normal2snake_case_invers($data_s["kelas_id"]) }}</h5>
            <div class="card-body">
                <h5 class="card-title">{{ $data_s["nama_mapel"] }} (ujian tanggal {{ $data_s["start_date"] }})</h5>
                <p class="card-text">mulai: {{ $data_s["start_time"] }}</p>
                <p class="card-text">berakhir: {{ add_unix_mins_return_format($data_s["unix"], $data_s["duration_time"], "H:i") }}</p>

                @if ($data_s["has_essay"] == true)
                <!-- <a href="/pengajar/koreksi_essay/validasi?kelas={{ $data_s['kelas_id'] }}&penugasan_id={{ $data_s['id'] }}&kode_mapel={{ $data_s['kode_mapel'] }}" class="btn btn-primary">Atur proporsi nilai</a> -->
                <button type="button" class="btn btn-primary modal-btn-hook" data-bs-toggle="modal" data-bs-target="#modalAskVal" data-penugasan-id="{{ $data_s['id'] }}">Ubah parameter</button>
                @else
                
                <button class="btn btn-primary" disabled>Atur proporsi nilai</button>
                <i>mapel ini tidak ada soal essay nya</i>
                @endif
            
            </div>
          </div>
    </div>
    @endforeach
    
</div>
@endsection

@section("script")
<script>
    let selected = null
    let selected_bobot = null
    sidebar_change_state("#sidebar-pengajar-pengaturan-nilai")

    $(document).ready(function() {
        $(".modal-btn-hook").click(function(obj) {
            selected = $(this).data("penugasan-id")
        })
        $(".data-selected-bobot-hook").click(function(obj) {
            selected_bobot = $(this).data("value")
            console.log(selected)
        })
        $("#save").click(function(obj) {
            $.ajax({
                url: "/api/pengajar/set_bobot_essay",
                method: "post",
                data: {
                    bobot_essay: selected_bobot,
                    penugasan_id: selected,
                    _token: "{{ csrf_token() }}"
                },
                success: function() {
                    swal("data disimpan")
                }
            })
        }) 
    })
</script>
@endsection