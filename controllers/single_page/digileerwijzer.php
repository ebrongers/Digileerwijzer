<?php
namespace  Concrete\Package\Digileerwijzer\Controller\SinglePage;

use \Concrete\Core\Page\Controller\PageController;
use Loader;
use Exception;
use \Concrete\Package\Digileerwijzer\Models;
use Concrete\Package\Digileerwijzer\Models\DglwModel;
use Concrete\Package\Digileerwijzer\Models\DglwResult;
use Concrete\Core\Routing\Redirect;

require_once('tcpdf.php');


class digileerwijzer extends PageController {

		/**
		 * De view functie.
		 */
		public function view() {
	
		}
	
		/**
		 * Q is de functie voor de vraag.
		 * 
		 * @param g
		 * @param v
		 */
		public function q($g=0,$v=0) {
	
			$vO=new DglwModel();
							
			/***
			 * Initiatie van de vragen.
			 */
			if ($g==0 && $v==0) {
				$g=1;
				$pA=$this->post();

				if ( $pA['sectie']!='' && $pA['code']=='DBZH78E'){
					
					
				
					$inschrijfID=$vO->setPersData($pA);
					$eID=$vO->newEnquete($inschrijfID);
					$_SESSION['eID']=$eID;
				}
				else  $this->redirect('/');
					
			}
			else {
				$eID=$this->checkEid();
			}
	
	
			if ($v==0) {
				$this->set("intro",$vO->getGroupIntro($g));
		
			}
			else {
			
				$this->set("vragen",$vO->getStellingen($g,$v));
	
			}
			$this->requireAsset('javascript', 'jquery');
			$this->set("enqueteID",$_SESSION['eID']);
			$this->set("vraagGroep",$vO->getVraagGroep($g));
			$this->set("vraagGroepID",$g);
			$this->set("vraag",$v);
			$this->set("grouptrail",$vO->getVraagGroepTrail());
			
			
			
			$this->set("vraagtrail",array_merge(array(array('vid'=>0,'naam'=>"intro")),$vO->getVraagTrail($g)));
			
			
			if ($this->post('stelling')) $vO->setStellingData($this->post('eID'),$this->post('stelling'));								// opslaan van het antwoord
			// previous and next question bepaling.
			$next_vraag = $v+1;		
			if ( $next_vraag > $vO->getAantalVragen( $g ) ) {
				$next_vraag = 0; 
				
				if ($g > $vO->getAantalGroepen() ) {
					//$rd= BASE_URL.$this->action("results");
					$this->redirect('digileerwijzer/opslaan/'.$eID);
					exit;
					
				}
				$g++;
				
			}
			
			$prevs_groep=($v-1 < 0 )? $g-1 : $g=$g ;			
			$this->set("next_vraag",$next_vraag );
			$this->set("prev_vraag",($v-1 > 0 )? $v-1 : $vO->getAantalVragen($g-1) );
			$this->set("current_vraag",$v);
			
			$this->set("next_groep",$g) ;
			$this->set("prevs_groep",$prevs_groep);		
			$this->set("action",'q');
		}
	

		/**
		 * Functie voor het bepalen van de visie.
		 * 
		 * @param unknown $eID
		 * @return Ambigous <multitype:, string>
		 */
		private function getVisie($eID) {

			$vO=new DglwModel();
			$rO=new DglwResult();

			$vA=array('K','A','C','S');
				
			$gVisie=array();
				
				
			// grijze balk settings
				
				
			foreach($vA as $visie) {
				$gVisie[$visie]['value']= $rO->getGemProcentOfStelling($eID,'%'.$visie);
				$gVisie[$visie]['grey']="";
				if ($gVisie[$visie]['value'] < 25 ) $gVisie[$visie]['grey'] =  'grey';
			
			}	

			return $gVisie;
		}
		
		/**
		 * Laat de resultaten van de enquete zien. De resultaten worden gesorteerd op
		 * relevantie.
		 * 
		 * @param eID
		 */
		public function resultaten($eID=0) {
			
			$vO=new DglwModel();
			
			
			if ($eID==0)  {
				$eID=$this->post('$eID');
			}
			

			$gVisie=$this->getVisie($eID);
			$gMedia=$this->getMedia($eID);

			
			$this->set("grouptrail",$vO->getVraagGroepTrail());	
			$this->set('visie',$this->aa_sort($gVisie,'value',SORT_DESC));
			$this->set('action','result');
			$this->set('eID',$eID);
		
		}
	
