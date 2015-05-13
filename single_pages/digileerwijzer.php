<?php  if ($action=='q') :
$t=0;
$st=0;
$done=false;?>
<div class="progressbarholder">
	<div class="w-clearfix progressbar">
		<?php foreach ($grouptrail as $gr) : 
		$t++;?>
		<a class="w-clearfix w-inline-block progresslinkblock w--current" href="/index.php/digileerwijzer/q/<?php echo $gr['vgID'];?>">
			<div class="progressstapbig <?php if ($t==1):?>activefirst<?php else:?>second<?php endif;?>">
				<h5  class="progressbarheader <?php if ($t==1):?>firstheader<?php else:?>secondheader<?php endif;?> active"><?php echo $gr['vg_naam']; ?></h5>
			</div>
		</a>
		<?php endforeach;?>		
	</div>
	<div class="w-clearfix progressbar">
	<?php foreach ($vraagtrail as $vr) :
	
	if ($current_vraag==0 && done==false) {$st=0;$done=true;}?>
		<a class="w-clearfix w-inline-block progresslinkblock w--current" href="/index.php/digileerwijzer/q/<?php echo $vraagGroepID;?>/<?php echo $st;?>">
		
			<div class="progresbarsmall  <?php if ($st!=0):?>second<?php endif;?>">
			<?php //echo $current_vraag;echo $st;echo $vr['vid']?>
				<h5  class="progressbarheadersmall <?php if ($current_vraag!=$st):?>inactive<?php endif;?>"><?php echo $vr['naam']; ?> </h5>
			</div>
		</a>		
	<?php $st++;endforeach;?>
	</div>

</div>
<div class="containerbreed">
	<div class="holderbreed <?php if ($vraagGroepID==1):?>paars<?php else:?>green<?php endif;?>">
		<h2><?php echo($vraagGroep['vg_naam']);?></h2>
	</div>
</div>


<?php if ($intro) :?>
<div class="holderbreed <?php if ($vraagGroepID==1):?>paars<?php else:?>green<?php endif;?>">
	<div class="headerholder">
		<?php echo $intro;?>
	</div>
</div>
<?php endif;?>
<form method="post" action="<?php echo $this->action('q',$next_groep,$next_vraag); ?>"  class="w-clearfix" id="form">
<div class="holderbreed wit">
	<div class="w-form">
		
		<input type="hidden" name="eID" value="<?php echo $enqueteID;?>" />
			<?php if (count($vragen['vragen']) > 0) :?>
				<h3><?php echo $vragen['titel'];?></h3>
				<div class="vraagintro"><?php echo $vragen['subTitel'];?></div>
				<div class="w-clearfix vraagholder">
					<p class="vraagtekst"><?php echo $vragen['vraag'];?></p>
				</div>
				
				<p class="antwoorduitleg">
				Geef met een (heel) cijfer tussen 0 en 100 aan wat de
				<span class="onderstreeptintekst">gewenste</span>
				situatie is van het onderwijs op uw school (0: geen enkele overeenkomst, 100: volledige overeenkomst). De toegekende cijfers moeten opgeteld 100 zijn. Kies maximaal drie opties.
				</p>
				

				
				<?php foreach ($vragen['vragen'] as $v) : ?>
					<div class="line paars"></div>
					<p class="antwoordtekst"><?php echo $v['stelling']; ?></p><input class="w-input vraagantwoord" type="text" placeholder="0-100" value="<?php echo Concrete\Package\Digileerwijzer\Models\DglwResult::getVraagResultByEid($enqueteID,$v['aid']);?>" name="stelling[<?php echo $v['aid'];?>]" />
				<?php endforeach;?>
				<div class="line paars"></div>
			<?php endif;?>
		</div>
	</div>
		
		<div class="navigatiesection">
			<div class="containerbreed">
				<div class="w-clearfix holderbreed wit">
					<?php if ($prev_vraag!=0) :?><a class="button vorige" href="/index.php/digileerwijzer/q/<?php echo $prevs_groep; ?>/<?php echo $prev_vraag; ?>">Vorige</a><?php endif;?>
					<input type="submit" <?php if (!$intro):?>  <?php endif;?> id="submit" value="Volgende" class="button volgende" style="border:0;background-color:#fff">
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
<script>
<?php if (!$intro) :?>
    var $total = $('#total'),
        $value =  $('.vraagantwoord');
        
    $('#form').submit( function(e) {
        var total = 0;
        
        $value.each(function(index, elem) {
            if(!isNaN(parseInt(this.value, 10)))
                total = total + parseInt(this.value, 10);
        });
        //$total.val(total);
        
        if (total == 100 ) {
            return;
        }
        else {
        	alert("Fout:\r\n\r\nPercentage hoger dan 100. Geef totaal maximaal 100 procent.");
        	e.preventDefault();
        }
            
        
    });

</script>
<?php endif;?>
<?php elseif ($action=='opslaan') :?>



<div class="progressbarholder">
	<div class="w-clearfix progressbar">
		<?php foreach ($grouptrail as $gr) : 
		$t++;?>
		<a class="w-clearfix w-inline-block progresslinkblock w--current" href="/index.php/digileerwijzer/q/1/0">
			<div class="progressstapbig <?php if ($t==1):?>activefirst<?php else:?>second<?php endif;?>">
				<h5  class="progressbarheader <?php if ($t==1):?>firstheader<?php else:?>secondheader<?php endif;?> active"><?php echo $gr['vg_naam']; ?></h5>
			</div>
		</a>
		<?php endforeach;?>	
		<a class="w-clearfix w-inline-block progresslinkblock w--current" href="/index.php/digileerwijzer/q/2/0">
			<div class="progressstapbig <?php if ($t==1):?>activethird<?php else:?>second<?php endif;?>">
				<h5  class="progressbarheader <?php if ($t==1):?>firstheader<?php else:?>thirdheader<?php endif;?> active">Scenario's</h5>
			</div>
		</a>
		<a class="w-clearfix w-inline-block progresslinkblock w--current" href="/index.php/digileerwijzer/suggesties/<?php echo $eID?>">
			<div class="progressstapbig <?php if ($t==1):?>activethird<?php else:?>second<?php endif;?>">
				<h5  class="progressbarheader <?php if ($t==1):?>firstheader<?php else:?>thirdheader<?php endif;?> active">Suggesties</h5>
			</div>
		</a>					
	</div>
