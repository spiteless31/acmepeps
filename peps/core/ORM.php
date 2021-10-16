<?php

declare(strict_types=1);

namespace peps\core;

/**
 * Abstraction ORM de la persistance des entités.
 * Indépentante du type de système de stockage.
 */
interface ORM
{
	/**
	 * Hydrate l'entité depuis le système de stockage.
	 *
	 * @return boolean True ou false selon que l'hydratation a réussi ou non.
	 */
	function hydrate(): bool;

	/**
	 * Persiste l'entité vers le système de stockage.
	 *
	 * @return boolean True systématiquement.
	 */
	function persist(): bool;

	/**
	 * Supprime l'entité du système de stockage.
	 *
	 * @return boolean True ou false selon que la suppression a réussi ou non.
	 */
	function remove(): bool;

	/**
	 * Sélectionne des entités correspondant aux critères dans le système de stockage.
	 * Retourne un tableau d'instances (implémentant ORM).
	 *
	 * @param array $filters Tableau associatif de filtres d'égalité reliées par 'AND' sous la forme 'champ' = 'valeur'. Ex: ['name' => 'truc', 'idCategory' => 3].
	 * @param array $sortKeys Tableau associatif de clés de tri sous la forme 'champ' => 'ASC' | 'DESC'. Ex: ['name' => 'DESC', 'price' => 'ASC'].
	 * @param string $limit Limite de la sélection.
	 *                      Ex: '3' signifie 3 entités à partir de la première.
	 *                      Ex: '2,5' signifie 5 entités à partir de la troisième incluse.
	 * @return array Tableau d'instances.
	 */
	static function findAllBy(array $filters = [], array $sortKeys = [], string $limit = ''): array;

	/**
	 * Sélectionne une entité correspondant aux critères dans le système de stockage.
	 * Retourne une instance (implémentant ORM) ou null si aucune correspondance.
	 *
	 * @param array $filters Tableau associatif de filtres d'égalité reliées par 'AND' sous la forme 'champ' = 'valeur'. Ex: ['name' => 'truc', 'idCategory' => 3].
	 * @return ORM|null L'instance ou null.
	 */
	static function findOneBy(array $filters = []): ?ORM;

	/**
	 * Retourne le résultat de l'invocation de la méthode get{PropertyName}() si elle existe.
	 * Sinon retourne null.
	 *
	 * @param string $propertyName Nom de la propriété.
	 * @return mixed Dépend de la classe enfant et de la propriété.
	 */
	function __get(string $propertyName): mixed;
}
