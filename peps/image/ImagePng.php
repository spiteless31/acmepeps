<?php

declare(strict_types=1);

namespace peps\image;

/**
 * Implémentation de Image pour le type PNG.
 * 
 * @see Image
 */
final class ImagePng extends Image
{
	/**
	 * Niveau de la compression PNG (-1 à 9).
	 * -1 = compression zlib (par défaut).
	 * 0 = pas de compression.
	 */
	private int $quality;

	/**
	 * Constructeur.
	 * 
	 * @param string $path Chemin du fichier source.
	 * @param int $quality Niveau de la compression. -1 par défaut.
	 */
	public function __construct(string $path, int $quality = -1)
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
		return 'image/png';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function from()
	{
		// Si la création de la ressource à partir du fichier échoue, déclencher une exception.
		if (@!($source = imagecreatefrompng($this->path)))
			throw new ImagePngException(ImagePngException::RESOURCE_FROM_PNG_CREATION_FAILED);
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
			throw new ImagePngException(ImagePngException::PNG_FROM_RESOURCE_CREATION_FAILED);
	}
}
