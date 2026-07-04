<?php
/**
 * includes/footer.php
 * Rodapé reutilizado em todas as páginas públicas.
 */
?>
<footer>
  <div class="container">
    <div class="footer-grid">
      <div>
        <a href="index.php" class="logo">Solu<span>Tech</span></a>
        <p style="color:var(--texto-secundario); margin-top:14px; font-size:14px; max-width:320px;">
          Soluções tecnológicas inteligentes para empresas que querem crescer com eficiência e inovação.
        </p>
        <div class="social-icons">
          <a href="#"><i class="fa-brands fa-instagram"></i></a>
          <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
          <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
          <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
        </div>
      </div>

      <div>
        <h4>Links Úteis</h4>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="sobre.php">Sobre</a></li>
          <li><a href="servicos.php">Serviços</a></li>
          <li><a href="diagnostico.php">Diagnóstico IA</a></li>
        </ul>
      </div>

      <div>
        <h4>Contato</h4>
        <ul>
          <li><a href="mailto:contato@solutech.com">contato@solutech.com</a></li>
          <li><a href="tel:+5531999999999">(31) 99999-9999</a></li>
          <li><a href="contato.php">Fale conosco</a></li>
        </ul>
      </div>

      <div>
        <h4>Newsletter</h4>
        <p style="font-size:13.5px; color:var(--texto-secundario);">Receba novidades e tendências em tecnologia.</p>
        <form class="newsletter-form" onsubmit="event.preventDefault(); mostrarToast('Inscrição realizada com sucesso!');">
          <input type="email" placeholder="Seu e-mail" required>
          <button type="submit" class="btn btn-primary" style="padding:12px 18px;">
            <i class="fa-solid fa-paper-plane"></i>
          </button>
        </form>
      </div>
    </div>

    <div class="footer-bottom">
      &copy; <?= date('Y') ?> SoluTech. Todos os direitos reservados.
    </div>
  </div>
</footer>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="js/scroll.js"></script>
<script src="js/main.js"></script>
