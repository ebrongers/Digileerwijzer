<?php
use Concrete\Core\Page\Page;
/* @var $subpage Concrete\Core\Page\Page */
?>
<div>
	<ul>
		<?php foreach($subpages AS $subpage): ?>
			<li>
				<a href="<?= BASE_URL."/index.php".$subpage->getCollectionPath() ?>"><?= $subpage->getCollectionName() ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>