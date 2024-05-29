@extends("layout._layout_pengajar")

@section("content") 
<div class="row">
    @foreach ($data as $data_s)
    <div class="col-6">
        <div class="card">
            <h5 class="card-header">{{ normal2snake_case_invers($data_s["kelas_id"]) }}</h5>
            <div class="card-body">
              <h5 class="card-title">{{ $data_s["nama_mapel"] }} (ujian tanggal {{ $data_s["start_date"] }})</h5>
              <p class="card-text">mulai: {{ $data_s["start_time"] }}</p>
              <p class="card-text">berakhir: {{ add_unix_mins_return_format($data_s["unix"], $data_s["duration_time"], "H:i") }}</p>
              <a href="/pengajar/nilai/check?kelas={{ $data_s['kelas_id'] }}&penugasan_id={{ $data_s['id'] }}" class="btn btn-primary">Lihat nilai</a>
            </div>
          </div>
    </div>
    @endforeach
    
</div>
@endsection

@section("script")
@endsection