		/**
		 * functie om de media te bepalen.
		 * 
		 * @param unknown $eID
		 * @return multitype:NULL
		 */
		private function getMedia($eID) 
		{
			$rO=new DglwResult();  				// result Object
			$vA=array('1','2','3','4');
				
			$gMedia=array();
			foreach ($vA as $media) {
				$gMedia[$media]=$rO->getGemProcentOfStelling($eID,'%'.$media);
			}

			return $gMedia;
		}
		/**
		 * haalt de TOP $top uit de media
		 * @param unknown $eID
		 * @param unknown $top
		 * @return multitype:
		 */
		private function getMediaTop($eID,$top)
		{
			$r=$this->getMedia($eID);

			$r=$this->aa_sort($r,'',SORT_DESC);
			
			$r=array_slice($r,0,$top,TRUE);
			
			return $r;
			
		}


		/**
		 * Geeft de details weer van een pagina
		 */
		public function details($a,$eID)
		{
			
			$rO=new DglwResult();  				// result Object
			$this->set('eID',$eID);

			$this->set('action','details');
			$this->set('prec',$rO->getGemProcentOfStelling($eID,'%'.$a));
			$this->set('p',$a);
			
		}
		
		/**
		 * Haalt de suggesties uit de database.
		 * Zie document 2014-12-17
		 * 
		 * @param a
		 * @param eID
		 */
		public function suggesties($eID,$detail=0)
		{

			$rO=new DglwResult();
			$sug=$this->getSuggestiesScore($eID);
			$mT=$this->getMediaTop($eID, 2);
			
			$this->set('detail',$detail);
			$this->set('action','suggesties');
			
			$this->set("mT",$mT);
			//$this->set("p",$a);

			$this->set('suggesties',$sug);
			$this->set('eID',$eID);
			
		}
		
		/**
		 * Functie voor het bepalen van de diepgang van een onderdeel ( FK, FA, FC, FS )
		 * @param unknown $onderdeel
		 */
		public function bepaalDiepgang($onderdeel,$eID)
		{
			$rO=new DglwResult();
			
			$gMedia=$this->getMedia($eID);
 			$best=array();
 			$interest=array();

 			foreach ($gMedia as $gm=>$foo)
 			{
 				// pick de beste.
 				if($foo>24.9) {
 					
 					if ( $gm-1 != $best['key'] ) {			// vorige waarde ( top ) mag niet grenzen aan de nieuwe waarde
					
	 					$best['value']=$onderdeel.$gm;
	 					$best['key']=$gm;
	 					$best['waarde']=$foo;
 					}

 				}
				
 			}
			// pick interests
 			if ($gMedia[$best['key']+1] > 14.9) {
				$interest[]=array('value'=>$onderdeel.($best['key']+1) ,
								  'key'=>($best['key']+1),
								  'waarde'=>$gMedia[$best['key']+1]);
 			}
 			elseif($gMedia[$best['key']-1] > 14.9) {
 				$interest[]=array('value'=>$onderdeel.($best['key']-1) ,
								  'key'=>($best['key']-1),
								  'waarde'=>$gMedia[$best['key']-1])	;			
 			} elseif($gMedia[$best['key']-2] > 14.9) {
 				$interest[]=array('value'=>$onderdeel.($best['key']-2) ,
								  'key'=>($best['key']-2),
								  'waarde'=>$gMedia[$best['key']-2])	;			
 			}

			return(array('best'=>$best,'interest'=>$interest));
			
		}
		
		public function overzicht($eID) {
			
			$this->checkEid($eID);


			$rO=new DglwResult();
			$vA=array('K','A','C','S');
			$MH=array('F','V','S','O','M','P');
			
			$mK=array(1,2,3,4);
			$mR=array('H','I','B','W','A');
			$gVisie=array();
			$gMedia=array();
				
			foreach($vA as $visie) {
				foreach ($MH as $MH_v)
				{
					$gVisie[$MH_v][$visie]= $rO->getGemProcentOfStelling($eID,$MH_v.$visie);
				}
			}
			
			foreach($mK as $media) {
				foreach ($mR as $row)
				{
					
					$mVisie[$row][$media]=$rO->getGemProcentOfStelling($eID,$row.$media);
				}
			}
			
			
			
			
			$this->set("vO",$gVisie);
			$this->set("mO",$mVisie);
			$this->set("action","overzicht");
			$this->set("eID",$eID);
			return(array('visie'=>$gVisie,'media'=>$mVisie));
		
		}
		
		
		/**
		 * Functie voor complete score tabel;
		 * 
		 * @param unknown $eID
		 * @return number
		 */
		private function getSuggestiesScore($eID) 
		{
			$rO=new DglwResult();
			
			$MH=array('F','V','S','O','M','P');
			$V = array ('K','A','C','S');
			$M = array ('1','2','3','4');
				
			foreach ($MH as $MH_v)
			{
				foreach ($V as $V_v)
				{
					$sug_t= $rO->getGemProcentOfStelling($eID,$MH_v.$V_v);
					foreach ($M as $M_v)
					{
						$sug_t2 =$rO->getGemProcentOfStelling($eID,$M_v);
						$sug[$MH_v][$V_v][$M_v]['score']=($sug_t/100)*($sug_t2/100)*100;
					}
				}
			}
			return $sug;
		}


