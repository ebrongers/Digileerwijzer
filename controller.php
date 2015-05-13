<?php
namespace Concrete\Package\Digileerwijzer;

use Package;
use BlockType;

use Concrete\Core\Page\Single as SinglePage;
use Concrete\Core\Page\Type\Type as PageType;
use Concrete\Core\Page\Page;
use PageTheme;
use BlockTypeSet;
use Route;
use CollectionAttributeKey;
use Concrete\Core\Attribute\Type as AttributeType;
use Config;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package
{
	protected $pkgHandle = 'digileerwijzer';
	protected $appVersionRequired = '5.7.1';
	protected $pkgVersion = '201504170712';
	

	
	
	public function getPackageDescription()
	{
		return t("Adds Proracom Webdevelopment Digileerwijzer Application.");
	}
	
	public function getPackageName()
	{
		return t("Digileerwijzer applicatie");
	}
	
	public function install()
	{
		$pkg = parent::install();


		$this->configurePackage($pkg);
		

	}
	
	public function upgrade()
	{
		$pkg = $this;
		
		parent::upgrade();
		$this->configurePackage($pkg);
		
	}
	
	public function configurePackage($pkg) {
		PageTheme::add('digileerwijzer', $pkg);
		//BlockType::installBlockTypeFromPackage('DigileerwijzerInlog', $pkg);
		$this->addSinglePages($pkg);
		$this->addDashboardPage($pkg);		
		
	}
	private function addSinglePages($pkg) {
		$this->addSinglePage('/digileerwijzer',$pkg);

	}
	
	private function addSinglePage($fullPath,$pkg) {

		$sp = SinglePage::add($fullPath, $pkg);
		
	}
	public function addDashboardPage($pkg)
	{
		$dashboardPaths = array(
				array(
						'path' => '/dashboard/digileerwijzerbeheer',
						'cName' => 'Digileerwijzer',
						'cDescription' => 'Applicatie voor Digileerwijzer'
				),
				array(
						'path' => '/dashboard/digileerwijzerbeheer/suggesties',
						'cName' => 'Suggesties',
						'cDescription' => 'Digileerwijzer suggesties'
				),
				array(
						'path' => '/dashboard/digileerwijzerbeheer/scholen',
						'cName' => 'Scholen',
						'cDescription' => 'Digileerwijzer scholen'
				),
				array(
						'path' => '/dashboard/digileerwijzerbeheer/resultaten',
						'cName' => 'Resultaten',
						'cDescription' => 'Digileerwijzer resultaten'
				)				
		);
		foreach ($dashboardPaths as $pathInfo) {
			$page = Page::getByPath($pathInfo['path']);
			if (! $page->isError())
				$page->delete();
			if ($page->isError()) {
				$page = SinglePage::add($pathInfo['path'], $pkg);
			}
			$page->update($pathInfo);
		}
	}	

	
	public function on_start() {
		
		Route::register('/digileerwijzer/API/getlocaties/{sID}', function($sID) {
			$sID = intval($sID);

			if ($sID != 0 )
				$res=json_encode(Models\DglwModel::getLocaties($sID));
			else 
				throw new Exception("72: Wrong parameters",401);
			return $res;
		});
		Route::register('/digileerwijzer/API/getSectiesPerLocatie/{sID}', function($sID) {
			$sID = intval($sID);
		
			if ($sID != 0 )
				$res=json_encode(Models\DglwModel::getSectiesPerLocatie($sID));
			else
				throw new Exception("81: Wrong parameters",401);
			return $res;
		});		

	}
	
}