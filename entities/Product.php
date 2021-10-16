<?php

declare(strict_types=1);

namespace entities;

use peps\core\DBAL;
use peps\core\ORMDB;

/**
 * Entité Product.
 * 
 * @see DBAL
 * @see ORMDB
 */
class Product extends ORMDB
{
	/**
	 * PK.
	 */
	public ?int $idProduct;

	/**
	 * FK de la catégorie.
	 */
	public ?int $idCategory;

	/**
	 * Nom.
	 */
	public ?string $name;

	/**
	 * Référence.
	 */
	public ?string $ref;

	/**
	 * Prix.
	 */
	public ?float $price;

	/**
	 * Catégorie de ce produit.
	 */
	protected ?Category $category;

	/**
	 * Constructeur.
	 */
	public function __construct(int $idProduct = null)
	{
		$this->idProduct = $idProduct;
	}

	/**
	 * Retourne la catégorie de ce produit.
	 * Lazy loading.
	 */
	protected function getCategory(): Category
	{
		// Si la catégorie n'est pas renseignée, requêter la DB.
		if (empty($this->category)) {
			// Solution 1 :
			//$this->category = Category::findOneBy(['idCategory' => $this->idCategory]);
			// Solution 2 :
			$category = new Category($this->idCategory);
			$this->category = $category->hydrate() ? $category : null;
		}
		return $this->category;
	}
}