		/**
		 * Sorteerd een multidemensionale array op key key v
		 *
		 * @param array    	De array die gesorteerd moet worden
		 * @param on    	De sleutel waarop gesorteerd moet worden
		 * @param order    	Op - of aflopend sorteren
		 */
		private function aa_sort($array, $on, $order=SORT_ASC)
		{
			$new_array = array();
			$sortable_array = array();
		
			if (count($array) > 0) {
				foreach ($array as $k => $v) {
					if (is_array($v)) {
						foreach ($v as $k2 => $v2) {
							if ($k2 == $on) {
								$sortable_array[$k] = $v2;
							}
						}
					} else {
						$sortable_array[$k] = $v;
					}
				}
		
				switch ($order) {
					case SORT_ASC:
						asort($sortable_array);
						break;
					case SORT_DESC:
						arsort($sortable_array);
						break;
				}
		
				foreach ($sortable_array as $k => $v) {
					$new_array[$k] = $array[$k];
				}
			}
		
			return $new_array;
		}
		private function checkEid($eID=0)
		{

			if ($eID==0)  {
				$eID=$this->post('eID');
				
				
				if ($eID==0 || $eID===null) {
					$eID=$_SESSION['eID'];
					
				}
				if ($eID==0 || !isset($eID)) {
					
					die('eID niet achterhalen.');
				}
			}
			else
			{
			
				if ($_SESSION['eID']!=$eID) $_SESSION['eID']=$eID;
			
			}

			return ($eID);
		}

