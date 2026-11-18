<!DOCTYPE html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Portfolio <?=e($pf['name']??'')?></title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Allura&family=Inter:wght@400;600&display=swap" rel="stylesheet">
<script>if(localStorage.th=='dark')document.documentElement.classList.add('dark')</script>
<script src="https://cdn.tailwindcss.com"></script><script>tailwind.config={darkMode:'class'}</script>
<style type="text/tailwindcss">
body{@apply bg-[#d8d6d0] dark:bg-[#0f0e0b] text-neutral-900 dark:text-[#f1ebdc] font-['Inter'];}
h1,h2,h3{@apply font-['Archivo_Black'] uppercase leading-tight;}
.paper{@apply bg-[#f1ebdc] dark:bg-[#171612] shadow-xl max-w-5xl mx-auto my-6 p-6 md:p-10;animation:fi .5s ease}
.card{@apply bg-[#faf6ea] dark:bg-[#222019] border-2 border-neutral-900 dark:border-[#f1ebdc] p-4 shadow-[4px_4px_0_#141414] dark:shadow-[4px_4px_0_#f1ebdc];}
.btn{@apply inline-block border-2 border-neutral-900 dark:border-[#f1ebdc] px-4 py-2 text-sm font-semibold hover:bg-[#a3365f] hover:text-white hover:border-[#a3365f];}
.btn-p{@apply bg-neutral-900 text-[#f1ebdc] dark:bg-[#f1ebdc] dark:text-neutral-900;}
.script{font-family:Allura,cursive;@apply text-3xl text-[#a3365f] dark:text-[#e07aa0] block -mb-2;}
.bar{@apply h-3 border-2 border-neutral-900 dark:border-[#f1ebdc] rounded mb-3;}.bar i{@apply block h-full bg-[#a3365f] w-0;transition:width 1.2s}
@keyframes fi{from{opacity:0;transform:translateY(14px)}to{opacity:1}}
@media print{.noprint{display:none!important}body{background:#fff}.paper{box-shadow:none;margin:0}}
</style></head><body>
<header class="noprint sticky top-0 z-20 bg-[#f1ebdc]/95 dark:bg-[#171612]/95 border-b-2 border-neutral-900 dark:border-[#f1ebdc]"><div class="max-w-5xl mx-auto flex flex-wrap items-center gap-2 p-3">
<a href="index.php" class="font-['Archivo_Black'] mr-auto">PORTFOLIO ×</a>
<?php foreach(['home'=>'Beranda','about'=>'Tentang','skills'=>'Keahlian','projects'=>'Proyek','certificates'=>'Prestasi','experience'=>'Pengalaman','testimonials'=>'Testimoni','blog'=>'Blog','contact'=>'Kontak'] as $k=>$l):?>
<a href="index.php?p=<?=$k?>" class="text-sm px-2 py-1 <?=$p==$k?'bg-neutral-900 text-[#f1ebdc] dark:bg-[#f1ebdc] dark:text-neutral-900':'hover:underline'?>"><?=$l?></a><?php endforeach?>
<a href="admin/" class="btn btn-p !py-1">Login Admin</a>
<button id="th" class="btn !py-1" aria-label="Ganti tema">◐</button></div></header>
<main class="paper">
