// Lightweight lazy loader: handles elements using data-src/data-bg and provides fallbacks.
(function(){
  'use strict';

  function applySrc(el){
    if(!el) return;
    const src = el.getAttribute('data-src');
    if(src){ el.src = src; el.removeAttribute('data-src'); }
    const srcset = el.getAttribute('data-srcset');
    if(srcset){ el.setAttribute('srcset', srcset); el.removeAttribute('data-srcset'); }
    const bg = el.getAttribute('data-bg');
    if(bg){ el.style.backgroundImage = 'url("'+bg+'")'; el.removeAttribute('data-bg'); }
    if(el.tagName === 'IFRAME'){
      const d = el.getAttribute('data-src');
      if(d) { el.src = d; el.removeAttribute('data-src'); }
    }
  }

  function init(){
    try{
      const obsSupported = 'IntersectionObserver' in window;

      // If images use data-src, observe them; otherwise native loading="lazy" will handle most browsers.
      const lazyEls = Array.from(document.querySelectorAll('img[data-src], iframe[data-src], [data-bg]'));
      if(lazyEls.length === 0) return;

      if(!obsSupported){
        // Fallback: just load all
        lazyEls.forEach(applySrc);
        return;
      }

      const io = new IntersectionObserver((entries, observer)=>{
        entries.forEach(entry=>{
          if(entry.isIntersecting){
            const el = entry.target;
            applySrc(el);
            observer.unobserve(el);
          }
        });
      }, { rootMargin: '200px 0px' });

      lazyEls.forEach(el=> io.observe(el));
    }catch(e){ console.error('lazyload init error', e); }
  }

  if(document.readyState === 'complete' || document.readyState === 'interactive'){
    setTimeout(init, 120);
  } else {
    window.addEventListener('DOMContentLoaded', init);
  }
})();
