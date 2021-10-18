<?php

declare(strict_types=1);

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
	<main>
		<div class="category">
			<a href="/product/list">Produits</a> &gt; Editer
		</div>
		<form name="form1" action="/product/save" method="POST">
			<input type="hidden" name="idProduct" value="<?= $product->idProduct ?>" />
			<div class="item">
				<label>Catégorie</label>
				<select name="idCategory">
					<!-- ICI PEUPLER LE MENU DEROULANT -->
				</select>
			</div>
			<div class="item">
				<label>Nom</label>
				<input name="name" value="<?= $product->name ?>" size="20" maxlength="50" required="required" />
			</div>
			<div class="item">
				<label>Référence</label>
				<input name="ref" value="<?= $product->ref ?>" size="10" maxlength="10" required="required" />
			</div>
			<div class="item">
				<label>Prix</label>
				<input type="number" name="price" value="<?= $product->price ? Cfg::get('NF_INPUT_2DEC')->format($product->price) : null ?>" min="0.1" max="9999.99" step="0.01" size="7" maxlength="7" required="required" />
			</div>
			<div class="item">
				<label></label>
				<a href="/product/list"><input type="button" value="Annuler" /></a>
				<input type="submit" value="Valider" />
			</div>
		</form>
	</main>
	<footer></footer>
</body>

</html>