{include file="`$smartyMailContainerRoot`header.tpl"}

  <h1>Ch&#224;o {$mailuser2->fullname},</h1>
  <p>{$mailuser->fullname} &#273;&#227; g&#7903;i l&#7901;i m&#7901;i k&#7871;t b&#7841;n v&#224; hy v&#7885;ng hai ng&#432;&#7901;i s&#7869; tr&#7903; th&#224;nh b&#7841;n b&#232; tr&#234;n Reader.vn.</p>
  <br />
<table cellpadding="10" cellspacing="4" bordercolor="#00CCFF" border="1" style="border-collapse:collapse; background-color:#09F">
    	<tr>
        	<td><b><big><a style="color:#ffffff; text-decoration:none;" href="{$conf.rooturl}gotomy?p=friend/request">Nh&#7845;n v&#224;o &#273;&#226;y &#273;&#7875; xem.</a></big></b></td>
        </tr>
</table>
  </p>
  <hr />
	<table>
		<tr>
			<td width="50" valign="top"><a href="{$mailuser->getUserPath()}"><img src="{$mailuser->getSmallImage()}" /></a></td>
			<td valign="top">
				<b><a style="text-decoration:none" href="{$mailuser->getUserPath()}">{$mailuser->fullname}</a></b> {if $mailuser->region > 0}&middot; {$mailuser->getRegionName()}{/if}<br />
				<p>{$mailuser->getRepImage(false)}</p>
				<p>
					{if $mailuser->countBook > 0}<a href="{$mailuser->getUserPath()}/book" style="text-decoration:none">{$mailuser->countBook} S&#225;ch</a> &middot; {/if}
					{if $mailuser->countSell > 0}<a href="{$mailuser->getUserPath()}/shop" style="text-decoration:none">{$mailuser->countSell} B&#225;n/Chia s&#7867;</a> &middot; {/if}
					{if $mailuser->countFav > 0}<a href="{$mailuser->getUserPath()}/fav" style="text-decoration:none">{$mailuser->countFav} Y&#234;u th&#237;ch</a> &middot; {/if}
					{if $mailuser->countReview > 0}<a href="{$mailuser->getUserPath()}/review" style="text-decoration:none">{$mailuser->countReview} B&#236;nh lu&#7853;n</a> &middot; {/if}
					{if $mailuser->countQuote > 0}<a href="{$mailuser->getUserPath()}/quote" style="text-decoration:none">{$mailuser->countQuote} Tr&#237;ch d&#7851;n t&#7915; s&#225;ch</a> &middot; {/if}
					{if $mailuser->countSample > 0}<a href="{$mailuser->getUserPath()}/sample" style="text-decoration:none">{$mailuser->countSample} Tr&#237;ch &#273;o&#7841;n</a> &middot; {/if}
					{if $mailuser->countFriend > 0}<a href="{$mailuser->getUserPath()}/friend" style="text-decoration:none">{$mailuser->countFriend} B&#7841;n b&#232;</a>{/if}
				</p>
			</td>
		</tr>
	</table>


{include file="`$smartyMailContainerRoot`footer.tpl"}