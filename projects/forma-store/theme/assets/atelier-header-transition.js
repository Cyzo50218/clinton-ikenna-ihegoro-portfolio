/* Homepage header: transparent over campaign, opaque once the visitor scrolls.
 * Keeps the search overlay and mobile menu readable at the page top.
 */
(() => {
 'use strict';
 const header=document.querySelector('body.home .atelier-header');
 if(!header) return;
 const search=document.getElementById('forma-mobile-search');
 const nav=document.getElementById('primary-navigation');
 const navButton=document.getElementById('nav-toggle');
 const searchButton=document.querySelector('.forma-search-open');
 let frame=0;
 const sync=()=>{
   frame=0;
   const menuOpen=nav?.classList.contains('is-open')||navButton?.getAttribute('aria-expanded')==='true';
   const searchOpen=search ? !search.hidden : searchButton?.getAttribute('aria-expanded')==='true';
   // Change to white as the hero ends, just before Shop Best Sellers.
   const hero=document.querySelector('.atelier-hero');
   const reachedProducts=hero ? hero.getBoundingClientRect().bottom<=header.getBoundingClientRect().bottom+30 : window.scrollY>45;
   const needsSolid=reachedProducts||menuOpen||searchOpen;
   header.classList.toggle('is-solid',Boolean(needsSolid));
 };
 const requestSync=()=>{
   if(frame)return;
   frame=window.requestAnimationFrame(sync);
 };
 window.addEventListener('scroll',requestSync,{passive:true});
 window.addEventListener('resize',requestSync,{passive:true});
 window.addEventListener('pageshow',requestSync);
 [navButton,searchButton,document.querySelector('.atelier-search-close')].forEach(control=>{
   control?.addEventListener('click',requestSync);
 });
 nav?.addEventListener('click',requestSync);
 document.addEventListener('keydown',event=>{
   if(event.key==='Escape')requestSync();
 });
 /* Draw correctly at load and on back/forward restored scroll positions. */
 sync();
})();
