<?php $s=trim($_GET['q']??'');$t=trim($_GET['tech']??'');
$rows=all('SELECT id,name,description,tech,image FROM projects WHERE name LIKE ? AND (?="" OR tech LIKE ? OR category LIKE ?) ORDER BY id DESC',["%$s%",$t,"%$t%","%$t%"]);
$opts=[];foreach(all("SELECT tech FROM projects WHERE tech<>''") as $r)foreach(explode(',',$r['tech']) as $o)if(trim($o))$opts[trim($o)]=1;?>
<span class="script">Selected</span><h2 class="text-4xl mb-4">Proyek</h2>
<form id="f" class="card mb-5 grid md:grid-cols-2 gap-3"><input type="hidden" name="p" value="projects"><input name="q" value="<?=e($s)?>" placeholder="Cari proyek…" class="border-2 p-2 bg-transparent">
<select name="tech" onchange="f.submit()" class="border-2 p-2 bg-transparent"><option value="">Semua teknologi/kategori</option><?php foreach(array_keys($opts) as $o):?><option <?=$o==$t?'selected':''?>><?=e($o)?></option><?php endforeach?></select></form>
<script>let tm;f.q.oninput=()=>{clearTimeout(tm);tm=setTimeout(()=>f.submit(),400)};if(f.q.value){f.q.focus();f.q.setSelectionRange(99,99)}</script>
<div class="grid md:grid-cols-3 gap-5"><?php foreach($rows as $r):?><a href="index.php?p=project&id=<?=(int)$r['id']?>" class="card block"><img src="<?=img($r['image'])?>" class="w-full aspect-video object-cover mb-2" loading="lazy" decoding="async" alt=""><h3 class="text-lg"><?=e($r['name'])?></h3><p class="text-sm"><?=e($r['description'])?></p><p class="text-xs mt-1"><?=e($r['tech'])?></p></a>
<?php endforeach; if(!$rows)echo '<p>Tidak ada proyek yang cocok.</p>';?></div>
