<?php

namespace App\Http\Controllers;

use App\Traits;
use Illuminate\Http\Request;
use App\Repositories;
use App\Exceptions;

class KerjakanController extends Controller
{
    use Traits\CurrentSessionTrait;

    public function __construct(
        protected Repositories\PenugasanRepository $penugasan_repo,
        protected Repositories\SoalRepository $soal_repo,
        protected Repositories\PgRepo $pg_repo,
        protected Repositories\onRunTimePilihanGandaRepository $on_runtime_pg_repo
    ) {}

    private function validate_request(Request $request, $kode_mapel) {
        /**
         * make sure request valid by checking
         * !exist(kelas) 
         *  -> exist soal
         *    -> id are free
         * 
         * by penugasan db
         */

        if ($this->penugasan_repo->is_exist_penugasan_by_kelas_and_mapel($this->cookie_kelas, $kode_mapel)) {
            return true;
        }
    }

    private function soal_data_get($kode_mapel, $offset_id) {
        return $this->soal_repo->get_soal($kode_mapel, $offset_id);
    }

    private function pilihan_ganda_soal_get($kode_mapel, $offset_id) {
        return $this->pg_repo->get_option_ordered($kode_mapel, $offset_id);
    }

    private function get_soal_selector_status($kode_mapel) {
        $total = $this->soal_repo->get_ordered_list_id($kode_mapel)->toArray();

        for($i = 0; $i < count($total); $i++) {
            $total[$i]["id_view"] = $i + 1;
            $total[$i]["actual_id"] = $total[$i]["id"];
            $total[$i]["status"] = $this->on_runtime_pg_repo->get_answer_status(
                $this->cookie_identity, $kode_mapel, $total[$i]["id"]
            );
        }
        
        return $total;
    }

    private function get_current_sequence($kode_mapel, $id) {
        $all = $this->soal_repo->get_ordered_list_id($kode_mapel)->toArray();
        $init = 1;
        
        for($i = 0; $i < count($all); $i++) {
            if ($all[$i]["id"] == $id) {
                return $init;
            }
            $init++;
        }
    }

    private function soal_first($kode_mapel) {
        $data = $this->soal_repo->get_ordered_list_id($kode_mapel);
        if ($data != null) {
            $firstid = $data[0]["id"];
            $first_soal = $this->soal_data_get($kode_mapel, $firstid);

            // dd($first_option);
            if ($first_soal["tipe_soal"] == "pilihan_ganda") {
                $first_option = $this->pilihan_ganda_soal_get($kode_mapel, $firstid);
                $data2return = [
                    "soal" => $first_soal["text_soal"],
                    "option" => $first_option,
                    "type" => $first_soal["tipe_soal"]
                ];
            } else {
                $data2return = [
                    "soal" => $first_soal["text_soal"],
                    "type" => $first_soal["tipe_soal"]
                ];
            }

            $data2return["seq"] = $this->get_current_sequence($kode_mapel, $firstid);
            $data2return["next"] = $this->get_current_sequence($kode_mapel, $firstid);
            return $data2return;
            
        }
    }

    private function soal($kode_mapel, $id) {
        $first_soal = $this->soal_data_get($kode_mapel, $id);

        if ($first_soal["tipe_soal"] == "pilihan_ganda") {
            $first_option = $this->pilihan_ganda_soal_get($kode_mapel, $id);
            $data2return = [
                "soal" => $first_soal["text_soal"],
                "option" => $first_option,
                "type" => $first_soal["tipe_soal"]
            ];
        } else {
            $data2return = [
                "soal" => $first_soal["text_soal"],
                "type" => $first_soal["tipe_soal"]
            ];
        }

        $data2return["seq"] = $this->get_current_sequence($kode_mapel, $id);
        return $data2return;
    }

    public function Index(Request $request, $kode_mapel, $id = null) {
        $this->request = $request;
        $this->cookie_deserialize();

        if ($this->validate_request($request, $kode_mapel)) {
            if ($id == null) {
                $data_from_soal = $this->soal_first($kode_mapel);
            } else {
                $data_from_soal = $this->soal($kode_mapel, $id);
            }



            $data2view = [
                "base" => $data_from_soal,
                "selector" => $this->get_soal_selector_status($kode_mapel)
            ];
            // dd($data2view);

            return view("views/kerjakan", $data2view);
        } else {
            // throw new Exceptions\InvalidRequest();
            throw new \App\Exceptions\InvalidRequest();
        }
        
    }
}
