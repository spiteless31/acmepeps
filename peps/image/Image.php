<?php

declare(strict_types=1);

namespace peps\image;

/**
 * Représente un fichier image indépendamment de son type et permet de le redimensionner en mode "contain" ou "cover".
 * Extension PHP 'gd2' requise.
 */
abstract class Image
{
	/**
	 * Constante du mode "contain".
	 */
	public const CONTAIN = 'CONTAIN';

	/**
	 * Constante du mode "cover". 
	 */
	public const COVER = 'COVER';

	/**
	 * Chemin absolu du fichier image.
	 */
	protected ?string $path = null;

	/**
	 * Largeur de l'image en pixels.
	 */
	protected ?int $width = null;

	/**
	 * Hauteur de l'image en pixels.
	 */
	protected ?int $height = null;

	/**
	 * Constructeur protected. Les classes enfants DOIVENT avoir un constructeur public qui DEVRAIT appeler ce constructeur parent.
	 * 
	 * @param string $path Chemin du fichier source.
	 * @throws ImageException Si chemin ou type MIME invalides.
	 */
	protected function __construct(string $path)
	{
		// Récupérer le type MIME du fichier.
		@$mimeType = mime_content_type($path);
		// Si chemin ou type MIME invalides, déclencher une exception.
		if (!$mimeType || $mimeType !== $this->getMimeType())
			throw new ImageException(ImageException::UNREADABLE_IMAGE);
		// Récupérer les dimensions de l'image.
		@[$this->width, $this->height] = getimagesize($path);
		// Affecter le chemin.
		$this->path = $path;
	}

	/**
	 * Retourne le type MIME dédié de la classe enfant.
	 * 
	 * @return string Type MIME.
	 */
	public abstract function getMimeType(): string;

	/**
	 * Accès public en lecture seule à la largeur et la hauteur.
	 *
	 * @param string $propertyName Nom de la propriété ("width" ou "height").
	 * @return integer|null Largeur ou hauteur en pixels. Null si autre.
	 */
	public function __get(string $propertyName): ?int
	{
		return $propertyName === 'width' || $propertyName === 'height' ? $this->$propertyName : null;
	}

	/**
	 * Crée un fichier correspondant au redimensionnement de l'image selon un mode donné pour l'inscrire dans un cadre donné. Copie simplement le fichier source si le cadre cible est plus grand dans ses deux dimensions.
	 *
	 * @param int $frameWidth Largeur du cadre cible.
	 * @param int $frameHeight Hauteur du cadre cible.
	 * @param string $targetPath Chemin complet du fichier à créer.
	 * @param string $mode Mode de redimensionnement.
	 * @return void
	 * @throws ImageException Si la création de la ressource PHP cible ou le redimensionnement échouent.
	 */
	public function copyResize(int $frameWidth, int $frameHeight, string $targetPath, string $mode = self::CONTAIN): void
	{
		/*
		* Données connues:
		* $this->width/height: largeur/hauteur de l'image source.
		* $frameWidth/Height: largeur/hauteur du cadre cible.
		* Donnée à calculer:
		* $targetWidth/Height: largeur/hauteur de l'image finale.
		*/
		// Calculer les ratios largeur/hauteur de l'image source et du cadre cible.
		$sourceRatio = $this->width / $this->height;
		$frameRatio = $frameWidth / $frameHeight;
		// Créer un booléen pour déterminer si redimensionnement nécessaire.
		$resize = true;
		// Calculer selon ratio et mode de redimensionnement.
		if (($mode === self::CONTAIN && $sourceRatio > $frameRatio) || ($mode === self::COVER && $sourceRatio < $frameRatio)) {
			// Largeur prioritaire.
			$targetWidth = $frameWidth;
			// Déterminer la hauteur en conservant les proportions.
			$targetHeight = (int) ($targetWidth / $sourceRatio);
			// Si largeur source inférieure ou égale à largeur cible, pas de redimensionnement.
			if ($this->width <= $targetWidth)
				$resize = false;
		} else {
			// Hauteur prioritaire.
			$targetHeight = $frameHeight;
			// Déterminer la largeur en conservant les proportions.
			$targetWidth = (int) ($targetHeight * $sourceRatio);
			// Si hauteur source inférieure ou égale à hauteur cible, pas de redimensionnement.
			if ($this->height <= $targetHeight)
				$resize = false;
		}
		// Si pas de redimensionnement, faire une simple copie et arrêter.
		if (!$resize) {
			// Si la copie échoue, déclencher une exception.
			if (!copy($this->path, $targetPath))
				throw new ImageException(ImageException::IMAGE_COPY_FAILED);
			return;
		}
		// Créer la ressource PHP source à partir du fichier source.
		$source = $this->from();
		// Créer la ressource PHP cible.
		if (!($target = imagecreatetruecolor($targetWidth, $targetHeight)))
			throw new ImageException(ImageException::TARGET_IMAGE_CREATION_FAILED);
		// Redimensionner la ressource PHP source vers la ressource PHP cible.
		if (!imagecopyresampled($target, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $this->width, $this->height))
			throw new  ImageException(ImageException::IMAGE_RESIZING_FAILED);
		// Libérer la ressource PHP source.
		imagedestroy($source);
		// Créer le fichier cible.
		$this->to($target, $targetPath);
		// Libérer la ressource PHP cible.
		imagedestroy($target);
	}

	/**
	 * Crée la ressource PHP source à partir du fichier source. Implémentation nécessaire en fonction du type de l'image.
	 *
	 * @return resource Ressource PHP créée.
	 */
	protected abstract function from();

	/**
	 * Crée le fichier cible à partir de la ressource PHP source. Implémentation nécessaire en fonction du type de l'image.
	 *
	 * @param resource $target Ressource PHP cible.
	 * @param string $targetPath Chemin complet du fichier cible à créer.
	 * @return void
	 */
	protected abstract function to($target, string $targetPath): void;
}
