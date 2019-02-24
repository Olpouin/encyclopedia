<?php
$lang = array(
	'help' => 'Aide',
	'close' => 'Fermer',
	'language' => "Langage",
	'password' => 'Mot de passe',
	'wrong' => 'Incorrect',
	'send' => 'Envoyer',
	'homepage-top_message' => 'La galerie a un total de [TOTALPAGES] pages.',
	'homepage-search_input' => 'Recherche d\'une fiche...',
	'homepage-search_button' => 'Chercher',
	'homepage-sourcecode' => 'Code sur GitHub',
	'cookie-warning' => 'En modifiant les paramètres par défaut, vous acceptez l\'utilisation de cookies.',
	'homepage-prefs-title' => 'Préférences',
	'homepage-prefs-nightmode' => 'Mode nuit',
	'homepage-prefs-needsReload' => 'Vous deverez recharger la page pour changer cette préférence.',
	'homepage-prefs-confirm_changes' => 'Confirmer les changements',
	'edition-info-example_title' => 'Exemple',
	'edition-hide_card' => 'Cacher la fiche (Pas affiché dans la barre de navigation)',
	'edition-group_placeholder' => 'Groupe de la fiche',
	'edition-name_placeholder' => 'Nom de la fiche',
	'edition-type_placeholder' => 'Type de la fiche',
	'notif-show' => 'Afficher la page',
	'footer-edit_page' => 'Modifier la page',
	'footer-top' => 'Aller en haut',
	'toc' => 'Table des matières',
	'admin-title' => 'Interface d\'administration',
	'admin-createcard' => 'Créer une fiche'
);
$lang['editor-bar'] = array(
	'title1' => 'Titre 1',
	'title2' => 'Titre 2',
	'title3' => 'Titre 3',
	'title4' => 'Titre 4',
	'title5' => 'Titre 5',
	'title6' => 'Titre 6',
	'italic' => 'Italique',
	'bold' => 'Gras',
	'strikethrough' => 'Barré',
	'underlined' => 'Soulignage',
	'color' => 'Couleur',
	'img' => 'Image',
	'url' => 'Lien',
	'sound' => 'Son',
	'video' => 'Vidéo',
	'quote' => 'Citation',
	'hr' => 'Barre horizontale',
	'tab' => 'Tabulation',
	'help-dsc' => 'Description'
);
$lang['error'] = array(
	"menu-close_message" => "Fermer le rapport d'erreur",
	"menu-send_message" => "Merci d'envoyer ceci au propriétaire du site :",
	"homepage" => "Page d'accueil",
	"menu-open" => "Signaler l'erreur",
	"error_messages" => array(
		"400" => "Bad Request: \"The 400 (Bad Request) status code indicates that the server cannot or will not process the request due to something that is perceived to be a client error (e.g., malformed request syntax, invalid request message framing, or deceptive request routing).\" - <a href=\"https://tools.ietf.org/html/rfc7231#section-6.5.1\" target=\"_blank\">ietf.org</a>",
		"401" => "Unauthorized: Your access is denied. The password you entered is incorrect or you are trying to use something you are not allowed to.",
		"403" => "Forbidden: You are not allowed to look at that. Wherever you are, it probably is a file that will just create a lot of errors if used alone. or something you shouldn't use at all.",
		"404" => "Not Found: Nous ne pouvons pas trouver la page. La fiche a peut être changé de nom, été déplacée dans une autre catégorie ou supprimée. Si vous ne recherchiez pas une fiche, vous vous êtes probablement trompé d'endroit.",
		"408" => "Request Timeout: It seems you have a problem right now. Please come back later.",
		"414" => "URI Too Long: The URL is too long. Don't know what you are trying to do, but it certainly isn't right.",
		"Unknown error" => "Nous ne pouvons pas trouver l'erreur ou aucun message d'erreur n'a été préparé pour ce cas."
	)
);

$lang['api'] = array(
	"error" => "Erreur",
	"error-type" => "Type de la fiche manquant.",
	"error-type-notfound" => "Type de la fiche inexistant.",
	"error-name" => "Nom de la fiche manquant.",
	"error-name-size" => "Nom trop court ou trop long. Rappel : La limite maximale est de 35 caractères et minimale de 1 caractère.",
	'error-name-alreadyexist' => 'La fiche existe déjà.',
	"error-name-notfound" => "Nom de la fiche inexistant.",
	"error-pass" => "Mot de passe manquant.",
	"error-pass-wrong" => "Mot de passe incorrect.",
	"error-group" => "Groupe de la fiche manquant.",
	"error-group-size" => "Le nom du groupe est trop court ou trop long. Rappel : La limite maximale est de 25 de caractères et minimale de 1 caractère.",
	"error-text-size" => "Le texte est trop court ou trop long. Rappel : La limite maximale est de 1 000 000 de caractères et minimale de 10 caractères.",
	"success" => "Succès",
	"success-edit" => "La fiche a bien été modifiée.",
	"success-add" => "La fiche a bien été crée."
)
?>
