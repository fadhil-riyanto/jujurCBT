<?php

namespace App\Http\Controllers;

use App\Traits;
use Illuminate\Http\Request;
use App\Repositories;
use App\Exceptions;
use App\Helper;

class KerjakanController extends Controller
{
    use Traits\CurrentSessionTrait;
    protected $sequence_array_index;
    protected $first_id = null;
    protected $kode_mapel = null;
    protected $penugasan_id = null;

    public function __construct(
        protected Repositories\PenugasanRepository $penugasan_repo,
        protected Repositories\SoalRepository $soal_repo,
        protected Repositories\PgRepo $pg_repo,
        protected Repositories\onRunTimePilihanGandaRepository $on_runtime_pg_repo,
        protected Repositories\onRunTimeEssayRepository $on_runtime_essay_repo,
        protected Repositories\PenyelesaianRepository $penyelesaian_repo,
        protected Repositories\DaftarMataPelajaranRepository $daftar_mapel_repo
    ) {}

    private function validate_time($db_time, $min) {
        $added_time = add_unix_mins($db_time, $min);
        
        if (time() > $db_time) { // now > db time 
            if (time() < $added_time) { // time now must be less than added time (end)
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function validate_request(Request $request, $kode_mapel) {
        /**
         * make sure request valid by checking
         * !exist(kelas) 
         *  -> exist soal
         *    -> id are free
         * 
         * by penugasan db
         */

        if ($this->penugasan_repo->is_exist_penugasan_by_kelas_and_mapel_and_id(
            $this->cookie_kelas, $kode_mapel, $this->penugasan_id
        )) {
            if ($this->penyelesaian_repo->set(
                $kode_mapel, $this->cookie_identity, $this->penugasan_id
            )->isFixed()) {
                throw new Exceptions\AccessDenied();
            } else {
                $data = $this->penugasan_repo->get_penugasan_detail_by_penugasan_id($this->penugasan_id);
                if ($this->validate_time($data["unix"], $data['duration_time'])) {
                    return true;
                } else {
                    throw new Exceptions\AccessDenied();
                }
            }
            
        } else {
            throw new \App\Exceptions\InvalidRequest(); 
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

            $total[$i]["status"] = match ($this->soal_repo->soal_typeof($kode_mapel, $total[$i]["id"])) {
                "pilihan_ganda" =>  $this->on_runtime_pg_repo->get_answer_detail(
                                        $this->cookie_identity, $kode_mapel, $total[$i]["id"], $this->penugasan_id) 
                                    == false ? false : true,
                "essay" =>  $this->on_runtime_essay_repo->get_answer_detail(
                                        $this->cookie_identity, $kode_mapel, $total[$i]["id"], $this->penugasan_id) 
                                    == false ? false : true,
                default => false
            };
            // $total[$i]["status"] = $this->on_runtime_pg_repo->get_answer_detail(
            //     $this->cookie_identity, $kode_mapel, $total[$i]["id"]
            // ) == false ? false : true;
            // if ($)
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
            $data2return["image"] = $first_soal["image_soal"];
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
        $data2return["image"] = $first_soal["image_soal"];
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

    private function get_soal_status($id) {
        return $this->on_runtime_pg_repo->get_answer_detail(
            $this->cookie_identity, 
            $this->kode_mapel, 
            ($this->first_id != null) ? $this->first_id : $id,
            $this->penugasan_id
        ) == false ? false : true;
    }

    private function get_selection($id) {
        return $this->on_runtime_pg_repo->get_answer_detail(
            $this->cookie_identity, 
            $this->kode_mapel, 
            ($this->first_id != null) ? $this->first_id : $id,
            $this->penugasan_id
        );
    }

    private function get_essay_current_value($id) {
        return $this->on_runtime_essay_repo->get_answer_detail(
            $this->cookie_identity, 
            $this->kode_mapel, 
            ($this->first_id != null) ? $this->first_id : $id,
            $this->penugasan_id
        );
    }

    //

    public function Index(Request $request, $kode_mapel_n_penugasan_id, $id = null) {

        $exp_internal = explode('-', $kode_mapel_n_penugasan_id);
        $kode_mapel = $exp_internal[0];
        $this->penugasan_id = $exp_internal[1];
        
        $this->request = $request;
        $this->seq_index_position($id);
        $this->cookie_deserialize();

        // if () {
        // try {ar
        $this->validate_request($request, $kode_mapel);
        $this->kode_mapel = $kode_mapel;
        if ($id == null) {
            $data_from_soal = $this->soal_first($kode_mapel);
        } else {
            $data_from_soal = $this->soal($kode_mapel, $id);
        }

        // validate time and etc

        $mapelconf = $this->daftar_mapel_repo->get_mapel_info($kode_mapel);

        $data2view = [
            "base" => $data_from_soal,
            "selector" => $this->get_soal_selector_status($kode_mapel),
            "button_control" => [
                "next" => $this->seq_next($kode_mapel),
                "before" => $this->seq_before($kode_mapel)
            ],
            "js_data" => [
                "kode_mapel" => $kode_mapel,
                "nomor_ujian" => $this->cookie_identity,
                "id_soal" => ($this->first_id != null) ? $this->first_id : $id,
                "penugasan_id" => $this->penugasan_id
            ],
            "preload_data" => [
                "current_selection" => $this->get_selection($id),
                "current_value_essay" => $this->get_essay_current_value($id)
            ],
            "mapel_config" => [
                "allow_copy" => $mapelconf["allow_copy"],
                "enable_right_click" => $mapelconf["enable_right_click"],
            ]
        ];

        // dd($data2view);

        // return view("views/kerjakan", $data2view);
        return view("views/kerjakan_bs5", $data2view);
        
        
    }
}
