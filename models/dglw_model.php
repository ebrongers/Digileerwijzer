<?php

namespace Concrete\Package\Digileerwijzer\Models;

use Loader;
use Concrete\Core\Legacy\Model;
use Concrete\Package\Digileerwijzer\Models\DglwResult;



	/**
	 * Model voor digitale leerwijzer. Dit model zorgt voor de koppelingen met de
	 * database.
	 * @author Eric
	 * @version 1.0
	 * @updated 10-jan-2015 09:00:28
	 */
	class DglwModel extends Model
	{
	


		/**
		 * Haalt alle scholen uit de database.
		 * 
		 * @param active    Geeft aan of de active scholen of ook de niet active scholen
		 * gezocht moeten worden.
		 */
		static public function getScholen($active=0) {
			$db=Loader::db();
			
			if ($active==0) $res=$db->fetchAll("select id,school from dglw_scholen order by school");
			if ($active==1) $res=$db->fetchAll("select id,school from dglw_scholen where active=1 order by school");
		
			$r=array();
			
			
	
			foreach($res as $k=>$rw) {
	
				$r[$rw['id']]=$rw['school'];
			}
	
			return $r;
		}
		public function newSchool($naam,$actief) {
			$db=Loader::db();
			$q="insert into dglw_scholen (school,active) values (?,?)" ;
			$v=array($naam,$actief);
			$db->query($q,$v);
			
			$id=$db->Insert_Id();	
			return $id;
				
		}
		public function addLocatie($locatienaam,$schoolid) {
			$db=Loader::db();
			$q="insert into dglw_locatie (naam,sID) values (?,?)" ;
			$v=array($locatienaam,$schoolid);
			$db->query($q,$v);
				
			$id=$db->Insert_Id();
			return $id;
		}
		
		static public function getSchool($sID) {
			$db=Loader::db();
			$res=$db->getRow("select * from dglw_scholen where id=?",array($sID));
			
			return $res;
		}
		public function updateSchool($sID,$naam,$actief) {
			$db=Loader::db();
			$q="update dglw_scholen set school=?,active=?  where id=?";
			$v=array($naam,$actief,$sID);
			$db->query($q,$v);
			return array("school"=>$naam,"id"=>$sID,"active"=>$actief);
		}
		public function deleteLocatie($lID,$sID) {
			$db=Loader::db();
			$q="delete from dglw_locatie where lID=? and sID=?";
			$v=array($lID,$sID);
			$db->query($q,$v);
		}
		
		/**
		 * Haal de locaties van een school uit de database.
		 * 
		 * @param sID
		 */
		static public function getLocaties($sID) {
			$db=Loader::db();
			$res=$db->fetchAll("select lID, naam from dglw_locatie where sID=?",array($sID));
			return $res;
		}
		public function getLocatie($lID) {
			$db=Loader::db();
			$res=$db->getRow("select * from dglw_locatie where lID=?",array($lID));
			
			return $res;
		}

		
		public function updateLocatie($naam,$lID) {
			$db=Loader::db();
			$q="update dglw_locatie set naam=? where lID=?";
			$v=array($naam,$lID);
			$r=$db->query($q,$v);			
		}

		/**
		 * Haal de locaties van een school uit de database.
		 *
		 * @param sID
		 */
		static public function getSectiesPerLocatie($sID) {
			$db=Loader::db();
			//$res=$db->fetchAll("select lID, naam from dglw_locatie where sID=?",array($sID));
			$res=$db->fetchAll("select dglw_secties.secID,dglw_sec_loc.sec_locID,sectienaam from
			dglw_secties
			inner join  dglw_sec_loc on dglw_secties.secID=dglw_sec_loc.secID
			
			
			where locID=?",array($sID));
			return $res;
		}		
		
		
		/**
		 * Haalt alle secties uit de database.
		 */
		static public function getSecties() {
			$db=Loader::db();
			$r=array();
			
			$res=$db->fetchAll("select secID,sectienaam from dglw_secties order by sectienaam");
			foreach($res as $k=>$rw) {
			
				$r[$rw['secID']]=$rw['sectienaam'];
			}
			
			return $r;		
		} 
	
		/**
		 * Get the intro correspondending to the question section
		 * 
		 * @param g    The number of the question section
		 */
		public function getGroupIntro($g) {
			$db=Loader::db();
			if ($g<1) $g=1;
			
			$res=$this->getVraagGroep($g);

			return $res['vg_intro'];

			
		}
		
		static public function getSuggesties() {
			$db=Loader::db();
			$q="select * from dglw_suggesties";
			$res=$db->getAll($q);
			return $res;
			
		}
		static public function getSuggestieByCode($sugId) {
			$dglw_result=new DglwResult();

			return $dglw_result->getSuggestieByCode($sugId);
			
			
		}
		
		public function updateSuggestie($code, $sText='',$lText='')
		{
			$db=loader::db();
			$q="update dglw_suggesties  set sText=?, lText=? where code=?";
			$v=array($sText,$lText,$code);
			$res=$db->execute($q,$v);
			
		}
		
		public function getVraagGroep($g) {
			$db=Loader::db();
			$query="select * from dglw_vraag_groepen where volgorde=? order by volgorde";
			$vals=array($g);
			$res=$db->getRow($query,$vals);
			
			return $res;
		}
		public function getStellingen($g,$v) {
			$db=Loader::db();
			
			// algemene zaken.
			$query="select * from dglw_vragen where volgorde=? and vgID=?";
			$vars=array($v,$g);
			
			$r=$db->getAll($query,$vars);
				
			foreach($r as $k=>$rw) {
				$res['vID']=$rw['vID'];					
				$res['vgID']=$rw['vgID'];
				$res['titel']=$rw['titel'];
				$res['subTitel']=$rw['subTitel'];
				$res['naam']=$rw['naam'];
				$res['vraag']=$rw['vraag'];
			}
				
			//return $res;			
			
			// eerst de vraag tekst
			$query="select aid,stelling from dglw_vragen join dglw_antwoorden
					on dglw_antwoorden.vID=dglw_vragen.vID	
					and dglw_vragen.volgorde=?	
					and dglw_vragen.vgID=?			
					order by RAND()";
			$vars=array($v,$g);
			$res['vragen']= $db->getAll($query,$vars);
			
			return $res;
			

		}

		/**
		 * Haalt het menu op gebasseerd op de vraag groepen.
		 */
		public function getVraagGroepTrail()
		{
			$db=Loader::db();
			$r=array();
			
			$query="select vgID,vg_naam from dglw_vraag_groepen order by volgorde";
			$res=$db->fetchAll($query);
			

				
			return $res;			
			
		}
		
		public function getVraagTrail($g) {
			$db=Loader::db();
			$r=array();
			
			$query="select vid, naam from dglw_vragen where vgID=? order by volgorde";
			$vars=array($g);
			
			return $db->fetchAll($query,$vars);
		}
		public function getAantalVragen($g) {
			$db=Loader::db();
			$query="select count(vid) as aantal from dglw_vragen where vgID=? ";
			$vars=array($g);
			
			$res=$db->getRow($query,$vars);
				
			return $res['aantal'];			
		}

		/**
		 * Haalt het aantal groepen uit de database.
		 */
		public function getAantalGroepen()
		{
			$db=Loader::db();
			$query="select count(vgID) as aantal from dglw_vraag_groepen";
			$res=$db->getRow($query);

			return $res['aantal'];
		}

		/**
		 * Save the personal data
		 */
		public function setPersData($pA)
		{
			//print_r($pA);
			$db=Loader::db();
			
			$q = "select dglw_inschrijvers.inschrijfID from dglw_inschrijvers 
					join dglw_enquetes on 	dglw_enquetes.inschrijfID = dglw_inschrijvers.inschrijfID
					where email=? and lID=? and secID=? and saved=1";
			$v = array($pA['email'],$pA['locatie'],$pA['sectie']);
			$inschrijfID = $db->getOne($q,$v);

			
			if ( $inschrijfID==FALSE) {
				//nieuwe inschrijver maken.
				$q = "insert into dglw_inschrijvers (naam,email,lID,secID) values (?,?,?,?)";
				$v = array($pA['naam'],$pA['email'],$pA['locatie'],$pA['sectie']);
				$r=$db->query($q,$v);
				// inschrijver ID ophalen.
				$inschrijfID=$db->Insert_ID();
				
			}	

			return $inschrijfID;

		}

		/**
		 * Slaat de (tussentijdse) stelling op
		 */
		public function setStellingData($eID=0,$aSd=0)
		{

			$db=Loader::db();
			if ($aSd!=0 && $eID!=0) {											// check of er data is
				
				foreach ($aSd as $key=>$antwoord) {
					// checken of er al een record is
					$query="select rID from dglw_results where aID=? and eID=?";
					$vars=array($key,$eID);
					$rid=$db->getOne($query,$vars);
					if ( $rid==NULL ) {
						$q="insert into dglw_results (aID,eID,result) values(?,?,?) ";
						$v=array($key,$eID,$antwoord);
						
					}
					else {
						$q="update dglw_results set result=? where rID=?";
						$v=array($antwoord,$rid);
					}		
					$r=$db->query($q,$v);	

				}
				
			}

		}

		/**
		 * Maakt een nieuwe enquete aan
		 */
		public function newEnquete($inschrijfID)
		{
			$db=Loader::db();
			
			// zoek eerst naar een bestaande sessie die opgeslagen is.
			$q="select eID from dglw_enquetes where inschrijfID=? and saved='1'";
			$v=array($inschrijfID);
			$r=$db->getOne($q,$v);
			
		
			if ($r!==false) {

				return $r;
			}
			
			$q="insert into dglw_enquetes (inschrijfID,datum,saved) values (?,?,?)";
			$v=array($inschrijfID,time(),0);
			
			$r=$db->query($q,$v);
			
			$eID=$db->insert_ID();
			
			
			return $eID;
			
			
		}
		
		private function saveEnquete($eID=0,$save=0) 
		{
			$db=Loader::db();
			
			
			
		}
		
		public function setSaved($eID=0,$save) {
			$db=Loader::db();
			$q="update dglw_enquetes set saved=? where eID=?";
			$v=array($save,$eID);
			$r=$db->query($q,$v);
		}


	}
?>