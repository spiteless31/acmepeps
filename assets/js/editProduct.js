"use strict";
/*
* Retient la source initiale pour restaurer si fichier invalide.
*/
// Récupérer une référence à l'élément IMG.
let img = document.querySelector('#thumbnail img');
// Retenir la source initiale.
let initialSource = img.src;
/*
* Charge la photo choisie par drag and drop.
*/
// Supprimer le comportement par défaut de dragover.
img.addEventListener('dragover', evt => evt.preventDefault());
// Supprimer le comportement par défaut de drop et transférer les données.
img.addEventListener('drop', evt => {
	evt.preventDefault();
	// Transférer les données à l'élément INPUT.
	document.form1.photo.files = evt.dataTransfer.files;
	// Déléguer vérification et affichage à displayPhoto().
	displayPhoto(evt.dataTransfer.files);
});
//----------------------------------------
/*
* Récupère et vérifie la photo choisie. Si valide, affiche la photo.
* Retourne systématiquement true pour comportement correct si fichier drag and drop invalide.
*/
function displayPhoto(files) {
	//return; // DEBUG: pour tester les sécurités côté serveur.
	// Si pas de FileList ou FileList vide, abandonner.
	if (!files || !files.length)
		return;
	// Récupérer le File en premier élément de la FileList.
	let file = files[0];
	// Si fichier vide, alerter, supprimer le fichier, restaurer la source initiale et retourner true.
	if (!file.size) {
		alert("Le fichier est vide.");
		document.form1.photo.value = '';
		img.src = initialSource;
		return true;
	}
	// Si fichier trop lourd, alerter, supprimer le fichier, restaurer la source initiale et retourner true.
	if (file.size > IMG_MAX_FILE_SIZE) {
		alert("Le fichier est trop lourd.");
		document.form1.photo.value = '';
		img.src = initialSource;
		return true;
	}
	// Si type MIME fichier invalide, alerter, supprimer le fichier, restaurer la source initiale et retourner true. Attention, JS ne se base que sur l'extension, pas sur l'encodage du fichier.
	if (IMG_ALLOWED_MIME_TYPES.length && !IMG_ALLOWED_MIME_TYPES.includes(file.type)) {
		alert("Le type MIME du fichier est invalide.");
		document.form1.photo.value = '';
		img.src = initialSource;
		return true;
	}
	// Instancier un FileReader.
	let reader = new FileReader();
	// Définir le traitement à effectuer quand le résultat de la lecture sera disponible.
	reader.onload = () => img.src = reader.result;
	// Lire le fichier.
	reader.readAsDataURL(file);
	// Retourner true.
	return true;
}
