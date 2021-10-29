<?php

declare(strict_types=1);

namespace views;

use peps\core\Cfg;

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= Cfg::get('appTitle') ?></title>
	<link rel="stylesheet" href="/assets/css/acme.css" />
</head>

<body>
	<?php require 'views/inc/header.php' ?>
	<main>
		<div class="category">
			<input id="autocomplete" oninput="test()" />
			<div id="autocomplete_results"></div>
		</div>
	</main>
	<footer></footer>
	<script src="/assets/js/test.js"></script>
</body>

</html>