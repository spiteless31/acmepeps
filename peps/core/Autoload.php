<?php

declare(strict_types=1);

namespace peps\core;

/**
 * Classe 100% statique d'autoload.
 */
final class Autoload
{
	/**
	 * Constructeur privé.
	 */
	private function __construct()
	{
	}

	/**
	 * Initialise l'autoload.
	 * DOIT être appelée depuis le contrôleur frontal EN TOUT PREMIER.
	 */
	public static function init(): void
	{
		// Inscrire la fonction d'autolad dans la pile d'autoload.
		spl_autoload_register(fn ($className) => require $className . '.php');
	}
}

