<?php

declare(strict_types=1);

namespace peps\image;

/**
 * Implémentation de Image pour le type JPEG.
 * 
 * @see Image
 */
final class ImageJpeg extends Image
{
	/**
	 * Qualité (1 à 100).
	 */
	private int $quality;

	/**
	 * Constructeur.
	 * 
	 * @param string $path Chemin du fichier source.
	 * @param int $quality Qualité. 60 par défaut.
	 */
	public function __construct(string $path, int $quality = 60)
	{
		// Appeler le constructeur parent.
		parent::__construct($path);
		// Définir les propriétés propres.
		$this->quality = $quality;
	}

	/**
	 * Retourne le type MIME dédié.
	 * 
	 * @return string Type MIME.
	 */
	public function getMimeType(): string
	{
		return 'image/jpeg';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function from()
	{
		// Si la création de la ressource à partir du fichier échoue, déclencher une exception.
		if (@!($source = imagecreatefromjpeg($this->path)))
			throw new ImageJpegException(ImageJpegException::RESOURCE_FROM_JPEG_CREATION_FAILED);
		// Retourner la ressource.
		return $source;
	}

	/**
	 * {@inheritDoc}
	 */
	protected function to($target, string $targetPath): void
	{
		// Si la création du fichier depuis la ressource échoue, déclencher une exception.
		if (@!imagejpeg($target, $targetPath, $this->quality))
			throw new ImageJpegException(ImageJpegException::JPEG_FROM_RESOURCE_CREATION_FAILED);
	}
}
