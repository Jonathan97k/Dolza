(function() {
  'use strict';

  function initCommon() {
    initHamburger();
    initStickyNav();
    initBackToTop();
    initPWA();
    initActiveNav();
    initLogo();
    initScrollReveal();
  }

  function initHamburger() {
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    if (!hamburger || !navLinks) return;

    hamburger.addEventListener('click', function() {
      navLinks.classList.toggle('open');
      this.classList.toggle('open');
    });

    navLinks.querySelectorAll('a').forEach(function(link) {
      link.addEventListener('click', function() {
        navLinks.classList.remove('open');
        hamburger.classList.remove('open');
      });
    });
  }

  function initStickyNav() {
    const navbar = document.querySelector('.navbar');
    if (!navbar) return;

    window.addEventListener('scroll', function() {
      navbar.classList.toggle('scrolled', window.scrollY > 100);
    }, { passive: true });
  }

  function initBackToTop() {
    const backToTop = document.querySelector('.back-to-top');
    if (!backToTop) return;

    window.addEventListener('scroll', function() {
      backToTop.classList.toggle('visible', window.scrollY > 300);
    }, { passive: true });

    backToTop.addEventListener('click', function() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  function initPWA() {
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('/sw.js');
    }
  }

  function initActiveNav() {
    const current = window.location.pathname.split('/').pop() || 'index.html';
    document.querySelectorAll('.nav-links a').forEach(function(link) {
      var href = link.getAttribute('href');
      if (href === current || (current === 'index.html' && href === '#')) {
        link.classList.add('active');
      }
    });
  }

  function initLogo() {
    fetch('/api/settings').then(function(r) { return r.json(); }).then(function(s) {
      if (!s) return;
      if (s.logo) {
        var imgs = document.querySelectorAll('.logo img, .footer-logo img');
        for (var i = 0; i < imgs.length; i++) {
          imgs[i].src = s.logo;
        }
        var fav = document.querySelector('link[rel="icon"]');
        if (fav) fav.href = s.logo;
      }
    }).catch(function() {});
  }

  function initScrollReveal() {
    var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(function(el) {
      observer.observe(el);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCommon);
  } else {
    initCommon();
  }
})();