</div>	

<div class="containerbreed">
	<div class="holderbreed blauw">
		<h2>Gegevens opslaan</h2><a href="/index.php/digileerwijzer/do_opslaan/<?php echo $eID;?>" <?php if (!$intro):?>  <?php endif;?>  class="button volgende" style="border:0;">Wel&nbsp;opslaan</a>
		<p class="onderwerpintro">U kunt uw gegevens opslaan. Zodra u digileerwijzer opnieuw gebruikt met dezelfde inloggegevens kunt u uw gegevens aanpassen of opnieuw inzien. </p>
	
	</div>

	<div class="holderbreed wit">
		<h2 style="color:black">Gegevens niet opslaan</h2><a href="/index.php/digileerwijzer/overzicht/<?php echo $eID;?>" <?php if (!$intro):?>  <?php endif;?>  class="button volgende" style="border:0;">Niet&nbsp;opslaan</a>
		<p class="onderwerpintro" style="color:black">Indien uw gegevens niet opslaat zijn ze alleen gedurende deze sessie beschikbaar. </p>
	
	</div>	
	</div>

<?php elseif ($action=='result') :?>




<div class="progressbarholder">
	<div class="w-clearfix progressbar">
		<?php foreach ($grouptrail as $gr) : 
		$t++;?>
		<a class="w-clearfix w-inline-block progresslinkblock w--current" href="/index.php/digileerwijzer/q/1/0">
			<div class="progressstapbig <?php if ($t==1):?>activefirst<?php else:?>second<?php endif;?>">
				<h5  class="progressbarheader <?php if ($t==1):?>firstheader<?php else:?>secondheader<?php endif;?> active"><?php echo $gr['vg_naam']; ?></h5>
			</div>
		</a>
		<?php endforeach;?>	
		<a class="w-clearfix w-inline-block progresslinkblock w--current" href="/index.php/digileerwijzer/q/2/0">
			<div class="progressstapbig <?php if ($t==1):?>activethird<?php else:?>second<?php endif;?>">
				<h5  class="progressbarheader <?php if ($t==1):?>firstheader<?php else:?>thirdheader<?php endif;?> active">Scenario's</h5>
			</div>
		</a>
		<a class="w-clearfix w-inline-block progresslinkblock w--current" href="/index.php/digileerwijzer/suggesties/<?php echo $eID?>">
			<div class="progressstapbig <?php if ($t==1):?>activethird<?php else:?>second<?php endif;?>">
				<h5  class="progressbarheader <?php if ($t==1):?>firstheader<?php else:?>thirdheader<?php endif;?> active">Suggesties</h5>
			</div>
		</a>					
	</div>
</div>	

<div class="containerbreed">
	<div class="holderbreed blauw">
		<h2> "Eet smakelijk"</h2><a href="/index.php/digileerwijzer/suggesties/<?php echo $eID;?>" <?php if (!$intro):?>  <?php endif;?>  class="button volgende" style="border:0;">Suggesties</a>
		<p class="onderwerpintro">Door middel van een metafoor wordt duidelijk welke digileerwijze bij uw toekomstvisie past. Onder elke metafoor kunt u via de knop Meer informatie een uitgebreide omschrijving van deze onderwijstypering vinden. Klikt u op Suggesties, dan krijgt u meer informatie over de te gebruiken media die bij uw visie passen.</p>
	
	</div>
</div>

