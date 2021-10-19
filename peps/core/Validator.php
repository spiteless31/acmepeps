<?php

declare(strict_types=1);

namespace peps\core;

/**
 * Interface de validation des entités.
 * DEVRAIT être implémentée par les classes entité pour valider les données qu'elles contiennent typiquement avant persistance.
 */
interface Validator
{
	/**
	 * Vérifie si l'entité contient des données valides (typiquement après saisie utilisateur).
	 *
	 * @var string[] $errors Tableau des messages d'erreurs passé par référence.
	 * @return boolean True ou false selon que les données sont valides ou non.
	 */
	function validate(?array &$errors = []): bool;
}
