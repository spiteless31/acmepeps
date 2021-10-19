<?php

declare(strict_types=1);

namespace controllers;

use entities\Category;
use entities\Product;
use peps\core\Router;

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
		Router::render('test.php');
	}
}
