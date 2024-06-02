<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits;
use App\Repositories;
use Yajra\DataTables\Facades\DataTables;

define("pilihan_bobot_soal_essay_dlm_persen", 50); // 1/2
define("length_pemoin", env("ESSAY_MAX_POINTS_RANGE"));

class calculate_proporsi {
	protected $total_essay, $total_pilgan, $essay_dijawab, $pilgan_dijawab;

    // deprecation warning parameter, essay_dijawab, pilgan_dijawab unused
	public function set_parameter($total_essay, $total_pilgan, $essay_dijawab = null, $pilgan_dijawab = null) {
		$this->total_essay = $total_essay;
		$this->total_pilgan = $total_pilgan;
		$this->essay_dijawab = $essay_dijawab;
		$this->pilgan_dijawab = $pilgan_dijawab;
		return $this;
	}

	// essay

	private function calculate_epoints() { 
		return pilihan_bobot_soal_essay_dlm_persen / $this->total_essay; 
	}

	private function calculate_epoints_kpk() {
		return $this->calculate_epoints() / length_pemoin;
	}

	private function calculate_epoints_divider_table() {
		$table = [];
		for($i = 0; $i < length_pemoin; $i++) {
			array_push($table, $this->calculate_epoints_kpk() * ($i + 1));
		}
		return $table;
	}

	public function result_table_essay() { 
		return $this->calculate_epoints_divider_table(); 
	}

	// pilgan
	public function result_pilgan_static_point() { 
		return (100 - pilihan_bobot_soal_essay_dlm_persen) / $this->total_pilgan; 
	}

	public function result_pilgan_static_point_without_essay() { 
		return (100) / $this->total_pilgan; 
	}

}

class calculate_nilai {
	protected $essay_nilai_table, $static_pilgan_value, $session_current_essay_nilai = 0, $session_current_pilgan_nilai = 0;
	public function __construct($essay_nilai_table, $static_pilgan_value) {
		$this->essay_nilai_table = $essay_nilai_table;
		$this->static_pilgan_value = $static_pilgan_value;
	}

	public function essay_input($penilaian_rate) {
		$this->session_current_essay_nilai = $this->session_current_essay_nilai + ($this->essay_nilai_table[$penilaian_rate - 1]);
	}

	public function pilgan_input($penilaian_cond) {
		if ($penilaian_cond == 1) {
			// echo $this->static_pilgan_value . PHP_EOL; 
			$this->session_current_pilgan_nilai = $this->session_current_pilgan_nilai + ($this->static_pilgan_value);
		} 
		// $this->session_current_pilgan_nilai + ($this->essay_nilai_table[$penilaian_rate - 1]);
	}

	public function get_nilai_essay() {
		return $this->session_current_essay_nilai;
	}


	public function get_nilai_pilgan() {
		return $this->session_current_pilgan_nilai;
	}
}

class build_table {
    protected $nomor_ujian;

    public function __construct(
        protected Repositories\SoalRepository $soal_repo,

        protected Repositories\onRunTimePilihanGandaRepository $on_runtime_pilgan,
        protected Repositories\onRunTimeEssayRepository $on_runtime_essay,

        protected Repositories\PgRepo $pg_repo,
        
        protected string $kode_mapel,
        protected int $penugasan_id,
        
    ) {}

    // public function return_

    public function return_total_soal_both() {
        return [
            $this->soal_repo->get_total_soal_pilgan($this->kode_mapel),
            $this->soal_repo->get_total_soal_essay($this->kode_mapel)
        ];
    }

    // return array of answered exam, but not compare
    public function return_id_soal_filled_both() {
        // dd($this->penugasan_id);
        return [
            $this->on_runtime_pilgan->get_all_answer_by_siswa_and_penugasan(
                $this->nomor_ujian, $this->kode_mapel, $this->penugasan_id
            ),
            $this->on_runtime_essay->get_all_answer_by_siswa_and_penugasan(
                $this->nomor_ujian, $this->kode_mapel, $this->penugasan_id
            )
        ];
    }

    private function pg_return_indexof_id($id_soal_obj) { // return true or false only
        $pilihan_option = $this->pg_repo->get_option_ordered($this->kode_mapel, $id_soal_obj["id_soal"]);
        for($i = 0; $i < count($pilihan_option); $i++) {
            if ($id_soal_obj["index_jawaban"] == $pilihan_option[$i]["id"]) {
                return $i;
            }
        }
    }
    private function pg_compare_answer($id_soal_obj) {
        $selected_id = $this->pg_return_indexof_id($id_soal_obj);
        $actual_answer = $this->soal_repo->get_soal($this->kode_mapel, $id_soal_obj["id_soal"]);
        // dd($selected_id);
        // return "selected " . $selected_id . " ans " . $actual_answer["index_kunci_jawaban"];
        return ($selected_id == $actual_answer["index_kunci_jawaban"]) ? true : false;
    }