		/**
		 * Functie voor het maken van een PDF
		 * Deze functie roept 'pdftemplate' aan, dit is de pdf pagina. 
		 * @param eID
		 */
		public function createPdf($eID)
		{
			set_time_limit ( 60 );
			$persoon=DglwResult::getInvulPersoonByEid($eID);
			$invuldatum=DglwResult::getInvulDatumByEid($eID);
			$team=DglwResult::getInvulTeam($eID);
			$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Digileerwijzer');
			$pdf->SetTitle('Digileerwijzer');
			$pdf->SetSubject('Digileerwijzer resultaten');
			$pdf->SetKeywords('');
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			
			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			
			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			// set default font subsetting mode
			$pdf->setFontSubsetting(true);
			
			// Set font
			// dejavusans is a UTF-8 Unicode font, if you only need to
			// print standard ASCII chars, you can use core fonts like
			// helvetica or times to reduce file size.
			$pdf->SetFont('dejavusans', '', 12, '', true);
			
			// Add a page
			// This method has several options, check the source code documentation for more information.
			$pdf->AddPage();
			
			// set text shadow effect
			//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
			
			// Set some content to print
			$pdf->ImageSVG($file='http://digileerwijzer.proracom.com/packages/digileerwijzer/themes/digileerwijzer/images/logoDigiLeerWijzer.svg', $x=15, $y=30, $w='', $h='', $link='http://www.digileerwijzer.nl', $align='', $palign='', $border=0, $fitonpage=false);
			
			$html="  <br />
			<br /><br />
			<br /><br />
			<br /><br />
			<br />  Datum: ".$invuldatum."
			<br />
			
			Contactpersoon: ".$persoon['school'].", "."locatie ".$persoon['locatienaam'].", ". $persoon['email']."
			<br />
			Groep: ".$persoon['sectienaam']."<?php echo Concrete\Package\Digileerwijzer\Models\DglwResult::getInvulTeamByEid($enqueteID);?>
			<br />
			<br />
			Dit document bevat de resultaten van een bespreking over de visie op leren en het gebruik van digitale hulpmiddelen uit de Digileerwijzer. <br />
			<br />
			Achtereenvolgens treft u aan:<br />
			1. De verwoording van uw visie op onderwijs zoals die naar aanleiding van de door u gegeven waarderingen opgemaakt is.<br />
			2. De verwoording van uw visie op mediagebruik zoals die naar aanleiding van de door u gegeven waarderingen opgemaakt is.<br />
			3. De scenario's die het beste aansluiten bij deze antwoorden met een korte omschrijving.<br />
			4. Suggesties voor het gebruik van digitale middelen die bij deze visie passen.<br />
			5. Concrete invullingen van de suggesties die bij deze visie passen. <br />
			<br />
			<br />
			<br /> ";
			// Print text using writeHTMLCell()
			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
			$pdf->AddPage();
			$html="  <h1 style='color:black'>1. Visie op onderwijs</h1>
					Een veelgemaakte fout is dat een school begint met het aanschaffen van apparatuur en het aanleggen van een netwerk zonder dat er een duidelijke visie is geformuleerd. \"We hebben acht iPads gekocht en die circuleren nu zodat de leerkrachten wat kunnen uitproberen.\"
					Technologie mag niet leidend zijn bij onze keuzes. De Digileerwijzer heeft u een aantal kritische vragen gesteld om uw visie op onderwijs scherp te krijgen. Wie moet volgens u de regie hebben bij het leren: de leraar of de leerling? Gaat het in uw lessen om weten of om begrijpen? Hoe belangrijk is de ontmoeting tussen leraar en leerling? Het antwoord op deze vragen is belangrijk - dat bepaalt hoe u die media wilt gaan inzetten.
					Aan de hand van zes vragen denkt u na over uw visie op onderwijs. De vragen gaan over:
					  <br />
					 <br />  ";
			
 			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
			 // ---------------------------------------------------------

 			
 			$rij=array(
 					'F'=>'Focus van het onderwijs',
 					'V'=>'Vormen van Feedback',
 					'S'=>'Sturing van het leren',
 					'O'=>'Organisatie van het leren',
 					'M'=>'Manier van leren',
 					'P'=>'Vormen van ontmoeting',
 			
 			
 			);
			$pdf->setFontSize(7);
			$pdf->SetLineWidth(0.1);
 			$pdf->setX(100);
 			$pdf->setY(-150);

 			$m=$this->overzicht($eID);
 				

			foreach ($m['visie'] as $k=>$a):
				//$pdf->Ln();
				$pdf->Cell(40, 8, $rij[$k], 0, 0, 'L', 0,'');
				$nl=0;
 				$last=count($a);
 				$cur=0;
	 			foreach ( $a as $A_k=>$A_v):
	 				$cur++;
	 				$pdf->SetFillColor(round(255-($A_v/100)*255), 255, round(255-($A_v/100)*255));
					//$html.='<td class="result data" style="background-color:rgb('.  round(255-($A_v/100)*255).' ,255,'.round(255-($A_v/100)*255). $A_v.'%</td>';
					if ($cur==$last) $nl=1;		
	 				$pdf->Cell(8, 6,  $A_v.'%',1, $nl, 'L', 1,'');		 						
	 			endforeach;
 			endforeach;
 			
 			$kolom=array(
 					'K'=>'De thuiseters',
 					'A'=>'De Amerikaanse barbecue',
 					'C'=>'Het wokrestaurant',
 					'S'=>'De kookworkshop'
 			);
 			$pdf->setX(-100);
 			$pdf->setY(-150);
 			$pdf->StartTransform();
 			$pdf->Rotate(90);
 			$pdf->Cell(40, 40, '', 0, 1, 'L', 0,'');
 			foreach ($kolom as $k) {
 				$pdf->Cell(40, 8, $k, 0, 1, 'L', 0,'');
 			} 		
 			$pdf->StopTransform();
 			$pdf->setFontSize(12);
 			$pdf->setY(200);
 			
			$html="De focus van het onderwijs: programmagericht of ontwikkelingsgericht?<br />
					Vormen van feedback: wie koppelt terug en hoe gebeurt dat?<br />
					Sturing van het leren: wie is verantwoordelijk voor het leerproces?<br />
					Organisatie van het leren: gericht op samenwerking of op alleen leren?<br />
					Manier van leren: gericht op weten of op begrijpen?<br />
					Vormen van ontmoeting: hoe belangrijk is fysieke aanwezigheid van personen en voorwerpen?<br />
			";
 			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true); 	
 			$pdf->addPage();
 			
 			$html='  <h1 style="color:black">2. Visie op mediagebruik</h1>
					Wordt het Microsoft of Google, Apple of Samsung? Belangrijke vragen, maar niet d&eacute; belangrijkste. Bij Digileerwijzer gaan we een spa dieper. Wat vindt u: moeten we mediagebruik op school aanmoedigen of juist afremmen? Moeten we ons zorgen maken over de verminderde aandacht van leerlingen? Is de beeldcultuur een bedreiging of moeten leerlingen daar juist mee leren omgaan? 
					Deze tweede serie vragen van Digileerwijzer gaat dus over uw visie op mediagebruik. Media hebben grote invloed op de leefwereld van jongeren en het gebruik op school staat daar niet los van. Het antwoord op deze vragen speelt daarom ook een rol bij keuzes rond mediagebruik in het onderwijs.
					    <br /> 
					 <br />  ';

 			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

 
 			$rij=array(
 					'H'=>'Houding t.o.v. mediagebruik',
 					'I'=>'Intensiteit van mediagebruik',
 					'B'=>'Begeleide confrontatie/vreemdelingschap',
 					'W'=>'Concentratie en woordgerichtheid',
 					'A'=>'Altru&iuml;sme vs individualisme'
 			);
 			
 			$pdf->setFontSize(7);
 			$pdf->SetLineWidth(0.1);
 			$pdf->setX(100);
 			$pdf->setY(-150); 
 			

