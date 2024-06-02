@extends("layout._layout_pengajar")

@section("content") 
<div class="card mt-1 mb-1">
    <h5 class="card-header">Info siswa yang dikoreksi essay nya</h5>
    <div class="card-body">
      <p class="card-text">nama: {{ $details["nama"] }}<br>
        kelas: {{ $details["kelas"] }}<br>
        nomor ujian: {{ $details["nomor_ujian"] }}</p>
    </div>
</div>
<div class="accordion" id="accordionExample">
    @foreach ($data as $data_s)
    <div class="accordion-item mt-3 mb-3">
        <h2 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            soal nomor {{ $data_s["nomor_soal"] }}
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            {{ $data_s["soal"]["text_soal"] }}
            <img src="/images/{{ $data_s['soal']['image_soal'] }}" alt="" srcset="">
          </div>
          <hr>
          <div class="accordion-body">
            @if ($data_s["jawab"] == false) 
            <strong>soal ini tidak dijawab</strong>
            @elseif ($data_s["jawab"] != false)
            <strong>jawaban : </strong>{{ $data_s["jawab"] }}
            @endif
          </div>
          <div class="row p-1">
            <!-- <button class="ms-auto btn btn-secondary me-1">benar</button>
            <button class="btn btn-danger">salah</button> -->
            <div class="col-6">
            </div>
            <div class="col-6 watch_range">
                @if ($data_s["jawab"] == false) 
                <label for="customRange3" class="form-label label_poin">poin 0</label>
                <input type="range" class="form-range range_poin" min="0" max="5" step="1" value=0 disabled>
                @elseif ($data_s["jawab"] != false)
                <label id="range_for_id_{{ $data_s['id_soal'] }}" class="form-label label_poin">point {{ $data_s["points"]["points"] }}</label>
                <input type="range" class="form-range range_poin" min="0" max="5" step="1" data-id-soal="{{ $data_s['id_soal'] }}" value="{{ $data_s['points']['points'] }}">
                @endif
              
            </div>
          </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section("script")
<script>

function init() {
    $("#label_poin").html("poin " + $("#range_poin").val())
}

$(document).ready(function() {
    // init()
    // $("#range_poin").on("change", function(data) {
    //     $("#label_poin").html("poin " + $("#range_poin").val())
    // })

    $(".range_poin").on("change", function() {
        $("#range_for_id_" + $(this).data("id-soal")).html("poin " + $(this).val())
        // console.log($(this).val())
        $.ajax({
            url: "/api/pengajar/set_points", 
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                kode_mapel: "{{ $preload_data['kode_mapel'] }}",
                penugasan_id: "{{ $preload_data['penugasan_id'] }}",
                nomor_ujian: "{{ $preload_data['nomor_ujian'] }}",
                id_soal: $(this).data("id-soal"),
                points: $(this).val()
            },
            success: function() {
                swal("poin disimpan!", {
                    buttons: false,
                    timer: 500,
                });
            }
        })

    })
})

new DataTable('#nilai_siswa');
</script>
@endsection