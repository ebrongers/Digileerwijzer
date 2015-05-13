<?php
namespace Concrete\Package\Digileerwijzer\Controller\SinglePage\Dashboard;

use \Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Page\Page;

class Digileerwijzerbeheer extends DashboardPageController
{

	function view()
	{

		
		$page = Page::getByPath('/dashboard/digileerwijzerbeheer');
		$subpages = $page->getCollectionChildren();
		$this->set('subpages', $subpages);
	}
}
