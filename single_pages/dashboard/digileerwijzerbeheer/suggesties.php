<?php
	defined('C5_EXECUTE') or die("Access Denied.");
?>
<?php 
switch ($controller->getAction()) :
case "view":
?>
<div class="ccm-dashboard-content">

		<fieldset style="margin-bottom:20px">
    		<legend><?php echo t('PDC inhoud: '). $productgroep['code']." ".$productgroep['naam'];?></legend>
			<div class="row">
				<div class="form-group">

					<div class="col-sm-5">
						<div class="input-group">

							<?php foreach($suggesties as $suggestie):?>
							
								<div><a href="/index.php/dashboard/digileerwijzerbeheer/suggesties/editsuggestie/<?php echo($suggestie['code']);?>"><?php echo($suggestie['code']);?></a></div>
				
							<?php endforeach;?>
						
						</div>
					</div>
				</div>
			</div>
		</fieldset>

	
</div>
<?php break;

case 'editsuggestie':

	$fp = FilePermissions::getGlobal();
$tp = new TaskPermission();

?>

<style>
.edit { display:none; }
</style>
<div class="ccm-dashboard-content">

		<a href="/index.php/dashboard/digileerwijzerbeheer/suggesties">Suggesties</a> > Wijzigen suggestie
				<form method="post" class="form-horizontal" action="<?=$view->action('save_suggestie')?>">		
		<fieldset style="margin-bottom:20px">
    		<legend><?php echo t('Suggestie wijzigen: '). $suggestie['code']." ".$product['naam'];?></legend>
			<div class="row">
				<div class="form-group">

					<div class="col-sm-5">
						<div class="input-group">
						
							<h4>Code</h4>
							<div class="no_edit"><?php echo $suggestie['code'];?></div>
							<div class="edit"><input type="text" name="code" value="<?php echo $suggestie['code'];?>" ></div>
							
							<div class="no_edit"><?php echo $suggestie['sText'];?></div>
							<div class="edit"><textarea style="display: none" id="redactor-content" name="content"><?php echo $suggestie['sText'];?></textarea></div>
						
							
							
							<h4>Doel</h4>
							<div class="no_edit"><?php echo $suggestie['sText'];?></div>
							<div class="edit"><textarea style="width:450px;height:250px;"  name="sText"><?php echo $suggestie['sText'];?></textarea></div>
							<h4>Omschrijving</h4>
							<div class="no_edit"><?php echo $suggestie['lText'];?></div>
							<div class="edit"><textarea style="width:450px;height:250px;" name="lText"><?php echo $suggestie['lText'];?></textarea></div>
						
						
						</div>
						<a id="edit" class="no_edit">Wijzigen</a>
						<input class="edit" type="submit" value="opslaan" />
						
					</div>
				</div>
			</div>
		</fieldset>

		<input type="hidden" name="sugID" value="<?php echo $suggestie['sugID']?>" />
		

	</form>	
		<div class="ccm-dashboard-form-actions-wrapper">
			<div class="ccm-dashboard-form-actions">
			

			</div>
		</div>
	
</div>
<script>
$("#edit").click(function(){

	$(".edit").css("display","block");
	$(".no_edit").css("display","none");
	
})
</script>
<?php break;

endswitch;?>