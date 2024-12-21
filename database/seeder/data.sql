INSERT INTO ref.periode (id_periode, nama_periode) VALUES ('20201', '2020/2021 Ganjil');
INSERT INTO ref.periode (id_periode, nama_periode) VALUES ('20202', '2020/2021 Genap');
INSERT INTO ref.periode (id_periode, nama_periode) VALUES ('20211', '2021/2022 Ganjil');
INSERT INTO ref.periode (id_periode, nama_periode) VALUES ('20212', '2021/2022 Genap');
INSERT INTO ref.periode (id_periode, nama_periode) VALUES ('20221', '2022/2023 Ganjil');
INSERT INTO ref.periode (id_periode, nama_periode) VALUES ('20222', '2022/2023 Genap');

INSERT INTO ref.jenjang_pendidikan (id_jenjang_didik, nama_jenjang_didik, nama_singkat) VALUES (30, 'Strata I', 'S1');

INSERT INTO ref.program_studi (nama_program_studi, id_jenjang_didik) VALUES ('Teknik Industri', 30);

INSERT INTO mata_kuliah (nama_mata_kuliah, id_program_studi, sks_tatap_muka, sks_praktikum, sks_praktikum_lapangan, sks_simulasi, sks_mata_kuliah)
VALUES ('Pengantar Manajemen', 1, 3, 0, 0, 0, 0);

INSERT INTO kelas (nama_kelas, id_mata_kuliah, id_program_studi) VALUES ('ABC12', '1', '1');

INSERT INTO mahasiswa (nama, tmp_lahir, tgl_lahir, email, nim, id_periode_masuk) VALUES ('John', 'Jakarta Utara', '2006-11-02', 'j@ex.id', '123456789', '20211');
INSERT INTO mahasiswa (nama, tmp_lahir, tgl_lahir, email, nim, id_periode_masuk) VALUES ('Bill', 'Jakarta Selatan', '2004-02-28', 'j@ex.id', '893282738', '20201');
INSERT INTO mahasiswa (nama, tmp_lahir, tgl_lahir, email, nim, id_periode_masuk) VALUES ('Noem', 'Gunung Kidul', '2002-03-15', 'j@ex.id', '928773361', '20211');
INSERT INTO mahasiswa (nama, tmp_lahir, tgl_lahir, email, nim, id_periode_masuk) VALUES ('Peet', 'Bondowoso', '2003-04-27', 'j@ex.id', '902218293', '20221');
INSERT INTO mahasiswa (nama, tmp_lahir, tgl_lahir, email, nim, id_periode_masuk) VALUES ('Ters', 'Bogor', '2008-09-17', 'j@ex.id', '372839448', '20211');

INSERT INTO krs (id_mahasiswa, id_kelas) VALUES ('1', '1');
INSERT INTO krs (id_mahasiswa, id_kelas) VALUES ('2', '1');
INSERT INTO krs (id_mahasiswa, id_kelas) VALUES ('3', '1');
INSERT INTO krs (id_mahasiswa, id_kelas) VALUES ('4', '1');
INSERT INTO krs (id_mahasiswa, id_kelas) VALUES ('5', '1');

INSERT INTO komponen_nilai_kelas (id_kelas, nama_komponen, percentage) VALUES (1, 'Kehadiran', '10');
INSERT INTO komponen_nilai_kelas (id_kelas, nama_komponen, percentage) VALUES (1, 'Tugas', '10');
INSERT INTO komponen_nilai_kelas (id_kelas, nama_komponen, percentage) VALUES (1, 'Quiz', '15');
INSERT INTO komponen_nilai_kelas (id_kelas, nama_komponen, percentage) VALUES (1, 'UTS', '30');
INSERT INTO komponen_nilai_kelas (id_kelas, nama_komponen, percentage) VALUES (1, 'UAS', '35');

INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (1, 1, 29);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (1, 2, 48);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (1, 3, 88);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (1, 4, 47);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (1, 5, 93);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (2, 1, 44);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (2, 2, 57);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (2, 3, 82);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (2, 4, 63);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (2, 5, 57);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (3, 1, 92);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (3, 2, 65);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (3, 3, 33);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (3, 4, 85);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (3, 5, 71);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (4, 1, 67);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (4, 2, 84);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (4, 3, 75);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (4, 4, 79);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (4, 5, 86);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (5, 1, 65);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (5, 2, 87);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (5, 3, 95);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (5, 4, 98);
INSERT INTO komponen_nilai_mhs (id_mahasiswa, id_komp_nilai_kls, nilai) VALUES (5, 5, 63);

INSERT INTO log.table_setting (table_name) VALUES ('krs');
INSERT INTO log.table_setting (table_name) VALUES ('komponen_nilai_mhs');