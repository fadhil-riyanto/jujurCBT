@extends("layout._layout_bs5")

@section("content")
<div class="row mt-4 ">
    <div class="col-lg-9 d-flex flex-column flex-grow-1">
        <div class="p-2 m-1 bg-white pe-auto" style="box-shadow: 0 0 10px gray;">
            <b>soal nomor {{ $base["seq"] }} </b>
        </div>
        <div class="p-2 m-1 bg-white pe-auto" style="box-shadow: 0 0 10px gray;">
            {{ $base["soal"] }}

            @if ($base["image"] != null)
            <img src="{{ asset('/images/' . $base['image']) }}" class="img-fluid">
            @endif
        </div>
        <div class="p-2 m-1 bg-white pe-auto d-flex flex-column" style="box-shadow: 0 0 10px gray;">
            @if ($base["type"] == "pilihan_ganda")
                @foreach ($base["option"] as $option_s) 
                <label class="my-2">

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
        <div class="p-2 m-1 bg-white pe-auto d-flex" style="box-shadow: 0 0 10px gray;">
            @if ($button_control["before"] != null)
            <a href="{{ $button_control['before'] }}" class="btn btn-secondary" id="btn-primary-previous">sebelumnya</a>

                @if ($button_control["next"] == null)
                <a href="/confirm/{{ $js_data['kode_mapel'] }}-{{ $js_data['penugasan_id'] }}/{{ $js_data['nomor_ujian'] }}" class="btn btn-secondary" style="background-color: yellow; color: black;" id="btn-primary-next">kirim</a>
                @endif
            @endif
            
            @if ($button_control["next"] != null)
            <a href="{{ $button_control['next'] }}" class="btn btn-secondary ms-auto" id="btn-primary-next">selanjutnya</a>
            @endif
        </div>
        
    </div>
    <div class="col-lg-3">
        <div class="row">
            <!-- <div class=""> -->
                @foreach ($selector as $selector_s)
                    @if ($selector_s["status"] == true) 
                    <a class="col-2 btn btn-secondary m-2" id="numlist-num-1" style="background-color: green;" href="{{ $selector_s['actual_id'] }}">{{ $selector_s['id_view'] }}</a>
                    @else 
                    <a class="col-2 btn btn-primary m-2" id="numlist-num-1" href="{{ $selector_s['actual_id'] }}">{{ $selector_s['id_view'] }}</a>
                    @endif
                @endforeach
            <!-- </div> -->
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