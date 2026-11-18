<span class="script">Kind words</span><h2 class="text-4xl mb-6">Testimoni</h2>
<?php $g=group(all('SELECT name,role,content FROM testimonials ORDER BY id'),'role');foreach(['guru'=>'Guru Pembimbing','teman'=>'Teman','pengguna'=>'Pengguna','plk'=>'Tempat PLK'] as $k=>$l):if(empty($g[$k]))continue;?>
<h3 class="mt-4 mb-2 text-base"><?=$l?></h3><div class="grid md:grid-cols-2 gap-4"><?php foreach($g[$k] as $t):?><div class="card">“<?=e($t['content'])?>”<p class="font-semibold mt-2">— <?=e($t['name'])?></p></div><?php endforeach?></div><?php endforeach?>
