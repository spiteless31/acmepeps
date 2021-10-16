<?php

declare(strict_types=1);

namespace entities;

use peps\core\DBAL;
use peps\core\ORMDB;

/**
 * Entité Category.
 * 
 * @see DBAL
 * @see ORMDB
 */
class Category extends ORMDB
{
	/**
	 * PK.
	 */
	public ?int $idCategory;

	/**
	 * Nom.
	 */
	public ?string $name;

	/**
	 * Collection des produits de cette catégorie.
	 * 
	 * @var Product[]
	 */
	protected ?array $products;

	/**
	 * Constructeur.
	 */
	public function __construct(int $idCategory = null)
	{
		$this->idCategory = $idCategory;
	}

	/**
	 * Retourne un tableau des produits (triés par nom) de cette catégorie.
	 * Lazy loading.
	 *
	 * @return Product[] Tableau des produits.
	 */
	protected function getProducts(): array
	{
		// Si le tableau n'est pas renseigné, requêter la DB.
		if (empty($this->products))
			$this->products = Product::findAllBy(['idCategory' => $this->idCategory], ['name' => 'ASC']);
		return $this->products;
	}
}
