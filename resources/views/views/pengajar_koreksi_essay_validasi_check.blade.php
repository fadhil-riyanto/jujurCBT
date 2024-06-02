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
    <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            soal nomor soal_number
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            text soal here
          </div>
          <hr>
          <div class="accordion-body">
            <strong>jawaban : abc</strong>
          </div>
        </div>
    </div>
    
</div>
@endsection

@section("script")
<script>


new DataTable('#nilai_siswa');
</script>
@endsection