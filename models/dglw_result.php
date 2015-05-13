<?php

namespace Concrete\Package\Digileerwijzer\Models;

use Loader;
use Concrete\Core\Legacy\Model;




	/**
	 * Model voor digitale leerwijzer.
	 * Dit model zorgt voor de calculatie van de resultaten.
	 * @author Eric
	 * @version 1.0
	 * @updated 11-jan-2015 14:02:18
	 */
	 class DglwResult extends Model
	{
		
		public function getProcentOfStelling($eID,$query) {
			$db=Loader::db();
			
			$result=$this->getResultByWeging($eID,$query);
			
			$r=array();
			foreach( $result as $row) {
				$r=array_merge($r,array(array('rID'=>$row['rID'],'result'=>$row['result'])));
			}

			return($r);
			
			
			
			
		}
		public function getGemProcentOfStelling($eID,$query) {
			$total=0;
			
			$result=$this->getResultByWeging($eID,$query);
			$aantal=$this->getTotalOfWeging($eID,$query);
			
			foreach ($result as $row ) {
				$total+=$row['result'];
			}
			if ($aantal > 0 )
			return $total / $aantal;
			
			else return 0;
			
		}
		
		/**
		 * getResultByWeging
		 * Haalt resultaten by weging uit de database. Bijvoorbeeld "Haal alle resultaten bji F*
		 * 
		 *
		 * @param eID
		 * @param query
		 */		
		public function getResultByWeging($eID,$query,$limit=0) {
			$db=Loader::db();
			$q="select dglw_results.*,dglw_antwoorden.weging,dglw_vragen.* from dglw_results
			
				join dglw_antwoorden on
				dglw_antwoorden.aID=dglw_results.aID
				
				join dglw_vragen on
				dglw_vragen.vID=dglw_antwoorden.vID
				
				where dglw_results.eID=?
				and
				weging like ? ";
				
			if($limit==0) $q.="ORDER BY weging";
			else $q.=" ORDER BY result desc limit ".$limit;
	
			$v=array($eID,$query);

			$r=$db->getAll($q,$v);
			return $r;
		
		}
		
		private function getTotalOfWeging($eID,$query) {
			$db=Loader::db();
			$q="select count(dglw_results.rID) as aantal from dglw_results
			
			join dglw_antwoorden on
			dglw_antwoorden.aID=dglw_results.aID
			
			join dglw_vragen on
			dglw_vragen.vID=dglw_antwoorden.vID
			
			where dglw_results.eID=?
			and
			weging like ? ORDER BY weging";
			
			$v=array($eID,$query);
			$res=$db->getOne($q,$v);

			return $res;
			
		}
		
		public function getSuggestieByCode($sugId) {
			$db=Loader::db();
				
			$q = "select code, sText, lText  from dglw_suggesties where code=?";
			
			$v = array ($sugId);
			$res=$db->getRow($q,$v);
			return $res;	
		}
		
		static public function getSuggestiesText($sugId='',$nivo) {
			
			if ($sugId!='' )
			{
				$res=DglwResult::getSuggestieByCode($sugId);
				if ($nivo==0)
					return ($res['sText']);
				else 
					return ($res['lText']);
			}
			else {
				return("Onvoldoende gegevens ingevoerd voor het bepalen van de visie");
			}
		}
		static public function getVraagResultByEid($eID=0,$aid) {
			if ($eID==0) die('Eid niet meegegeven');
			$db=Loader::db();
			$q="select result from dglw_results where aID=? and eID=?";
			$v=array($aid,$eID);
			$r=$db->getOne($q,$v);
			
			return $r;
			
		}
		
		public function getInvullers() {
			$db=Loader::db();
			$q="select * from dglw_inschrijvers";
			$res=$db->getAll($q);
			
			return $res;
		}
		static public function getInvulDatumByEid($eID) {
			$db=Loader::db();
			$q="select datum from dglw_enquetes where eID=?";
			$v=array($eID);
			$r=$db->getOne($q,$v);
			
			setlocale(LC_TIME, 'NL_nl');
			$r=date('d-m-Y',$r);

			return $r;			
		}
		
		static public function getInvulTeam($eID) {
			
		}
		
		static public function getInvulPersoonByEid($eID) {
			$db=Loader::db();
			$q="select *,dglw_inschrijvers.naam as naam,dglw_locatie.naam as locatienaam from dglw_enquetes
				join dglw_inschrijvers 
				on dglw_inschrijvers.inschrijfID=dglw_enquetes.inschrijfID
				inner join dglw_secties
				on dglw_inschrijvers.secID = dglw_secties.secID
				join dglw_locatie
				on dglw_inschrijvers.lID = dglw_locatie.lID
				join dglw_scholen
				on dglw_locatie.sID = dglw_scholen.id
				where eID=?";
			$v=array($eID);
			$r=$db->getRow($q,$v);	
			return $r;			
		}
		
		public function getInvulTeamByEid($eID) {
			$db=Loader::db();
			$q="select * from dglw_enquetes
				join dglw_inschrijvers 
				on dglw_inschrijvers.inschrijfID=dglw_enquetes.inschrijfID
				where eID=?";
			$v=array($eID);
			$r=$db->getRow($q,$v);
				
			return $r;			
		}
		
		public function getResultaten() {
			$db=Loader::db();
			$q="select * from dglw_enquetes
					join dglw_inschrijvers
					on dglw_inschrijvers.inschrijfID=dglw_enquetes.inschrijfID";
			$r=$db->getAll($q);
			
			return $r;
		}
		
		public function getResultatenByEid($eID) {
			$db=Loader::db();
			$q="select * from dglw_enquetes 
					join dglw_results on dglw_enquetes.eID=dglw_results.eID
					join dglw_antwoorden  on dglw_results.aID=dglw_antwoorden.aID
					where dglw_enquetes.eID=?
					order by dglw_antwoorden.aID
					";
			$v=array($eID);
			$r=$db->getAll($q,$eID);
				
			return $r;
		}		
	





	}
?>