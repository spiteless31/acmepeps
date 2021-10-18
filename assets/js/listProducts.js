"use strict";
/**
 * Supprime un produit et ses images.
 * 
 * @var idProduct PK du produit.
 * @returns void
 */
function deleteAll(idProduct) {
	// Si l'utilisateur le confirme, rediriger vers la route adéquate.
	if (confirm("Vraiment supprimer le produit et ses photos ?")) {
		// SOLUTION SYNCHRONE
		//location = `/product/delete/${idProduct}/all`;
		// SOLUTION ASYNCHRONE
		let url = `/product/delete/${idProduct}/all`;
		fetch(url).then(() => location.reload());
	}
}

/**
 * Supprime les images d'un produit.
 * 
 * @var idProduct PK du produit.
 * @returns void
 */
function deleteImg(idProduct) {
	// Si l'utilisateur le confirme, rediriger vers la route adéquate.
	if (confirm("Vraiment supprimer les photos du produit ?")) {
		// SOLUTION SYNCHRONE
		//location = `/product/delete/${idProduct}/img`;
		// SOLUTION ASYNCHRONE
		let url = `/product/delete/${idProduct}/img`;
		fetch(url).then(() => location.reload());
	}
}
