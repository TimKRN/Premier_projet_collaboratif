{extends file="views/structure.tpl"}

{block name="content"}
	{if $strPage == "ajoutImg"}
		<h2>Ajouter une image</h2>
		<p>Formulaire permettant d'ajouter une image</p>
	{else}
		<h2>Modifier une image</h2>
		<p>Formulaire permettant de modifier une image</p>
	{/if}
	{include file="views/error_display.tpl"}
	<form name="formAdd" method="POST" action="index.php?ctrl=form&action={$strPage}" enctype="multipart/form-data">
		<fieldset>
			<p>
				<label for="description">Description</label>
				<textarea id="description" name="description" >{$objPicture->getDescription()}</textarea>
			</p>
			<p>
				{if $objPicture->getName() != ''}
				<img src="assets/imgUsers/{$objPicture->getName()}" />
				<input type="hidden" name="name" value="{$objPicture->getName()}" />
				{/if}
				<label for="image">Image</label>
				<input id="image" type="file" name="image" />
			</p>
			<p>
				<input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" name="personal_data">
				<label class="form-check-label" for="inlineCheckbox1" name="personal_data">J’autorise ce site à conserver
					mes données transmises via ce formulaire</label>
			</p>
			<p><input type="submit" value="{if $strPage == 'ajoutImg'}Ajouter{else}Modifier{/if}" />
		</fieldset>
	</form>	
{/block}
