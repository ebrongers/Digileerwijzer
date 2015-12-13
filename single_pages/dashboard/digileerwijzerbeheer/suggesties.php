<?php
	defined('C5_EXECUTE') or die("Access Denied.");
?>
<?php 
switch ($controller->getAction()) :
case "view":
?>
	
	<div class="ccm-dashboard-content">

		<fieldset style="margin-bottom:20px">
    		<legend><?php echo t('Overzicht suggesties ');?></legend>
			<div class="row">
				<div class="form-group">

					<div class="col-sm-10">
						<div class="input-group">
							<?php $index=0;?>
							<table>
							<?php foreach($suggesties as $suggestie):?>
								<tr>
								<td class="col-sm-2" <?php if($index%2==1):?>style="background:rgba(86, 61, 124, 0.15);"<?php endif;?>><a href="/index.php/dashboard/digileerwijzerbeheer/suggesties/editsuggestie/<?php echo($suggestie['code']);?>"><?php echo($suggestie['code']);?></a></td>
								<td class="col-sm-9" <?php if($index%2==1):?>style="background:rgba(86, 61, 124, 0.15);"<?php endif;?>><?php echo($suggestie['sText']);?></td>
								</tr>
								<?php $index++;?>
							<?php endforeach;?>
						</table>
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
		<form method="post" class="form-horizontal" action="<?=$view->action('saveSuggestie')?>">		
		<fieldset style="margin-bottom:20px">
    		<legend><?php echo t('Suggestie wijzigen: '). $suggestie['code']." ".$product['naam'];?></legend>
			<div class="row">
				<div class="form-group">

					<div class="col-sm-5">
						<div class="input-group">
						
							<h4>Code</h4>
							<div class="no_edit"><?php echo $suggestie['code'];?></div>
							<div class="edit"><?php echo $suggestie['code'];?></div>
							
							
							
							<h4>Doel</h4>
							<div class="no_edit"><?php echo $suggestie['sText'];?></div>
							<div class="edit"><textarea style="width:450px;height:250px;"  name="sText"><?php echo $suggestie['sText'];?></textarea></div>
							<h4>Omschrijving</h4>
							<div class="no_edit"><?php echo $suggestie['lText'];?></div>
							<div class="edit"><textarea style="width:450px;height:250px;" name="lText"><?php echo $suggestie['lText'];?></textarea></div>
						
						
						</div>
						<a id="edit" class="no_edit btn btn-primary">Wijzigen</a>
						<input class="edit btn btn-primary" type="submit" value="opslaan" />
						
					</div>
				</div>
			</div>
		</fieldset>

		<input type="hidden" name="sugID" value="<?php echo $suggestie['code']?>" />
		

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