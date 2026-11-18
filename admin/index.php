<?php
require __DIR__.'/../inc/bootstrap.php';
$R=[
 'profile'=>['profiles',['name'=>'text','class_name'=>'text','tagline'=>'text','bio'=>'textarea','main_skills'=>'text','birth_info'=>'text','address'=>'text','interests'=>'text','goal'=>'textarea','email'=>'text','phone'=>'text','github'=>'text','instagram'=>'text','linkedin'=>'text','photo'=>'file'],'Profil'],
 'projects'=>['projects',['name'=>'text','category'=>'text','description'=>'textarea','problem'=>'textarea','goal'=>'textarea','tech'=>'text','role'=>'text','features'=>'textarea','demo_url'=>'text','github_url'=>'text','documentation'=>'textarea','detail'=>'textarea','feedback'=>'textarea','image'=>'file'],'Proyek'],
 'skills'=>['skills',['name'=>'text','type'=>['hard','soft'],'percent'=>'number'],'Keahlian'],
 'educations'=>['educations',['school'=>'text','period'=>'text','description'=>'textarea'],'Pendidikan'],
 'experiences'=>['experiences',['title'=>'text','type'=>['plk','organisasi','lomba'],'place'=>'text','period'=>'text','description'=>'textarea','image'=>'file'],'Pengalaman'],
 'certificates'=>['certificates',['title'=>'text','year'=>'text','description'=>'textarea','image'=>'file'],'Sertifikat'],
 'testimonials'=>['testimonials',['name'=>'text','role'=>['guru','teman','pengguna','plk'],'content'=>'textarea'],'Testimoni'],
 'blog_posts'=>['blog_posts',['title'=>'text','excerpt'=>'text','content'=>'textarea'],'Blog'],
 'messages'=>['messages',['name'=>'text','category'=>'text','body'=>'textarea'],'Pesan'],
];
$a=$_GET['a']??'dash';$r=$_GET['r']??'';$id=(int)($_GET['id']??0);$msg='';$err=[];
if($a=='logout'){session_destroy();header('Location: ./');exit;}
if(empty($_SESSION['uid'])){
 $le='';
 if($_SERVER['REQUEST_METHOD']=='POST'){chk();$u=one('SELECT * FROM users WHERE username=?',[trim($_POST['username']??'')]);
  if($u&&password_verify($_POST['password']??'',$u['password'])){session_regenerate_id(true);$_SESSION['uid']=$u['id'];header('Location: ./');exit;}$le='Username atau password salah';}
 ?><!DOCTYPE html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-[#f1ebdc] min-h-screen grid place-items-center"><form method="post" class="bg-[#faf6ea] border-2 border-neutral-900 p-6 w-80 space-y-3"><input type="hidden" name="_t" value="<?=csrf()?>"><h1 class="text-2xl font-black">LOGIN ADMIN</h1>
<input name="username" placeholder="Username" autocomplete="username" class="w-full border-2 p-2"><input name="password" type="password" placeholder="Password" class="w-full border-2 p-2">
<?php if($le):?><p class="text-red-600 text-sm"><?=$le?></p><?php endif?><button class="bg-neutral-900 text-white px-4 py-2 w-full">Masuk</button></form></body></html><?php exit;}
// ---- aksi ----
$cfgR=$R[$r]??null;
if($r&&!$cfgR){http_response_code(404);die('Tidak ditemukan');}
if($cfgR){[$tbl,$F,$title]=$cfgR;
 if($r=='profile'){$row0=one('SELECT id FROM profiles LIMIT 1');if(!$row0){q("INSERT INTO profiles(name) VALUES('Nama')");$row0=one('SELECT id FROM profiles LIMIT 1');}$id=(int)$row0['id'];$a='edit';}
 if($_SERVER['REQUEST_METHOD']=='POST'&&$a=='del'){chk();$o=one("SELECT * FROM `$tbl` WHERE id=?",[$id]);
  foreach($F as $k=>$t)if($t=='file'&&!empty($o[$k])&&is_file(__DIR__.'/../uploads/'.$o[$k]))unlink(__DIR__.'/../uploads/'.$o[$k]);
  q("DELETE FROM `$tbl` WHERE id=?",[$id]);header("Location: ?r=$r&ok=Data+dihapus");exit;}
 if($_SERVER['REQUEST_METHOD']=='POST'&&in_array($a,['new','edit'])){chk();
  $old=$id?one("SELECT * FROM `$tbl` WHERE id=?",[$id]):[];$d=[];$i=0;
  foreach($F as $k=>$t){
   if($t=='file'){[$d[$k],$e1]=upload($k,$old[$k]??null);if($e1)$err[]="$k: $e1";if(!empty($_POST["del_$k"])&&!empty($old[$k])&&!$e1&&empty($_FILES[$k]['name'])){@unlink(__DIR__.'/../uploads/'.$old[$k]);$d[$k]=null;}continue;}
   $v=trim($_POST[$k]??'');
   if(is_array($t)&&!in_array($v,$t))$err[]="$k tidak valid";
   elseif($t=='number'&&!(ctype_digit($v)&&$v<=100))$err[]="$k harus angka 0–100";
   elseif($i==0&&$v==='')$err[]="$k wajib diisi";
   elseif(!is_array($t)&&$t!='number'&&mb_strlen($v)>($t=='textarea'?65000:255))$err[]="$k terlalu panjang";
   if(!is_array($t)&&$t!='number'&&$i>0&&$v==='')$v=null;
   $d[$k]=$v;$i++;}
  if($r=='testimonials'||$r=='messages'){foreach(['content','body'] as $k)if(isset($d[$k])&&$d[$k]==='')$err[]="$k wajib diisi";}
  if(!$err){$cols=array_keys($d);
   if($id)q("UPDATE `$tbl` SET ".implode(',',array_map(fn($c)=>"`$c`=?",$cols))." WHERE id=?",[...array_values($d),$id]);
   else q("INSERT INTO `$tbl`(".implode(',',array_map(fn($c)=>"`$c`",$cols)).") VALUES(".implode(',',array_fill(0,count($cols),'?')).")",array_values($d));
   header("Location: ?".($r=='profile'?"r=profile":"r=$r")."&ok=Tersimpan");exit;}
 }
}
$ok=$_GET['ok']??'';
?><!DOCTYPE html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin</title>
<script src="https://cdn.tailwindcss.com"></script>
<style type="text/tailwindcss">.in{@apply w-full border-2 border-neutral-800 p-2 bg-white;}.btn{@apply inline-block bg-neutral-900 text-[#f1ebdc] px-3 py-1.5 text-sm font-semibold border-2 border-neutral-900;}.btn.o{@apply bg-transparent text-neutral-900;}</style></head>
<body class="bg-[#f1ebdc] text-neutral-900 min-h-screen"><div class="md:flex">
<aside class="md:w-56 bg-neutral-900 text-[#f1ebdc] p-4 md:min-h-screen text-sm"><b class="block mb-3 text-lg">ADMIN ×</b>
<a class="block py-1 hover:underline" href="./">Dashboard</a><?php foreach($R as $k=>$v):?><a class="block py-1 hover:underline" href="?r=<?=$k?>"><?=$v[2]?></a><?php endforeach?>
<a class="block py-1" href="../" target="_blank">↗ Lihat situs</a><a class="block py-1 underline mt-3" href="?a=logout">Logout</a></aside>
<main class="flex-1 p-6"><?php if($ok):?><p class="bg-green-100 border border-green-600 p-2 mb-4"><?=e($ok)?></p><?php endif;
if(!$cfgR):?><h1 class="text-2xl font-black mb-4">Dashboard</h1><div class="grid grid-cols-2 md:grid-cols-4 gap-4"><?php foreach($R as $k=>$v)if($k!='profile'):?><a href="?r=<?=$k?>" class="bg-[#faf6ea] border-2 border-neutral-900 p-4"><div class="text-3xl font-black"><?=one("SELECT COUNT(*) c FROM `{$v[0]}`")['c']?></div><?=$v[2]?></a><?php endif?></div>
<?php elseif(in_array($a,['new','edit'])):$row=$id?one("SELECT * FROM `$tbl` WHERE id=?",[$id]):[];if($_POST)$row=array_merge($row,$_POST);?>
<h1 class="text-2xl font-black mb-4"><?=$title?></h1><?php foreach($err as $m):?><p class="text-red-600 text-sm"><?=e($m)?></p><?php endforeach?>
<form method="post" enctype="multipart/form-data" class="space-y-3 max-w-2xl"><input type="hidden" name="_t" value="<?=csrf()?>">
<?php foreach($F as $k=>$t):$v=$row[$k]??'';?><label class="block text-sm font-semibold"><?=ucwords(str_replace('_',' ',$k))?>
<?php if($t=='textarea'):?><textarea name="<?=$k?>" rows="4" class="in"><?=e($v)?></textarea>
<?php elseif($t=='file'):?><input type="file" name="<?=$k?>" accept="image/*" class="in"><?php if(!empty($row[$k])&&!$_POST):?><img src="../uploads/<?=e($row[$k])?>" class="h-20 mt-1"><label class="font-normal"><input type="checkbox" name="del_<?=$k?>" value="1"> Hapus gambar</label><?php endif?>
<?php elseif(is_array($t)):?><select name="<?=$k?>" class="in"><?php foreach($t as $o):?><option <?=$v==$o?'selected':''?>><?=$o?></option><?php endforeach?></select>
<?php else:?><input type="<?=$t=='number'?'number':'text'?>" name="<?=$k?>" value="<?=e($v)?>" class="in"><?php endif?></label><?php endforeach?>
<button class="btn">Simpan</button></form>
<?php else:$rows=all("SELECT * FROM `$tbl` ORDER BY id DESC");$cols=array_slice(array_keys($F),0,3);?>
<div class="flex justify-between mb-4"><h1 class="text-2xl font-black"><?=$title?></h1><?php if($r!='messages'):?><a class="btn" href="?r=<?=$r?>&a=new">+ Tambah</a><?php endif?></div>
<div class="overflow-x-auto"><table class="w-full bg-white border"><tr class="bg-neutral-200 text-left"><?php foreach($cols as $c):?><th class="p-2"><?=$c?></th><?php endforeach?><th></th></tr>
<?php foreach($rows as $x):?><tr class="border-t"><?php foreach($cols as $c):?><td class="p-2"><?=e(mb_strimwidth((string)$x[$c],0,60,'…'))?></td><?php endforeach?><td class="p-2 flex gap-2"><a class="btn o" href="?r=<?=$r?>&a=edit&id=<?=$x['id']?>">Edit</a>
<form method="post" action="?r=<?=$r?>&a=del&id=<?=$x['id']?>" onsubmit="return confirm('Hapus data ini?')"><input type="hidden" name="_t" value="<?=csrf()?>"><button class="btn">Hapus</button></form></td></tr><?php endforeach; if(!$rows):?><tr><td class="p-3" colspan="4">Belum ada data.</td></tr><?php endif?></table></div><?php endif?></main></div></body></html>