 			foreach ( $m['media'] as $k=>$a):
	 			//$pdf->Ln();
	 			$pdf->Cell(60, 8, $rij[$k], 0, 0, 'L', 0,'');
	 			$nl=0;
	 			$last=count($a);
	 			$cur=0;
	 			foreach ( $a as $A_k=>$A_v):
		 			$cur++;
		 			$pdf->SetFillColor(round(255-($A_v/100)*255), 255, round(255-($A_v/100)*255));
		 			//$html.='<td class="result data" style="background-color:rgb('.  round(255-($A_v/100)*255).' ,255,'.round(255-($A_v/100)*255). $A_v.'%</td>';
		 			if ($cur==$last) $nl=1;
		 			$pdf->Cell(8, 6,  $A_v.'%',1, $nl, 'L', 1,'');
	 			endforeach;
 			endforeach; 			
 			
 			
 			$kolom=array(
 					'1'=>'Zeer terughoudend',
 					'2'=>'Beperkt',
 					'3'=>'Ruimhartig',
 					'4'=>'Zeer vooruitstrevend'
 			);
 			
 			$pdf->setX(-100);
 			$pdf->setY(-150);
 			$pdf->StartTransform();
 			$pdf->Rotate(90);
 			$pdf->Cell(30, 60, '', 0, 1, 'L', 0,'');
 			foreach ($kolom as $k) {
 				$pdf->Cell(40, 8, $k, 0, 1, 'L', 0,'');
 			}
 			$pdf->StopTransform();
 			$pdf->setFontSize(12);
 			$pdf->setY(200);
 			$html="Media-educatie: in de vorm van een aparte les of in alle vakken?<br />
		 			Extensief of intensief: moeten we mediagebruik stimuleren of afremmen<br />
		 			Begeleide confrontatie: hoe moeten leerlingen omgaan met invloeden van buiten?<br />
		 			Concentratie: hoe ernstig is het probleem van afleiding door mediagebruik?<br />
		 			Altru&iuml;sme: moet mediagebruik gericht zijn op dienstbaarheid aan anderen of juist op eigen belang?<br />";
 			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 			$pdf->addPage();

 			$html="<h1>3. Scenario's</h1>
 			Digileerwijzer schets aan de hand van de onderwijs- en mediavisie een scenario voor u. Dat is nog geen blauwdruk voor uw ict-plannen voor de komende jaren. Het is pas het begin van een traject waarbij nog tal van andere vragen verschijnen. Maar het scenario wijst u wel een bepaalde richting en die is optimaal afgestemd op uw visie op leren en mediagebruik. Hieronder ziet u hoeveel procent uw keuzes overeenkomen met de 4 scenario's. Een beschrijving van deze scenario's kunt u daaronder vinden.";
 			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
			
 			$html="<br /><h2 style=\"color:#2E74B5\">Beschrijving scenario's</h2>";
 			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

