<?php

declare(strict_types=1);

namespace peps\upload;

/**
 * Gestion des uploads de fichiers.
 */
class Upload
{
	/**
	 * Nom du champ INPUT de type "file".
	 */
	public string $inputName;

	/**
	 * Types MIME autorisés, ex: ['image/jpeg'].
	 *
	 * @var string[]
	 */
	public array $allowedMimeTypes = [];

	/**
	 * Nom du fichier côté client.
	 */
	public string $fileName;

	/**
	 * Chemin du fichier temporaire côté serveur.
	 */
	public string $tmpFilePath;

	/**
	 * Nombre d'octets téléchargés.
	 */
	public int $bytesUploaded;

	/**
	 * Type MIME du fichier.
	 */
	public string $mimeType;

	/**
	 * Eventuel code d'erreur.
	 */
	public int $errorCode;

	/**
	 * Affecte les propriétés et déclenche une exception en cas d'erreur.
	 *
	 * @param string $inputName Nom du champ INPUT de type "file".
	 * @param array $allowedMimeTypes Tableau des types MIME autorisés.
	 * @param boolean $optional True si le fichier est facultatif, false sinon.
	 * @throws UploadException Si erreur.
	 */
	public function __construct(string $inputName, array $allowedMimeTypes = [], bool $optional = true)
	{
		// Récupérer les données pour les affecter aux propriétés.
		$this->inputName = $inputName;
		$this->allowedMimeTypes = $allowedMimeTypes;
		$file = $_FILES[$this->inputName] ?? null;
		// Si la taille du fichier excède la limite post_max_size, déclencher une exception.
		if (!$file)
			throw new UploadException(UploadException::FILE_SIZE_EXCEEDS_POST_MAX_SIZE);
		$this->fileName = $file['name'];
		$this->tmpFilePath = $file['tmp_name'];
		$this->bytesUploaded = $file['size'];
		$this->mimeType = $file['type'];
		$this->errorCode = $file['error'];
		// Si fichier absent alors que obligatoire, déclencher une exception.
		if ($this->errorCode === UPLOAD_ERR_NO_FILE) {
			if ($optional)
				return;
			throw new UploadException(UploadException::FILE_NOT_FOUND);
		}
		// Si le fichier n'est pas un fichier uploadé, déclencher une exception.
		if (!is_uploaded_file($this->tmpFilePath))
			throw new UploadException(UploadException::CORRUPTED_FILE);
		// Si la taille du fichier excède la limite max_file_uploads (mais pas la limite post_max_size), déclencher une exception.
		if ($this->errorCode === UPLOAD_ERR_INI_SIZE || $this->errorCode === UPLOAD_ERR_FORM_SIZE)
			throw new UploadException(UploadException::FILE_SIZE_EXCEEDS_UPLOAD_MAX_SIZE);
		// Si le fichier est vide, déclencher une exception.
		if (!$this->bytesUploaded)
			throw new UploadException(UploadException::EMPTY_FILE);
		// Si types MIME imposés et fichier non compatible, déclencher une exception.
		if ($this->allowedMimeTypes && !in_array($this->mimeType, $this->allowedMimeTypes))
			throw new UploadException(UploadException::WRONG_MIME_TYPE);
		// Tester les cas improbables.
		if ($this->errorCode === UPLOAD_ERR_PARTIAL)
			throw new UploadException(UploadException::FILE_PARTIALLY_UPLOADED);
		if ($this->errorCode === UPLOAD_ERR_EXTENSION)
			throw new UploadException(UploadException::UPLOAD_FAILED_DUE_TO_PHP_EXTENSION);
		if ($this->errorCode === UPLOAD_ERR_NO_TMP_DIR)
			throw new UploadException(UploadException::NO_TMP_DIR);
		if ($this->errorCode === UPLOAD_ERR_CANT_WRITE)
			throw new UploadException(UploadException::CANT_WRITE);
	}

	/**
	 * Sauvegarde le fichier uploadé selon le chemin donné.
	 *
	 * @param string $path Chemin complet du fichier cible.
	 * @return void
	 * @throws UploadException Si erreur.
	 */
	public function save(string $path): void
	{
		// Utiliser move_uploaded_file() comme recommandé.
		if (@!move_uploaded_file($this->tmpFilePath, $path))
			throw new UploadException(UploadException::FILE_COPY_FAILED);
	}
}
