<?php

declare(strict_types=1);

namespace cfg;

use peps\core\Cfg;

/**
 * Classe 100% statique de configuration générale de l'application.
 * DOIT être étendue par une classe finale par serveur.
 *
 * @see Cfg
 */
class CfgApp extends Cfg
{
	/**
	 * Tableau associatif des classes de configuration des serveurs.
	 * Clé = nom du serveur.
	 * Valeur = classe de configuration.
	 *
	 * @var string[]
	 */
	public const HOSTS = [
		'gitacmepeps' => CfgLocal::class
	];

	/**
	 * Constructeur privé.
	 */
	private function __construct()
	{
	}

	/**
	 * Initialise la configuration.
	 */
	protected static function init(): void
	{
		// Inscription des constantes de la classe parente.
		parent::init();

		// Titre de l'application.
		self::register('appTitle', "ACME");

		// Poids maxi d'une photo (octets).
		self::register('imgMaxFileSize', 10 * 1024 * 1024);

		// Tableau des types MIME autorisés pour la photo. Vide si tous types autorisés.
		self::register('imgAllowedMimeTypes', ['image/jpeg']);

		// Largeur du cadre de destination des images (pixels).
		self::register('imgBigWidth', 450);

		// Hauteur du cadre de destination des images (pixels).
		self::register('imgBigHeight', 450);

		// Largeur du cadre de destination des vignettes (pixels).
		self::register('imgSmallWidth', 300);

		// Hauteur du cadre de destination des vignettes (pixels).
		self::register('imgSmallHeight', 300);
	}
}
