<?php

use Modules\Web\Models\KomponenNilaiMahasiswa;
use Helpers\URL;
?>

<style>
    .toast-container {
        position: fixed;
        bottom: 1rem;
        right: 1rem;
        z-index: 9;
    }

    #loadingOverlay {
        display: none !important;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1050;
        text-align: center;
        align-items: center;
        justify-content: center;
    }

    #loadingOverlay .spinner-border {
        color: white;
    }
</style>

<div id="loadingOverlay" class="d-flex">
    <div>
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="text-white mt-3">Sedang memproses...</p>
    </div>
</div>

<h1>Daftar Nilai</h1>
<form action="<?= URL::base() . "/krs" ?>" method="post" id="form-krs">

    <button type="button" data-type="save" class="btn btn-success">
        <i class="fa-solid fa-floppy-disk"></i> Simpan
    </button>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th rowspan=2>No</th>
                <th rowspan="2">NIM</th>
                <th rowspan="2">Nama</th>
                <th colspan="<?= count($data['komp_kelas']) ?>">Nilai</th>
                <th rowspan="2">Nilai Akhir</th>
            </tr>
            <tr>
                <?php
                foreach ($data['komp_kelas'] as $row) { ?>
                    <th><?= $row->nama_komponen . "<br>" . $row->percentage . "%" ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($data['krs'] as $krs) { ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $krs->mahasiswa()->nim ?></td>
                    <td><?= $krs->mahasiswa()->nama ?></td>
                    <?php
                    foreach ($data['komp_kelas'] as $komp) {
                        $encid = base64_encode($krs->id_mahasiswa . "__" . $komp->id_komp_nilai_kls);
                        $komp_nilai_mhs = KomponenNilaiMahasiswa::find($krs->id_mahasiswa . "/" . $komp->id_komp_nilai_kls);
                        $value = !empty($komp_nilai_mhs) ? "value='{$komp_nilai_mhs->nilai}'" : null;
                    ?>
                        <td><input type="number" class="nilai_komp" id="nilai_<?= $encid ?>" name="nilai_<?= $encid ?>" max="100" min="0" <?= $value ?>></td>
                    <?php } ?>
                    <td><span id="nilai-akhir"><?= $krs->nilai_numerik ?></span></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</form>
<div class="toast-container">
    <div id="toast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="polite" aria-atomic="true" data-bs-delay="3000">
        <div class="d-flex">
            <div class="toast-body">
                Pengubahan nilai berhasil
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    let success = 0;
    let failed = 0;
    $(document).ready(function(){
        $("#loadingOverlay").fadeOut();
    })

    $("button[data-type='save']").click(function() {

        $(".nilai_komp").each(function(evt){
            const data = {};
            data[$(this).attr('name')] = $(this).val()

            dispatch(data);
        })

        console.log(success);
        console.log(failed)
    })

    function dispatch(data) {
        $.ajax({
            type: "POST",
            url: '<?= URL::base() . '/krs' ?>',
            cache: false,
            async: false,
            data: data,
            dataType: "json",
            beforeSend: function() {
                $('#loadingOverlay').fadeIn();
            },
            success: function(response) {
                console.log(response)
                if (!response.error_code) {
                    success++;
                } else {
                    failed++;
                }
            },
            error: function(obj, err) {},
            complete: function() {
                $('#loadingOverlay').fadeOut();
            }
        });
    }

    $(".nilai_komp").on('keypress', function(evt) {
        if (evt.key === 'Enter' || evt.key === 'Tab') {
            var inputs = $(this).parents("form").eq(0).find(":input");
            var idx = inputs.index(this);
            var key = $(this).attr('name');

            const data = {};
            data[key] = $(this).val();

            sendData(data);

            if (idx == inputs.length - 1) {
                inputs[0].select()
            } else {
                inputs[idx + 1].focus(); //  handles submit buttons
                inputs[idx + 1].select();
            }
            return false;
        }
    })

    $(".nilai_komp").on("blur", function() {
        var key = $(this).attr('name');

        const data = {};
        data[key] = $(this).val();
        sendData(data)
    })

    function sendData(dataBody) {
        $.ajax({
            url: '<?= URL::base() . "/krs" ?>',
            type: 'POST',
            data: dataBody,
            dataType: 'json',
            success: function(response, status) {
                if (!response.error_code) {
                    const toastElem = document.getElementById('toast');
                    const toast = new bootstrap.Toast(toastElem);
                    toast.show();
                }
            }
        })
    }
</script>