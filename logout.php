<?php
/**
 * logout.php
 * Encerra a sessão do administrador.
 */
require_once __DIR__ . '/includes/auth.php';
fazerLogout();
header('Location: login.php');
exit;
