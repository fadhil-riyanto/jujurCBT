@inc
<div class="class-selector">
    <button class="classlist-btn" id="classlist-btn">daftar kelas</button>

    <div class="classlist" id="classlist">

        <!-- get from backend -->
        <!-- <div class="classlist-list" data-kelas="12" data-jurusan="tkj" data-index="1"><a href="#">TKJ 1</a></div>
        <div class="classlist-list" data-kelas="12" data-jurusan="tkj" data-index="2"><a href="#">TKJ 2</a></div>
        <div class="classlist-list" data-kelas="12" data-jurusan="tkj" data-index="3"><a href="#">TKJ 3</a></div>
        <div class="classlist-list" data-kelas="12" data-jurusan="tkj" data-index="industri"><a href="#">TKJ industri</a></div>
        <div class="classlist-list" data-kelas="12" data-jurusan="tkj" data-index="telkom"><a href="#">TKJ telkom</a></div> -->
    </div>
</div>

<div class="user-table" style="display: none;">
    <!-- add button -->
    <div class="operation-root">
        <div class="search-form" style="display: none;">
            <input class="searchbox" type="text" placeholder="search">
        </div>
        
        <button class="btn-primary">
            Tambah siswa
        </button>
        <button class="btn-primary">
            Tambah kelas
        </button>
        <button class="btn-danger">
            Hapus kelas
        </button>
    </div>
    <table id="tabel_siswa">
        <tr>
            <th class="user-table-nomor">No</th>
            <th class="user-table-nama">Nama</th>
            <th class="user-table-ujian-num">Nomor ujian</th>
            <th class="user-table-is-block">blokir</th>
            <th class="user-table-is-action">aksi</th>
        </tr>

    </table>
</div>
