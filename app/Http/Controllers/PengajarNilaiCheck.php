<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits;
use App\Repositories;
use Yajra\DataTables\Facades\DataTables;

class calculate_proporsi {
	protected $total_essay, $total_pilgan, $essay_dijawab, $pilgan_dijawab;
	public function set_parameter($total_essay, $total_pilgan, $essay_dijawab, $pilgan_dijawab) {
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
			echo $this->static_pilgan_value . PHP_EOL; 
			$this->session_current_pilgan_nilai = $this->session_current_pilgan_nilai + ($this->static_pilgan_value);
		} 
		// $this->session_current_pilgan_nilai + ($this->essay_nilai_table[$penilaian_rate - 1]);
	}

	public function get_essay_nilai_essay() {
		return $this->session_current_essay_nilai;
	}


	public function get_essay_nilai_pilgan() {
		return $this->session_current_pilgan_nilai;
	}
}

class PengajarNilaiCheck extends Controller
{
    use Traits\CurrentSessionTrait;
    
    protected $kelas, $penugasan_id;

    public function __construct(
        protected Repositories\PenyelesaianRepository $penyelesaian_repo,
        protected Repositories\SiswaAccountRepository $siswa_repo,
        protected Repositories\SoalRepository $soal_repo
        
        // 
    ) {}

    private function return_siswa_by_spesific_class() {
        return $this->siswa_repo->getByTable("kelas", $this->kelas)->get();
        // dd($list_of_all_student);
    }

    private function pack_data() {
        foreach($this->return_siswa_by_spesific_class() as $data_s) {
            yield [
                "nama" => $data_s["nama"]
            ];
        }
    }

    public function Index(Request $request) {
        $validated = $request->validate([         // convention list
            "kelas" => "required",
            "penugasan_id" => "required"
        ]);

        $this->kelas = $request->kelas;
        $this->penugasan_id = $request->penugasan_id;

        return view("views/pengajar_nilai_check", [
            "data" => iterator_to_array($this->pack_data())
        ]);
    }
}
