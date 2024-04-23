@extends("layout._layout_all")

@section("include-opt")
    @vite("resources/css/components/_container.css")
    @vite("resources/css/components/_navbar.css")
    @vite("resources/css/components/_modal.css")
    @vite("resources/css/components/_buttons.css")
    @vite("resources/css/components/_alert.css")
    @vite("resources/css/dashboard.css")

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="/js/utils.js"></script>
@endsection

@section("login")
<div class="alert alert-primary" id="alert-sambutan">
    null
</div>

<div class="exam-study-container">
    <div class="exam-list">
        <div class="exam-list-name">
            <span class="exam-name">PKN</span>
            <span class="exam-status">belum dikerjakan</span>
        </div>
        <div class="exam-list-time">
            <div class="exam-start">
                10.00
            </div>
            <div class="exam-end">
                12.00
            </div>
        </div>
    
        <div class="exam-list-go">
            <a href="#" class="exam-list-go-confirmation" onclick="show_modal('konfirmasi', 'apakah anda ingin mengerjakan soal ini?', 'modal-container-confirmation');"">kerjakan</a>
        </div>

    </div>
    
    <div class="exam-list">
        <div class="exam-list-name">
            <span class="exam-name">PKN</span>
            <span class="exam-status">belum dikerjakan</span>
        </div>
        <div class="exam-list-time">
            <div class="exam-start">
                10.00
            </div>
            <div class="exam-end">
                12.00
            </div>
        </div>
    
        <div class="exam-list-go">
            <a href="#" class="exam-list-go-confirmation" onclick="show_modal('konfirmasi', 'apakah anda ingin mengerjakan soal ini?', 'modal-container-confirmation');"">kerjakan</a>
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
        url: "/api/dashboard/get_me",
        type: "POST",
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