{if $galleryList|@count > 0}
{foreach item=gal from=$galleryList}
	{if $gal@iteration % 3 == 0}
	<img src="{$gal->getSmallImage()}" width="200px" height="150px" alt="{if !empty($gal->caption)}{$gal->caption}{/if}" /><br />
	{else}
	<img src="{$gal->getSmallImage()}" width="200px" height="150px" alt="{if !empty($gal->caption)}{$gal->caption}{/if}" />
	{/if}
{/foreach}
{/if}
