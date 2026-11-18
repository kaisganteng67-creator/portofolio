</main>
<footer class="noprint text-center text-sm py-6">© <?=date('Y')?> <?=e($pf['name']??'')?> · <a class="underline" href="admin/">Admin</a></footer>
<button id="top" class="btn btn-p noprint fixed right-4 bottom-4 hidden">↑</button>
<script>
document.getElementById('th').onclick=()=>{document.documentElement.classList.toggle('dark');localStorage.th=document.documentElement.classList.contains('dark')?'dark':'light'};
const tp=document.getElementById('top');tp.onclick=()=>scrollTo({top:0,behavior:'smooth'});onscroll=()=>tp.classList.toggle('hidden',scrollY<300);
addEventListener('load',()=>document.querySelectorAll('.bar i').forEach(i=>i.style.width=i.dataset.w+'%'));
</script></body></html>
