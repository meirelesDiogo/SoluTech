/**
 * js/main.js
 * Comportamentos globais do site: loader, navbar, menu mobile,
 * ripple nos botões, toasts, contadores animados e partículas do hero.
 */

document.addEventListener('DOMContentLoaded', () => {
  esconderLoader();
  ativarNavbarScroll();
  ativarMenuMobile();
  ativarRipple();
  ativarContadores();
  iniciarParticulas();
  ativarTextoDigitando();
});

/* ---------- Loader inicial ---------- */
function esconderLoader() {
  const loader = document.getElementById('loader');
  if (!loader) return;
  window.addEventListener('load', () => {
    setTimeout(() => loader.classList.add('hide'), 400);
  });
}

/* ---------- Navbar muda ao rolar ---------- */
function ativarNavbarScroll() {
  const navbar = document.querySelector('.navbar');
  if (!navbar) return;
  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 30);
  });
}

/* ---------- Menu mobile ---------- */
function ativarMenuMobile() {
  const toggle = document.querySelector('.nav-toggle');
  const links = document.querySelector('.nav-links');
  if (!toggle || !links) return;
  toggle.addEventListener('click', () => links.classList.toggle('open'));
}

/* ---------- Efeito Ripple nos botões ---------- */
function ativarRipple() {
  document.querySelectorAll('.btn').forEach((btn) => {
    btn.addEventListener('click', function (e) {
      const circle = document.createElement('span');
      const diametro = Math.max(this.clientWidth, this.clientHeight);
      const raio = diametro / 2;
      const rect = this.getBoundingClientRect();

      circle.style.width = circle.style.height = `${diametro}px`;
      circle.style.left = `${e.clientX - rect.left - raio}px`;
      circle.style.top = `${e.clientY - rect.top - raio}px`;
      circle.classList.add('ripple');

      const antigo = this.querySelector('.ripple');
      if (antigo) antigo.remove();

      this.appendChild(circle);
      setTimeout(() => circle.remove(), 600);
    });
  });
}

/* ---------- Contadores animados (seção Sobre / Home) ---------- */
function ativarContadores() {
  const contadores = document.querySelectorAll('[data-count]');
  if (!contadores.length) return;

  const observer = new IntersectionObserver((entradas) => {
    entradas.forEach((entrada) => {
      if (entrada.isIntersecting) {
        animarContador(entrada.target);
        observer.unobserve(entrada.target);
      }
    });
  }, { threshold: 0.4 });

  contadores.forEach((el) => observer.observe(el));
}

function animarContador(el) {
  const alvo = parseInt(el.dataset.count, 10);
  const duracao = 1600;
  const inicio = performance.now();

  function passo(agora) {
    const progresso = Math.min((agora - inicio) / duracao, 1);
    const valor = Math.floor(progresso * alvo);
    el.textContent = valor.toLocaleString('pt-BR');
    if (progresso < 1) requestAnimationFrame(passo);
    else el.textContent = alvo.toLocaleString('pt-BR');
  }
  requestAnimationFrame(passo);
}

/* ---------- Partículas simples no Hero (canvas leve, sem libs externas) ---------- */
function iniciarParticulas() {
  const canvas = document.getElementById('particles-bg');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  let largura, altura, particulas;

  function redimensionar() {
    largura = canvas.width = canvas.offsetWidth;
    altura = canvas.height = canvas.offsetHeight;
  }

  function criarParticulas() {
    particulas = Array.from({ length: 60 }, () => ({
      x: Math.random() * largura,
      y: Math.random() * altura,
      r: Math.random() * 1.8 + 0.4,
      vx: (Math.random() - 0.5) * 0.3,
      vy: (Math.random() - 0.5) * 0.3,
      alpha: Math.random() * 0.5 + 0.2,
    }));
  }

  function desenhar() {
    ctx.clearRect(0, 0, largura, altura);
    particulas.forEach((p) => {
      p.x += p.vx;
      p.y += p.vy;
      if (p.x < 0 || p.x > largura) p.vx *= -1;
      if (p.y < 0 || p.y > altura) p.vy *= -1;

      ctx.beginPath();
      ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
      ctx.fillStyle = `rgba(255, 193, 7, ${p.alpha})`;
      ctx.fill();
    });
    requestAnimationFrame(desenhar);
  }

  redimensionar();
  criarParticulas();
  desenhar();
  window.addEventListener('resize', () => { redimensionar(); criarParticulas(); });
}

/* ---------- Texto digitando (efeito no hero, opcional) ---------- */
function ativarTextoDigitando() {
  const el = document.querySelector('.typing-text');
  if (!el) return;
  const frases = JSON.parse(el.dataset.frases || '[]');
  if (!frases.length) return;

  let fraseIdx = 0, charIdx = 0, apagando = false;

  function tick() {
    const fraseAtual = frases[fraseIdx];
    el.textContent = apagando
      ? fraseAtual.substring(0, charIdx--)
      : fraseAtual.substring(0, charIdx++);

    let delay = apagando ? 40 : 80;

    if (!apagando && charIdx === fraseAtual.length + 1) {
      delay = 1400; apagando = true;
    } else if (apagando && charIdx === 0) {
      apagando = false;
      fraseIdx = (fraseIdx + 1) % frases.length;
      delay = 300;
    }
    setTimeout(tick, delay);
  }
  tick();
}

/* ---------- Sistema de Toasts (usado em várias páginas) ---------- */
function mostrarToast(mensagem, tipo = 'success') {
  let container = document.querySelector('.toast-container');
  if (!container) {
    container = document.createElement('div');
    container.className = 'toast-container';
    document.body.appendChild(container);
  }
  const toast = document.createElement('div');
  toast.className = `toast ${tipo}`;
  toast.textContent = mensagem;
  container.appendChild(toast);

  setTimeout(() => {
    toast.classList.add('fade-out');
    setTimeout(() => toast.remove(), 350);
  }, 3500);
}

/* ---------- Estado de loading em botões de formulário ---------- */
function ativarLoadingBotao(botao, textoCarregando = 'Processando...') {
  botao.dataset.textoOriginal = botao.innerHTML;
  botao.classList.add('btn-loading');
  botao.innerHTML = `<span class="spinner-inline"></span> ${textoCarregando}`;
  botao.disabled = true;
}

function desativarLoadingBotao(botao) {
  botao.classList.remove('btn-loading');
  botao.innerHTML = botao.dataset.textoOriginal || botao.innerHTML;
  botao.disabled = false;
}
