<?php
namespace Concrete\Package\Digileerwijzer\Controller\SinglePage\Dashboard\Digileerwijzerbeheer;

use \Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Legacy\Loader;
use Concrete\Core\Page\Page;
use Concrete\Core\Form\Service\Form;
use Concrete\Core\Application\Service\UserInterface;
use Concrete\Package\Digileerwijzer\Models\DglwModel;

class Suggesties extends DashboardPageController {

	public function view()
	{
		//$this->setIndex();

	
		$this->set('form', new Form());
		$this->set('ih', new UserInterface());
		$this->set('c', Page::getCurrentPage());
		$sa=$this->getSuggesties();

		$this->set("suggesties",$sa);

	}
	
	public function editsuggestie($sugId=0) {
		$s=new DglwModel();
		$sA=$s->getSuggestieByCode($sugId);
		$this->requireAsset('redactor');		
		$this->set("suggestie",$sA);
	}
	
	private function getSuggesties() {
		$s=new DglwModel();
		return $s->getSuggesties();
		
	}
	public function saveSuggestie() {
		$s=new DglwModel();
		$suggestie['code']=$this->post('code');
		$suggestie['sText']=$this->post('sText');
		$suggestie['lText']=$this->post('lText');
		
		
	}
	
	
/* 	public function groep($gID) {
		$this->set("actie","groep");
		$this->setProductGroep($gID);
		$this->setProductenPerGroep($gID);
	}
	
	
	
	public function product($pid) {
		$this->setProduct($pid);
		$gID = $this->getProductGroepByPID($pid);
		$this->setProductGroep($gID);
		$this->set("actie","product");
	}
	
	public function add_product() {
		$pdc=new modelpdc();
		$pdc->addProduct($_POST['pname'],$_POST['gID']);
		$this->redirect('dashboard/dienstict/pdc/groep/'.$_POST['gID']);
	}
	
	public function save_product() {
		$pdc=new modelpdc();
		$product['pcode']=$_POST['pcode'];
		$product['naam']=$_POST['naam'];
		$product['gid']=$_POST['gid'];
		$product['omschrijving']=$_POST['omschrijving'];
		$pdc->saveProduct($product);
		$this->redirect('dashboard/dienstict/pdc/product/'.$_POST['pid']);
	}
	
// 	public function example_submit() {
// 		// Load validation helper
// 		$token = Loader::helper('validation/token');
// 		// Check
// 		if (empty($_POST['example_value']))
// 			$this->error->add(t('Example value may not be empty.'));
// 		// Check token
// 		if (!$token->validate('example_submit'))
// 			$this->error->add($valt->getErrorMessage());
// 	}
	
	private function setIndex() {
		$pdc=new modelpdc();
		
		
		$this->set("productgroepen",$pdc->getIndex());
		
	}
	
	private function setProductenPerGroep($gID) {
		$pdc=new modelpdc();
		$this->set("producten",$pdc->getProductenPerGroep($gID));
	}
	private function setProductGroep($gID) {
		$pdc=new modelpdc();
		$this->set("productgroep",$pdc->getProductGroep($gID));
	}
	private function setProduct($pid) {
		$pdc=new modelpdc();
		$this->set("product",$pdc->getProduct($pid));
	}
	private function getProductGroepByPID($pid) {
		$pdc=new modelpdc();
		return $pdc->getProductGroepByPID($pid);
	} */
}
