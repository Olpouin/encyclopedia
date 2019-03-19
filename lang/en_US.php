<?php
$lang = array(
	'help' => 'Help',
	'close' => 'Close',
	'language' => "Language",
	'password' => 'Password',
	'wrong' => 'Wrong',
	'send' => 'Send',
	'optional' => 'Optional',
	'homepage-top_message' => 'The gallery has a total of [TOTALPAGES] pages.',
	'homepage-search_input' => 'Search a card...',
	'homepage-search_button' => 'Search',
	'homepage-sourcecode' => 'Code on GitHub',
	'cookie-warning' => 'By changing the default settings, you allow the use of cookies.',
	'homepage-prefs-title' => 'Settings',
	'homepage-prefs-nightmode' => 'Night mode',
	'homepage-prefs-editor' => 'Text editor',
	'homepage-prefs-dyslexic' => 'Dyslexic mode',
	'homepage-prefs-confirm_changes' => 'Confirm changes',
	'edition-info-example_title' => 'Example',
	'edition-hide_card' => 'Hide the card (Not shown in the navigation bar)',
	'edition-group_placeholder' => 'Card\'s group',
	'edition-name_placeholder' => 'Card\'s name',
	'edition-type_placeholder' => 'Card\'s type',
	'edition-gene-deflang_placeholder' => 'Default language',
	'edition-gene-sitename_placeholder' => 'Site\'s name',
	'edition-gene-defimg_placeholder' => 'Infobox default image',
	'notif-show' => 'Show card',
	'footer-edit_page' => 'Edit card',
	'footer-show_page' => 'Return to the card',
	'footer-top' => 'Go to top',
	'toc' => 'Table of content',
	'admin-title' => 'Administration interface',
	'admin-createcard' => 'Create a card'
);
$lang['editor-bar'] = array(
	'title1' => 'Title 1',
	'title2' => 'Title 2',
	'title3' => 'Title 3',
	'title4' => 'Title 4',
	'title5' => 'Title 5',
	'title6' => 'Title 6',
	'italic' => 'Italic',
	'bold' => 'Bold',
	'strikethrough' => 'Strikethrough',
	'underlined' => 'Underlined',
	'color' => 'Color',
	'clear' => 'Clear format',
	'img' => 'Picture',
	'url' => 'Link',
	'sound' => 'Sound',
	'video' => 'Video',
	'quote' => 'Quote',
	'hr' => 'Horizontal bar',
	'tab' => 'Tab',
	'ib' => 'Infobox',
	'ibd' => 'Infobox data',
	'help-dsc' => 'Description'
);
$lang['error'] = array(
	"menu-send_message" => "Error message:",
	"error_messages" => array(
		"400" => "Bad Request: \"The 400 (Bad Request) status code indicates that the server cannot or will not process the request due to something that is perceived to be a client error (e.g., malformed request syntax, invalid request message framing, or deceptive request routing).\" - <a href=\"https://tools.ietf.org/html/rfc7231#section-6.5.1\" target=\"_blank\">ietf.org</a>",
		"401" => "Unauthorized: Your access is denied. The password you entered is incorrect or you are trying to use something you are not allowed to.",
		"403" => "Forbidden: You are not allowed to look at that. Wherever you are, it probably is a file that will just create a lot of errors if used alone. or something you shouldn't use at all.",
		"404" => "Not Found: We can't find this page. The entry may have changed name, been moved to another category or even removed. If you weren't looking for a card, you are somewhere you should not be.",
		'404-1' => 'The type you are searching for does not exist.',
		'404-2' => 'The card you are searching for does not exist.',
		"408" => "Request Timeout: It seems you have a problem right now. Please come back later.",
		"414" => "URI Too Long: The URL is too long. Don't know what you are trying to do, but it certainly isn't right.",
		"Unknown error" => "We can't find what error you got or (most likely) there are no error message prepared for this case. Sorry."
	)
);

$lang['api'] = array(
	"titles" => [
		"error" => "Error",
		"serverror" => "Server error",
		"success" => "Success"
	],
	"successes" => [
		"admin-config" => "General parameters has been changed",
		"add" => "The card has been created"
	],
	"isset" => "Missing variable: ",
	"errorserv-lang" => "The language does not exit",
	"error-pass" => "Mot de passe incorrect",
	"admin-config" => [
		"name-size" => "Website name too short or too long (1 < name < 20)",
		"image-size" => "Images' URL too short or too long (7 < URL < 100"
	],
	"error-type-notfound" => "Can't find a card : Parameter 'type' sent doesn't exist.",
	"error-name-size" => "Name too long or too short. Reminder: The upper limit is 35 characters.",
	'error-name-alreadyexist' => 'The card already exist.',
	"error-name-notfound" => "Parameter 'name' sent doesn't exist.",
	"error-pass-wrong" => "Wrong password.",
	"error-group-size" => "Group's name is too long. Reminder: The limit is 25 characters.",
	"error-text-size" => "Text too long or too short. Reminder: The upper limit is 1 000 000 characters.",
	"success" => "Success",
	"success-edit" => "The card was successfully edited."
)
?>
