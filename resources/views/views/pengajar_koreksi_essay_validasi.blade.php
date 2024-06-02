@extends("layout._layout_pengajar")

@section("content") 
<div class="alert alert-primary mt-1" role="alert">
    Catatan: data yang ditampilkan disini hanya data bagi mereka yang sudah selesai mengerjakan ujian. 
    jika siswa ybs belum selesai, maka ia tidak akan muncul disini
</div>
  
<table id="nilai_siswa" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Nama</th>
            <th>status</th>
            <th>terkoreksi?</th>
            <th>aksi</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $data_s)
        <tr>
            <th>{{ $data_s["nama"] }}</th>
            <th>{{ $data_s["status"] }}</th> 
            <th>{{ $data_s["terkoreksi"] }}</th> 
            @if ($data_s["aksi"] == "ya")
                <th><a type="button" class="btn btn-secondary" href="/pengajar/koreksi_essay/validasi/check?kelas={{ $preload_data['kelas'] }}&penugasan_id={{ $preload_data['penugasan_id'] }}&kode_mapel={{ $preload_data['kode_mapel'] }}&nomor_ujian={{ $data_s['nomor_ujian'] }}">koreksi lagi</a></th> 
            @elseif ($data_s["aksi"] == "belum") 
            <th><a type="button" class="btn btn-secondary" href="/pengajar/koreksi_essay/validasi/check?kelas={{ $preload_data['kelas'] }}&penugasan_id={{ $preload_data['penugasan_id'] }}&kode_mapel={{ $preload_data['kode_mapel'] }}&nomor_ujian={{ $data_s['nomor_ujian'] }}">koreksi sekarang</a></th> 
            @elseif ($data_s["aksi"] == "-") 
            <th><a type="button" class="btn btn-secondary" disabled>koreksi sekarang</a></th> 
            @endif
        </tr>
        @endforeach
    </tbody>
    
</table>
@endsection

@section("script")
<script>


new DataTable('#nilai_siswa');
</script>
@endsection