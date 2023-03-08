{extends file="views/structure.tpl"}

{block name="head_infos" append}
	<link rel="icon" type="image/png" href="assets/images/logo.png" />	
	<link rel="stylesheet" href="assets/styles/jquery.dataTables.min.css" />	
	
	<script src="assets/javascript/jquery-3.5.1.js"></script>
	<script src="assets/javascript/jquery.dataTables.min.js"></script>
{/block}

{block name="content"}
	<h2 class="text-center mb-5 mt-5">Liste des utilisateurs</h2>
	<table id="list" class="table table-striped" style="width:100%">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Actions</th>
				
			</tr>
		</thead>
		
		<tbody>
			{foreach from=$arrUsersToDisplay item=objUser} 
			<tr>
				<td>{$objUser->getName()|unescape}</td>
				<td>{$objUser->getFirstName()|unescape}</td>
				
				<td>
					<a href="index.php?ctrl=user&action=edit_account&id={$objUser->getId()}" >Modifier</a>
					/
					
					<a href="index.php?ctrl=user&action=deleteUser&id={$objUser->getId()}" >Supprimer</a>
				</td>
				
			</tr>
			{/foreach}
		</tbody>
		<tfoot>
		</tfoot>
	</table>
	<div class="container">
	<div class="row my-5">
	{if isset($smarty.session.user.id) && $smarty.session.user.role == 1}
		<a href="index.php?ctrl=form&action=list_pet" title="Modifier son profil">Animaux</a>
	{/if}
	</div>
	</div>
{/block}

{block name='js_foot' append}
	{literal}
	<script>
		$(document).ready(function () {
			$('#list').DataTable( {
				"language": {
					"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
				}
			} );
		});
	</script>
	{/literal}

{/block}
