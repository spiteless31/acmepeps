"use strict";
/**
 * Supprime un produit et ses images.
 * 
 * @var idProduct PK du produit.
 * @returns void
 */
function deleteAll(idProduct) {
	// Si l'utilisateur le confirme, rediriger vers la route adéquate.
	if (confirm("Vraiment supprimer le produit et ses photos ?"))
		location = `/product/delete/${idProduct}/all`;
}

/**
 * Supprime les images d'un produit.
 * 
 * @var idProduct PK du produit.
 * @returns void
 */
function deleteImg(idProduct) {
	// Si l'utilisateur le confirme, rediriger vers la route adéquate.
	if (confirm("Vraiment supprimer les photos du produit ?"))
		location = `/product/delete/${idProduct}/img`;
}
