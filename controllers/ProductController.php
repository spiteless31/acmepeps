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
final class ProductController
{
	/**
	 * Constructeur privé.
	 */
	private function __construct()
	{
	}

	/**
	 * Affiche les produits par catégorie.
	 * 
	 * GET /
	 * GET /product/list
	 */
	public static function list(): void
	{
		// Récupérer toutes les catégories.
		$categories = Category::findAllBy([], ['name' => 'ASC']);
		// Rendre la vue.
		Router::render('listProducts.php', ['categories' => $categories]);
	}

	/**
	 * Affiche le détail d'un produit.
	 * 
	 * GET /product/show/{idProduit}
	 */
	public static function show(array $params): void
	{
		// Récupérer idProduct.
		$idProduct = (int) $params['idProduct'];
		// Créer le produit.
		$product = new Product($idProduct);
		// Hydrater le produit et si idProduct inexistant, rendre la vue noProduct.
		if (!$product->hydrate())
			Router::render('noProduct.php');
		// Ajouter dynamiquement la propriété idImg.
		$product->idImg = file_exists("assets/img/product_{$product->idProduct}_big.jpg") ? $product->idProduct : 0;
		// Rendre la vue showProduct.
		Router::render('showProduct.php', ['product' => $product]);
	}

	/**
	 * Supprime un produit et/ou ses images.
	 * 
	 * GET /product/delete/{idProduct}/{mode = all | img}
	 *
	 * @param array $params Tableau associatif des paramètres.
	 */
	public static function delete(array $params): void
	{
		// Récupérer idProduct et mode.
		$idProduct = (int) $params['idProduct'];
		$mode = $params['mode'];
		// Si mode 'all', créer un produit pour le supprimer.
		if ($mode === 'all')
			(new Product($idProduct))->remove();
		// Dans tous les cas, tenter de supprimer les images.
		@unlink("assets/img/product_{$idProduct}_small.jpg");
		@unlink("assets/img/product_{$idProduct}_big.jpg");
		// Rediriger vers la liste (synchrone).
		//Router::redirect('/');
		// Faire un echo sans précision (asynchrone).
		Router::json('');
	}
}
