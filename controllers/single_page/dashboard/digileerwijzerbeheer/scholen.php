<?php
namespace Concrete\Package\Digileerwijzer\Controller\SinglePage\Dashboard\Digileerwijzerbeheer;

use \Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Legacy\Loader;
use Concrete\Core\Page\Page;
use Concrete\Core\Form\Service\Form;
use Concrete\Core\Application\Service\UserInterface;
use Concrete\Package\Digileerwijzer\Models\DglwModel;

class Scholen extends DashboardPageController {

	public function view()
	{
		//$this->setIndex();

	
		$this->set('form', new Form());
		$this->set('ih', new UserInterface());
		$this->set('c', Page::getCurrentPage());

		$this->set("scholen",$this->getScholen());

	}
	public function detail($sID) {
		$this->set("school",$this->getSchool($sID));
		$this->set("locaties",$this->getLocaties($sID));
	}
	
	public function editsuggestie($sugId=0) {
		$s=new DglwModel();
		$sA=$s->getSuggestieByCode($sugId);
		$this->requireAsset('redactor');		
		$this->set("suggestie",$sA);
	}
	public function toevoegen($sID=0) {
		
		if ($sID!=0)
		{
			
			$m=$this->getSchool($sID);
			$this->set('school',$m);
		}
		
		
	}
	public function locatie_toevoegen($sID) {
		$m=new DglwModel();
		if ($sID!=0)
		{
				
			$m=$this->getSchool($sID);
			$this->set('school',$m);
		}		

	}
	
	public function locatie_toevoegenOpslaan() {
		$locatieNaam=$this->post('locatienaam');
		$sID=$this->post('sID');
		if (strlen($locatieNaam) >0 ) {
			$m=new DglwModel();
			$m->addLocatie($locatieNaam,$sID);
		}
		$this->redirect('/dashboard/digileerwijzerbeheer/scholen/detail/'.$sID);
	}
	public function locatie_verwijderen($lID=0,$sID){
		//23/7
		$m=new DglwModel();
		$m->deleteLocatie($lID,$sID);
		$this->redirect('dashboard/digileerwijzerbeheer/scholen/detail/'.$sID);
	}
	public function locatieWijzigen($lID=0,$sID) {
		$m=new DglwModel();
		$this->set('locatie',$m->getLocatie($lID));
		$this->set('secties',$m->getSecties());
		$this->set('sID',$sID);
		
		
	}
	public function locatieWijzigenOpslaan() {
		$m=new DglwModel();

		$m->updateLocatie($this->post('naam'),$this->post('lID'));
		
		
		$this->redirect('/dashboard/digileerwijzerbeheer/scholen/detail/'.$this->post('sID'));
	}
	public function toevoegen_opslaan() {
		$m=new DglwModel();
		$naam=$this->post('naam');
		$actief=$this->post('actief');
		$sID=$this->post('sID');
		
		echo $sID;
		if (isset($sID) && $sID!=0) {
			$id=$sID;
			$ns=$m->updateSchool($sID,$naam,$actief);
			$this->redirect('/dashboard/digileerwijzerbeheer/scholen/detail',$id);
			
			
		}
		else {
		
			$id=$m->newSchool($naam,$actief);
		}
		$this->set("schoolId",$id);
		$this->set("school",$naam);
		$this->set("actief",$actief);
		$this->set("locaties",$m->getLocaties($sId))	;
		//$this->locaties_wijzigen();
		
	}
	
	public function locaties_wijzigen() {
		$m=new DglwModel();
		
		$sId=$this->post('schoolId');
		
		$m->addLocatie($this->post('locatienaam'),$sId);
		
		$this->set("schoolId",$sId);	
		$this->set("locaties",$m->getLocaties($sId))	;
		
	}
	
	private function getSchool ($sID) {
		$m=new DglwModel();
		return $m->getSchool($sID);
	}
	private function getLocaties ($sID) {
		$m=new DglwModel();
		return $m->getLocaties($sID);
	}
	

	public function saveSuggestie() {
		$s=new DglwModel();
		$suggestie['code']=$this->post('code');
		$suggestie['sText']=$this->post('sText');
		$suggestie['lText']=$this->post('lText');
		
		
	}
	
	private function getScholen() {
		$m=new DglwModel();
		return $m->getScholen(0);
		
		
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
