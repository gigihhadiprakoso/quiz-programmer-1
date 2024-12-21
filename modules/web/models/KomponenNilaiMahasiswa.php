<?php

namespace Modules\Web\Models;

use Core\Model;
use Modules\Web\Models\KomponenNilaiKelas;

class KomponenNilaiMahasiswa extends Model{
    protected $table = "komponen_nilai_mhs";
    protected $primaryKey = ["id_mahasiswa", "id_komp_nilai_kls"];
    private $abc;

    public function komponenNilaiKelas() {
        return KomponenNilaiKelas::find($this->id_komp_nilai_kls);
    }

    public function mahasiswa() {
        return Mahasiswa::find($this->id_mahasiswa);
    }

    protected static function afterSave($attributes, $last_id) {
        $a_komp_mhs = static::where('id_mahasiswa','=', $attributes['id_mahasiswa']);
        $komponen_kelas = KomponenNilaiKelas::find($attributes['id_komp_nilai_kls']);
        
        $nilai_numerik = 0;
        foreach ($a_komp_mhs as $komp_mhs) {
            $komp_kls = $komp_mhs->komponenNilaiKelas();
            if($komp_kls->id_kelas == $komponen_kelas->id_kelas)
                $nilai_numerik += $komp_mhs->nilai * ($komp_kls->percentage/100);
        }

        $krs = new KRS();
        $krs->__set('id_mahasiswa', $attributes['id_mahasiswa']);
        $krs->__set('id_kelas', $komponen_kelas->id_kelas);
        $krs->__set('nilai_numerik', $nilai_numerik);
        $krs->save();
    }
}