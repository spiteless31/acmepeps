<?php

declare(strict_types=1);

namespace views;

use peps\core\Cfg;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title><?= Cfg::get('appTitle') ?></title>
	<link rel="stylesheet" href="/assets/css/acme.css">
</head>

<body>
	<header></header>
	<main>
		<?= $obj->k ?>
	</main>
	<footer></footer>
</body>

</html>