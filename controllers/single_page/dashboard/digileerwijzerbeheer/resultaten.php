<?php
namespace Concrete\Package\Digileerwijzer\Controller\SinglePage\Dashboard\Digileerwijzerbeheer;

use \Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Legacy\Loader;
use Concrete\Core\Page\Page;
use Concrete\Core\Form\Service\Form;
use Concrete\Core\Application\Service\UserInterface;
use Concrete\Package\Digileerwijzer\Models\DglwModel;
use Concrete\Package\Digileerwijzer\Models\DglwResult;


class Resultaten extends DashboardPageController {

	public function view()
	{
		//$this->setIndex();

	
		$this->set('form', new Form());
		$this->set('ih', new UserInterface());
		$this->set('c', Page::getCurrentPage());
		$sa=$this->getResultaten();

		$this->set("resultaten",$sa);

	}
	
	public function show($eID) {
		$s=new DglwResult();
		$this->set("team",$s->getInvulPersoonByEid($eID));
		$this->set("resultaten",$s->getResultatenByEid($eID));
		
		
	}
	
	public function excel() {
 		ini_set('memory_limit', -1);
		set_time_limit(0);
		$s=new DglwResult();
		
		header("Content-Type: application/vnd.ms-excel");
		header("Cache-control: private");
		header("Pragma: public");
		$date = date('Ymd');
		header("Content-Disposition: inline; filename=digileerwijzer_report_{$date}.xls");
		header("Content-Title: Digileerwijzer Report - Run on {$date}");
 	 
		$sa=$this->getResultaten();

		
		echo '<meta http-equiv="Content-Type" content="text/html; charset=' . APP_CHARSET . '">';
		echo("<table border='1'><tr>");
		echo("<td><b>".t('naam')."</b></td>");
		echo("<td><b>".t('email')."</b></td>");
		echo("<td><b>".t('school')."</b></td>");
		echo("<td><b>".t('locatie')."</b></td>");
		echo("<td><b>".t('team')."</b></td>");	
		
		//
		
		echo("<td><b>".t('FK')."</b></td>");
		echo("<td><b>".t('FA')."</b></td>");
		echo("<td><b>".t('FC')."</b></td>");
			
		echo("<td><b>".t('FS')."</b></td>");
		echo("<td><b>".t('VK')."</b></td>");
		echo("<td><b>".t('VA')."</b></td>");
		echo("<td><b>".t('VC')."</b></td>");
			
		echo("<td><b>".t('VS')."</b></td>");
		echo("<td><b>".t('SK')."</b></td>");
		echo("<td><b>".t('SA')."</b></td>");
		echo("<td><b>".t('SC')."</b></td>");
			
		echo("<td><b>".t('SS')."</b></td>");
		echo("<td><b>".t('OK')."</b></td>");
		echo("<td><b>".t('OA')."</b></td>");
		echo("<td><b>".t('OC')."</b></td>");
			
		echo("<td><b>".t('OS')."</b></td>");
		echo("<td><b>".t('MK')."</b></td>");
		echo("<td><b>".t('MA')."</b></td>");
		echo("<td><b>".t('MC')."</b></td>");
			
		echo("<td><b>".t('MS')."</b></td>");
		echo("<td><b>".t('PK')."</b></td>");
		echo("<td><b>".t('PA')."</b></td>");
		echo("<td><b>".t('PC')."</b></td>");	
		echo("<td><b>".t('PS')."</b></td>");		
		
		echo("<td><b>".t('GEM K')."</b></td>");		
		echo("<td><b>".t('GEM A')."</b></td>");
		echo("<td><b>".t('GEM C')."</b></td>");
		echo("<td><b>".t('GEM S')."</b></td>");	
		
		echo("<td><b>".t('GEM 1')."</b></td>");
		echo("<td><b>".t('GEM 2')."</b></td>");
		echo("<td><b>".t('GEM 3')."</b></td>");
		echo("<td><b>".t('GEM 4')."</b></td>");		
		echo("</tr>");
		foreach ($sa as $row) {
			$t=$s->getInvulPersoonByEid($row['inschrijfID']);
			
			echo("<tr>");
			echo ("<td>".$row['naam']."</td>");
			echo ("<td>".$row['email']."</td>");
			echo ("<td>".$t['school']."</td>");
			echo ("<td>".$t['locatienaam']."</td>");
			echo ("<td>".$t['sectienaam']."</td>");
			
			//Absolute waarde toevoegen
			foreach (array('FK','FA','FC','FS','VK','VA','VC','VS','SK','SA','SC','SS','OK','OA','OC','OS','MK','MA','MC','MS','PK','PA','PC','PS') as $onderdeel) {
				$r=\Concrete\Package\Digileerwijzer\Models\DglwResult::getResultByWeging($row['eID'], $onderdeel.'%',0);
				echo "<td>".$r[0]['result']."</td>";
				
				
			}
			
			
			// Relative gemiddelde toevoegen
			$k_Gem=0;
			$a_Gem=0;
			$c_Gem=0;
			$s_Gem=0;
			
			$rGemiddeld= \Concrete\Package\Digileerwijzer\Models\DglwResult::getResultByWeging($row['eID'], '%K',0);
			foreach ($rGemiddeld as $rGemRow) {
				$k_Gem+=$rGemRow['result'];
			}
			echo "<td>" .round($k_Gem/6) ."%</td>";
			
			$rGemiddeld= \Concrete\Package\Digileerwijzer\Models\DglwResult::getResultByWeging($row['eID'], '%A',0);
			foreach ($rGemiddeld as $rGemRow) {
				$a_Gem+=$rGemRow['result'];
			}
			echo "<td>". round($a_Gem/6) ."%</td>";
			
			$rGemiddeld= \Concrete\Package\Digileerwijzer\Models\DglwResult::getResultByWeging($row['eID'], '%C',0);
			foreach ($rGemiddeld as $rGemRow) {
				$c_Gem+=$rGemRow['result'];
			}
			echo "<td>" .round($c_Gem/6)."%</td>";
			
			$rGemiddeld= \Concrete\Package\Digileerwijzer\Models\DglwResult::getResultByWeging($row['eID'], '%S',0);
			foreach ($rGemiddeld as $rGemRow) {
				$s_Gem+=$rGemRow['result'];
			}
			echo "<td>". round($s_Gem/6) ."%</td>";

			$s_Gem=0;
			$rGemiddeld= \Concrete\Package\Digileerwijzer\Models\DglwResult::getResultByWeging($row['eID'], '%1',0);
			foreach ($rGemiddeld as $rGemRow) {
				$s_Gem+=$rGemRow['result'];
			}
			echo "<td>". round($s_Gem/5) ."%</td>";			

			$s_Gem=0;
			$rGemiddeld= \Concrete\Package\Digileerwijzer\Models\DglwResult::getResultByWeging($row['eID'], '%2',0);
			foreach ($rGemiddeld as $rGemRow) {
				$s_Gem+=$rGemRow['result'];
			}
			echo "<td>". round($s_Gem/5) ."%</td>";			

			$s_Gem=0;
			$rGemiddeld= \Concrete\Package\Digileerwijzer\Models\DglwResult::getResultByWeging($row['eID'], '%3',0);
			foreach ($rGemiddeld as $rGemRow) {
				$s_Gem+=$rGemRow['result'];
			}
			echo "<td>". round($s_Gem/5) ."%</td>";

			$s_Gem=0;
			$rGemiddeld= \Concrete\Package\Digileerwijzer\Models\DglwResult::getResultByWeging($row['eID'], '%4',0);
			foreach ($rGemiddeld as $rGemRow) {
				$s_Gem+=$rGemRow['result'];
			}
			echo "<td>". round($s_Gem/5) ."%</td>";			
			
			echo("</tr>\r\n");
		}

		echo("</table>");
		exit;
		
	}

	
	private function getResultaten() {
		$s=new DglwResult();
		return $s->getResultaten();
		
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
