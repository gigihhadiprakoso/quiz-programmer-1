<?php

namespace Modules\Web\Controllers;

use Classes\Controller;
use Classes\Request;
use Modules\Web\Models\Mahasiswa;
use Modules\Web\Models\KRS;
use Modules\Web\Models\KomponenNilaiKelas;
use Modules\Web\Models\KomponenNilaiMahasiswa;
use Helpers\URL;

class KRSController extends Controller {

    private $data;
    private $app;

    public function __construct() {
        global $app;

        parent::__construct();
        $this->data = ['title' => 'KRS'];
        $this->app = $app;
    }

    public function index(Request $request){

        $input = $request->getAll();
        $id_kelas = !empty($input['id']) ? $input['id'] : 1;

        $a_krs = KRS::where('id_kelas','=', $id_kelas);
        $a_komp_kls = KomponenNilaiKelas::where('id_kelas', '=', $id_kelas);

        $condition = [];
        foreach($a_komp_kls as $komp) {
            $condition[] = $komp->id_komp_nilai_kls;
        }
        $a_komp_mhs = KomponenNilaiMahasiswa::where('id_komp_nilai_kls', 'in', "('".implode("','", $condition)."')");

        $this->data['krs'] = $a_krs;
        $this->data['komp_kelas'] = $a_komp_kls;
        $this->data['komp_mhs'] = $a_komp_mhs;
        $this->view('krs/index', $this->data);
    }

    public function store(Request $request) {
        $input = $request->getAll();
        foreach ($input as $key => $score) {
            list(, $enc_id) = explode("_",$key);
            list($id_mhs, $id_komp_kls) = explode("__", base64_decode($enc_id));

            $komp_nilai_mhs = new KomponenNilaiMahasiswa();
            $komp_nilai_mhs->__set('id_mahasiswa', $id_mhs);
            $komp_nilai_mhs->__set('id_komp_nilai_kls', $id_komp_kls);
            $komp_nilai_mhs->__set('nilai', $score ?: 0);
            $komp_nilai_mhs->save();
        }
        
        if($request->isXHR()) {
            echo json_encode(['error_code' => 0, 'error_msg' => '', 'data' => $input]);
            exit;
        } else 
            URL::to('krs');

    }
}