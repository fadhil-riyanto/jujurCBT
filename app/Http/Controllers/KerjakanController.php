<?php

namespace App\Http\Controllers;

use App\Traits;
use Illuminate\Http\Request;
use App\Repositories;
use App\Exceptions;

class KerjakanController extends Controller
{
    use Traits\CurrentSessionTrait;
    protected $sequence_array_index;
    protected $first_id;

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

    private function get_array_sequence($kode_mapel) {
        return $this->soal_repo->get_ordered_list_id($kode_mapel)->toArray();
    }

    private function soal_first($kode_mapel) {
        $data = $this->soal_repo->get_ordered_list_id($kode_mapel);
        if ($data != null) {
            $this->first_id = $data[0]["id"];
            $first_soal = $this->soal_data_get($kode_mapel, $this->first_id);

            // dd($first_option);
            if ($first_soal["tipe_soal"] == "pilihan_ganda") {
                $first_option = $this->pilihan_ganda_soal_get($kode_mapel, $this->first_id);
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

            $data2return["seq"] = $this->get_current_sequence($kode_mapel, $this->first_id);
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

    private function seq_index_position($id) {
        $this->sequence_array_index = ($id == null) ? 0 : $id;                      // null ids == indexOf 0
    }
    private function seq_index2arr_index($seq_all) {
        for($i = 0; $i < count($seq_all); $i++) {                                   // sigma (n --> count(seq)) { n = n + 1 }
            if ($seq_all[$i]["id"] == $this->sequence_array_index) {
                return $i;
            }
        }
    }

    private function seq_next($kode_mapel) {
        $id_x_sequence = $this->get_array_sequence($kode_mapel);
        
        $current_array_index = $this->seq_index2arr_index($id_x_sequence);
        if ($this->sequence_array_index == $id_x_sequence[count($id_x_sequence) - 1]["id"]) {  // last = count - 1
            return null;
        } else {
            return $id_x_sequence[$current_array_index + 1]["id"];                             // next =  current + 1
        }
    }

    private function seq_before($kode_mapel) {
        $id_x_sequence = $this->get_array_sequence($kode_mapel);
        
        $current_array_index = $this->seq_index2arr_index($id_x_sequence);
        if ($this->sequence_array_index == $id_x_sequence[0]["id"]) {
            return null;
        } else {
            // dd($current_array_index);
            if ($this->first_id != null) {
                return  null;
            }
            return $id_x_sequence[$current_array_index - 1]["id"];
        }
    }

    public function Index(Request $request, $kode_mapel, $id = null) {
        $this->request = $request;
        $this->seq_index_position($id);
        $this->cookie_deserialize();

        if ($this->validate_request($request, $kode_mapel)) {
            if ($id == null) {
                $data_from_soal = $this->soal_first($kode_mapel);
            } else {
                $data_from_soal = $this->soal($kode_mapel, $id);
            }



            $data2view = [
                "base" => $data_from_soal,
                "selector" => $this->get_soal_selector_status($kode_mapel),
                "button_control" => [
                    "next" => $this->seq_next($kode_mapel),
                    "before" => $this->seq_before($kode_mapel)
                ]
            ];

            return view("views/kerjakan", $data2view);
        } else {
            // throw new Exceptions\InvalidRequest();
            throw new \App\Exceptions\InvalidRequest();
        }
        
    }
}
