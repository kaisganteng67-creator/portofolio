<?php $edu=all('SELECT * FROM educations ORDER BY id DESC');$ex=group(all("SELECT title,type,place,period FROM experiences WHERE type IN('plk','organisasi')"),'type');$by=fn($t)=>$ex[$t]??[];?>
<span class="script">Get to know</span><h2 class="text-4xl mb-6">Tentang Saya</h2><div class="grid md:grid-cols-2 gap-5">
<div class="card"><h3>Biodata</h3><p><?=e($pf['name'])?><br><?=e($pf['birth_info'])?><br><?=e($pf['address'])?></p></div>
<div class="card"><h3>Pendidikan</h3><?php foreach($edu as $r):?><p><b><?=e($r['school'])?></b> (<?=e($r['period'])?>)<br><?=e($r['description'])?></p><?php endforeach?></div>
<div class="card"><h3>Minat &amp; Teknologi</h3><p><?=e($pf['interests'])?></p></div>
<div class="card"><h3>Organisasi</h3><?php foreach($by('organisasi') as $r):?><p><b><?=e($r['title'])?></b> — <?=e($r['place'])?> <?=e($r['period'])?></p><?php endforeach?></div>
<div class="card"><h3>Pengalaman PLK</h3><?php foreach($by('plk') as $r):?><p><b><?=e($r['title'])?></b> — <?=e($r['place'])?> <?=e($r['period'])?></p><?php endforeach?></div>
<div class="card"><h3>Cita-cita</h3><p><?=e($pf['goal'])?></p></div></div>
