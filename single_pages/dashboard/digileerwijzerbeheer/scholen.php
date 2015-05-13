<?php
use Concrete\Core\Page\Page;
/* @var $subpage Concrete\Core\Page\Page */

switch ($controller->getAction()):
case 'view':
?>
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
case 'detail':?>
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