<div class="profielsection">
    <div class="containerbreed">
      <div class="holderbreed wit">
        <div class="w-row profielrow">
        
        <!--  K -->
       
        
        <?php foreach ($visie as $key=>$v ): ?>
        
        
        <?php if($key=='K'):?>
          <div class="w-col w-col-3 w-clearfix">
            <div class="w-clearfix profielheader">
              <div class="profielpercentage <?php echo $visie['K']['grey'];?>">
                <div class="profielpercentagetekst"><?php  printf("%2d",$visie['K']['value']);?>%</div>
              </div>
              <div class="profielheading">
                <h4 class="eenregel blue <?php echo $visie['K']['grey'];?>">De thuiseters</h4>
              </div>
            </div>
            <div class="w-clearfix profielholder">
              <div class="fotoholder"><img src="<?php echo $this->getThemePath()?>/images/thuis-eten.jpg" width="100%" alt="5465f51c17ee63533d8533c0_thuis-eten.jpg">
              </div>
              <ul class="unorderedlist scenario vastehoogte <?php echo $visie['K']['grey'];?>">
                <li class="scenariolistitem">
                  <p>Gevarieerde, voedzame maaltijd</p>
                </li>
                <li class="scenariolistitem">
                  <p>Moeder heeft touwtjes in handen</p>
                </li>
                <li class="scenariolistitem">
                  <p>Kind doet mee: boodschappen, vaatwassen</p>
                </li>
                <li class="scenariolistitem">
                  <p>Techniek is hulpmiddel</p>
                </li>
              </ul><a class="button profiel <?php echo $visie['K']['grey'];?>" href="<?php echo BASE_URL;?>/index.php/digileerwijzer/details/<?php echo $key;?>/<?php echo $eID?>">Meer informatie</a>
            </div>
          </div>
          <?php endif; ?>
          <!--  A -->
           <?php if($key=='A'):?>
          <div class="w-col w-col-3 w-clearfix">
            <div class="w-clearfix profielheader">
              <div class="profielpercentage <?php echo $visie['A']['grey'];?>">
                <div class="profielpercentagetekst"><?php  printf("%2d",$visie['A']['value']);?>%</div>
              </div>
              <div class="profielheading">
                <h4 class="blue <?php echo $visie['A']['grey'];?>">De Amerikaanse barbecue</h4>
              </div>
            </div>
            <div class="w-clearfix profielholder">
              <div class="fotoholder"><img src="<?php echo $this->getThemePath()?>/images/amerikaansebbq.jpg" width="100%" alt="5465f5270f62bd513dc27982_amerikaansebbq.jpg">
              </div>
              <ul class="unorderedlist scenario vastehoogte <?php echo $visie['A']['grey'];?>">
                <li class="scenariolistitem">
                  <p>Iedere deelnemer actief en zelfstandig</p>
                </li>
                <li class="scenariolistitem">
                  <p>Gevarieerde gerechten</p>
                </li>
                <li class="scenariolistitem">
                  <p>Wisselende kwaliteit</p>
                </li>
                <li class="scenariolistitem">
                  <p>Feedback op kookprestaties</p>
                </li>
              </ul><a class="button profiel <?php echo $visie['A']['grey'];?>" href="<?php echo BASE_URL;?>/index.php/digileerwijzer/details/<?php echo $key;?>/<?php echo $eID?>">Meer informatie</a>
            </div>
          </div>
          <?php endif; ?>
        <!--  C -->          
           <?php if($key=='C'):?>
          <div class="w-col w-col-3 w-clearfix">
            <div class="w-clearfix profielheader">
              <div class="profielpercentage <?php echo $visie['C']['grey'];?>">
                <div class="profielpercentagetekst"><?php  printf("%2d",$visie['C']['value']);?>%</div>
              </div>
              <div class="profielheading">
                <h4 class="eenregel blue <?php echo $visie['C']['grey'];?>">Het wokrestaurant</h4>
              </div>
            </div>
            <div class="w-clearfix profielholder">
              <div class="fotoholder"><img src="<?php echo $this->getThemePath()?>/images/wokrestaurant.jpg" width="100%" alt="5465f52fad5ef59373f507ff_wokrestaurant.jpg">
              </div>
              <ul class="unorderedlist scenario vastehoogte <?php echo $visie['C']['grey'];?>">
                <li class="scenariolistitem">
                  <p>Gasten uitgedaagd door groot aanbod</p>
                </li>
                <li class="scenariolistitem">
                  <p>Nodigt uit om combinaties te proberen</p>
                </li>
                <li class="scenariolistitem">
                  <p>Kok adviseert, gast bepaalt z'n keuze</p>
                </li>
                <li class="scenariolistitem">
                  <p>Onderlinge feedback over kwaliteit</p>
                </li>
              </ul><a class="button profiel <?php echo $visie['C']['grey'];?>" href="<?php echo BASE_URL;?>/index.php/digileerwijzer/details/<?php echo $key;?>/<?php echo $eID?>">Meer informatie</a>
            </div>
          </div>
          <?php endif; ?>
          <!--  S -->
           <?php if($key=='S'):?>
          <div class="w-col w-col-3 w-clearfix">
            <div class="w-clearfix profielheader">
              <div class="profielpercentage <?php echo $visie['S']['grey'];?>">
                <div class="profielpercentagetekst"><?php  printf("%2d",$visie['S']['value']);?>%</div>
              </div>
              <div class="profielheading">
                <h4 class="eenregel blue <?php echo $visie['S']['grey'];?>">De kookworkshop</h4>
              </div>
            </div>
            <div class="w-clearfix profielholder">
              <div class="fotoholder"><img src="<?php echo $this->getThemePath()?>/images/kookworkshop.jpg" width="100%" alt="5465f53706fd919573373f25_kookworkshop.jpg">
              </div>
              <ul class="unorderedlist scenario vastehoogte <?php echo $visie['S']['grey'];?>">
                <li class="scenariolistitem">
                  <p>Leren door participeren</p>
                </li>
                <li class="scenariolistitem">
                  <p>Samenwerken is randvoorwaarde</p>
                </li>
                <li class="scenariolistitem">
                  <p>Leerling intensief betrokken bij proces</p>
                </li>
                <li class="scenariolistitem">
                  <p>Technologie is royaal aanwezig</p>
                </li>
              </ul><a class="button profiel <?php echo $visie['S']['grey'];?>" href="<?php echo BASE_URL;?>/index.php/digileerwijzer/details/<?php echo $key;?>/<?php echo $eID?>">Meer informatie</a>
            </div>
          </div>
       		<?php endif; ?>
       	<?php endforeach;?>
       
       
       
        </div>
      </div>
    </div></div>
    
<?php elseif ($action=='details'):?>    

	<?php include('details-'.$p.'.php');?>
             
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php elseif ($action=='suggesties'):?>
<div id="maincontainer">

    <div id="maincontainer_contents_fullpage">

            

	  <div class="contentsection">
    <div class="progressbarholder">
      <div class="w-clearfix progressbar">
        <a class="w-clearfix w-inline-block progresslinkblock" href="../onderwijsvisie-intro.html">
          <div class="progressstapbig activefirst">
            <h5 class="progressbarheader firstheader inactive">Visie op onderwijs</h5>
          </div>
        </a>
        <a class="w-clearfix w-inline-block progresslinkblock" href="../mediavisie-intro.html">
          <div class="progressstapbig second activesecond">
            <h5 class="progressbarheader inactivemedia">Visie op mediagebruik</h5>
          </div>
        </a>
        <a class="w-clearfix w-inline-block progresslinkblock" href="/index.php/digileerwijzer/resultaten/<?php echo $eID;?>">
          <div class="progressstapbig second activethird">
            <h5 class="progressbarheader active">Scenario's</h5>
          </div>
        </a>
        
      </div>
    </div>
    <div class="containerbreed">
      <div class="w-clearfix holderbreed blauw"><a class="button vorige terug" href="/index.php/digileerwijzer/resultaten/<?php echo $eID;?>">Terug</a>
        <h2 class="scenario">Suggesties voor mediagebruik</h2>
        <div class="w-clearfix scenarioscoreholder">
