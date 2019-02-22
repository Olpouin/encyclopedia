<?php
$lang = array(
	'help' => 'Help',
	'close' => 'Close',
	'language' => "Language",
	'homepage-top_message' => 'The gallery has a total of [TOTALPAGES] pages.',
	'homepage-search_input' => 'Search a card...',
	'homepage-search_button' => 'Search',
	'homepage-sourcecode' => 'Code on GitHub',
	'cookie-warning' => 'By changing the default settings, you allow the use of cookies.',
	'homepage-prefs-title' => 'Settings',
	'homepage-prefs-nightmode' => 'Night mode',
	'homepage-prefs-needsReload' => 'You will have to reload the page to change this setting.',
	'homepage-prefs-confirm_changes' => 'Confirm changes',
	'edition-password' => 'Password',
	'edition-info-example_title' => 'Example',
	'edition-hide_card' => 'Hide the card (Not shown in the navigation bar)',
	'edition-group_placeholder' => 'Card\'s group',
	'notif-show' => 'Show card',
	'footer-edit_page' => 'Edit card',
	'footer-top' => 'Go to top',
	'toc' => 'Table of content'
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
	'img' => 'Picture',
	'url' => 'Link',
	'sound' => 'Sound',
	'video' => 'Video',
	'quote' => 'Quote',
	'hr' => 'Horizontal bar',
	'tab' => 'Tab'
);
$lang['error'] = array(
	"menu-close_message" => "Close the error report",
	"menu-send_message" => "Please send the following to the owner of the website:",
	"homepage" => "Homepage",
	"menu-open" => "Report error",
	"error_messages" => array(
		"400" => "Bad Request: \"The 400 (Bad Request) status code indicates that the server cannot or will not process the request due to something that is perceived to be a client error (e.g., malformed request syntax, invalid request message framing, or deceptive request routing).\" - <a href=\"https://tools.ietf.org/html/rfc7231#section-6.5.1\" target=\"_blank\">ietf.org</a>",
		"401" => "Unauthorized: Your access is denied. The password you entered is incorrect or you are trying to use something you are not allowed to.",
		"403" => "Forbidden: You are not allowed to look at that. Wherever you are, it probably is a file that will just create a lot of errors if used alone. or something you shouldn't use at all.",
		"404" => "Not Found: We can't find this page. The entry may have changed name, been moved to another category or even removed. If you weren't looking for a card, you are somewhere you should not be.",
		"408" => "Request Timeout: It seems you have a problem right now. Please come back later.",
		"414" => "URI Too Long: The URL is too long. Don't know what you are trying to do, but it certainly isn't right.",
		"Unknown error" => "We can't find what error you got or (most likely) there are no error message prepared for this case. Sorry."
	)
);

$lang['api'] = array(
	"error" => "Error",
	"error-type" => "Can't find a card : Parameter 'type' missing.",
	"error-type-wrong" => "Can't find a card : Parameter 'type' sent doesn't exist.",
	"error-name" => "Can't find a card : Parameter 'name' missing.",
	"error-name-wrong" => "Can't find a card : Parameter 'name' sent doesn't exist.",
	"error-pass" => "Can't edit card : Password missing.",
	"error-pass-wrong" => "Can't edit card : Wrong password.",
	"error-group" => "Can't edit card : Parameter 'groupe' missing.",
	"error-group-wrong" => "Can't edit card : Group's name is too long. Reminder : The limit is 25 characters.",
	"error-text-wrong" => "Can't edit card : Text too long or too short. Reminder : The upper limit is 1 000 000 characters.",
	"success" => "Card edited",
	"success-message" => "The card was successfully edited."
)
?>
