document.documentElement.classList.add('motion-enabled');

document.getElementById('year').textContent = new Date().getFullYear();

const header = document.querySelector('.site-header');
const menuButton = document.querySelector('.menu-button');
const hero = document.querySelector('.hero');
const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

menuButton.addEventListener('click', () => {
  const open = header.classList.toggle('menu-open');
  menuButton.setAttribute('aria-expanded', String(open));
  menuButton.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
});

document.querySelectorAll('.nav a').forEach(link => {
  link.addEventListener('click', () => {
    header.classList.remove('menu-open');
    menuButton.setAttribute('aria-expanded', 'false');
    menuButton.setAttribute('aria-label', 'Open menu');
  });
});

const heroMotionTargets = [
  '.hero-identity .role',
  '.hero-identity h1',
  '.hero-profile .hero-lead',
  '.hero-profile .hero-disciplines',
  '.hero-profile .hero-actions',
  '.hero-profile .hero-meta'
];

heroMotionTargets.forEach(selector => {
  const element = document.querySelector(selector);
  if (element) element.classList.add('motion-hero');
});

const revealGroups = [
  ['.section-title-row', 0],
  ['.case-featured', 1],
  ['.case-pair .case:nth-child(1)', 1],
  ['.case-pair .case:nth-child(2)', 2],
  ['.experience-intro', 0],
  ['.experience-item:nth-child(1)', 0],
  ['.experience-item:nth-child(2)', 1],
  ['.experience-item:nth-child(3)', 2],
  ['.capability-head', 0],
  ['.capability-row:nth-child(1)', 0],
  ['.capability-row:nth-child(2)', 1],
  ['.capability-row:nth-child(3)', 2],
  ['.capability-row:nth-child(4)', 3],
  ['.capability-row:nth-child(5)', 4],
  ['.contact-layout > div:nth-child(1)', 0],
  ['.contact-layout > div:nth-child(2)', 1]
];

revealGroups.forEach(([selector, delay]) => {
  document.querySelectorAll(selector).forEach(element => {
    element.classList.add('motion-reveal');
    if (delay) element.dataset.motionDelay = String(delay);
  });
});

if (reduceMotion) {
  hero?.classList.add('is-entered');
  document.querySelectorAll('.motion-reveal').forEach(element => {
    element.classList.add('is-visible');
  });
} else {
  requestAnimationFrame(() => {
    requestAnimationFrame(() => hero?.classList.add('is-entered'));
  });

  const revealObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const element = entry.target;

      if (!element.dataset.motionPlayed && typeof element.animate === 'function') {
        const delay = Number(element.dataset.motionDelay || 0) * 70;
        element.animate(
          [
            { opacity: 0, transform: 'translateY(26px)' },
            { opacity: 1, transform: 'translateY(0)' }
          ],
          {
            duration: 560,
            delay,
            easing: 'cubic-bezier(.22,1,.36,1)',
            fill: 'both'
          }
        );
        element.dataset.motionPlayed = '1';
      }

      element.classList.add('is-visible');
      revealObserver.unobserve(element);
    });
  }, {
    threshold: 0.14,
    rootMargin: '0px 0px -8% 0px'
  });

  document.querySelectorAll('.motion-reveal').forEach(element => {
    revealObserver.observe(element);
  });

  const revealVisibleNow = () => {
    const limit = window.innerHeight * 0.98;
    document.querySelectorAll('.motion-reveal:not(.is-visible)').forEach(element => {
      const rect = element.getBoundingClientRect();
      if (rect.top < limit && rect.bottom > 0) {
        if (!element.dataset.motionPlayed && typeof element.animate === 'function') {
          const delay = Number(element.dataset.motionDelay || 0) * 70;
          element.animate(
            [
              { opacity: 0, transform: 'translateY(26px)' },
              { opacity: 1, transform: 'translateY(0)' }
            ],
            {
              duration: 560,
              delay,
              easing: 'cubic-bezier(.22,1,.36,1)',
              fill: 'both'
            }
          );
          element.dataset.motionPlayed = '1';
        }
        element.classList.add('is-visible');
        revealObserver.unobserve(element);
      }
    });
  };

  requestAnimationFrame(revealVisibleNow);
  setTimeout(revealVisibleNow, 120);
  window.addEventListener('hashchange', () => setTimeout(revealVisibleNow, 80));
}

const updateHeaderState = () => {
  document.body.classList.toggle('is-scrolled', window.scrollY > 18);
};

updateHeaderState();
window.addEventListener('scroll', updateHeaderState, { passive: true });

const sectionLinks = new Map();
document.querySelectorAll('.nav a[href^="#"]').forEach(link => {
  const target = document.querySelector(link.getAttribute('href'));
  if (target) sectionLinks.set(target, link);
});

if (sectionLinks.size) {
  const navObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      sectionLinks.forEach(link => link.classList.remove('is-active'));
      const activeLink = sectionLinks.get(entry.target);
      if (activeLink) activeLink.classList.add('is-active');
    });
  }, {
    rootMargin: '-28% 0px -60% 0px',
    threshold: 0
  });

  sectionLinks.forEach((link, section) => navObserver.observe(section));
}