<a target="_blank" class="button volgende" href="/index.php/digileerwijzer/createPdf/<?php echo $eID;?>">PDF</a>
        </div>
      </div>
    </div>
  </div>  
<div class="profielsection">
    <div class="containerbreed">
      <div class="holderbreed wit">
        <div class="w-row profielrow" style="color:black;">

       
In de bijlage die u aan het eind in de vorm van een PDF krijgt, kunt u per onderdeel een verdergaande praktische invulling van deze suggesties terugvinden met veel aanklikbare linken. 
         
  <table border=1>
	  <tr>
		  <td Width="50%">Wat het beste bij de samengestelde visie op onderwijs past</td>
		  <td Width="50%">Wat in mindere mate ook bij de samengestelde visie op onderwijs past.</td>
	  </tr>

  <?php foreach (array('F'=>'Focus van het onderwijs','V'=>'Vormen van Feedback','S'=>'Sturing van het leren','O'=>'Organisatie van het leren','M'=>'Manier van leren','P'=>'Vormen van ontmoeting') as $onderdeel=>$titel):?>
  	<tr><td colspan="2" align="center"><span  style="color:#3D6892;   font-size: 16px;
    font-weight: bold;"><?php echo $titel;?></span></td></tr> 	
  	
  	<?php $k=( Concrete\Package\Digileerwijzer\Models\DglwResult::getResultByWeging($eID, $onderdeel.'%',2));?>
  	<tr>
  	<?php foreach ($k as $d) : ?> 	
  		
		<?php $dG=$this->controller->bepaalDiepgang($d['weging'],$eID);?>

	<td valign="top"><strong><em>Wat het beste bij de visie op media-inzet past:</em></strong>
		<?php 
		$mTv=$dG['best'];
		?>
		
  			<p ><?php echo "<strong>".$mTv['value'].": ( ".$mTv['waarde']."% ): </strong>"; echo Concrete\Package\Digileerwijzer\Models\DglwResult::getSuggestiesText($mTv['value'],$detail);?></p>

  		
  		
  		<br /><strong><em>Wat niet direct bij de visie past, maar mogelijk ook interessant is:</em></strong>
		<?php 
		foreach ($dG['interest'] as $mTv):
		?>
		
  			<p ><?php echo "<strong>".$mTv['value'].": ( ".$mTv['waarde']."% ): </strong>"; echo Concrete\Package\Digileerwijzer\Models\DglwResult::getSuggestiesText($mTv['value'],$detail);?></p>

  		<?php endforeach;?>  		
  	</td>
  	<?php endforeach;?>
  	</tr>
  <?php endforeach;?> 
  </table>           
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php elseif ($action=='overzicht'):?>
  <div class="contentsection">
    <div class="progressbarholder">
      <div class="w-clearfix progressbar">
        <a class="w-clearfix w-inline-block progresslinkblock" href="/index.php/digileerwijzer/q/1/0">
          <div class="progressstapbig activefirst">
            <h5 class="progressbarheader firstheader inactive">Visie op onderwijs</h5>
          </div>
        </a>
        <a class="w-clearfix w-inline-block progresslinkblock" href="/index.php/digileerwijzer/q/2/0">
          <div class="progressstapbig second activesecond">
            <h5 class="progressbarheader inactivemedia">Visie op mediagebruik</h5>
          </div>
        </a>
        <a class="w-clearfix w-inline-block progresslinkblock" href="/index.php/digileerwijzer/resultaten/<?php echo $eID?>">
          <div class="progressstapbig second activethird">
            <h5 class="progressbarheader active">Resultaat</h5>
          </div>
        </a>
        
      </div>
    </div>
    <div class="containerbreed">
      <div class="w-clearfix holderbreed blauw">
        <h2 class="scenario">Resultaat</h2>
        <div class="w-clearfix scenarioscoreholder">
          <div class="scenariouwscorer"></div>

        </div>
      </div>
    </div>
  </div>
  <div class="profielsection">
    <div class="containerbreed">
      <div class="holderbreed wit">
        <div class="w-row profielrow" style="color:black;">
        	<table style="margin-top:40px;">
			 <?php 
			 $rij=array(
			 		'F'=>'Focus van het onderwijs',
			 		'V'=>'Vormen van Feedback',
			 		'S'=>'Sturing van het leren',
			 		'O'=>'Organisatie van het leren',
			 		'M'=>'Manier van leren',
			 		'P'=>'Vormen van ontmoeting',
			 		
			 		
			 );
			 $kolom=array(
			 		'K'=>'De thuiseters',
			 		'A'=>'De Amerikaanse barbecue',
			 		'C'=>'Het wokrestaurant',
			 		'S'=>'De kookworkshop'
			 );
			 
			 $kolom_i=0;
			 foreach ($vO as $k=>$a): ?>
			 	<?php if ($kolom_i==0) :?>
			 	<tr><th class="rotate" style="width:350px;"></th>
			 	<?php 
	 		
	 				foreach($a as $A_k=>$A_v):
	 				$kolom_i=1;?>
			 			<th class="rotate"><div><span><?php echo $kolom[$A_k];?></span></div></th>
			 		<?php endforeach;?>
			 		
			 	
			 	
			 	</tr>
			 	<?php endif;?>
				<tr>
					<td class="result row"><?php echo $rij[$k];?></td>
				 	<?php foreach ( $a as $A_k=>$A_v):?>
				 	 	<td class="result data" style="background-color:rgb(<?php echo round(255-($A_v/100)*255); ?>,255,<?php echo round(255-($A_v/100)*255); ?>)"><?php echo $A_v."%";?></td>
				 	<?php endforeach;?> 
				 	</tr>
			 	 <?php endforeach;?>
			 </table>
			 
			 
       	<table>
			 <?php 
			 $rij=array(
			 		'H'=>'Houding t.o.v. mediagebruik',
			 		'I'=>'Intensiteit van mediagebruik',
			 		'B'=>'Begeleide confrontatie/vreemdelingschap',
			 		'W'=>'Concentratie en woordgerichtheid',
			 		'A'=>'Altru&iuml;sme vs individualisme'
			 		
			 		
			 		
			 );
			 $kolom=array(
			 		'1'=>'Zeer terughoudend',
			 		'2'=>'Beperkt',
			 		'3'=>'Ruimhartig',
			 		'4'=>'Zeer vooruitstrevend'
			 );
			 
			 $kolom_i=0;
			 foreach ($mO as $k=>$a): ?>
			 	<?php if ($kolom_i==0) :?>
			 	<tr><th class="rotate"  style="width:350px;"></th>
			 	<?php 
			 		
			 				foreach($a as $A_k=>$A_v):
			 				$kolom_i=1;?>
			 			<th class="rotate"><div><span><?php echo $kolom[$A_k];?></span></div></th>
			 		<?php endforeach;?>
			 		
			 	
			 	
			 	</tr>
			 	<?php endif;?>
				<tr>
					<td class="result row"><?php echo $rij[$k];?></td>
				 	<?php foreach ( $a as $A_k=>$A_v):?>
				 	 	<td class="result data" style="background-color:rgb(<?php echo round(255-($A_v/100)*255); ?>,255,<?php echo round(255-($A_v/100)*255); ?>)"><?php echo $A_v."%";?></td>
				 	<?php endforeach;?> 
				 	</tr>
			 	 <?php endforeach;?>
			 </table>			 
			 
           </div>
        </div>
      </div>
    </div>
  </div> 
  
  		<div class="navigatiesection">
			<div class="containerbreed">
				<div class="w-clearfix holderbreed wit">
					<a class="button vorige" href="/index.php/digileerwijzer/q/2/5">Vorige</a>
					<a class="button volgende" href="/index.php/digileerwijzer/resultaten/<?php echo $eID?>">Volgende</a>
				</div>
			</div>
		</div>
  <?php elseif ($action=='pdfTemplate'):?>		
  <style>.holderbreed{width:auto;}
  body{ background-color:#ffffff;}
  </style>
  Datum: <?php echo Concrete\Package\Digileerwijzer\Models\DglwResult::getInvulDatumByEid($enqueteID);?>
  <br />
  <br />
  Contactpersoon: <?php $persoon= Concrete\Package\Digileerwijzer\Models\DglwResult::getInvulPersoonByEid($enqueteID);
  echo $persoon['naam'];
  ?>
  <br />
  <br />
  Team: <?php echo Concrete\Package\Digileerwijzer\Models\DglwResult::getInvulTeamByEid($enqueteID);?>
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
 <br /> 
  
  <h1 style="color:black">1. Visie op onderwijs</h1>
Een veelgemaakte fout is dat een school begint met het aanschaffen van apparatuur en het aanleggen van een netwerk zonder dat er een duidelijke visie is geformuleerd. "We hebben acht iPads gekocht en die circuleren nu zodat de leerkrachten wat kunnen uitproberen." 
Technologie mag niet leidend zijn bij onze keuzes. De Digileerwijzer heeft u een aantal kritische vragen gesteld om uw visie op onderwijs scherp te krijgen. Wie moet volgens u de regie hebben bij het leren: de leraar of de leerling? Gaat het in uw lessen om weten of om begrijpen? Hoe belangrijk is de ontmoeting tussen leraar en leerling? Het antwoord op deze vragen is belangrijk - dat bepaalt hoe u die media wilt gaan inzetten.
Aan de hand van zes vragen denkt u na over uw visie op onderwijs. De vragen gaan over:
  <br /> 
 <br />  
       	<table style="margin-top:40px;">
			 <?php 
			 $rij=array(
			 		'F'=>'Focus van het onderwijs',
			 		'V'=>'Vormen van Feedback',
			 		'S'=>'Sturing van het leren',
			 		'O'=>'Organisatie van het leren',
			 		'M'=>'Manier van leren',
			 		'P'=>'Vormen van ontmoeting',
			 		
			 		
			 );
			 $kolom=array(
			 		'K'=>'De thuiseters',
			 		'A'=>'De Amerikaanse barbecue',
			 		'C'=>'Het wokrestaurant',
			 		'S'=>'De kookworkshop'
			 );
			 
			 $kolom_i=0;
			 foreach ($vO as $k=>$a): ?>
			 	<?php if ($kolom_i==0) :?>
			 	<tr><th class="rotate" style="width:350px;"></th>
			 	<?php 
	 		
	 				foreach($a as $A_k=>$A_v):
	 				$kolom_i=1;?>
			 			<th class="rotate"><div><span><?php echo $kolom[$A_k];?></span></div></th>
			 		<?php endforeach;?>
			 		
			 	
			 	
			 	</tr>
			 	<?php endif;?>
				<tr>
					<td class="result row"><?php echo $rij[$k];?></td>
				 	<?php foreach ( $a as $A_k=>$A_v):?>
				 	 	<td class="result data" style="background-color:rgb(<?php echo round(255-($A_v/100)*255); ?>,255,<?php echo round(255-($A_v/100)*255); ?>)"><?php echo $A_v."%";?></td>
				 	<?php endforeach;?> 
				 	</tr>
			 	 <?php endforeach;?>
			 </table> 
  <br /> 
 <br />  
De focus van het onderwijs: programmagericht of ontwikkelingsgericht?
Vormen van feedback: wie koppelt terug en hoe gebeurt dat?
Sturing van het leren: wie is verantwoordelijk voor het leerproces?
Organisatie van het leren: gericht op samenwerking of op alleen leren?
Manier van leren: gericht op weten of op begrijpen?
Vormen van ontmoeting: hoe belangrijk is fysieke aanwezigheid van personen en voorwerpen?
  
    <br /> 
 <br /> 
  <h1 style="color:black">2. Visie op mediagebruik</h1>
Wordt het Microsoft of Google, Apple of Samsung? Belangrijke vragen, maar niet d&eacute; belangrijkste. Bij Digileerwijzer gaan we een spa dieper. Wat vindt u: moeten we mediagebruik op school aanmoedigen of juist afremmen? Moeten we ons zorgen maken over de verminderde aandacht van leerlingen? Is de beeldcultuur een bedreiging of moeten leerlingen daar juist mee leren omgaan? 
Deze tweede serie vragen van Digileerwijzer gaat dus over uw visie op mediagebruik. Media hebben grote invloed op de leefwereld van jongeren en het gebruik op school staat daar niet los van. Het antwoord op deze vragen speelt daarom ook een rol bij keuzes rond mediagebruik in het onderwijs.
    <br /> 
 <br />   
  
      	<table>
			 <?php 
			 $rij=array(
			 		'H'=>'Houding t.o.v. mediagebruik',
			 		'I'=>'Intensiteit van mediagebruik',
			 		'B'=>'Begeleide confrontatie/vreemdelingschap',
			 		'W'=>'Concentratie en woordgerichtheid',
			 		'A'=>'Altru&iuml;sme vs individualisme'
			 		
			 		
			 		
			 );
			 $kolom=array(
			 		'1'=>'Zeer terughoudend',
			 		'2'=>'Beperkt',
			 		'3'=>'Ruimhartig',
			 		'4'=>'Zeer vooruitstrevend'
			 );
			 
			 $kolom_i=0;
			 foreach ($mO as $k=>$a): ?>
			 	<?php if ($kolom_i==0) :?>
			 	<tr><th class="rotate"  style="width:350px;"></th>
			 	<?php 
			 		
			 				foreach($a as $A_k=>$A_v):
			 				$kolom_i=1;?>
			 			<th class="rotate"><div><span><?php echo $kolom[$A_k];?></span></div></th>
			 		<?php endforeach;?>
			 		
			 	
			 	
			 	</tr>
			 	<?php endif;?>
				<tr>
					<td class="result row"><?php echo $rij[$k];?></td>
				 	<?php foreach ( $a as $A_k=>$A_v):?>
				 	 	<td class="result data" style="background-color:rgb(<?php echo round(255-($A_v/100)*255); ?>,255,<?php echo round(255-($A_v/100)*255); ?>)"><?php echo $A_v."%";?></td>
				 	<?php endforeach;?> 
				 	</tr>
			 	 <?php endforeach;?>
			 </table>	     <br /> 
 <br />  
Media-educatie: in de vorm van een aparte les of in alle vakken?
Extensief of intensief: moeten we mediagebruik stimuleren of afremmen
Begeleide confrontatie: hoe moeten leerlingen omgaan met invloeden van buiten?
Concentratie: hoe ernstig is het probleem van afleiding door mediagebruik?
Altru&iuml;sme: moet mediagebruik gericht zijn op dienstbaarheid aan anderen of juist op eigen belang?
	    <br /> 
 <br /> 
 		<h1 style="color:black"> 3. Scenario's</h1>
Digileerwijzer schets aan de hand van de onderwijs- en mediavisie een scenario voor u. Dat is nog geen blauwdruk voor uw ict-plannen voor de komende jaren. Het is pas het begin van een traject waarbij nog tal van andere vragen verschijnen. Maar het scenario wijst u wel een bepaalde richting en die is optimaal afgestemd op uw visie op leren en mediagebruik. Hieronder ziet u hoeveel procent uw keuzes overeenkomen met de 4 scenario's. Een beschrijving van deze scenario's kunt u daaronder vinden
 		    <br /> 
 <br /> 	
Beschrijving scenario's
De Kookworkshop
Elke dinsdagavond volgen acht vrienden, in een lokaal boven de kookwinkel een workshop. In steeds wisselende koppels bereiden ze een onderdeel van een diner.  
	    <br /> 
 <br /> 
In overleg beslissen de vrienden welke gerechten er op het menu komen. Bij de chefkok en zijn keukenassistent kunnen zij vervolgens terecht voor de recepten en tips en aanwijzingen voor het bereiden ervan. 
 	    <br /> 
 <br />  
De chefkok geeft gevraagd en ongevraagd advies tijdens de bereiding, zowel wat betreft de te gebruiken hulpmiddelen als bij de receptuur. In het kooklokaal zijn allerlei handige keukenapparaten aanwezig en er is een groot aanbod aan ingredi&euml;nten. Nadat het diner is gemaakt, eten de vrienden de gerechten gezamenlijk op in het restaurantgedeelte. 
Samenwerken
De 'kookworkshop' staat model voor samenwerken: leren door participeren. De leerling is intensief betrokken bij het hele proces. Centraal staat dat ze elkaar helpen om tot een goed en gevarieerd resultaat te komen, met veel variatie in bereidingswijze en gerechten, en veel mogelijkheden om van elkaar te leren.
Adviezen
Samenwerkend leren is niet noodzakelijkerwijs verbonden met de inzet van veel technologie. Zoals bij een kookworkshop iemand kan kiezen voor een heel ambachtelijke benadering of juist voor hightech bij de bereiding - zo geldt dat ook hier.
	    <br /> 
 <br /> 
Het Wokrestaurant
Een  vriendenclub gaat regelmatig samen uit eten en kiest vanwege de verschillende voorkeuren voor een wokrestaurant. Iedere gast kan daar wat vinden dat bij zijn voorkeur past. Wie niet van wokken houdt, kiest friet met een gehaktbal. Ook de hoeveelheid gerechten en het aantal rondes is vrij.  
	    <br /> 
 <br /> 
Elke gast maakt zelf een keus uit de aangeboden gerechten en sausen, maar hij hoeft ze niet zelf te bereiden. De ingredi&euml;nten zijn aantrekkelijk gepresenteerd, zodat ze uitnodigen om verschillende combinaties uit te proberen. Wie geen keus kan maken, vraagt anderen naar hun ervaring - de drempel om een gesprek te beginnen met gasten buiten de vriendenkring is laag. Sommige gerechten worden vaak gekozen. Dat stimuleert anderen om daar ook voor te kiezen.  
	    <br /> 
 <br /> 
De rol van de kok is beperkt tot het bereiden van de gerechten. Soms geeft hij advies: deze saus is extra pittig, deze combinatie van vlees en vis is heerlijk. De klant is helemaal vrij in zijn keuze - maar is het gerecht eenmaal bereid dan lijkt de inhoud van de verschillende borden verrassend veel op elkaar...  
	    <br /> 
 <br /> 
Een wokrestaurant dat veel keus biedt, een grote voorraad heeft en de verschillende soorten vlees en vis mooi presenteert, is aantrekkelijker. Ook sfeer en de prijs-kwaliteitverhouding zijn belangrijke factoren.
Contextrijk
Het wokrestaurant is een metafoor voor de contextrijke lessituatie. De leerling wordt uitgedaagd en nieuwsgierig gemaakt door een royaal aanbod aan lesinhouden. Docenten adviseren de leerlingen, maar zij kunnen hun licht ook opsteken bij externe experts. Daarnaast letten ze goed op elkaars gedrag en resultaten: kunst afkijken en oefenen.
Adviezen
Een contextrijke onderwijssituatie is mogelijk met beperkte inzet van technologie. Een voorbeeld daarvan is het praktijkonderwijs waarbij leerlingen 'zorg verlenen' aan medeleerlingen op een bed in het praktijklokaal. Maar het gebruik van ict en media kan deze onderwijssituatie sterk verrijken. 
	    <br /> 
 <br /> 
De Amerikaanse barbecue
Bij de Amerikaanse barbecue, de 'potluck', brengt iedere gast een gerecht mee dat hij of zij lekker vindt, bereidt naar zijn persoonlijke voorkeur. 
  	    <br /> 
 <br /> 
Voor zo'n gerecht beslis je zelf wat je aan ingredi&euml;nten koopt. Iedereen neemt zijn of haar gerecht mee en samen vormt dit de maaltijd. Er zijn speciale websites waarmee de gasten hun maaltijd kunnen plannen om te voorkomen dat iedereen hetzelfde gerecht meebrengt. 
	    <br /> 
 <br /> 
De presentaties van de meegebrachte gerechten kunnen sterk verschillen. Mensen met weinig tijd kopen wellicht iets dat al kant-en-klaar is, maar iemand die graag kookt maakt een speciaal hapje voor de andere gasten en zorgt ook dat het er leuk en smakelijk uit ziet.  
	    <br /> 
 <br /> 
Bij een wat grotere barbecue eten de gasten vaak in kleinere groepjes in plaats van met z'n allen. Tijdens de maaltijd blijkt uit de reacties of de andere gasten de gerechten lekker vonden of niet.
Actief zelfstandig
De 'Amerikaanse barbecue' staat model voor een lessituatie afgestemd op actieve, zelfstandige leerlingen. Heel gevarieerd, maar de 'gerechten' zijn van wisselende kwaliteit.  
	    <br /> 
 <br /> 
De leraar, in dit model de 'gastheer' van de barbecue, bouwt wel een aantal randvoorwaarden in ('de gasten mogen niet met lege handen op de barbecue komen'), maar biedt de leerlingen veel vrijheid. Hij stimuleert de zelfwerkzaamheid en de nadruk ligt meer op het proces dan op het resultaat. De leerlingen kennen het 'recept': ze moeten zelf actief bijdragen aan het eindresultaat. Maar de ene leerling stopt er meer tijd in dan de ander en 'bakt' er dan ook meer van. 
	    <br /> 
 <br /> 
De samenwerking en afstemming tussen leerlingen is beperkt, maar ze leveren wel onderlinge feedback op elkaars prestaties. Zo organiseren ze hun eigen leerproces. 
	    <br /> 
 <br /> 
Een lessituatie met actieve zelfstandige leerlingen gaat niet noodzakelijkerwijs gepaard met intensief mediagebruik. Maar er zijn veel ict-toepassingen die de leerling kunnen helpen om zelfstandig zijn eigen leerroute samen te stellen. Zij kunnen kiezen uit een royaal aanbod van media en nemen daar zelf ook het initiatief toe. Een elektronisch portfolio is hierbij een nuttig hulpmiddel. 
Adviezen
Een onderwijssituatie gebaseerd op actieve zelfstandige leerlingen betekent dat de leraar meer een coach is dan een docent.
	    <br /> 
 <br /> 
De Thuiseter
Gezellig, iedereen eet vanavond thuis. Moeder heeft vanmorgen al verteld wat er die avond gegeten wordt. In de meeste gevallen bepaalt zij zelf wat er op tafel komt: 's zondag soep, op zaterdag friet en op de andere dagen is er een eenvoudige voedzame maaltijd.  
	    <br /> 
 <br /> 
Meestal doet moeder zelf de boodschappen voor de maaltijd, volgens een voorgeschreven lijstje gehaald. Soms schilt &eacute;&eacute;n van de kinderen de aardappels. Tafeldekken en afwassen is een roulerende taak voor de kinderen in het gezin. 
  	    <br /> 
 <br /> 
Tijdens de maaltijd is er tijd voor persoonlijke aandacht. Natafelen is er echter meestal niet bij. Voor ieder weer aan zijn of haar bezigheden gaat, moet er nog wel worden afgeruimd en afgewassen.
Klassiek
De 'thuiseters' staan model voor de klassieke lessituatie. Een gevarieerde en voedzame 'maaltijd', keurig bereid volgens de schijf van vijf en dankzij het kookboek verloopt de bereiding probleemloos.
	    <br /> 
 <br /> 
Het onderwijs is docentgestuurd. De leraar, 'moeder' in dit model, heeft de touwtjes in handen, maar heeft er ook zijn handen aan vol. Hij bereidt de inhoud van de lessen goed voor en is intensief betrokken bij de invulling ervan. De leerling heeft ook zijn aandeel ('boodschappen doen, aardappels schillen, afruimen en de vaat'), maar dat zit meer in de marge van de les. 
	    <br /> 
 <br /> 
Bij deze lessituatie is er ruimte voor het inzetten van ict en media. De 'thuiseters' in deze metafoor kunnen een vaatwasser, keukenmachine en magnetron gebruiken zonder dat dat afbreuk doet aan de kwaliteit van de maaltijd: dat verlicht de taken, biedt moeder meer tijd voor een goed gesprek of het leren koken door de andere gezinsleden en draagt zo bij aan gezelligheid tijdens het eten. 
Adviezen
Niets mis met dit model: oost-west-thuis-best! Maar.. overweeg eens de mogelijkheid om de rollen om te draaien? Of de andere gezinsleden meer bij het bereiden van de maaltijd te betrekken? Of wat meer variatie aan te brengen door eens een uitstapje te maken naar een 'oosterse keuken'
	    <br /> 
 <br /> 
 
 <h1 style="color:black">4. Suggesties voor mediagebruik</h1>
In deze bijlage kunt u per onderdeel een verdergaande praktische invulling van deze suggesties terugvinden met veel aanklikbare linken. 
 
   <table border=1>
	  <tr>
		  <td Width="50%">Wat het beste bij de samengestelde visie op onderwijs past</td>
		  <td Width="50%">Wat in mindere mate ook bij de samengestelde visie op onderwijs past.</td>
	  </tr>

  <?php foreach (array('F'=>'Focus van het onderwijs','V'=>'Vormen van Feedback','S'=>'Sturing van het leren','O'=>'Organisatie van het leren','M'=>'Manier van leren','P'=>'Vormen van ontmoeting') as $onderdeel=>$titel):?>
  	<tr><td colspan="2" align="center"><span  style="color:#3D6892;   font-size: 16px;
    font-weight: bold;"><?php echo $titel;?></span></td></tr> 	
  	
  	<?php $k=( Concrete\Package\Digileerwijzer\Models\DglwResult::getResultByWeging($eID, $onderdeel.'%',2));?>
  	<tr>
  	<?php foreach ($k as $d) : ?> 	
  		
		<?php $dG=$this->controller->bepaalDiepgang($d['weging'],$eID);?>

	<td valign="top"><strong><em>Wat het beste bij de visie op media-inzet past:</em></strong>
		<?php 
		$mTv=$dG['best'];
		?>
		
  			<p ><?php echo "<strong>".$mTv['value'].": ( ".$mTv['waarde']."% ): </strong>"; echo Concrete\Package\Digileerwijzer\Models\DglwResult::getSuggestiesText($mTv['value'],$detail);?></p>

  		
  		
  		<br /><strong><em>Wat niet direct bij de visie past, maar mogelijk ook interessant is:</em></strong>
		<?php 
		foreach ($dG['interest'] as $mTv):
		?>
		
  			<p ><?php echo "<strong>".$mTv['value'].": ( ".$mTv['waarde']."% ): </strong>"; echo Concrete\Package\Digileerwijzer\Models\DglwResult::getSuggestiesText($mTv['value'],$detail);?></p>

  		<?php endforeach;?>  		
  	</td>
  	<?php endforeach;?>
  	</tr>
  <?php endforeach;?> 
  </table>  
  
  <br />
  <br />
  <h1 style="color:white">5. Concrete invulling van de suggesties voor mediagebruik</h1>
  Gaan we dat in het concrete voorbeeld invullen, dan ontstaat het volgende beeld voor Suggesties:
  <br />
  
     <table border=1>
	  <tr>
		  <td Width="50%">Wat het beste bij de samengestelde visie op onderwijs past</td>
		  <td Width="50%">Wat in mindere mate ook bij de samengestelde visie op onderwijs past.</td>
	  </tr>

  <?php foreach (array('F'=>'Focus van het onderwijs','V'=>'Vormen van Feedback','S'=>'Sturing van het leren','O'=>'Organisatie van het leren','M'=>'Manier van leren','P'=>'Vormen van ontmoeting') as $onderdeel=>$titel):?>
  	<tr><td colspan="2" align="center"><span  style="color:#3D6892;   font-size: 16px;
    font-weight: bold;"><?php echo $titel;?></span></td></tr> 	
  	
  	<?php $k=( Concrete\Package\Digileerwijzer\Models\DglwResult::getResultByWeging($eID, $onderdeel.'%',2));?>
  	<tr>
  	<?php foreach ($k as $d) : ?> 	
  		
		<?php $dG=$this->controller->bepaalDiepgang($d['weging'],$eID);?>

	<td valign="top"><strong><em>Wat het beste bij de visie op media-inzet past:</em></strong>
		<?php 
		$mTv=$dG['best'];
		?>
		
  			<p ><?php echo "<strong>".$mTv['value'].": ( ".$mTv['waarde']."% ): </strong>"; echo Concrete\Package\Digileerwijzer\Models\DglwResult::getSuggestiesText($mTv['value'],1);?></p>

  		
  		
  		<br /><strong><em>Wat niet direct bij de visie past, maar mogelijk ook interessant is:</em></strong>
		<?php 
		foreach ($dG['interest'] as $mTv):
		?>
		
  			<p ><?php echo "<strong>".$mTv['value'].": ( ".$mTv['waarde']."% ): </strong>"; echo Concrete\Package\Digileerwijzer\Models\DglwResult::getSuggestiesText($mTv['value'],1);?></p>

  		<?php endforeach;?>  		
  	</td>
  	<?php endforeach;?>
  	</tr>
  <?php endforeach;?> 
  </table> 
  <script>window.print();</script>
 
<?php endif;?>