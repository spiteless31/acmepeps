<?php

declare(strict_types=1);

namespace peps\image;

/**
 * Exceptions en lien avec ImageJpeg. Classe 100% statique.
 * 
 * @see ImageJpeg
 * @see ImageException
 */
final class ImageJpegException extends ImageException
{
	/**
	 * Le type de l'image n'est pas JPEG.
	 */
	public const IMAGE_NOT_JPEG = "Le type de l'image n'est pas JPEG.";

	/**
	 * La création de la ressource PHP à partir de l'image JPEG a échoué.
	 */
	public const RESOURCE_FROM_JPEG_CREATION_FAILED = "La création de la ressource PHP à partir de l'image JPEG a échoué.";

	/**
	 * La création de l'image JPEG à partir de la ressource PHP a échoué.
	 */
	public const JPEG_FROM_RESOURCE_CREATION_FAILED = "La création de l'image JPEG à partir de la ressource PHP a échoué.";
}
