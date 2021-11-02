<?php

declare(strict_types=1);

namespace controllers;

use DateTime;
use entities\User;
use peps\core\DBAL;
use peps\core\ORMDB;
use peps\core\Router;

/**
 * Contrôle la connexion/déconnexion des utilisateurs.
 * 
 * @see User
 * @see Router
 */
final class UserController
{
	// Messages d'erreur.
	private const ERR_LOGIN = "Identifiant ou mot de passe absents ou invalides";
	private const ERR_INVALID_LOG = "Identifiant  absents ou invalides";
	private const ERR_INVALID_HASH = "lien invalide ou expiré";

	/**
	 * Constructeur privé.
	 */
	private function __construct()
	{
	}

	/**
	 * Affiche le formulaire de connexion.
	 * 
	 * GET user/signin
	 */
	public static function signin(): void
	{
		// Rendre la vue.
		Router::render('signin.php', ['log' => null]);
	}

	/**
	 * Connecte l'utilisateur si possible puis redirige.
	 * 
	 * POST user/login
	 */
	public static function login(): void
	{
		// Prévoir le tableau des messages d'erreur.
		$errors = [];
		// Instancier un utilisateur.
		$user = new User();
		// Récupérer les données POST.
		$user->log = filter_input(INPUT_POST, 'log', FILTER_SANITIZE_STRING) ?: null;
		$user->pwd = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_STRING) ?: null;
		// Si login OK, rediriger vers l'accueil.
		if ($user->login())
			Router::redirect('/');
		// Sinon, afficher de nouveau le formulaire avec le message d'erreur.
		$errors[] = self::ERR_LOGIN;
		Router::render('signin.php', ['log' => $user->log, 'errors' => $errors]);
	}

	/**
	 * Déconnecte l'utilisateur puis redirige.
	 * 
	 * GET user/logout
	 */
	public static function logout(): void
	{
		// Détruire la session.
		session_destroy();
		// Rediriger vers l'accueil.
		Router::redirect('/');
	}

	//affiche la vue mot de passe oublié
	public static function forgottenPwd(): void
	{
		Router::render("forgottenPwd.php", ['log' => null]);
	}

	public static function newPwd(): void
	{

		$errors = [];


		$log = filter_input(INPUT_POST, 'log', FILTER_SANITIZE_STRING) ?: null;

		if (!$user = User::findOneBy(['log' => $log])) {
			$errors[] = self::ERR_INVALID_LOG;
			Router::render("forgottenPwd.php", ['log' =>  $log, 'errors' =>  $errors]);
		}




		$hash = hash('sha1', microtime(), false);
		$user->pwdHash = $hash;
		$user->pwdTimeout = date('Y-m-d H:i:s', time() + 10 * 60);
		$user->persist();

		$subject = 'renouvellement du mot de passe';
		$link = "bonjour,
cliquez sur le lien ci-dessous pour reinitialiser votre mot de passe.
Ce lien sera expiré dans 10min
http://gitacmepeps/user/setPwd/{$hash}
";
		mail($user->email, $subject, $link);

		router::redirect('/');
	}
	/**
	 * 
	 * 
	 *
	 * @param array $params
	 * @return void
	 */
	public static function setPwd(array $params): void
	{

		$hash = $params['hash'];
		var_dump($hash);
		if (!$hash || !($user = User::findOneBy(['pwdHash' => $hash])) || $user->pwdTimeout < date('Y-m-d H:i:s')) {
			$errors[] = self::ERR_INVALID_HASH;
			Router::render("forgottenPwd.php", ['log' =>  null, 'errors' =>  $errors]);
		}
		Router::render('setPwd.php', ['hash' => $hash]);
	}
	public static function savePwd(): void
	{
		$hash = filter_input(INPUT_POST, 'hash', FILTER_SANITIZE_STRING) ?: null;
		$pwd = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_STRING) ?: null;
		

		if (!$pwd || !$hash || !($user = User::findOneBy(['pwdHash' => $hash])) || $user->pwdTimeout < date('Y-m-d H:i:s')) {
			$errors[] = self::ERR_INVALID_HASH;
			Router::render("forgottenPwd.php", ['log' =>  null, 'errors' =>  $errors]);
		}

		$user->pwd = password_hash($pwd, PASSWORD_DEFAULT);
		$user->pwdHash = null;
		$user->pwdTimeout = null;

		$user->persist();
		$_SESSION['idUser'] = $user->idUser;

		$subject = 'changement reussi de votre mot de passe';
		$link = "bonjour,
votre mot de passe vient d'etre modifié
";
		mail($user->email, $subject, $link);
		Router::redirect('/');
	}
}
