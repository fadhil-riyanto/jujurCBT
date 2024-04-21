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

@section("admin")
<div class="sidebar">
    <div class="sidebar_profile">
        <i class="bi bi-person-circle profile-icon"></i>
        <div class="sidebar_profile_name">
            Fadhil Riyanto
        </div>
    </div>

    <div class="sidebar_menu">
        <i class="bi bi-people-fill"></i>
        <a href="#">peserta assesmen</a>
    </div>
    <div class="sidebar_menu">
        <i class="bi bi-patch-question"></i>
        <a href="#">soal assesmen</a>
    </div>
    <div class="sidebar_menu">
        <i class="bi bi-info-circle"></i>
        <a href="#">report</a>
    </div>
    <div class="sidebar_menu">
        <i class="bi bi-check2-square"></i>
        <a href="#">nilai</a>
    </div>
</div>
<div class="content">
    <div id="assesment-user-page">
        <div class="class-selector">
            <button class="classlist-btn" id="classlist-btn">daftar kelas</button>

            <div class="classlist" id="classlist">
                <div class="classlist-list"><a href="#">TKJ 1</a></div>
                <div class="classlist-list"><a href="#">TKJ 2</a></div>
                <div class="classlist-list"><a href="#">TKJ 3</a></div>
                <div class="classlist-list"><a href="#">TKJ industri</a></div>
                <div class="classlist-list"><a href="#">TKJ telkom</a></div>
            </div>
        </div>

        <div class="user-table">
            <table>
                <tr>
                    <th class="user-table-nomor">No</th>
                    <th class="user-table-nama">Nama</th>
                    <th class="user-table-ujian-num">Nomor ujian</th>
                    <th class="user-table-passwd">password</th>
                    <th class="user-table-is-block">blokir</th>
                    <th class="user-table-is-action">aksi</th>
                </tr>

                <tr>
                    <td>1</td>
                    <td>damaris lidia </td>
                    <td>10823</td>
                    <td>123fadhi</td>
                    <td>tidak</td>
                    <td>
                        <button type="button" class="btn-danger">blokir</button>
                        <button type="button" class="btn-primary">hapus</button>
                        <button type="button" class="btn-danger">ubah</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>


    <div id="soal-list">

    </div>
    <footer>
        <span class="footer-txt">&copy Fadhil Riyanto</span>
    </footer>
</div>
@endsection


@section('script')
<script>

    setInterval(function() {
        setHtml("nav-time-js", getTimeStr())
    }, 1000)

</script>
@endsection('script')