/**
 * js/scroll.js
 * Scroll Reveal genérico: qualquer elemento com [data-animate]
 * recebe a classe .in-view assim que entra na viewport, e leve
 * efeito parallax para elementos com [data-parallax].
 */

document.addEventListener('DOMContentLoaded', () => {
  const alvos = document.querySelectorAll('[data-animate]');

  if (alvos.length) {
    const observer = new IntersectionObserver((entradas) => {
      entradas.forEach((entrada) => {
        if (entrada.isIntersecting) {
          entrada.target.classList.add('in-view');
          observer.unobserve(entrada.target);
        }
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });

    alvos.forEach((el) => observer.observe(el));
  }

  // Parallax leve baseado na posição do scroll
  const parallaxEls = document.querySelectorAll('[data-parallax]');
  if (parallaxEls.length) {
    window.addEventListener('scroll', () => {
      const scrollY = window.scrollY;
      parallaxEls.forEach((el) => {
        const velocidade = parseFloat(el.dataset.parallax) || 0.2;
        el.style.transform = `translateY(${scrollY * velocidade}px)`;
      });
    }, { passive: true });
  }
});
