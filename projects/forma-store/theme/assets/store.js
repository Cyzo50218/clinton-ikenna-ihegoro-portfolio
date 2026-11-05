/* FORMA retail interactions: mobile menu, mobile search, product tabs, browser-only wishlist. */
(() => {
  'use strict';

  const menu = document.getElementById('primary-navigation');
  const menuButton = document.getElementById('nav-toggle');
  const mobileSearch = document.getElementById('forma-mobile-search');
  const mobileSearchButton = document.querySelector('.forma-search-open');

  if (menu && menuButton) {
    menuButton.addEventListener('click', () => {
      const open = menu.classList.toggle('is-open');
      menuButton.setAttribute('aria-expanded', String(open));
      menuButton.setAttribute('aria-label', open ? 'Close category menu' : 'Open category menu');
    });
    menu.addEventListener('click', (event) => {
      if (!event.target.closest('a')) return;
      menu.classList.remove('is-open');
      menuButton.setAttribute('aria-expanded', 'false');
    });
  }

  if (mobileSearch && mobileSearchButton) {
    mobileSearchButton.addEventListener('click', () => {
      const opened = mobileSearch.hidden;
      mobileSearch.hidden = !opened;
      mobileSearchButton.setAttribute('aria-expanded', String(opened));
      if (opened) mobileSearch.querySelector('input[type=search]')?.focus();
    });
  }

  const tabButtons = Array.from(document.querySelectorAll('.r-tab[role=tab]'));
  const activateTab = (button) => {
    for (const tab of tabButtons) {
      const active = tab === button;
      tab.classList.toggle('is-active', active);
      tab.setAttribute('aria-selected', String(active));
      tab.tabIndex = active ? 0 : -1;
      const panel = document.getElementById(tab.dataset.panel);
      if (panel) panel.hidden = !active;
    }
  };
  tabButtons.forEach((button, index) => {
    button.addEventListener('click', () => activateTab(button));
    button.addEventListener('keydown', event => {
      if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) return;
      event.preventDefault();
      let target = index;
      if (event.key === 'ArrowRight') target = (index + 1) % tabButtons.length;
      else if (event.key === 'ArrowLeft') target = (index - 1 + tabButtons.length) % tabButtons.length;
      else if (event.key === 'Home') target = 0;
      else if (event.key === 'End') target = tabButtons.length - 1;
      activateTab(tabButtons[target]);
      tabButtons[target].focus();
    });
  });

  const showBestSellers = () => {
    if (window.location.hash === '#best-sellers') {
      const tab = document.getElementById('r-tab-faves-trigger');
      if (tab) activateTab(tab);
    }
  };
  window.addEventListener('hashchange', showBestSellers);
  showBestSellers();

  // The compact desktop/mobile search is hidden until the icon is pressed.
  const closeSearch = document.querySelector('.atelier-search-close');
  if (closeSearch && mobileSearch && mobileSearchButton) {
    closeSearch.addEventListener('click', () => {
      mobileSearch.hidden = true;
      mobileSearchButton.setAttribute('aria-expanded','false');
      mobileSearchButton.focus();
    });
    document.addEventListener('keydown', event => {
      if (event.key === 'Escape' && !mobileSearch.hidden) {
        mobileSearch.hidden = true;
        mobileSearchButton.setAttribute('aria-expanded','false');
        mobileSearchButton.focus();
      }
    });
  }

  // Scrollable best-seller shelf: controls update both the shelf and counter.
  for (const track of document.querySelectorAll('.atelier-carousel-track')) {
    const cards = Array.from(track.querySelectorAll('.product-card'));
    const controls = track.closest('.atelier-best')?.querySelector('.atelier-carousel-controls');
    const counter = controls?.querySelector('.atelier-carousel-index');
    const progress = controls?.querySelector('.atelier-carousel-progress span');
    const update = () => {
      if (!cards.length) return;
      const left = track.getBoundingClientRect().left;
      const visible = cards.findIndex(card => card.getBoundingClientRect().right > left + 15);
      const index = Math.max(0, visible < 0 ? cards.length - 1 : visible);
      if (counter) counter.textContent = String(index+1).padStart(2,'0')+' / '+String(cards.length).padStart(2,'0');
      if (progress) progress.style.width = (Math.min(100,(index+1)/cards.length*100))+'%';
    };
    track.addEventListener('scroll', update, { passive:true });
    window.addEventListener('resize', update);
    for (const button of controls?.querySelectorAll('.atelier-carousel-button') || []) {
      button.addEventListener('click', () => {
        const card = cards[0];
        if (!card) return;
        const width = card.getBoundingClientRect().width+17;
        const dir = parseInt(button.dataset.direction || '1',10);
        track.scrollBy({left:dir*width*2,behavior:window.matchMedia('(prefers-reduced-motion: reduce)').matches?'auto':'smooth'});
      });
    }
    update();
  }

  const savedKey = 'forma-demo-wishlist-v1';
  const catalog = window.formaRetailData?.catalog || {};
  function readSaved() {
    try {
      const raw = JSON.parse(window.localStorage.getItem(savedKey) || '[]');
      if (!Array.isArray(raw)) return [];
      return raw.map(String).filter(id => Object.prototype.hasOwnProperty.call(catalog, id)).slice(0, 80);
    } catch (_) {
      return [];
    }
  }
  function storeSaved(items) {
    try { window.localStorage.setItem(savedKey, JSON.stringify(items)); return true; }
    catch (_) { return false; }
  }
  function updateSavedUI() {
    const items = readSaved();
    const values = new Set(items);
    for (const button of document.querySelectorAll('.forma-save-item[data-product-id]')) {
      const selected = values.has(String(button.dataset.productId));
      button.setAttribute('aria-pressed', String(selected));
      button.setAttribute('aria-label', selected ? 'Remove from saved products' : 'Save product for later');
      const label = button.querySelector('span');
      if (label) label.textContent = selected ? 'Saved — remove' : 'Save for later';
    }
    for (const count of document.querySelectorAll('.forma-wishlist-count')) {
      count.textContent = String(items.length);
      count.hidden = items.length === 0;
    }
    const grid = document.getElementById('forma-wishlist-grid');
    if (!grid) return;
    grid.replaceChildren();
    const empty = document.getElementById('forma-wishlist-empty');
    if (empty) empty.hidden = items.length !== 0;
    for (const id of items) {
      const product = catalog[id];
      if (!product) continue;
      const card = document.createElement('article');
      card.className = 'forma-wishlist-card';
      const imageLink = document.createElement('a');
      imageLink.href = product.url;
      if (product.image) {
        const img = document.createElement('img');
        img.src = product.image;
        img.loading = 'lazy';
        img.alt = product.name;
        imageLink.append(img);
      }
      const h3 = document.createElement('h3');
      const name = document.createElement('a');
      name.href = product.url;
      name.textContent = product.name;
      h3.append(name);
      const price = document.createElement('p');
      price.textContent = product.price;
      const buy = document.createElement('a');
      buy.className = 'forma-wishlist-action';
      buy.href = product.addUrl;
      buy.textContent = product.variable ? 'Choose options →' : product.inStock ? 'Add to cart →' : 'View item →';
      const remove = document.createElement('button');
      remove.type = 'button';
      remove.className = 'forma-save-item';
      remove.dataset.productId = id;
      remove.setAttribute('aria-label', 'Remove from saved products');
      remove.setAttribute('aria-pressed', 'true');
      remove.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M20.3 5.8a4.9 4.9 0 0 0-6.9 0L12 7.2l-1.4-1.4a4.9 4.9 0 0 0-6.9 6.9L12 21l8.3-8.3a4.9 4.9 0 0 0 0-6.9Z"/></svg>';
      card.append(imageLink, h3, price, buy, remove);
      grid.append(card);
    }
  }
  document.addEventListener('click', event => {
    const button = event.target.closest('.forma-save-item[data-product-id]');
    if (!button) return;
    event.preventDefault();
    const id = String(button.dataset.productId);
    if (!Object.prototype.hasOwnProperty.call(catalog, id)) return;
    const saved = readSaved();
    const next = saved.includes(id) ? saved.filter(value => value !== id) : [...saved, id];
    if (!storeSaved(next)) return;
    updateSavedUI();
  });
  window.addEventListener('storage', event => {
    if (event.key === savedKey) updateSavedUI();
  });
  updateSavedUI();
})();
