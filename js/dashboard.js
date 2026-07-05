/**
 * js/dashboard.js
 * Comportamentos do painel administrativo: sidebar recolhível,
 * modais, busca/filtro em tabelas e confirmações com SweetAlert.
 */

document.addEventListener('DOMContentLoaded', () => {
  ativarToggleSidebar();
  ativarBuscaTabela();
  ativarModais();
});

/* ---------- Sidebar recolhível ---------- */
function ativarToggleSidebar() {
  const btn = document.getElementById('btn-toggle-sidebar');
  const sidebar = document.getElementById('sidebar');
  if (!btn || !sidebar) return;

  btn.addEventListener('click', () => {
    if (window.innerWidth <= 768) {
      sidebar.classList.toggle('mobile-open');
    } else {
      sidebar.classList.toggle('collapsed');
    }
  });
}

/* ---------- Busca simples em tabelas (client-side) ---------- */
function ativarBuscaTabela() {
  document.querySelectorAll('[data-busca-tabela]').forEach((input) => {
    const seletorTabela = input.dataset.buscaTabela;
    const tabela = document.querySelector(seletorTabela);
    if (!tabela) return;

    input.addEventListener('input', () => {
      const termo = input.value.trim().toLowerCase();
      tabela.querySelectorAll('tbody tr').forEach((linha) => {
        linha.style.display = linha.textContent.toLowerCase().includes(termo) ? '' : 'none';
      });
    });
  });
}

/* ---------- Modais genéricos ---------- */
function ativarModais() {
  document.querySelectorAll('[data-abrir-modal]').forEach((el) => {
    el.addEventListener('click', () => {
      const modal = document.querySelector(el.dataset.abrirModal);
      if (modal) modal.classList.add('ativo');
    });
  });
  document.querySelectorAll('[data-fechar-modal]').forEach((el) => {
    el.addEventListener('click', () => {
      el.closest('.modal-overlay')?.classList.remove('ativo');
    });
  });
}

/* ---------- Confirmação de exclusão via SweetAlert2 ---------- */
function confirmarExclusao(formOuUrl, mensagem = 'Esta ação não poderá ser desfeita.') {
  Swal.fire({
    title: 'Tem certeza?',
    text: mensagem,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#2563EB', // azul-medio (mesma cor dos botões primários do site)
    cancelButtonColor: '#64748B',  // texto-secundario
    background: '#FFFFFF',
    color: '#334155',              // texto
    confirmButtonText: 'Sim, excluir',
    cancelButtonText: 'Cancelar',
  }).then((resultado) => {
    if (resultado.isConfirmed) {
      if (typeof formOuUrl === 'string') {
        window.location.href = formOuUrl;
      } else {
        formOuUrl.submit();
      }
    }
  });
  return false; // impede submit/navegação imediata em onclick="return confirmarExclusao(...)"
}