 			$html="<div style=\"background-color:#F5F5F5\">De Kookworkshop
					Elke dinsdagavond volgen acht vrienden, in een lokaal boven de kookwinkel een workshop. In steeds wisselende koppels bereiden ze een onderdeel van een diner. <br />
					<br />
					In overleg beslissen de vrienden welke gerechten er op het menu komen. Bij de chefkok en zijn keukenassistent kunnen zij vervolgens terecht voor de recepten en tips en aanwijzingen voor het bereiden ervan.<br /> 
					<br />
					De chefkok geeft gevraagd en ongevraagd advies tijdens de bereiding, zowel wat betreft de te gebruiken hulpmiddelen als bij de receptuur. In het kooklokaal zijn allerlei handige keukenapparaten aanwezig en er is een groot aanbod aan ingredi&euml;nten. Nadat het diner is gemaakt, eten de vrienden de gerechten gezamenlijk op in het restaurantgedeelte.<br />  					
					</div>";

 			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 			
 			$html="<span style=\"color:#2E74B5\">Samenwerken</span><br />
					De 'kookworkshop' staat model voor samenwerken: leren door participeren. De leerling is intensief betrokken bij het hele proces. Centraal staat dat ze elkaar helpen om tot een goed en gevarieerd resultaat te komen, met veel variatie in bereidingswijze en gerechten, en veel mogelijkheden om van elkaar te leren.<br />
					<br /><span style=\"color:#2E74B5\">Adviezen</span><br />
					Samenwerkend leren is niet noodzakelijkerwijs verbonden met de inzet van veel technologie. Zoals bij een kookworkshop iemand kan kiezen voor een heel ambachtelijke benadering of juist voor hightech bij de bereiding - zo geldt dat ook hier.<br />
 			";
 			$pdf->AddPage();
 			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 			$html="<div style=\"background-color:#F5F5F5\">Het Wokrestaurant<br />
					Een  vriendenclub gaat regelmatig samen uit eten en kiest vanwege de verschillende voorkeuren voor een wokrestaurant. Iedere gast kan daar wat vinden dat bij zijn voorkeur past. Wie niet van wokken houdt, kiest friet met een gehaktbal. Ook de hoeveelheid gerechten en het aantal rondes is vrij.<br />  
					<br />
					Elke gast maakt zelf een keus uit de aangeboden gerechten en sausen, maar hij hoeft ze niet zelf te bereiden. De ingredi&euml;nten zijn aantrekkelijk gepresenteerd, zodat ze uitnodigen om verschillende combinaties uit te proberen. Wie geen keus kan maken, vraagt anderen naar hun ervaring - de drempel om een gesprek te beginnen met gasten buiten de vriendenkring is laag. Sommige gerechten worden vaak gekozen. Dat stimuleert anderen om daar ook voor te kiezen.<br />  
					<br />
					De rol van de kok is beperkt tot het bereiden van de gerechten. Soms geeft hij advies: deze saus is extra pittig, deze combinatie van vlees en vis is heerlijk. De klant is helemaal vrij in zijn keuze - maar is het gerecht eenmaal bereid dan lijkt de inhoud van de verschillende borden verrassend veel op elkaar...<br />  
					<br />
					Een wokrestaurant dat veel keus biedt, een grote voorraad heeft en de verschillende soorten vlees en vis mooi presenteert, is aantrekkelijker. Ook sfeer en de prijs-kwaliteitverhouding zijn belangrijke factoren.<br />
 					</div>";
 			
 			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 			$html="<br />
		 			<span style=\"color:#2E74B5\">Contextrijk</span><br />
		 			Het wokrestaurant is een metafoor voor de contextrijke lessituatie. De leerling wordt uitgedaagd en nieuwsgierig gemaakt door een royaal aanbod aan lesinhouden. Docenten adviseren de leerlingen, maar zij kunnen hun licht ook opsteken bij externe experts. Daarnaast letten ze goed op elkaars gedrag en resultaten: kunst afkijken en oefenen.<br />
		 			<br /><span style=\"color:#2E74B5\">Adviezen</span><br />
		 			Een contextrijke onderwijssituatie is mogelijk met beperkte inzet van technologie. Een voorbeeld daarvan is het praktijkonderwijs waarbij leerlingen 'zorg verlenen' aan medeleerlingen op een bed in het praktijklokaal. Maar het gebruik van ict en media kan deze onderwijssituatie sterk verrijken.<br />
		 			";
 			
 			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 			$html="
		 			<div style=\"background-color:#F5F5F5\">De Amerikaanse barbecue<br />
		 			Bij de Amerikaanse barbecue, de 'potluck', brengt iedere gast een gerecht mee dat hij of zij lekker vindt, bereidt naar zijn persoonlijke voorkeur.<br />
		 			<br />
		 			Voor zo'n gerecht beslis je zelf wat je aan ingredi&euml;nten koopt. Iedereen neemt zijn of haar gerecht mee en samen vormt dit de maaltijd. Er zijn speciale websites waarmee de gasten hun maaltijd kunnen plannen om te voorkomen dat iedereen hetzelfde gerecht meebrengt.<br />
		 			<br />
					De presentaties van de meegebrachte gerechten kunnen sterk verschillen. Mensen met weinig tijd kopen wellicht iets dat al kant-en-klaar is, maar iemand die graag kookt maakt een speciaal hapje voor de andere gasten en zorgt ook dat het er leuk en smakelijk uit ziet.<br />
					<br /> 			
					Bij een wat grotere barbecue eten de gasten vaak in kleinere groepjes in plaats van met z'n allen. Tijdens de maaltijd blijkt uit de reacties of de andere gasten de gerechten lekker vonden of niet.<br />
		 			</div>";
 			
 			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 			$html="<span style=\"color:#2E74B5\">Actief zelfstandig</span><br />
		 			De 'Amerikaanse barbecue' staat model voor een lessituatie afgestemd op actieve, zelfstandige leerlingen. Heel gevarieerd, maar de 'gerechten' zijn van wisselende kwaliteit.<br />
		 			<br />
		 			De leraar, in dit model de 'gastheer' van de barbecue, bouwt wel een aantal randvoorwaarden in ('de gasten mogen niet met lege handen op de barbecue komen'), maar biedt de leerlingen veel vrijheid. Hij stimuleert de zelfwerkzaamheid en de nadruk ligt meer op het proces dan op het resultaat. De leerlingen kennen het 'recept': ze moeten zelf actief bijdragen aan het eindresultaat. Maar de ene leerling stopt er meer tijd in dan de ander en 'bakt' er dan ook meer van.<br />
		 			<br />
		 			De samenwerking en afstemming tussen leerlingen is beperkt, maar ze leveren wel onderlinge feedback op elkaars prestaties. Zo organiseren ze hun eigen leerproces.<br />
		 			<br />
		 			Een lessituatie met actieve zelfstandige leerlingen gaat niet noodzakelijkerwijs gepaard met intensief mediagebruik. Maar er zijn veel ict-toepassingen die de leerling kunnen helpen om zelfstandig zijn eigen leerroute samen te stellen. Zij kunnen kiezen uit een royaal aanbod van media en nemen daar zelf ook het initiatief toe. Een elektronisch portfolio is hierbij een nuttig hulpmiddel.<br />
		 			<br /><span style=\"color:#2E74B5\">Adviezen</span><br />
		 			Een onderwijssituatie gebaseerd op actieve zelfstandige leerlingen betekent dat de leraar meer een coach is dan een docent.<br />
		 			";
 			
 			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 			$html="<div style=\"background-color:#F5F5F5\">De Thuiseter<br />
					Gezellig, iedereen eet vanavond thuis. Moeder heeft vanmorgen al verteld wat er die avond gegeten wordt. In de meeste gevallen bepaalt zij zelf wat er op tafel komt: 's zondag soep, op zaterdag friet en op de andere dagen is er een eenvoudige voedzame maaltijd.<br />  
					<br />
					Meestal doet moeder zelf de boodschappen voor de maaltijd, volgens een voorgeschreven lijstje gehaald. Soms schilt &eacute;&eacute;n van de kinderen de aardappels. Tafeldekken en afwassen is een roulerende taak voor de kinderen in het gezin.<br /> 
					<br />  
					Tijdens de maaltijd is er tijd voor persoonlijke aandacht. Natafelen is er echter meestal niet bij. Voor ieder weer aan zijn of haar bezigheden gaat, moet er nog wel worden afgeruimd en afgewassen.<br />
		 			</div>";
 			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 			$html="<span style=\"color:#2E74B5\">Klassiek</span><br />  
		 			De 'thuiseters' staan model voor de klassieke lessituatie. Een gevarieerde en voedzame 'maaltijd', keurig bereid volgens de schijf van vijf en dankzij het kookboek verloopt de bereiding probleemloos.<br />  
		 			<br />  
		 			Het onderwijs is docentgestuurd. De leraar, 'moeder' in dit model, heeft de touwtjes in handen, maar heeft er ook zijn handen aan vol. Hij bereidt de inhoud van de lessen goed voor en is intensief betrokken bij de invulling ervan. De leerling heeft ook zijn aandeel ('boodschappen doen, aardappels schillen, afruimen en de vaat'), maar dat zit meer in de marge van de les.<br />  
		 			<br />  
		 			Bij deze lessituatie is er ruimte voor het inzetten van ict en media. De 'thuiseters' in deze metafoor kunnen een vaatwasser, keukenmachine en magnetron gebruiken zonder dat dat afbreuk doet aan de kwaliteit van de maaltijd: dat verlicht de taken, biedt moeder meer tijd voor een goed gesprek of het leren koken door de andere gezinsleden en draagt zo bij aan gezelligheid tijdens het eten.<br />  
		 			<br />  <span style=\"color:#2E74B5\">Adviezen</span><br />  
		 			Niets mis met dit model: oost-west-thuis-best! Maar.. overweeg eens de mogelijkheid om de rollen om te draaien? Of de andere gezinsleden meer bij het bereiden van de maaltijd te betrekken? Of wat meer variatie aan te brengen door eens een uitstapje te maken naar een 'oosterse keuken'";
 			
 			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 			$pdf->addPage();
 			$html="<h1>4. Suggesties voor mediagebruik</h1>
		 			In deze bijlage, kunt u per onderdeel een verdergaande praktische invulling van deze suggesties terugvinden met veel aanklikbare linken.
		 			<br />";
 			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 			$html="";
			 foreach (array('F'=>'Focus van het onderwijs','V'=>'Vormen van Feedback','S'=>'Sturing van het leren','O'=>'Organisatie van het leren','M'=>'Manier van leren','P'=>'Vormen van ontmoeting') as $onderdeel=>$titel):
			  	$html='<table style="      
					        font-family: helvetica;
					        font-size: 10pt;
					        border-left: 1px solid #DCDCDC;
					        border-right: 1px solid #DCDCDC;
					        border-top: 1px solid #DCDCDC;
					        border-bottom: 1px solid #DCDCDC;
					        background-color: #F0F0FF;"><tr>
			  					<td style="border-left: 1px solid #101010;
									        border-right: 1px solid #101010;
									        border-top: 1px solid #101010;
									        border-bottom: 1px solid #101010;
			  								height:24px"  
			  			
