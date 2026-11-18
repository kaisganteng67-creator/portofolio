<?php
// Buka sekali di browser: membuat database, tabel, akun admin, dan data awal dari CV.
// Tambahkan ?reset=1 untuk MENGGANTI semua data konten (profil, proyek, dst.) dengan data awal. Pesan masuk tidak dihapus.
// HAPUS file ini setelah selesai.
$cfg=require __DIR__.'/config.php';
$pdo=new PDO("mysql:host={$cfg['host']};charset=utf8mb4",$cfg['user'],$cfg['pass'],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
$pdo->exec("CREATE DATABASE IF NOT EXISTS `{$cfg['db']}` CHARACTER SET utf8mb4");
require __DIR__.'/inc/bootstrap.php';
db()->exec(file_get_contents(__DIR__.'/database.sql'));
if(!one("SHOW COLUMNS FROM users LIKE 'username'"))db()->exec('ALTER TABLE users ADD username VARCHAR(100) UNIQUE AFTER name');
if(!one("SHOW COLUMNS FROM profiles LIKE 'phone'"))db()->exec('ALTER TABLE profiles ADD phone VARCHAR(50) AFTER email');
if(!one('SELECT id FROM users WHERE username=?',['admin123'])){q('DELETE FROM users');q('INSERT INTO users(name,username,password) VALUES(?,?,?)',['Admin','admin123',password_hash('admin123',PASSWORD_DEFAULT)]);}
if(isset($_GET['reset']))foreach(['profiles','educations','skills','projects','certificates','experiences','testimonials','blog_posts'] as $t)db()->exec("DELETE FROM `$t`");
if(!one('SELECT id FROM profiles LIMIT 1')){
 q('INSERT INTO profiles(name,class_name,tagline,bio,main_skills,birth_info,address,interests,goal,email,phone,github,instagram,linkedin,photo) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[
  "Muhammad Qais Al-Asy'Ari",'Siswa PPLG — SMK Negeri 2 Banjarmasin','Siswa PPLG yang tertarik pada web development, desain, dan editing.',
  'Siswa SMK Negeri 2 Banjarmasin jurusan Pengembangan Perangkat Lunak dan Gim (PPLG) yang tertarik pada web development serta desain dan editing. Berpengalaman magang sebagai Data Entry Intern dan aktif di ekstrakurikuler basket.',
  'HTML, CSS, Tailwind, Figma, CapCut','5 Maret 2009 · Warga Negara Indonesia','Banjarmasin, Kalimantan Selatan, Indonesia','Web Development, Design & Editing, Basket, Musik',
  'Mengembangkan kemampuan di bidang web development dan desain.','mqaisalasyari@gmail.com','+62 851 2406 2991',null,null,null,'profile.jpg']);
 foreach([['MI Nurul Hidayah','2015 – 2021','Simpang Empat, Indonesia'],['MTs Darul Azhar','2021 – 2024','Simpang Empat, Indonesia'],['SMK Negeri 2 Banjarmasin','2024 – 2027','Banjarmasin, Indonesia. Jurusan Pengembangan Perangkat Lunak dan Gim (PPLG)']] as $e)q('INSERT INTO educations(school,period,description) VALUES(?,?,?)',$e);
 foreach([['HTML','hard',80],['CSS','hard',75],['Tailwind','hard',70],['Figma','hard',70],['CapCut','hard',75],['Kerja sama tim','soft',85],['Disiplin','soft',80],['Komunikasi','soft',80],['Ketelitian','soft',80]] as $s)q('INSERT INTO skills(name,type,percent) VALUES(?,?,?)',$s);
 q('INSERT INTO experiences(title,type,place,period,description) VALUES(?,?,?,?,?)',['Data Entry Intern','plk','Dinas Perpustakaan dan Kearsipan','2026','Memasukkan, mengelola, dan memperbarui data ke dalam sistem komputer; membantu pengelolaan data dan tugas administrasi; memeriksa data agar akurat dan lengkap.']);
 q('INSERT INTO experiences(title,type,place,period,description) VALUES(?,?,?,?,?)',['Ekstrakurikuler Basket','organisasi','SMK Negeri 2 Banjarmasin','2024 – 2027','Mengikuti latihan dan kegiatan basket sekolah; melatih kerja sama tim, disiplin, dan sportivitas; meningkatkan kemampuan komunikasi dan kolaborasi.']);
 foreach([
  ["IPAWN — Game Puzzle Tekanan", "Web / Edukasi", "Game edukasi interaktif pada platform belajar IPA IPAWN. Siswa mencocokkan istilah (paku, bendungan, dongkrak, kapal, balon) dengan konsep tekanan yang sesuai: tekanan zat padat, hidrostatis, hukum Pascal, hukum Archimedes, dan tekanan gas.", "Materi tekanan terasa abstrak sehingga siswa sulit mengaitkan konsep dengan contoh nyata di sekitar mereka.", "Membantu siswa memahami konsep tekanan lewat permainan mencocokkan yang singkat, visual, dan memberi skor langsung.", "HTML, CSS, JavaScript", "Frontend Developer", "Mencocokkan istilah dengan definisi; skor langsung; kartu berwarna dengan ikon; menu Beranda, Materi, Ulangan, Game, dan Eksplorasi.", "Bagian dari IPAWN, platform belajar IPA yang juga memiliki materi, ulangan, dan eksplorasi.", "proj-ipawn-puzzle.jpg"],
  ["IPAWN — Modul Ulangan Online", "Web / Edukasi", "Halaman ulangan pada IPAWN. Soal pilihan ganda tampil satu per satu dengan pengatur waktu dan penomoran soal 1–10, sehingga siswa mudah berpindah antarsoal.", "Ulangan di kertas lambat dikoreksi dan kurang menarik bagi siswa.", "Menyediakan ulangan digital yang rapi, terukur waktunya, dan nyaman dikerjakan di layar.", "HTML, CSS, JavaScript", "Frontend Developer", "Soal pilihan ganda dengan 4 opsi berwarna; timer; navigasi nomor soal; tombol Selanjutnya; maskot kucing sebagai elemen visual.", "Tampilan pada tangkapan layar ini masih memakai teks soal contoh.", "proj-ipawn-ulangan.jpg"],
  ["Website Portofolio Pribadi (Laravel)", "Web / Portofolio", "Website portofolio bertema gelap modern dengan halaman Beranda, Tentang, Portofolio, Kontak, dan Admin, dibangun dengan Laravel dan Tailwind CSS.", "Profil dan karya tersebar di banyak tempat sehingga sulit ditampilkan secara profesional dalam satu halaman.", "Menyajikan profil dan karya dalam satu situs yang bersih, responsif, dan bisa dikelola lewat halaman admin.", "PHP, Laravel, Blade, Tailwind CSS", "Full-stack Developer", "Navigasi menu; hero dengan foto profil dan tag teknologi; halaman portofolio; halaman kontak; halaman admin.", "Dijalankan secara lokal di portofolio.test menggunakan Laravel.", "proj-portfolio.jpg"]
 ] as $p)q('INSERT INTO projects(name,category,description,problem,goal,tech,role,features,detail,image) VALUES(?,?,?,?,?,?,?,?,?,?)',$p);
}
// Sertifikat: ditambahkan bila belum ada (aman dijalankan ulang, tanpa ?reset=1, tidak membuat duplikat)
if(!one('SELECT id FROM certificates WHERE image=?',['cert-workshop.jpg']))q('INSERT INTO certificates(title,year,description,image) VALUES(?,?,?,?)',['Peserta Workshop Pengelola Perpustakaan','2026','Diselenggarakan oleh Dinas Perpustakaan dan Kearsipan Provinsi Kalimantan Selatan pada 26 Agustus 2026 di Aula DISPERSIP Prov. Kalsel. Nomor sertifikat: 400.3.8.5/5/DISPERSIP/2026. Ditandatangani secara elektronik (BSrE).','cert-workshop.jpg']);
// Indeks untuk query yang sering dipakai
foreach(['experiences'=>'type','testimonials'=>'role','skills'=>'type'] as $t=>$c){if(!one("SHOW INDEX FROM `$t` WHERE Key_name='idx_$c'"))db()->exec("ALTER TABLE `$t` ADD INDEX idx_$c (`$c`)");}
echo 'Instalasi selesai. Login: <a href="admin/">admin/</a> (username admin123 / password admin123). Hapus install.php sekarang.';
