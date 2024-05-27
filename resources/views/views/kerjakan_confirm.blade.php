@extends("layout._layout_all")

@section("include-opt")
    @vite("resources/css/components/_container.css")
    @vite("resources/css/components/_navbar.css")
    @vite("resources/css/components/_modal.css")
    @vite("resources/css/components/_buttons.css")
    @vite("resources/css/components/_alert.css")
    @vite("resources/css/dashboard.css")
    @vite("resources/css/dashboard_css/index.css")
    @vite("resources/css/dashboard_css/soal_interface.css")
    @vite("resources/css/dashboard_css/util.css")

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="/js/utils.js"></script>
@endsection

@section("content")
<div class="main-layout">
    <div class="canvas-num">
        <span class="canvas-num-inc">Konformasi soal yang diisi</span>
        <br><br>
        <p>pilihan ganda: {{ $details["jawaban_pg_terisi"] }} soal</p>
        <p>essay: {{ $details["jawaban_essay_terisi"] }} soal</p>
        <p>belum dikerjakan: {{ $details["belum_disi"] }} soal</p>
        <br><br>
        <a href="#" class="btn-secondary" style="background-color: yellow; color: black;" id="send-confirmation">kirim</a>
        <p>soal yang sudah dikirim, tidak akan bisa diedit lagi</p>
        <!-- <span class="canvas-num-inc">
            <a href="#" class="btn-secondary " style="background-color: yellow; color: black;" id="btn-primary-next">kirim</a>
        </span> -->
        
    </div>
</div>
@endsection


@section('script')
<script>
    let global_kode_mapel = "{{ $kode_mapel }}"
    let global_nomor_ujian = "{{ $nomor_ujian }}"
    let global_penugasan_id = "{{ $penugasan_id }}"

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    })


    $(document).ready(function() {
        $("#send-confirmation").click(function() {
            $.ajax({
                url: "/api/kerjakan/confirm_exam",
                method: "POST",
                data: {
                    kode_mapel: global_kode_mapel,
                    nomor_ujian: global_nomor_ujian,
                    penugasan_id: global_penugasan_id
                },
                success: function(data) {
                    window.location = "/"
                }
            })
        })
    })

    setInterval(function() {
        setHtml("nav-time-js", getTimeStr())
    }, 1000)
</script>
@endsection('script')