<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
$this->inc('elements/header.php'); ?>

 

<div class="contentsection">
    <div class="contentsection">
      <div class="containerbreed">
        <div class="holderbreed darkblue">
          <h1>Welkom bij Digileerwijzer</h1>
          <div class="w-row homerow">
            <div class="w-col w-col-6 homerowcolumn1">
              <p class="onderwerpintro intro">Dit hulpmiddel wijst u de 
weg in het oerwoud van keuzes rond digitale leermiddelen. Vul, liefst in
 overleg met uw teamgenoten, de vragenlijsten in en ontdek welke keuzes 
het beste passen bij uw visie en uw onderwijssituatie.&nbsp;</p>
              <h3 class="wit">Digileerwijzer</h3>
              <p class="onderwerpintro">Onderwijs is in beweging. Wie 
zijn oor te luister legt bij de goeroes van de 21e eeuw, voelt de 
spanning. "We klikken ons verstand kapot", schrijft dr. Manfred Spitzer.
 "We bereiden onze kinderen niet voor op de maatschappij van 2025 maar 
van 1990", zegt Maurice de Hond.&nbsp;
                <br> Welke richting is de juiste - en welke 
consequenties heeft dat voor de vele keuzes bij het gebruik van ict en 
media in het onderwijs? De Digileerwijzer helpt u daarbij, in drie 
stappen:&nbsp;</p>
              <h3 class="wit">1. Visie op onderwijs</h3>
              <p class="onderwerpintro">Een veelgemaakte fout is dat een
 school begint met het aanschaffen van apparatuur en het aanleggen van 
een netwerk zonder dat er een duidelijke visie is geformuleerd. "We 
hebben acht iPads gekocht en die circuleren nu zodat de leerkrachten wat
 kunnen uitproberen."&nbsp;
                <br> Technologie mag niet leidend zijn bij onze keuzes. 
De Digileerwijzer stelt u een aantal kritische vragen om uw visie op 
onderwijs scherp te krijgen. Wie moet volgens u de regie hebben bij het 
leren: de leraar of de leerling? Gaat het in uw lessen om weten of om 
begrijpen? Hoe belangrijk is de ontmoeting tussen leraar en leerling? 
Het antwoord op deze vragen is belangrijk - dat bepaalt hoe u die media 
wilt gaan inzetten.</p>
            </div>
            <div class="w-col w-col-6 homerowcolumn2">
              <h3 class="wit">2. Visie op mediagebruik</h3>
              <p class="onderwerpintro">Wordt het Microsoft of Google, 
Apple of Samsung? Belangrijke vragen, maar niet d&eacute; belangrijkste. Bij 
Digileerwijzer gaan we een spa dieper. Wat vindt u: moeten we 
mediagebruik op school aanmoedigen of juist afremmen? Moeten we ons 
zorgen maken over de verminderde aandacht van leerlingen? Is de 
beeldcultuur een bedreiging of moeten leerlingen daar juist mee leren 
omgaan?
                <br> Deze tweede serie vragen van Digileerwijzer gaat 
dus over uw visie op mediagebruik. Media hebben grote invloed op de 
leefwereld van jongeren en het gebruik op school staat daar niet los 
van. Het antwoord op deze vragen speelt daarom ook een rol bij keuzes 
rond mediagebruik in het onderwijs.</p>
              <h3 class="wit">3. Scenario's</h3>
              <p class="onderwerpintro">Als u een tiental vragen heeft 
beantwoord, schetst Digileerwijzer een scenario voor u. Dat is nog geen 
blauwdruk voor uw ict-plannen voor de komende jaren. Het is pas het 
begin van een traject waarbij nog tal van andere vragen verschijnen. 
Maar het scenario wijst u wel een bepaalde richting en die is optimaal 
afgestemd op uw visie op leren en mediagebruik.&nbsp;</p>
              <h3 class="wit">Werkwijze</h3>
              <p class="onderwerpintro">Digileerwijzer is meer dan een 
simpele vragenlijst. Het gaat niet alleen om de antwoorden op de vragen,
 maar om het denkproces dat daar aan vooraf gaat. Daarom haalt u het 
meeste uit deze Digileerwijzer als u die samen met uw collega's invult. 
Dat kunnen de collega's uit uw team, sectie, vakgroep of afdeling zijn -
 in elk geval de collega's met wie u in een vergelijkbare 
onderwijssituatie zit.&nbsp;
                <br> Neem er even de tijd voor, een half uur tot een 
