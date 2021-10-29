<?php

declare(strict_types=1);

namespace controllers;

use entities\Category;
use entities\Product;
use entities\User;
use peps\core\DBAL;
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
		//mail('gillesvds@adok.info', 'Test', "Test");
		Router::render('test.php');
	}

	/**
	 * Méthode d'auto-completion.
	 * 
	 * GET /test/autocomplete/{value}
	 */
	public static function autocomplete(array $params): void
	{
		// Récupérer value.
		$value = $params['value'];
		// Exécuter la requête.
		$q = "SELECT * FROM product WHERE name LIKE :value ORDER BY name";
		$paramsSQL = [':value' => "%{$value}%"];
		$products = DBAL::get()->xeq($q, $paramsSQL)->findAll();
		Router::json(json_encode($products));
	}
}
