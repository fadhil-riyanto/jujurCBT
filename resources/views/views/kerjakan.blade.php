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
        <span class="canvas-num-inc">soal nomor {{ $base["seq"] }}</span>
    </div>
    <div class="canvas-questions">
        {{ $base["soal"] }}
    </div>
    <div class="canvas-answer">
        <div class="form-wrap">
            @if ($base["type"] == "pilihan_ganda")
                @foreach ($base["option"] as $option_s) 
                <label class="form-wrap-class">
                    <input type="radio" class="answer_select" name="input_radio" data-option="{{ $option_s['id'] }}">
                    <span class="checkmark"></span>
                    {{ $option_s['pilihan_text'] }}
                </label>
                @endforeach
            @else
                <textarea name="essay_value" id="essay_value" rows="10"></textarea>
                <button href="{{ $button_control['next'] }}"  class="btn-secondary" id="save_answer">simpan</button>
            @endif
        </div>
    </div>
    <div class="canvas-button">
        @if ($button_control["before"] != null)
        <a href="{{ $button_control['before'] }}" class="btn-secondary" id="btn-primary-previous">sebelumnya</a>

            @if ($button_control["next"] == null)
            <a href="{{ $button_control['next'] }}" class="btn-secondary" style="background-color: yellow; color: black;" id="btn-primary-next">kirim</a>
            @endif
        @endif
        
        @if ($button_control["next"] != null)
        <a href="{{ $button_control['next'] }}" class="btn-secondary" id="btn-primary-next">selanjutnya</a>
        @endif
    </div>
    <div class="canvas-numlist">
        <div class="nulist-container">
            @foreach ($selector as $selector_s)
            <a class="numlist-num" id="numlist-num-1" href="{{ $selector_s['actual_id'] }}">{{ $selector_s['id_view'] }}</a>
            @endforeach
            
        </div>
    </div>
</div>
@endsection


@section('script')
<script>

    setInterval(function() {
        setHtml("nav-time-js", getTimeStr())
    }, 1000)

    $(document).ready(function() {
        // listen for callback

        $(".answer_select").click(function() {
            console.log("sel " + $(this).data("option"))
            swal("jawaban disimpan!", {
                buttons: false,
                timer: 500,
            });
        })

        $("#save_answer").click(function() {
            swal("essay disimpan!", {
                buttons: false,
                timer: 500,
            });
        })
    })

</script>
@endsection('script')