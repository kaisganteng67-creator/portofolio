<span class="script">Software</span><h2 class="text-4xl mb-6">Keahlian</h2><div class="grid md:grid-cols-2 gap-5">
<?php $g=group(all('SELECT name,type,percent FROM skills ORDER BY id'),'type');foreach(['hard'=>'Hard Skill','soft'=>'Soft Skill'] as $t=>$l):?><div class="card"><h3 class="mb-3"><?=$l?></h3>
<?php foreach($g[$t]??[] as $s):?><div class="flex justify-between text-sm font-semibold"><span><?=e($s['name'])?></span><span><?=(int)$s['percent']?>%</span></div><div class="bar"><i data-w="<?=(int)$s['percent']?>"></i></div><?php endforeach?></div><?php endforeach?></div>
