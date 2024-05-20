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
        <span class="canvas-num-inc">soal nomor 1</span>
    </div>
    <div class="canvas-questions">
        “Hanya itu alasan dari Mama mengapa melarang Laras menikah dengan Dani? ”Bibir Laras menyinggung dengan sinis. “Oh, begitu liciknya yang ada di dalam pikiran Mama! Lalu, apa artinya kemuliaan dari hati Mama yang selama ini selalu Laras kagumi? Padahal Mama dulu tidak pernah mempermasalahkan status dari Dani yang masih belum bisa menemukan pekerjaan tetap. Demikian kakakku yang selama ini juga mendukungku, sekarang justru berbalik arah”.
        <br><br>Menurut kutipan dari cerpen yang ada di atas, konflik yang terjadi adalah….
    </div>
    <div class="canvas-answer">
        <div class="form-wrap">
            <label class="form-wrap-class">
                <input type="radio" name="radio_answer">
                <span class="checkmark"></span>
                Laras dan Dani yang membatalkan pernikahan
            </label>
            <label class="form-wrap-class">
                <input type="radio" name="radio_answer">
                <span class="checkmark">s</span>
                Keinginan Mama agar Laras bisa menjalani hidup yang bahagia
            </label>
            <label class="form-wrap-class">
                <input type="radio" checked="checked" name="radio_answer">
                <span class="checkmark"></span>
                Laras yang dilarang untuk menikah dengan Dani oleh Mama dan kakaknya
            </label>
            <label class="form-wrap-class">
                <input type="radio" name="radio_answer">
                <span class="checkmark"></span>
                Kakak yang tidak mendukung keinginan dari Laras untuk bisa menikah dengan Dani Kakak yang tidak mendukung keinginan dari Laras untuk bisa menikah dengan DaniKakak yang tidak mendukung keinginan dari Laras untuk bisa menikah dengan Dani
            </label>
        </div>
    </div>
    <div class="canvas-button">
        <button type="button" class="btn-secondary" id="btn-primary-previous" onclick="close_display('modal-container-login-notify');">sebelumnya</button>
        <button type="button" class="btn-secondary" id="btn-primary-next" onclick="close_display('modal-container-login-notify');">selanjutnya</button>
    </div>
    <div class="canvas-numlist">
        <div class="nulist-container">
            <button class="numlist-num" id="numlist-num-1" onclick="identify_pressed_numlist(1);">1</button>
            <button class="numlist-num" id="numlist-num-2" onclick="identify_pressed_numlist(2);">2</button>
            <button class="numlist-num" id="numlist-num-3" onclick="identify_pressed_numlist(3);">3</button>
            <button class="numlist-num" id="numlist-num-4" onclick="identify_pressed_numlist(4);">4</button>
            <button class="numlist-num" id="numlist-num-5" onclick="identify_pressed_numlist(5);">5</button>
            <button class="numlist-num" id="numlist-num-6" onclick="identify_pressed_numlist(6);">6</button>
            <button class="numlist-num" id="numlist-num-7" onclick="identify_pressed_numlist(7);">7</button>
            <button class="numlist-num" id="numlist-num-8" onclick="identify_pressed_numlist(8);">8</button>
            <button class="numlist-num" id="numlist-num-9" onclick="identify_pressed_numlist(9);">9</button>

        </div>
    </div>
</div>
@endsection


@section('script')
<script>

    setInterval(function() {
        setHtml("nav-time-js", getTimeStr())
    }, 1000)

    $.ajax({
        url: "/api/global/get_me",
        type: "GET",
        cache: false,
        data: {
            "_token": "{{ csrf_token() }}",
        },
        success: function(result) {
            $("#alert-sambutan").html("Selamat datang " + result.data + " di JujurCBT!")
        }
    })

</script>
@endsection('script')