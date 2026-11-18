<?php $r=one('SELECT * FROM projects WHERE id=?',[(int)($_GET['id']??0)]);if(!$r){echo '<p>Proyek tidak ditemukan. <a class="underline" href="index.php?p=projects">Kembali</a></p>';return;}?>
<a href="index.php?p=projects" class="underline text-sm">← Semua proyek</a><h2 class="text-4xl my-3"><?=e($r['name'])?></h2>
<?php if($r['image']):?><img src="<?=img($r['image'])?>" class="w-full max-h-96 object-cover border-2 mb-4" decoding="async" alt=""><?php endif;
foreach(['description'=>'Deskripsi','problem'=>'Permasalahan','goal'=>'Tujuan','tech'=>'Teknologi','role'=>'Peran','features'=>'Fitur','documentation'=>'Dokumentasi proses','detail'=>'Detail','feedback'=>'Feedback user'] as $k=>$l) if($r[$k]):?>
<div class="card mb-3"><h3 class="text-sm"><?=$l?></h3><p class="whitespace-pre-line"><?=e($r[$k])?></p></div><?php endif?>
<p><?php if($r['demo_url']):?><a class="btn btn-p" target="_blank" rel="noopener" href="<?=e($r['demo_url'])?>">Demo</a> <?php endif; if($r['github_url']):?><a class="btn" target="_blank" rel="noopener" href="<?=e($r['github_url'])?>">Source Code</a><?php endif?></p>
