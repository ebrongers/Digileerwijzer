<?php
use Concrete\Core\Page\Page;
/* @var $subpage Concrete\Core\Page\Page */

switch ($controller->getAction()):
case 'view':
?>
<div><a class="btn btn-success pull-right" type="submit"  href="<?=$this->action('toevoegen');?>">Toevoegen</a></div>
<div>
	<ul>
		<?php		foreach($scholen AS $KEY=>$school): ?>
			<li>
				<a href="<?=$this->action('detail').'/'.$KEY?>">
				
				
				<?=				$school ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
<?php 
break;
case 'toevoegen': ?>
Gegevens: <?php print_r($school['school']);?>
<form action="<?=$this->action('toevoegen_opslaan')?>" method="post">
<?php echo $form->hidden('sID',$school['id'])?>
<table class="table">
<tr>
	<td>Naam</td><td><?php echo $form->text('naam',$school['school']);?></td>
</tr>
<tr>	
	<td>Actief</td><td><?php echo $form->checkbox('actief',1,1);?></td>

	</tr>
	

</table>
<?php echo $form->submit($name, 'Opslaan', $tagAttributes, 'btn btn-primary');?>
</form>
<?php break;

case 'locatie_toevoegen': ?>
Gegevens: <?php print_r($school['school']);?>
<form action="<?=$this->action('locatie_toevoegenOpslaan')?>" method="post">
<?php echo $form->hidden('sID',$school['id'])?>
<table class="table">
<tr>
	<td>Naam school</td><td><?php echo $school['school'];?></td>
</tr>
<tr>	
	<td>Nieuwe locatie</td><td><?php echo $form->text('locatienaam');?></td>

	</tr>
	

</table>
<?php echo $form->submit('toevoegen', 'Toevoegen', $tagAttributes, 'btn btn-primary');?>
</form>
<?php break;

case 'toevoegen_opslaan':
case 'locaties_wijzigen':?>
<div><a class="btn btn-primary pull-right" type="submit"  href="<?=$this->action('');?>">Terug</a></div>
<div  style="clear:both;height:50px;"></div>
<div>
	<form action="<?php echo $this->action('locaties_wijzigen');?>" method="post">
	<?php echo $form->hidden('schoolId',$schoolId)?>
	<table class="table">
	<tr>
		<th>Naam</th>
		<th>Actief</th>
	
	</tr>
	<tr>
		<td><?php echo $school;?></td>
		<td><?php echo $actief;?></td>
	
	</table>
	
	<table class="table">
	<tr><th>Locaties</th><th></th><th></th></tr>
	<?php if(is_array($locaties)):
			foreach ($locaties as $locatie):?>
		<tr><td></td>
			<td>&nbsp;
		<?php echo $locatie['naam']?>
		</td>
		</tr>
	<?php endforeach;
	endif;?>
	
	<tr><td>Nieuwe locatie</td><td> <?php echo $form->text("locatienaam","",array("style"=>"display:inline-block;width:80%"));?><?php echo $form->submit($name, 'Opslaan', $tagAttributes, 'btn btn-primary');?></td></tr>
	</table>
	</form>
</div>	
<?php break;	
case 'locatieWijzigen':?>
	<form action="<?=$this->action('locatieWijzigenOpslaan')?>" method="post">
	<?php echo $form->hidden('sID',$sID)?>
	<?php echo $form->hidden('lID',$locatie['lID'])?>
	<table class="table">
		<tr>
			<td>Locatie naam</td><td><?php echo $form->text('naam',$locatie['naam']);?></td>
		</tr>
	


	</table>
	<?php echo $form->submit($name, 'Opslaan', $tagAttributes, 'btn btn-primary');?>
	
		<br />
		<br />	<table class="table">
		<tr>
			<th>Secties koppelen<br><em>Selecteer hieronder de secties</em></i></th><td></td>
		</tr>
		
		<?php foreach($secties as $sectie_id=>$sectie):?>
		<tr>
			<td><?php echo ($sectie);?></td>
			<td><?php echo $form->checkbox('locatie['.$sectie_id.']',1);?></td>
		</tr>
		<?php endforeach;?>
	</table>
	<?php echo $form->submit($name, 'Opslaan', $tagAttributes, 'btn btn-primary');?>
	</form>	

<?php break;
case 'detail':?>
<div></div>
<div  style="clear:both;height:50px;"></div>
Gegevens van: <?php print_r($school['school']);?>

<table class="table">
<tr>
	<th>Naam</th>
	<th>Actief</th>
		<th>&nbsp;</th>
</tr>
<tr>
	<td><?php echo $school['school'];?></td>
	<td><?php echo $school['active'];?></td>
	<td><a class="btn btn-primary pull-right" type="submit"  href="<?=$this->action('toevoegen',$school['id']);?>"><i class="fa fa-pencil-square-o"></i> Wijzigen</a></td>
</table>
<br />
<br />
<table class="table">
<tr><th>Locaties</th><th></th></tr>
<?php foreach ($locaties as $locatie):?>
	<tr>
		<td>
	<?php echo $locatie['naam']?>
	</td>
	<td><a class="btn btn-danger pull-right" type="submit"  href="<?=$this->action('locatie_verwijderen',$locatie['lID'],$school['id']);?>"><i class="fa fa-trash-o"></i> Verwijderen</a><a class="btn btn-primary pull-right" type="submit"  href="<?=$this->action('locatieWijzigen',$locatie['lID'],$school['id']);?>"><i class="fa fa-pencil-square-o"></i> Wijzigen</a>&nbsp;</td>	
	</tr>
<?php endforeach;?>
	<tr>
		<td>
	
	</td>
	<td><a class="btn btn-success pull-right" type="submit"  href="<?=$this->action('locatie_toevoegen',$school['id']);?>">Locatie toevoegen</a></td>	
	</tr>
</table>
<?php break;?>

<?php endswitch;?>