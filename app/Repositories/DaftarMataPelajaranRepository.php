<?php

namespace App\Repositories;

use App\Models;

class DaftarMataPelajaranRepository {
    public function __construct(
        protected Models\SoalModel $soal_model,
        protected Models\DaftarMataPelajaranModel $daftar_mapel_model,
        protected Models\PilihanGandaModel $store_db_pilihan_ganda,
        protected Models\EssayModel $store_db_essay
    ){}

    public function set_mapel_config($kode_mapel, $enable_right_click, $allow_copy, $pengampu) {
        $this->daftar_mapel_model->where("kode_mata_pelajaran", "=", $kode_mapel)
            ->update([
                "enable_right_click" => $enable_right_click,
                "allow_copy" => $allow_copy,
                "pengampu" => $pengampu
            ]);
    }

    public function get_mapel_info($kode_mapel) {
        return $this->daftar_mapel_model
            ->where("kode_mata_pelajaran", "=", $kode_mapel)
            ->first();
    }

    public function mapel_exist($kode_mapel) : bool {
        return $this->daftar_mapel_model
            ->where("kode_mata_pelajaran", "=", $kode_mapel)
            ->first() == null ? false : true;
    }

    protected function gen_kode_mapel($str_mapelname) {
        return str_replace(" ", "_", strtolower($str_mapelname)) . "_" . time();
    }

    public function generate_mata_pelajaran($mapelname) {
        $this->daftar_mapel_model->kode_mata_pelajaran = $this->gen_kode_mapel($mapelname);
        $this->daftar_mapel_model->nama_mata_pelajaran = $mapelname;
        $this->daftar_mapel_model->pengampu = json_encode([]);
        $this->daftar_mapel_model->save();
    }

    // public function add_pengampu_mapel($id_pengampu, $kode_mapel) { // use null as identifier
    //     $this->daftar_mapel_model->pengampu()
    //     $this->daftar_mapel_model->save();
    // }

    public function getAllAvailableMataPelajaran() {
        // return $this->daftar_mapel_model::all();
        return $this->daftar_mapel_model->get();
        // return 0;
    }

    public function deleteHardMataPelajaran($kodemapel) {
        // do in daftar_mapel_model, then delete all data in soal, essay. etc
        $this->daftar_mapel_model->where("kode_mata_pelajaran", $kodemapel)->delete();
        $this->soal_model->where("mata_pelajaran", $kodemapel)->delete();
        $this->store_db_pilihan_ganda->where("mata_pelajaran", $kodemapel)->delete();
        $this->store_db_essay->where("mata_pelajaran", $kodemapel)->delete();
    }
}