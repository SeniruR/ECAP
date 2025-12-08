/* Admin actions helper: modal confirm and toast notifications */
(function(window){
  'use strict';

  function createModal(){
    const modal = document.createElement('div');
    modal.id = 'admin-confirm-modal';
    modal.innerHTML = `
      <div class="adm-modal-backdrop" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="adm-modal">
          <div class="adm-modal-body"></div>
          <div class="adm-modal-actions">
            <button type="button" class="adm-btn adm-cancel">Cancel</button>
            <button type="button" class="adm-btn adm-confirm">OK</button>
          </div>
        </div>
      </div>
    `;
    document.body.appendChild(modal);
    return modal;
  }

  function getModal(){
    return document.getElementById('admin-confirm-modal') || createModal();
  }

  function showConfirm(message){
    return new Promise(function(resolve){
      const modal = getModal();
      const backdrop = modal.querySelector('.adm-modal-backdrop');
      const body = modal.querySelector('.adm-modal-body');
      const btnConfirm = modal.querySelector('.adm-confirm');
      const btnCancel = modal.querySelector('.adm-cancel');

      body.textContent = message || 'Are you sure?';
      backdrop.setAttribute('aria-hidden','false');
      backdrop.classList.add('open');

      function cleanup(){
        backdrop.classList.remove('open');
        backdrop.setAttribute('aria-hidden','true');
        btnConfirm.removeEventListener('click',onConfirm);
        btnCancel.removeEventListener('click',onCancel);
      }

      function onConfirm(){ cleanup(); resolve(true); }
      function onCancel(){ cleanup(); resolve(false); }

      btnConfirm.addEventListener('click', onConfirm);
      btnCancel.addEventListener('click', onCancel);
    });
  }

  function toast(message, timeout){
    timeout = timeout || 3000;
    let container = document.getElementById('adm-toast-container');
    if(!container){
      container = document.createElement('div');
      container.id = 'adm-toast-container';
      document.body.appendChild(container);
    }
    const el = document.createElement('div');
    el.className = 'adm-toast';
    el.textContent = message;
    container.appendChild(el);
    setTimeout(()=>{ el.classList.add('visible'); }, 20);
    setTimeout(()=>{ el.classList.remove('visible'); setTimeout(()=>el.remove(),300); }, timeout);
  }

  // handle elements with .js-submit and data-confirm attributes (forms submission)
  function initAutoSubmit(){
    document.addEventListener('click', async function(e){
      const el = e.target.closest && e.target.closest('.js-submit');
      if(!el) return;
      e.preventDefault();
      const msg = el.dataset.confirm || 'Proceed?';
      const ok = await showConfirm(msg);
      if(!ok) return;
      const form = el.closest('form');
      if(form) form.submit();
    });
  }

  // handle image-delete buttons (data-url)
  function initImageDelete(){
    document.addEventListener('click', async function(e){
      const btn = e.target.closest && e.target.closest('.image-delete');
      if(!btn) return;
      e.preventDefault();
      const url = btn.dataset.url;
      if(!url) return;
      const ok = await showConfirm('Delete this image?');
      if(!ok) return;
      try{
        const body = new URLSearchParams();
        body.append('_method','DELETE');
        body.append('_token', window.Laravel && window.Laravel.csrfToken ? window.Laravel.csrfToken : document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');
        const resp = await fetch(url, { method: 'POST', headers: { 'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8' }, body: body.toString(), credentials: 'same-origin' });
        if(!resp.ok){
          toast('Remove failed (status '+resp.status+')');
          console.error('Image delete failed', resp.status, await resp.text());
          return;
        }
        // remove preview node
        const wrapper = btn.closest('div[style]') || btn.parentElement;
        if(wrapper) wrapper.remove();
        toast('Image removed');
      }catch(err){
        console.error(err);
        toast('Error removing image');
      }
    });
  }

  function init(){
    initAutoSubmit();
    initImageDelete();
  }

  // expose to window
  window.AdminActions = {
    init, showConfirm, toast
  };

  // auto init on DOMContentLoaded
  if(document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init); else init();

})(window);
