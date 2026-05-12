const btn=document.getElementById("menuBtn");
const nav=document.getElementById("navMenu");

function closeNav(){
	if(nav.classList.contains('show')){
		nav.classList.remove('show');
		document.body.style.overflow='';
		btn && btn.setAttribute('aria-expanded','false');
	}
}

function openNav(){
	nav.classList.add('show');
	document.body.style.overflow='hidden';
	btn && btn.setAttribute('aria-expanded','true');
}

if(btn){
	btn.onclick = (e)=>{
		e.stopPropagation();
		if(nav.classList.contains('show')) closeNav(); else openNav();
	};
}

// Close nav when clicking outside or pressing Escape
document.addEventListener('click', (e)=>{
	if(!nav) return;
	if(nav.classList.contains('show')){
		if(!nav.contains(e.target) && e.target !== btn){ closeNav(); }
	}
});
document.addEventListener('keydown', (e)=>{ if(e.key==='Escape') closeNav(); });

document.querySelectorAll("table").forEach(t=>{
let d=document.createElement("div");
d.style.overflowX="auto";
t.parentNode.insertBefore(d,t);
d.appendChild(t);
});

document.body.style.opacity=0;
window.onload=()=>{
	// fade in
	document.body.style.transition="0.45s cubic-bezier(.2,.9,.3,1)";
	document.body.style.opacity=1;
	// animate stat counters
	document.querySelectorAll('.stat-card h3').forEach(el=>{
		const target = parseInt(el.dataset.target||el.textContent)||0;
		let cur = 0; const step = Math.max(1, Math.floor(target/50));
		const id = setInterval(()=>{
			cur += step; if(cur>=target) { el.textContent = target; clearInterval(id); } else el.textContent = cur;
		}, 12);
	});
};

// mark active menu link based on current pathname
(() => {
	const path = window.location.pathname.split('/').pop();
	if(!path) return;
	document.querySelectorAll('.main-menu a, .dropdown-content a').forEach(a=>{
		try{
			const href = a.getAttribute('href') || '';
			if(href.split('/').pop() === path) a.classList.add('active');
		}catch(e){}
	});
})();

// simple carousel auto-rotate
(function(){
	const carousel = document.getElementById('carousel');
	if(!carousel) return;
	const items = Array.from(carousel.querySelectorAll('.carousel-item'));
	if(items.length===0) return;
	let idx = 0;
	items.forEach((it,i)=>{ if(i===0) it.classList.add('active'); });
	setInterval(()=>{
		items[idx].classList.remove('active');
		idx = (idx+1) % items.length;
		items[idx].classList.add('active');
	}, 4000);
})();
