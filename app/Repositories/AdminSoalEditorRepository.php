<?php
namespace App\Repositories;
use App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function set_soal_image($id_soal, $file) {
        $this->soal_model->where("mata_pelajaran", "=", $this->kode_mapel)
            ->where("id", "=", $id_soal)
            ->update([
                "image_soal" => $file
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

    public function get_all_options_by_soal_id($id_soal) {
        return $this->store_db_pilihan_ganda->where("mata_pelajaran", "=", $this->kode_mapel)
            ->where("nomor_soal", "=", $id_soal)
            ->orderBy("nomor_soal", "asc")
            ->get();
    }

    public function clean_unneed_opsi_pilihan_ganda($id_soal, $len_from_actual_request) {
        // math expression
        /* 
            result = count(data) - len_from_actual_request        // cek jarak antara data ma req
            if ( !result < 0 ) {                                  // check jika invers(result) itu negatif
                sigma ( n = (result) --> n < count(data)) {       // loop dari result menuju ke jumlah data
                    delete(n)                                       // contoh: n = 2, loop nya adalah
                    n = n + 1;                                      // {2, 3, 4} dimana n < count(data) = 3
                }                                                   // hapus soal dgn id {2, 3, 4} menyisakan
            } else {                                                // {0, 1}
                sigma ( n = count(data) --> n < result) {
                    n = n + 1; 
                    add(n) 
                }
            }
         */

        $length_data_db = $this->store_db_pilihan_ganda
            ->select(DB::raw("count(*) as total"))
            ->where("mata_pelajaran", "=", $this->kode_mapel)
            ->where("nomor_soal", "=", $id_soal)->first()["total"];

        $distance_length = $length_data_db - $len_from_actual_request;

        if ($distance_length > 0) { // desc operation
            for($i = $len_from_actual_request; $i < $length_data_db; $i++) {
                // delete($i);
                $this->store_db_pilihan_ganda->where("mata_pelajaran", "=", $this->kode_mapel)
                    ->where("nomor_soal", "=", $id_soal)
                    ->where("index_jawaban", "=", $i)
                    ->delete();
            }
        } else { // distance_length < 0
            // do nothing
        }

        // $this->store_db_pilihan_ganda->updateOrInsert([
        //     "mata_pelajaran" => $this->kode_mapel, "nomor_soal" => $id_soal, "index_jawaban" => $index
        // ], [
        //     "pilihan_text" => $single_index_data
        // ]);
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

    public function store_essay($id_soal, $text_soal) {
        $this->soal_model->where("id", "=", $id_soal)
            ->where("mata_pelajaran", "=", $this->kode_mapel)
            ->update([
                "text_soal" => $text_soal,
                "tipe_soal" => "essay"
            ]);
    }
 
    public function hapus_soal($id_soal) {
        $query = $this->getSoalDetails($id_soal);
        if ($query->image_soal != null) {
            Storage::delete("images/" . $query->image_soal);
        }

        $this->soal_model->where("mata_pelajaran", "=", $this->kode_mapel)
            ->where("id", "=", $id_soal)
            ->delete();

        $this->store_db_pilihan_ganda->where("mata_pelajaran", "=", $this->kode_mapel)
            ->where("nomor_soal", "=", $id_soal)
            ->delete();

        $this->store_db_essay->where("mata_pelajaran", "=", $this->kode_mapel)
            ->where("nomor_soal", "=", $id_soal)
            ->delete();
    }
    
}