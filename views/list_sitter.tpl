{extends file="views/structure.tpl"}

{block name="head_infos" append}
	<link rel="icon" type="image/png" href="assets/images/logo.png" />	
	<link rel="stylesheet" href="assets/styles/jquery.dataTables.min.css" />	
	
	<script src="assets/javascript/jquery-3.5.1.js"></script>
	<script src="assets/javascript/jquery.dataTables.min.js"></script>
{/block}

{block name="content"}
	<h2 class="text-center mb-5 mt-5">Liste des Sitter</h2>
	<table id="list" class="table table-striped" style="width:100%">
		<thead>
			<tr>
				<th>Nom Du Sitter</th>
				<th>Profil</th>
			</tr>
		</thead>
		
		<tbody>
			{foreach from=$arrUsersToDisplay item=objUser} 
			<tr>
				<td>{$objUser->getName()|unescape}</td>
				
				
				<td>
					
					 <a href="index.php?ctrl=user&action=vueProfil&id={$objUser->getId()}" >Vue Profil</a> 
					
					
				</td>
				
			</tr>
			{/foreach}
		</tbody>
		<tfoot>
		</tfoot>
	</table>


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
