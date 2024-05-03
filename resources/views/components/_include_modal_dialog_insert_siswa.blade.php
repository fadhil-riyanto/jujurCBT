<div class="modal-container" id="modal-container-insert-siswa-dialog">
    <div class="modal-box">
        <div class="modal-text">
            <span class="modal-text-txt" id="modal-text-txt-idn">null title</span>
            <span class="modal-text-close" onclick="close_display('modal-container-insert-siswa-dialog');">x</span>
        </div>

        <div class="modal-msg" id="modal-msg" style="border-bottom: none;">
            <form method="post" action="/api/admin/add_siswa" id="add_siswa_modal">
                <a style="display: block;">nama: </a>
                <input type="text" name="nama" class="modal-input">

                <!-- <a style="display: block;">nomor ujian: </a>
                <input type="text" class="modal-input"> -->

                <a style="display: block;">password: </a>
                <input type="text" name="password" class="modal-input">
                <a><b>catatan: nomor ujian dibuat otomatis</b></a>
                
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="kelas" value="{{ csrf_token() }}">
                <div class="modal-btn">
                    <input type="submit" class="btn-primary" onclick="close_display('modal-container-insert-siswa-dialog');" value="tambahkan">
                    <button type="button" class="btn-danger" onclick="close_display('modal-container-insert-siswa-dialog');">tutup</button>
                </div>
            </form>
        </div>

        
    </div>
</div>