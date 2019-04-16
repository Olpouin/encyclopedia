<?php
$typeFormatted = ucfirst($config['types'][$type]);
$infoContent['g_title'] = $typeFormatted;
$cardsList = $groupTOC = "";

$groups = $db->prepare("SELECT groupe FROM {$config['database']['table']} WHERE hidden = 0 AND type = ? ORDER BY groupe");
$groups->execute(array($type));
$groupsArray = $groups->fetchAll(PDO::FETCH_COLUMN);
$groupsArray = array_unique($groupsArray);

foreach ($groupsArray as $group) {
	$cards = $db->prepare("SELECT name FROM {$config['database']['table']} WHERE hidden = 0 AND type = ? AND groupe = ? ORDER BY name");
	$cards->execute(array($type,$group));
	$cardsArray = $cards->fetchAll(PDO::FETCH_ASSOC);
	$cardsPerGroup = count($cardsArray);

	if ($cardsPerGroup > 4) $class = "largeFlexdata";
	else $class = "";

	$groupURL = urlencode($group);

	$groupTOC .= "<a href=\"#{$groupURL}\">{$group} ({$cardsPerGroup})</a>";

	$cardsList .= "<h2 id=\"{$groupURL}\">".$group."</h2>";
	foreach ($cardsArray as $card) {
		$cardsList .= "<a href=".hrefGen($type, $card['name'])." style=\"margin-right:20px;\">".$card['name']."</a>";
	}
}

$content['card'] = <<<TYPE
<h1>{$typeFormatted}</h1>
<br><br>
<div class="center navMenuGroups">
	{$groupTOC}
</div>
<p><b>Texte de description ici !</b> Beatae autem similique nulla et velit voluptatum magni vel. Esse in quo esse voluptates et totam et. Laborum qui ratione blanditiis occaecati. Temporibus architecto veritatis exercitationem qui rerum non minus. Commodi nostrum mollitia est voluptatum maiores quia non. Optio dolores eligendi quod magni dolorum aut. Omnis in cum tempora magni. Molestias et ratione totam rerum quia minus et. Veritatis dolor asperiores et labore hic. Voluptatem soluta ad quae sed dolorem. Est voluptatum minima vitae qui. Illum aut laborum dolores. Laborum error aut doloremque. Et est vel placeat. Adipisci tenetur quasi iusto consequatur dolore. Consequatur magni voluptatem et numquam aut laudantium. Neque quis architecto quia ipsam et. Amet impedit nisi quia. Eum consequatur omnis aliquam et dolores dolor sint ducimus. Omnis accusantium qui animi voluptate. Consequuntur quo ut modi temporibus. In quia voluptate voluptas rerum aut laboriosam. Temporibus est enim corporis quia magnam qui sint. Laudantium quasi beatae voluptas. Possimus a ea aut. Repellendus hic magnam est. Sit consequatur voluptatem aut illo fugiat quas nisi et. Cupiditate suscipit sed totam. Hic minus itaque dicta maxime velit dicta. Debitis voluptas eveniet eos. Quis et itaque recusandae doloribus perferendis quia id. Porro error harum delectus. Porro porro quas saepe earum vel enim. Ipsam nostrum ut dolores non delectus ut eveniet architecto. Rerum sit aliquid consequatur corporis deserunt labore. Et pariatur doloribus labore repellendus dolor. Ut autem velit quod eligendi dolorem et aperiam. Doloremque adipisci quam enim. Sunt omnis quaerat a quae praesentium minus eum atque. Necessitatibus laborum porro dolorem iusto velit nulla vel. Delectus suscipit nihil necessitatibus molestiae asperiores dolores vero. Eos officia blanditiis perferendis aut nihil. Sit enim possimus autem tempora tempora nisi dolores consequatur. Voluptas alias dolor illo.
</p>
<div>
	{$cardsList}
</div>
TYPE;
?>
