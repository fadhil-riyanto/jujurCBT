@extends("layout._layout_all")

@section("include-opt")
    @vite("resources/css/components/_container.css")
    @vite("resources/css/components/_navbar.css")
    @vite("resources/css/components/_modal.css")
    @vite("resources/css/components/_buttons.css")
    @vite("resources/css/components/_alert.css")
    @vite("resources/css/components/_searchbar.css")
    @vite("resources/css/admin.css")

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="/js/utils.js"></script>
    <script src="/js/admin.js"></script>
@endsection

@section("inject_before_container")
<div class="viewport-not-enough">
    maaf, halaman admin hanya bisa diakses melalui PC / komputer untuk pengalaman yang optimal
</div>
@endsection

@section("admin")
<div class="sidebar">
    <div class="sidebar_profile">
        <i class="bi bi-person-circle profile-icon"></i>
        <div class="sidebar_profile_name">
            Fadhil Riyanto
        </div>
    </div>

    <div class="sidebar_menu" id="assesment_list">
        <i class="bi bi-people-fill"></i>
        <a href="#">peserta assesmen</a>
    </div>
    <div class="sidebar_menu" id="assesment_question">
        <i class="bi bi-patch-question"></i>
        <a href="#">soal assesmen</a>
    </div>
    <div class="sidebar_menu" id="assesment_report">
        <i class="bi bi-info-circle"></i>
        <a href="#">report</a>
    </div>
    <div class="sidebar_menu" id="assesment_value">
        <i class="bi bi-check2-square"></i>
        <a href="#">nilai</a>
    </div>
</div>
<div class="content">
    <div id="page_0">
        @include("views/admin_page_0")
    </div>

    <div id="page_1" style="display: none;">
        page 1 coming soon
    </div>

    <div id="page_2" style="display: none;">
        page 2 coming soon
    </div>

    <div id="page_3" style="display: none;">
        page 3 coming soon
    </div>


</div>
@endsection


@section('script')
<script>
    // jam
    setInterval(function() {
        setHtml("nav-time-js", getTimeStr())
    }, 1000)
    
    // daftar kelas toggle
    $("#classlist-btn").click(function(){
        $("#classlist").toggle();
    });

    $(".classlist-list").click(function(){
        $("#classlist").hide();
    });

    $(".classlist-list").click(function () {
        var selected_kelas = $(this).attr("data-kelas");
        $.ajax({
            url: "/api/admin/get_siswa_by_kelas",
            method: "POST",
            data: jQuery.param({
                "kelas": selected_kelas,
                "_token": "{{ csrf_token() }}"
            }),
            success: function (response) {
                if (response["data"].length == 0) {
                    show_modal("perhatian", "data kosong")
                    $(".siswa-data-table").remove()
                    $(".user-table").hide()
                } else {
                    $(".siswa-data-table").remove()
                    for(i = 0; i < response["data"].length; i++) {
                        populate_data_siswa_list(i + 1, response["data"][i]["nama"], response["data"][i]["nomor_ujian"], (response["data"][i]["nomor_ujian"] == 0 ? "tidak" : "ya"))
                        console.log("loop")
                    }
                    // console.log(response["data"][0])
                    
                    $(".user-table").show()
                }
                
            }
        })
        // show kelas yg bersangkuta
    });


    function page_ajax(showed_page) {
        console.log(showed_page)
    }

    // page show and hide logic
    function hide_other_page(showed_page) {
        page_ajax(showed_page);
        for(i = 0; i < 4; i++) {
            if (("#page_" + i) != showed_page) {
                $("#page_" + i).hide()
            }
        }
    }

    // page num 0
    $("#assesment_list").click(function(){
            $("#page_0").show()
            hide_other_page("#page_0")
    });
    // page num 1
    $("#assesment_question").click(function(){
            $("#page_1").show()
            hide_other_page("#page_1")
    });

    $("#assesment_report").click(function(){
            $("#page_2").show()
            hide_other_page("#page_2")
    });

    $("#assesment_value").click(function(){
            $("#page_3").show()
            hide_other_page("#page_3")
    });
</script>
@endsection('script')