uur. Bespreek samen elke vraag voor u antwoord geeft. U kunt ervoor 
kiezen om &eacute;&eacute;n lijst in te vullen per groep of als groepsleden ieder de 
lijst in te vullen.&nbsp;</p>
            </div>
          </div>
          <?php 
          $this->requireAsset('javascript', 'jquery');
$c = Page::getCurrentPage();
$form = Loader::helper('form');
?>


          <h2 class="home">Inschrijven</h2>
          <div class="holderbreed wit2">
            <div class="w-form inschrijfformulierwrapper">
              <form action ="/index.php/Digileerwijzer/q" class="inschrijfformulier" 
              		id="wf-form-Inschrijfformulier" 
              		name="wf-form-Inschrijfformulier" 
              		method="post">
                <div class="w-row inschrijfformulierrow">
                  <div class="w-col w-col-4 w-clearfix inschrijfcolumn1">
                    <label class="veldlabel" for="name">Naam:</label>
                  </div>
                  <div class="w-col w-col-8 w-clearfix inschrijfcolumn2">
                    <input class="w-input invoerveld" id="naam" placeholder="Uw naam" name="naam" data-name="naam" required="required" type="text">
                  </div>
                </div>
                <div class="w-row inschrijfformulierrow">
                  <div class="w-col w-col-4 w-clearfix inschrijfcolumn1">
                    <label class="veldlabel" for="name-5">E-mailadres:</label>
                  </div>
                  <div class="w-col w-col-8 w-clearfix inschrijfcolumn2">
                    <input class="w-input invoerveld" id="email" placeholder="Uw e-mailadres" name="email" data-name="email" required="required" type="text">
                  </div>
                </div>
                <div class="w-row inschrijfformulierrow">
                  <div class="w-col w-col-4 w-clearfix inschrijfcolumn1">
                    <label class="veldlabel" for="name-4">Scholengemeenschap:</label>
                  </div>
                  <div class="w-col w-col-8 inschrijfcolumn2">
                  <?php 		
                  	$scholen= array(0=>"Selecteer een school...");
					$scholen=$scholen+\Concrete\Package\Digileerwijzer\Models\DglwModel::getScholen(1);
					?>
                   <?php echo  $form->select('scholengemeenschap', $scholen,0,array('class'=>'w-select dropdownmenu') ); ?>
                  
                   
                  </div>
                </div>
                
                <div class="w-row inschrijfformulierrow">
                  <div class="w-col w-col-4 w-clearfix inschrijfcolumn1">
                    <label class="veldlabel" for="name-4">Locatie:</label>
                  </div>
                  <div class="w-col w-col-8 inschrijfcolumn2">
                    <select class="w-select dropdownmenu" id="locatie" name="locatie">
                      <option selected="selected" value="">Selecteer een school...</option>

                    </select>
                  </div>
                </div>   
                
                <div class="w-row inschrijfformulierrow">
                  <div class="w-col w-col-4 w-clearfix inschrijfcolumn1">
                    <label class="veldlabel" for="name-4">Sectie:</label>
                  </div>
                  <div class="w-col w-col-8 inschrijfcolumn2">
                  
                    <select class="w-select dropdownmenu" id="sectie" name="sectie">
                      	<option selected="selected" value="">Selecteer een locatie...</option>

                    </select>      
                  </div>
                </div>                               
                
                 <div class="w-row inschrijfformulierrow">
                  <div class="w-col w-col-4 w-clearfix inschrijfcolumn1">
                    <label class="veldlabel" for="name-4">Toegangscode:</label>
                  </div>
                  <div class="w-col w-col-8 inschrijfcolumn2">
                  
 					<input class="w-input invoerveld" id=""code"" placeholder="Uw toegangscode" name="code" data-name=""code"" required="required" type="text">    
                  </div>
                </div>                 

                <div class="w-row inschrijfformulierrow">
                  <div class="w-col w-col-4 w-clearfix inschrijfcolumn1">
                    <label class="veldlabel" for="name-3"></label>
                  </div>
                  
                  <div class="w-col w-col-8 w-clearfix inschrijfcolumn2">
                    <input class="w-button verstuurbutton" value="Beginnen met test" data-wait="Een moment geduld aub..." wait="Een moment geduld aub..." type="submit">
                   
                  </div>
                </div>
              </form>
              <div class="w-form-done">
                <p>Thank you! Your submission has been received!</p>
              </div>
              <div class="w-form-fail">
                <p>Oops! Something went wrong while submitting the form :(</p>
              </div>
            </div>
          </div>





          
          
          
          </div>
      </div>

<script type="text/javascript" src="/packages/digileerwijzer/themes/digileerwijzer/js/dglw_inlog.js"></script>
<?php  $this->inc('elements/footer.php'); ?>