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

<style>
img {
  width: 100%;
  height: auto;
}
</style>
<div class="main-layout">
    <div class="canvas-num">
        <span class="canvas-num-inc">soal nomor {{ $base["seq"] }} </span>
    </div>
    <div class="canvas-questions">
        {{ $base["soal"] }}

        @if ($base["image"] != null)
        <img src="{{ asset('/images/' . $base['image']) }}" alt="">
        @endif
    </div>
    <div class="canvas-answer">
        <div class="form-wrap">
            @if ($base["type"] == "pilihan_ganda")
                @foreach ($base["option"] as $option_s) 
                <label class="form-wrap-class">

                    @if ($option_s['id'] == $preload_data["current_selection"])
                    <input type="radio" class="answer_select" name="input_radio" data-option="{{ $option_s['id'] }}" checked>
                    <span class="checkmark"></span>
                    {{ $option_s['pilihan_text'] }}
                    @else
                    <input type="radio" class="answer_select" name="input_radio" data-option="{{ $option_s['id'] }}">
                    <span class="checkmark"></span>
                    {{ $option_s['pilihan_text'] }}
                    @endif
                </label>
                @endforeach
            @else
                
                <textarea name="essay_value" id="essay_value" rows="10">{{ $preload_data['current_value_essay'] }}</textarea>
                <button href="{{ $button_control['next'] }}"  class="btn-secondary" id="save_answer">simpan</button>
            @endif
        </div>
    </div>
    <div class="canvas-button">
        @if ($button_control["before"] != null)
        <a href="{{ $button_control['before'] }}" class="btn-secondary" id="btn-primary-previous">sebelumnya</a>

            @if ($button_control["next"] == null)
            <a href="/confirm/{{ $js_data['kode_mapel'] }}-{{ $js_data['penugasan_id'] }}/{{ $js_data['nomor_ujian'] }}" class="btn-secondary" style="background-color: yellow; color: black;" id="btn-primary-next">kirim</a>
            @endif
        @endif
        
        @if ($button_control["next"] != null)
        <a href="{{ $button_control['next'] }}" class="btn-secondary" id="btn-primary-next">selanjutnya</a>
        @endif
    </div>
    <div class="canvas-numlist">
        <div class="nulist-container">
            @foreach ($selector as $selector_s)
                @if ($selector_s["status"] == true) 
                <a class="numlist-num" id="numlist-num-1" style="background-color: green;" href="{{ $selector_s['actual_id'] }}">{{ $selector_s['id_view'] }}</a>
                @else 
                <a class="numlist-num" id="numlist-num-1" href="{{ $selector_s['actual_id'] }}">{{ $selector_s['id_view'] }}</a>
                @endif
            @endforeach
            
        </div>
    </div>
</div>
@endsection


@section('script')
<script>

    let global_kode_mapel = "{{ $js_data['kode_mapel'] }}"
    let global_nomor_ujian = "{{ $js_data['nomor_ujian'] }}"
    let global_id_soal = "{{ $js_data['id_soal'] }}"
    let global_penugasan_id = "{{ $js_data['penugasan_id'] }}"

    setInterval(function() {
        setHtml("nav-time-js", getTimeStr())
    }, 1000)

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    })

    $(document).ready(function() {
        // listen for callback

        $(".answer_select").click(function() {
            console.log("sel " + $(this).data("option"))
            $.ajax({
                url: "/api/kerjakan/store_pg",
                method: "POST",
                data: {
                    kode_mapel: global_kode_mapel,
                    nomor_ujian: global_nomor_ujian,
                    id_soal: global_id_soal,
                    id_jawaban: $(this).data("option"),
                    penugasan_id: global_penugasan_id
                },
                success: function() {
                    swal("jawaban disimpan!", {
                        buttons: false,
                        timer: 500,
                    });
                }
            })

            
        })

        $("#save_answer").click(function() {
            $.ajax({
                url: "/api/kerjakan/store_essay",
                method: "POST",
                data: {
                    kode_mapel: global_kode_mapel,
                    nomor_ujian: global_nomor_ujian,
                    id_soal: global_id_soal,
                    jawaban_txt: $("#essay_value").val(),
                    penugasan_id: global_penugasan_id
                },
                success: function() {
                    swal("essay disimpan!", {
                        buttons: false,
                        timer: 500,
                    });
                }
            })
            
        })
    })

</script>
@endsection('script')