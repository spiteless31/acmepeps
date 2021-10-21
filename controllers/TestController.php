<?php

declare(strict_types=1);

namespace controllers;

use entities\Category;
use entities\Product;
use peps\core\Router;
use stdClass;

/**
 * Classe 100% statique.
 * Contrôle les produits.
 */
final class TestController
{
	/**
	 * Constructeur privé.
	 */
	private function __construct()
	{
	}

	/**
	 * Méthode de test.
	 * 
	 * GET /test
	 */
	public static function test(): void
	{
		session_start();
		$_SESSION['obj'] = $_SESSION['obj'] ?? new stdClass();
		$_SESSION['obj']->k = isset($_SESSION['obj']->k) ? $_SESSION['obj']->k + 1 : 0;
		Router::render('test.php', ['obj' => $_SESSION['obj']]);
	}
}
