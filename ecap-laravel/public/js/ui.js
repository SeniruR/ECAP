// UI interactions: mobile sidebar toggle and loader hide
(function(){
  'use strict';

  function qs(sel, el=document){return el.querySelector(sel)}
  function qsa(sel, el=document){return Array.from(el.querySelectorAll(sel))}

  function openSidebar(){
    const aside = qs('.mobile-sidebar');
    if(!aside) return;
    aside.classList.add('open');
    aside.setAttribute('aria-hidden','false');
    const hb = qs('.hamburger'); if(hb) hb.setAttribute('aria-expanded','true');
  }

  function closeSidebar(){
    const aside = qs('.mobile-sidebar');
    if(!aside) return;
    aside.classList.remove('open');
    aside.setAttribute('aria-hidden','true');
    const hb = qs('.hamburger'); if(hb) hb.setAttribute('aria-expanded','false');
  }

  document.addEventListener('click', function(e){
    if(e.target.closest && e.target.closest('.hamburger')){ openSidebar(); }
    if(e.target.closest && e.target.closest('.mobile-close')){ closeSidebar(); }
    if(e.target.closest && e.target.closest('.mobile-sidebar a')){ closeSidebar(); }
  });

  // Close sidebar when clicking outside of it
  document.addEventListener('click', function(e){
    const aside = qs('.mobile-sidebar');
    if(!aside) return;
    if(!aside.classList.contains('open')) return;
    const inside = e.target.closest && (e.target.closest('.mobile-sidebar') || e.target.closest('.hamburger'));
    if(!inside){ closeSidebar(); }
  });

  // Close on Escape key
  document.addEventListener('keydown', function(e){
    if(e.key === 'Escape' || e.key === 'Esc'){
      const aside = qs('.mobile-sidebar');
      if(aside && aside.classList.contains('open')) closeSidebar();
    }
  });

  // hide loader when page has loaded
  function hideLoader(){
    try{
      const loader = document.getElementById('site-loader');
      if(!loader) return;
      loader.classList.add('hidden');
      loader.setAttribute('aria-hidden','true');
      // fully remove from flow after transition
      setTimeout(()=>{ try{ loader.style.display = 'none'; }catch(e){} }, 400);
    }catch(e){ console.error('hideLoader error', e); }
  }

  // Ensure loader is hidden on DOMContentLoaded or on window load, and provide a fallback
  if(document.readyState === 'complete' || document.readyState === 'interactive'){
    setTimeout(hideLoader,300);
  } else {
    window.addEventListener('DOMContentLoaded', function(){ setTimeout(hideLoader,200); });
  }
  window.addEventListener('load', function(){ setTimeout(hideLoader,100); });
  // Fallback: ensure loader doesn't get stuck longer than 7s
  setTimeout(function(){ hideLoader(); }, 7000);

  // expose for debugging
  window.SiteUI = { openSidebar, closeSidebar, hideLoader };

})();