    private function gen_pilgan_table($nomor_ujian) : Iterable {
        $this->nomor_ujian = $nomor_ujian;

        if (($pilgan_total = $this->return_total_soal_both()[0]) > 0) {
            $pre_recv_soal = $this->return_id_soal_filled_both()[0];

            for($i = 0; $i < $pilgan_total; $i++) {
                if (isset($pre_recv_soal[$i])) {
                    // $this->pg_repo->get_option_ordered($this->kode_mapel, $pre_recv_soal[$i]["id_soal"])
                    yield $this->pg_compare_answer($pre_recv_soal[$i]);
                } else {
                    yield false;
                }
            }
        }
    }

    public function return_pilgan_table($nomor_ujian) : array|false {
        return iterator_to_array($this->gen_pilgan_table($nomor_ujian));
    }

    /**
     * essay section
     */

    
}

class PengajarNilaiCheck extends Controller
{
    use Traits\CurrentSessionTrait;
    
    protected $kelas, $penugasan_id;
    protected build_table $build_table;

    public function __construct(
        protected Repositories\PenyelesaianRepository $penyelesaian_repo,
        protected Repositories\SiswaAccountRepository $siswa_repo,
        protected Repositories\SoalRepository $soal_repo,
        protected Repositories\PgRepo $pg_repo,

        protected Repositories\onRunTimePilihanGandaRepository $on_runtime_pilgan,
        protected Repositories\onRunTimeEssayRepository $on_runtime_essay,
        
        
        // 
    ) {}

    private function return_siswa_by_spesific_class() {
        return $this->siswa_repo->getByTable("kelas", $this->kelas)->get();
        // dd($list_of_all_student);
    }

    private function calculate_nilai($pg_table) {
        
        [$total_soal_pilgan, $total_soal_essay] = $this->build_table->return_total_soal_both();
        
        // semua points didefinisikan disini
        $calc = new calculate_proporsi();
        $essay_table_points = $calc->set_parameter($total_soal_essay, $total_soal_pilgan)->result_table_essay(); //  dipake buat generate range selection nilai essay
        $pilgan_points = $calc->set_parameter($total_soal_essay, $total_soal_pilgan)->result_pilgan_static_point();  // point pilgan ketika betul
        
        // memulai penginputan nilai
        // pg dihitung poin jika ia benar
        $nilai = new calculate_nilai($essay_table_points, $pilgan_points);
        foreach ($pg_table as $pg_table_s) {
            $nilai->pilgan_input($pg_table_s);
        }

        foreach ($pg_table as $pg_table_s) {
            $nilai->pilgan_input($pg_table_s);
        }

        return $nilai->get_nilai_essay();
        
        // $pilgan_points = $calc->set_parameter($total_essay, $total_pilgan, $essay_dijawab, $pilgan_dijawab)->result_pilgan_static_point();  // point pilgan ketika betul
    }

    private function pack_data() {
        // dd($this->return_siswa_by_spesific_class());
        // this is const, same as runtime
        $this->build_table = new build_table(
            $this->soal_repo,
            $this->on_runtime_pilgan,
            $this->on_runtime_essay,
            $this->pg_repo,
            $this->kode_mapel,
            $this->penugasan_id
        );

        

        
        foreach($this->return_siswa_by_spesific_class() as $data_s) {
            yield [
                "nilai_pg" => $this->calculate_nilai($this->build_table->return_pilgan_table($data_s["nomor_ujian"]))
            ];
            // dd($data_s["nomor_ujian"]);
            // [$jml_pilgan, $jml_essay] = $this->get_total_soal_dikerjakan_by_nomor_ujian($data_s["nomor_ujian"]);
            
            // yield [
            //     "nama" => $data_s["nama"],
            //     "nilai_pilgan" => 1
            // ];
        }
    }

    public function Index(Request $request) {
        $validated = $request->validate([         // convention list
            "kelas" => "required",
            "kode_mapel" => "required",
            "penugasan_id" => "required"
        ]);

        $this->kelas = $request->kelas;
        $this->penugasan_id = $request->penugasan_id;
        $this->kode_mapel = $request->kode_mapel;

        // return response(json_encode(iterator_to_array($this->pack_data()), JSON_PRETTY_PRINT));
        dd(iterator_to_array($this->pack_data()));
        return view("views/pengajar_nilai_check", [
            "data" => iterator_to_array($this->pack_data())
        ]);
    }
}
