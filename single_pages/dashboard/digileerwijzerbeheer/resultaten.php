<?php
use Concrete\Core\Page\Page;
use Concrete\Package\Digileerwijzer\Models\DglwModel;
use Concrete\Package\Digileerwijzer\Models\DglwResult;
/* @var $subpage Concrete\Core\Page\Page */

switch ($controller->getAction()):
case 'view':

?>
<table class="table table-striped">
		<thead>
			<tr>
				<th><?=t('Email')?></th>
				<th><?=t('Name')?></th>
				<th><?=t('Date')?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($resultaten AS $resultaat): ?>
				<tr>
				<td>
				
					<a href="<?= BASE_URL."/dashboard/digileerwijzerbeheer/resultaten/show/".$resultaat['eID'];?>"><?php echo $resultaat['email']?></a>
				</td>
				<td>
			
					<a href="<?= BASE_URL."/dashboard/digileerwijzerbeheer/resultaten/show/".$resultaat['eID'];?>"><?php echo $resultaat['naam']?></a>
				</td>	
				<td>
				
					<a href="<?= BASE_URL."/dashboard/digileerwijzerbeheer/resultaten/show/".$resultaat['eID'];?>"><?php echo date("d-m-Y",$resultaat['datum'])?></a>
				</td>
				</tr>
			<?php endforeach; ?>
</tbody>
</table>

<?php break;?>

<?php case 'show':?>
<table class="table">
	<tr><td>Naam</td><td><?php echo $team['naam'];?></td></tr>
	<tr><td>E-mail</td><td><?php echo $team['email'];?></td></tr>
	<tr><td>School</td><td><?php echo $team['school'];?></td></tr>
	<tr><td>Locatie</td><td><?php echo $team['locatienaam'];?></td></tr>
	<tr><td>Team</td><td><?php echo $team['sectienaam'];?></td></tr>

		
</table>	
<table class="table">
	
	<?php foreach($resultaten as $resultaat): ?>
		<tr>
			<td><?php echo $resultaat['stelling'];?></td>
			<td><?php echo $resultaat['weging'];?></td>
			<td><?php echo $resultaat['result'];?></td>
		</tr>
	<?php endforeach;?>
	
</table>
<?php break;?>
<?php endswitch;?>