			  			colspan="2" align="center">
			  					<span  style="color:#3D6892;   font-size: 16px; font-weight: bold;">'.$titel.'</span></td></tr>'; 	
			  	
			  	$k=( DglwResult::getResultByWeging($eID, $onderdeel.'%',2));
			  	$html.='<tr>';
			  	foreach ($k as $d) :
			  		
					$dG=$this->bepaalDiepgang($d['weging'],$eID);
			
					$html.='<td style="border-left: 1px solid #101010;
									        border-right: 1px solid #101010;
									        border-top: 1px solid #101010;
									        border-bottom: 1px solid #101010;"   valign="top"><strong><em><br />Wat het beste bij de visie op media-inzet past:</em></strong><br />';
				
					$mTv=$dG['best'];
					
					
			  			$html.="<strong>".$mTv['value'].": ( ".$mTv['waarde']."% ): </strong>". $this->makeClickableLinks(DglwResult::getSuggestiesText($mTv['value'],0));
			  						
			  		
			  		
			  		$html.='<br /><br /><strong><em>Wat niet direct bij de visie past, maar mogelijk ook interessant is:</em></strong><br />';
					
					foreach ($dG['interest'] as $mTv):
						$html.= "<strong>".$mTv['value'].": ( ".$mTv['waarde']."% ): </strong>". $this->makeClickableLinks(DglwResult::getSuggestiesText($mTv['value'],0));
			
