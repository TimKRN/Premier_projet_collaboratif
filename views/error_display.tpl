{if count($arrError) > 0}
	<div class="alert alert-danger">
	{foreach from=$arrError item=strError}
		<p>{$strError}</p>
	{/foreach}
	</div>
{/if}