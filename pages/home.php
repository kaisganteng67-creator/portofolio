<div class="grid md:grid-cols-[260px_1fr] gap-8 items-center"><img src="<?=img($pf['photo']??'')?>" class="w-full max-w-[260px] aspect-square object-cover border-2 border-neutral-900 rounded-2xl" width="260" height="260" fetchpriority="high" alt="Foto profil">
<div><p class="tracking-[.4em] text-neutral-500">× × × × ×</p><span class="script">Hello, I am</span><h1 class="text-4xl md:text-6xl"><?=e($pf['name']??'')?></h1>
<p class="font-semibold my-2"><?=e($pf['class_name']??'')?></p><p><?=e($pf['tagline']??'')?></p>
<p class="my-3"><?php foreach(explode(',',$pf['main_skills']??'') as $s):?><span class="border px-2 rounded-full text-sm mr-1"><?=e(trim($s))?></span><?php endforeach?></p>
<a class="btn btn-p" href="index.php?p=projects">Lihat Portfolio</a> <a class="btn" href="uploads/cv.pdf" download="CV-Muhammad-Qais-Al-Asyari.pdf">Unduh CV</a></div></div>
