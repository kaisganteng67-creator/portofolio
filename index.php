<?php
require 'inc/bootstrap.php';
$pages=['home','about','skills','projects','project','certificates','experience','testimonials','blog','contact'];
$p=$_GET['p']??'home';if(!in_array($p,$pages))$p='home';
$pf=one('SELECT * FROM profiles ORDER BY id LIMIT 1');
$err=[];$old=['name'=>'','category'=>'Teman','body'=>''];
if($p=='contact'&&$_SERVER['REQUEST_METHOD']=='POST'){
 chk();$old=['name'=>trim($_POST['name']??''),'category'=>$_POST['category']??'','body'=>trim($_POST['body']??'')];
 if($old['name']===''||mb_strlen($old['name'])>100)$err[]='Nama wajib diisi (maks 100 karakter).';
 if(!in_array($old['category'],['Guru Pembimbing','Teman','Pengguna','Tempat PLK','Lainnya']))$err[]='Kategori tidak valid.';
 if($old['body']===''||mb_strlen($old['body'])>2000)$err[]='Pesan wajib diisi (maks 2000 karakter).';
 if(!$err){q('INSERT INTO messages(name,category,body) VALUES(?,?,?)',[$old['name'],$old['category'],$old['body']]);header('Location: index.php?p=contact&ok=1');exit;}
}
include 'inc/header.php';include "pages/$p.php";include 'inc/footer.php';
