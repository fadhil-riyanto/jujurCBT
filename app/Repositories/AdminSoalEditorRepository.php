<?php
namespace App\Repositories;
use App\Models;
use Illuminate\Support\Facades\DB;

class AdminSoalEditorRepository {
    protected $kode_mapel;
    public function __construct(
        protected Models\SoalModel $soal_model,
        protected Models\DaftarMataPelajaranModel $mapel_model,

        // answer_model

        protected Models\PilihanGandaModel $store_db_pilihan_ganda,
        protected Models\EssayModel $store_db_essay,
    ){}

    public function setkodeSoal($kodemapel) {
        $this->kode_mapel = $kodemapel;
        return $this;
    }

    public function create_new_soal(): int {
        // first, increment our soal num in DaftarMataPelajaranModel model
      
        // dd();
        $current = $this->mapel_model
            ->select("total_soal")
            ->where("kode_mata_pelajaran", "=", $this->kode_mapel)
            ->first()["total_soal"];

        $this->mapel_model->where("kode_mata_pelajaran", $this->kode_mapel)
            ->update([
                "total_soal" => $current + 1
            ]);

        return $this->soal_model->insertGetId([
            "mata_pelajaran" => $this->kode_mapel,
            "nomor_soal" => $current + 1,
            "image_soal" => null,
            "text_soal" => null,
            "index_kunci_jawaban" => null
        ]);
    }

    public function getAllSoalByKodeMapel() {
        return $this->soal_model->where("mata_pelajaran", "=", $this->kode_mapel)
            ->orderBy('id', 'asc')
            ->get();
    }

    public function getSoalDetails($id_soal) {
        return $this->soal_model->where("mata_pelajaran", "=", $this->kode_mapel)
                ->where("id", "=", $id_soal)
                ->first();
    }

    public function getTotalSoalByKodeMapel() {
        return $this->soal_model->select(DB::raw("count(*) as total_soal"))
            ->where("mata_pelajaran", "=", $this->kode_mapel)
            ->get()[0]["total_soal"];
    }

    public function store_opsi_pilihan_ganda($id_soal, $index, $single_index_data) {
        $this->store_db_pilihan_ganda->updateOrInsert([
            "mata_pelajaran" => $this->kode_mapel, "nomor_soal" => $id_soal, "index_jawaban" => $index
        ], [
            "pilihan_text" => $single_index_data
        ]);
    }

    public function store_pilihan_ganda($id_soal, $text_soal, $index_kunci_jawaban) {
        $this->soal_model->where("id", "=", $id_soal)
            ->where("mata_pelajaran", "=", $this->kode_mapel)
            ->update([
                "text_soal" => $text_soal,
                "tipe_soal" => "pilihan_ganda",
                "index_kunci_jawaban" => $index_kunci_jawaban
            ]);
    }
}