			  		endforeach;  		
			  	$html.='</td>';
			  	endforeach;
			  	$html.='</tr></table>';
			  	$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
			  endforeach;
			  //$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
			// This method has several options, check the source code documentation for more information.
			

			  $pdf->addPage();
			  $html="<h1>5. Concrete invulling van de suggesties voor mediagebruik</h1>";
			  $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
			  $html="";
			  foreach (array('F'=>'Focus van het onderwijs','V'=>'Vormen van Feedback','S'=>'Sturing van het leren','O'=>'Organisatie van het leren','M'=>'Manier van leren','P'=>'Vormen van ontmoeting') as $onderdeel=>$titel):
			  $html='<table style="
					        font-family: helvetica;
					        font-size: 10pt;
					        border-left: 1px solid #DCDCDC;
					        border-right: 1px solid #DCDCDC;
					        border-top: 1px solid #DCDCDC;
					        border-bottom: 1px solid #DCDCDC;
					        background-color: #F0F0FF;"><tr>
			  					<td style="border-left: 1px solid #101010;
									        border-right: 1px solid #101010;
									        border-top: 1px solid #101010;
									        border-bottom: 1px solid #101010;
			  								height:24px"
			  
			  			colspan="2" align="center">
			  					<span  style="color:#3D6892;   font-size: 16px; font-weight: bold;">'.$titel.'</span></td></tr>';
			  
			  $k=( DglwResult::getResultByWeging($eID, $onderdeel.'%',2));
			  $html.='<tr>';
			  foreach ($k as $d) :
			   
			  $dG=$this->bepaalDiepgang($d['weging'],$eID);
			  	
			  $html.='<td style="border-left: 1px solid #101010;
									        border-right: 1px solid #101010;
									        border-top: 1px solid #101010;
									        border-bottom: 1px solid #101010;"   valign="top"><strong><em><br />Wat het beste bij de visie op media-inzet past:</em></strong><br />';
			  
			  $mTv=$dG['best'];
			  	
			  	
			  $html.="<strong>".$mTv['value'].": ( ".$mTv['waarde']."% ): </strong>". $this->makeClickableLinks(DglwResult::getSuggestiesText($mTv['value'],1));
			  	
			   
			   
			  $html.='<br /><br /><strong><em>Wat niet direct bij de visie past, maar mogelijk ook interessant is:</em></strong><br />';
			  	
			  foreach ($dG['interest'] as $mTv):
			  $html.= "<strong>".$mTv['value'].": ( ".$mTv['waarde']."% ): </strong>". $this->makeClickableLinks(DglwResult::getSuggestiesText($mTv['value'],1));
			  	
			  endforeach;
			  $html.='</td>';
			  endforeach;
			  $html.='</tr></table>';
			  $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
			  endforeach;			  
			  
			  $pdf->Output('example_001.pdf', 'I');
			

			
		
		
		}
		public function pdfTemplate($eID)
		{
			$this->overzicht($eID);
			$this->suggesties($eID);
			$this->set("action","pdfTemplate");
			$this->set("enqueteID",$eID);
			
		//exit();
		
		}
		public static function makeClickableLinks($s) {
			return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
		}
		
		public function opslaan($eID) {
			$vO=new DglwModel();
			$this->set("eID",$eID);	
			$this->set("grouptrail",$vO->getVraagGroepTrail());
				
			$this->set("action","opslaan");	
		}
		
		public function do_opslaan($eID) {
			$vO=new DglwModel();
			$vO->setSaved($eID,1);
			$this->redirect('digileerwijzer/overzicht/'.$eID);
		}
}