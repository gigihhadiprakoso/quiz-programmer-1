<?php

namespace Modules\Web\Models;

use Core\Model;
use Modules\Web\Models\Mahasiswa;

class KRS extends Model {
    protected $table = 'krs';
    protected $primaryKey = ["id_mahasiswa", "id_kelas"];

    public function mahasiswa() {
        return Mahasiswa::find($this->id_mahasiswa);
    }

    public function kelas(){
        return Kelas::where('id_kelas', '=', $this->id_kelas);
    }
}