/* FORMA Atelier: accessible image carousels and gentle scroll reveals. */
(() => {
  'use strict';
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)');
  const carousels = document.querySelectorAll('.atelier-image-carousel');
  carousels.forEach(gallery => {
    const images = [...gallery.querySelectorAll('.atelier-image-slide')];
    if(images.length < 2) return;

    let index = Math.max(0, images.findIndex(img => img.classList.contains('is-active')));
    let interval = null;
    let isVisible = true;
    let isHovering = false;
    let focusInside = false;
    const wrapper = gallery.closest('.atelier-hero, .atelier-editorial__photo');
    const counter = wrapper?.querySelector('.atelier-image-count, .atelier-image-position');
    const dots = wrapper ? [...wrapper.querySelectorAll('[data-slide-to]')] : [];
    const duration = Math.max(3800, Number(gallery.dataset.interval)||5000);

    const update = n => {
      index = (n + images.length) % images.length;
      images.forEach((img,i)=>{
        img.classList.toggle('is-active',i===index);
        img.setAttribute('aria-hidden',i===index?'false':'true');
      });
      if(counter) counter.textContent = String(index+1).padStart(2,'0')+' / '+String(images.length).padStart(2,'0');
      dots.forEach((dot,i)=>{
        const selected = i===index;
        dot.classList.toggle('is-active',selected);
        dot.setAttribute('aria-pressed',String(selected));
      });
    };

    const stop = () => {
      if(interval !== null){window.clearInterval(interval);interval=null;}
    };
    const start = () => {
      stop();
      if(reduced.matches || !isVisible || document.hidden || isHovering || focusInside) return;
      interval = window.setInterval(()=>update(index+1),duration);
    };

    dots.forEach(dot=>{
      dot.addEventListener('click',()=>{
        const n=Number(dot.dataset.slideTo);
        if(!Number.isInteger(n)||n<0||n>=images.length)return;
        update(n);
        start();
      });
    });
    wrapper?.querySelectorAll('[data-slide]').forEach(btn=>{
      btn.addEventListener('click',()=>{
        const direction = btn.dataset.slide === 'prev' ? -1 : 1;
        update(index+direction);
        start();
      });
    });
    wrapper?.addEventListener('pointerenter',()=>{isHovering=true;stop()});
    wrapper?.addEventListener('pointerleave',()=>{isHovering=false;start()});
    wrapper?.addEventListener('focusin',()=>{focusInside=true;stop()});
    wrapper?.addEventListener('focusout',e=>{
      if(e.relatedTarget && wrapper.contains(e.relatedTarget)) return;
      focusInside=false;start();
    });
    document.addEventListener('visibilitychange',start);
    if (typeof IntersectionObserver === 'function') {
      const view = new IntersectionObserver(entries=>{
        for(const entry of entries){
          isVisible=entry.isIntersecting;
          start();
        }
      },{threshold:.12});
      view.observe(wrapper || gallery);
    }
    if(reduced.addEventListener) reduced.addEventListener('change',start);
    update(index);
    start();
  });

  if(!reduced.matches && typeof IntersectionObserver === 'function'){
    const targets = document.querySelectorAll(
      '.atelier-home .atelier-section-head, .atelier-home .atelier-editorial__text, '+
      '.atelier-home .atelier-campaign__content, .atelier-home .atelier-category-card, '+
      '.atelier-home .atelier-demo-benefits__row > div, .atelier-home .atelier-newsletter__inner'
    );
    // Avoid hiding content before this observer is installed.
    const observer = new IntersectionObserver(entries=>{
      entries.forEach(entry=>{
        if(!entry.isIntersecting)return;
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      });
    },{threshold:.07,rootMargin:'0px 0px -24px 0px'});
    targets.forEach(target=>{target.classList.add('atelier-reveal');observer.observe(target)});
    document.body.classList.add('atelier-motion-ready');
  }
})();
