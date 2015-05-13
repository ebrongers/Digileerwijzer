<?php 
defined('C5_EXECUTE') or die(_("Access Denied.")); 
$c = Page::getCurrentPage();
$form = Loader::helper('form');
?>


          <h2 class="home">Inschrijven</h2>
          <div class="holderbreed wit2">
            <div class="w-form inschrijfformulierwrapper">
              <form action ="/index.php/digileerwijzer/q" class="inschrijfformulier" 
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
                      <?php //echo  $form->select('sectie', $secties,0,array('class'=>'w-select dropdownmenu') ); ?>
 

      
                  </div>
                </div>                               
                
                

                <div class="w-row inschrijfformulierrow">
                  <div class="w-col w-col-4 w-clearfix inschrijfcolumn1">
                    <label class="veldlabel" for="name-3">Sectie:</label>
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






