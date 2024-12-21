create schema if not exists ref;

create table if not exists ref.periode (
	id_periode numeric(5,0) primary key,
	nama_periode varchar(30),
	is_deleted char(1) default '0',
	created_at timestamp default now(),
	updated_at timestamp
);

create table if not exists ref.jenjang_pendidikan (
	id_jenjang_didik int primary key,
	nama_jenjang_didik varchar(30),
	nama_singkat varchar(5),
	is_deleted char(1) default '0',
	created_at timestamp default now(),
	updated_at timestamp
);

create table if not exists ref.program_studi (
	id_program_studi serial primary key,
	nama_program_studi varchar(50),
	id_jenjang_didik int,
	is_deleted char(1) default '0',
	created_at timestamp default now(),
	updated_at timestamp,
	foreign key (id_jenjang_didik) references ref.jenjang_pendidikan(id_jenjang_didik)
);

create table if not exists mata_kuliah (
	id_mata_kuliah serial primary key,
	kode_mata_kuliah varchar(10),
	nama_mata_kuliah varchar(30),
	id_program_studi int not null,
	sks_tatap_muka numeric(5,2),
	sks_praktikum numeric(5,2),
	sks_praktikum_lapangan numeric(5,2),
	sks_simulasi numeric(5,2),
	sks_mata_kuliah numeric(5,2),
	is_deleted char(1) default '0',
	created_at timestamp default now(),
	updated_at timestamp,
	foreign key (id_program_studi) references ref.program_studi(id_program_studi),
	unique(kode_mata_kuliah)
);

create table if not exists mahasiswa (
	id_mahasiswa serial primary key,
	nama varchar(50) not null,
	tmp_lahir varchar(25) not null,
	tgl_lahir date not null,
	email varchar(30),
	nim varchar(30),
	id_periode_masuk numeric(5,0),
	is_deleted char(1) default '0',
	created_at timestamp default now(),
	updated_at timestamp,
	unique(nim),
	foreign key (id_periode_masuk) references ref.periode(id_periode) 
);

create table if not exists kelas (
	id_kelas serial primary key,
	nama_kelas varchar(20) not null,
	id_mata_kuliah int,
	id_program_studi int,
	is_deleted char(1) default '0',
	created_at timestamp default now(),
	updated_at timestamp,
	foreign key (id_mata_kuliah) references mata_kuliah(id_mata_kuliah),
	foreign key (id_program_studi) references ref.program_studi(id_program_studi)
);

create table if not exists krs (
	id_mahasiswa int,
	id_kelas int,
	nilai_numerik numeric(5,2),
	nilai_angka numeric(3,2),
	nilai_huruf varchar(3),
	is_deleted char(1) default '0',
	created_at timestamp default now(),
	updated_at timestamp,
	primary key(id_mahasiswa, id_kelas),
	foreign key (id_mahasiswa) references mahasiswa(id_mahasiswa),
	foreign key (id_kelas) references kelas(id_kelas)
);

create table if not exists komponen_nilai_kelas (
	id_komp_nilai_kls serial primary key,
	id_kelas int not null,
	nama_komponen varchar(30) not null,
	percentage numeric(5,2) not null,
	is_deleted char(1) default '0',
	created_at timestamp default now(),
	updated_at timestamp,
	foreign key (id_kelas) references kelas(id_kelas)
);

create table if not exists komponen_nilai_mhs (
	id_mahasiswa int not null,
	id_komp_nilai_kls int not null,
	nilai numeric(5,2),
	is_deleted char(1) default '0',
	created_at timestamp default now(),
	updated_at timestamp,
	primary key(id_mahasiswa, id_komp_nilai_kls),
	foreign key (id_mahasiswa) references mahasiswa(id_mahasiswa),
	foreign key (id_komp_nilai_kls) references komponen_nilai_kelas(id_komp_nilai_kls)
);

create schema if not exists log;

create table if not exists log.table_setting (
	id_table_setting serial primary key,
	table_name varchar(50),
);

create table if not exists log.transaction (
	id_transaction serial primary key,
	id_table_setting int not null,
	op char(1),
	pk1 varchar(100),
	pk2 varchar(100),
	pk3 varchar(100),
	new_data text,
	old_data text,
	foreign key (id_table_setting) references log.table_setting(id_table_setting)
);