{include file="`$smartyMailContainerRoot`header.tpl"}

  <h1>B&#7841;n c&#243; tin nh&#7855;n t&#7915; {$me->fullname}</h1>
  <p>{$message}</p>
  <p><br />
  <br />
<table cellpadding="10" cellspacing="4" bordercolor="#00CCFF" border="1" style="border-collapse:collapse; background-color:#09F">
    	<tr>
        	<td><b><big><a style="color:#ffffff; text-decoration:none;" href="{$conf.rooturl}gotomy?p=message">Nh&#7845;n v&#224;o &#273;&#226;y &#273;&#7875; t&#7899;i h&#7897;p tin nh&#7855;n c&#7911;a b&#7841;n.</a></big></b></td>
        </tr>
</table>
  </p>
  <hr />
	<table>
		<tr>
			<td width="50" valign="top"><a href="{$me->getUserPath()}"><img src="{$me->getSmallImage()}" /></a></td>
			<td valign="top">
				<b><a style="text-decoration:none" href="{$me->getUserPath()}">{$me->fullname}</a></b> {if $me->region > 0}&middot; {$me->getRegionName()}{/if}<br />
				<p>{$me->getRepImage(false)}</p>
				<p>
					{if $me->countBook > 0}<a href="{$me->getUserPath()}/book" style="text-decoration:none">{$me->countBook} S&#225;ch</a> &middot; {/if}
					{if $me->countSell > 0}<a href="{$me->getUserPath()}/shop" style="text-decoration:none">{$me->countSell} B&#225;n/Chia s&#7867;</a> &middot; {/if}
					{if $me->countFav > 0}<a href="{$me->getUserPath()}/fav" style="text-decoration:none">{$me->countFav} Y&#234;u th&#237;ch</a> &middot; {/if}
					{if $me->countReview > 0}<a href="{$me->getUserPath()}/review" style="text-decoration:none">{$me->countReview} B&#236;nh lu&#7853;n</a> &middot; {/if}
					{if $me->countQuote > 0}<a href="{$me->getUserPath()}/quote" style="text-decoration:none">{$me->countQuote} Tr&#237;ch d&#7851;n t&#7915; s&#225;ch</a> &middot; {/if}
					{if $me->countSample > 0}<a href="{$me->getUserPath()}/sample" style="text-decoration:none">{$me->countSample} Tr&#237;ch &#273;o&#7841;n</a> &middot; {/if}
					{if $me->countFriend > 0}<a href="{$me->getUserPath()}/friend" style="text-decoration:none">{$me->countFriend} B&#7841;n b&#232;</a>{/if}
				</p>
			</td>
		</tr>
	</table>

{include file="`$smartyMailContainerRoot`footer.tpl"}