<?php
session_start();
$cfg=require __DIR__.'/../config.php';
function db(){global $cfg;static $p;return $p??=new PDO("mysql:host={$cfg['host']};dbname={$cfg['db']};charset=utf8mb4",$cfg['user'],$cfg['pass'],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_PERSISTENT=>true]);}
function q($s,$a=[]){$t=db()->prepare($s);$t->execute($a);return $t;}
function all($s,$a=[]){return q($s,$a)->fetchAll();}
function one($s,$a=[]){return q($s,$a)->fetch()?:[];}
function e($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function csrf(){return $_SESSION['t']??=bin2hex(random_bytes(16));}
function chk(){if(!hash_equals($_SESSION['t']??'',$_POST['_t']??''))die('Sesi tidak valid, muat ulang halaman.');}
const PH="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='320' height='200'%3E%3Crect fill='%23d9cfb4' width='320' height='200'/%3E%3C/svg%3E";
function img($f,$pre=''){return $f?$pre.'uploads/'.e($f):PH;}
// Kelompokkan baris berdasarkan kolom (1 query untuk banyak kategori)
function group($rows,$k){$g=[];foreach($rows as $r)$g[$r[$k]][]=$r;return $g;}
// Perkecil gambar (maks 1280px) & kompres agar hemat bandwidth; dilewati bila GD tidak ada
function shrink($path,$ext,$max=1280){
 if(!function_exists('imagecreatetruecolor')||$ext=='gif')return;
 [$w,$h]=getimagesize($path);if(!$w||($w<=$max&&filesize($path)<300*1024))return;
 $src=match($ext){'png'=>@imagecreatefrompng($path),'webp'=>@imagecreatefromwebp($path),default=>@imagecreatefromjpeg($path)};if(!$src)return;
 $r=min(1,$max/max($w,$h));$nw=max(1,(int)($w*$r));$nh=max(1,(int)($h*$r));$dst=imagecreatetruecolor($nw,$nh);
 if($ext!='jpg'&&$ext!='jpeg'){imagealphablending($dst,false);imagesavealpha($dst,true);}
 imagecopyresampled($dst,$src,0,0,0,0,$nw,$nh,$w,$h);
 match($ext){'png'=>imagepng($dst,$path,8),'webp'=>imagewebp($dst,$path,80),default=>imagejpeg($dst,$path,80)};}
// return [namaFile, error]
function upload($key,$old){
 if(empty($_FILES[$key]['name']))return [$old,null];
 $f=$_FILES[$key];if($f['error']!==0||$f['size']>2*1024*1024)return [$old,'File gagal/lebih dari 2 MB'];
 $ext=strtolower(pathinfo($f['name'],PATHINFO_EXTENSION));
 if(!in_array($ext,['jpg','jpeg','png','webp','gif'])||!@getimagesize($f['tmp_name']))return [$old,'Hanya gambar jpg/png/webp/gif'];
 $n=bin2hex(random_bytes(8)).'.'.$ext;if(move_uploaded_file($f['tmp_name'],__DIR__.'/../uploads/'.$n))shrink(__DIR__.'/../uploads/'.$n,$ext);
 if($old&&is_file(__DIR__.'/../uploads/'.$old))unlink(__DIR__.'/../uploads/'.$old);
 return [$n,null];}
