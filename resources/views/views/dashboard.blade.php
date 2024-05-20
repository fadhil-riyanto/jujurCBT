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

@section("content")
<div class="alert alert-primary" id="alert-sambutan">
    null
</div>

<div class="exam-study-container">
    @foreach($mapels_data as $mapel_data)
    <div class="exam-list">
        <div class="exam-list-name">
            <span class="exam-name">{{ $mapel_data["nama_mapel"] }}</span>
            <span class="exam-status">{{ $mapel_data["status_dikerjakan"] }}</span>
        </div>
        <div class="exam-list-time">
            <div class="exam-start">
                {{ $mapel_data["start"] }}
            </div>
            <div class="exam-end">
                {{ $mapel_data["end"] }}
            </div>
        </div>
    
        <div class="exam-list-go">
            <a href="{{ $mapel_data['kerjakan_link'] }}" class="exam-list-go-confirmation">lihat soal</a>
        </div>
    </div>
    @endforeach
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