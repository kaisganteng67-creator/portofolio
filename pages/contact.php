<span class="script">Say hi</span><h2 class="text-4xl mb-6">Kontak</h2><div class="grid md:grid-cols-2 gap-5">
<div class="card"><h3>Hubungi</h3><p><a class="underline" href="mailto:<?=e($pf['email'])?>"><?=e($pf['email'])?></a></p><?php if(!empty($pf['phone'])):?><p><?=e($pf['phone'])?></p><?php endif?><p>
<?php foreach(['github'=>'GitHub','instagram'=>'Instagram','linkedin'=>'LinkedIn'] as $k=>$l) if($pf[$k]):?><a class="underline mr-2" target="_blank" rel="noopener" href="<?=e($pf[$k])?>"><?=$l?></a><?php endif?></p></div>
<form method="post" action="index.php?p=contact" class="card space-y-3"><input type="hidden" name="_t" value="<?=csrf()?>"><h3>Kesan &amp; Pesan</h3>
<?php if(isset($_GET['ok'])):?><p class="text-green-700 font-semibold">Terima kasih, pesanmu sudah terkirim.</p><?php endif?>
<input name="name" value="<?=e($old['name'])?>" placeholder="Nama" class="w-full border-2 p-2 bg-transparent">
<select name="category" class="w-full border-2 p-2 bg-transparent"><?php foreach(['Guru Pembimbing','Teman','Pengguna','Tempat PLK','Lainnya'] as $c):?><option <?=$old['category']==$c?'selected':''?>><?=$c?></option><?php endforeach?></select>
<textarea name="body" rows="4" placeholder="Kesan dan pesan" class="w-full border-2 p-2 bg-transparent"><?=e($old['body'])?></textarea>
<?php foreach($err as $m):?><p class="text-red-600 text-sm"><?=e($m)?></p><?php endforeach?><button class="btn btn-p">Kirim</button></form></div>
