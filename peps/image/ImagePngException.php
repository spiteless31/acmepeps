<?php

declare(strict_types=1);

namespace peps\image;

/**
 * Exceptions en lien avec ImagePng. Classe 100% statique.
 * 
 * @see ImagePng
 * @see ImageException
 */
final class ImagePngException extends ImageException
{
	/**
	 * Le type de l'image n'est pas PNG.
	 */
	public const IMAGE_NOT_PNG = "Le type de l'image n'est pas PNG.";

	/**
	 * La création de la ressource PHP à partir de l'image PNG a échoué.
	 */
	public const RESOURCE_FROM_PNG_CREATION_FAILED = "La création de la ressource PHP à partir de l'image PNG a échoué.";

	/**
	 * La création de l'image PNG à partir de la ressource PHP a échoué.
	 */
	public const PNG_FROM_RESOURCE_CREATION_FAILED = "La création de l'image PNG à partir de la ressource PHP a échoué.";
}
