<?php

declare(strict_types=1);

namespace peps\upload;

use Exception;

/**
 * Exceptions en lien avec Upload. Classe 100% statique.
 */
class UploadException extends Exception
{
	/**
	 * Le fichier est introuvable.
	 */
	public const FILE_NOT_FOUND = "Le fichier est introuvable.";

	/**
	 * Le fichier est vide.
	 */
	public const EMPTY_FILE = "Le fichier est vide.";

	/**
	 * Le poids du fichier excède la limite POST.
	 */
	public const FILE_SIZE_EXCEEDS_POST_MAX_SIZE = "Le poids du fichier excède la limite POST.";

	/**
	 * Le poids du fichier excède la limite UPLOAD.
	 */
	public const FILE_SIZE_EXCEEDS_UPLOAD_MAX_SIZE = "Le poids du fichier excède la limite UPLOAD.";

	/**
	 * Le type MIME du fichier est incorrect.
	 */
	public const WRONG_MIME_TYPE = "Le type MIME du fichier est incorrect.";

	/**
	 * L'enregistrement du fichier a échoué.
	 */
	public const FILE_COPY_FAILED = "L'enregistrement du fichier a échoué.";

	/**
	 * Le fichier n'a été que partiellement uploadé.
	 */
	public const FILE_PARTIALLY_UPLOADED = "Le fichier n'a été que partiellement uploadé.";

	/**
	 * Une extension PHP a bloqué l'upload.
	 */
	public const UPLOAD_FAILED_DUE_TO_PHP_EXTENSION = "Une extension PHP a bloqué l'upload.";

	/**
	 * Le répertoire temporaire est introuvable.
	 */
	public const NO_TMP_DIR = "Le répertoire temporaire est introuvable.";

	/**
	 * Impossible d'enregistrer le fichier temporaire.
	 */
	public const CANT_WRITE = "Impossible d'enregistrer le fichier temporaire.";

	/**
	 * Fichier corrompu.
	 */
	public const CORRUPTED_FILE = "Fichier corrompu.";
}
