<?php
use Concrete\Core\Page\Page;
/* @var $subpage Concrete\Core\Page\Page */

switch ($controller->getAction()):
case 'view':
?>
<div><a class="btn btn-primary pull-right" type="submit"  href="<?=$this->action('toevoegen');?>">Toevoegen</a></div>
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
<table class="table">
<tr>
	<td>Naam</td><td><?php echo $form->text('naam');?></td>
</tr>
<tr>	
	<td>Actief</td><td><?php echo $form->checkbox('actief',1,1);?></td>

	</tr>
	

</table>
<?php echo $form->submit($name, 'Opslaan', $tagAttributes, 'btn btn-primary');?>
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
	<tr><th>Locaties</th><th></th></tr>
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
case 'detail':?>
<div><a class="btn btn-primary pull-right" type="submit"  href="<?=$this->action('toevoegen');?>">Wijzigen</a></div>
<div  style="clear:both;height:50px;"></div>
Gegevens van: <?php print_r($school['school']);?>

<table class="table">
<tr>
	<th>Naam</th>
	<th>Actief</th>
</tr>
<tr>
	<td><?php echo $school['school'];?></td>
	<td><?php echo $school['active'];?></td>

</table>

<table class="table">
<tr><th>Locaties</th></tr>
<?php foreach ($locaties as $locatie):?>
	<tr>
		<td>
	<?php echo $locatie['naam']?>
	</td>
	</tr>
<?php endforeach;?>
</table>
<?php break;?>

<?php endswitch;?>