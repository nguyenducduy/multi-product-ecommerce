<link href="{$currentTemplate}min/?g=cssmessage" rel="stylesheet" type="text/css" />

<div id="panelleft">
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		{include file="`$smartyControllerGroupContainer`leftheading-top.tpl"}
			<h2><a href="{$me->getUserPath()}/blog" title="{$lang.controller.titleBlog}">{$lang.controller.titleBlog}</a></h2>
			
		{include file="`$smartyControllerGroupContainer`leftheading-bottom.tpl"}
		
		{include file="`$smartyControllerGroupContainer`panel-userbox.tpl"}
		
		
	</div><!-- end #panelleft -->
	
	<div id="panelright">
	{include file="notify.tpl" notifyError=$error}
		<div id="blogform" class="myform myformwide stylizedform">
			<form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
				<h1>{if $myBlogEvent->id > 0}{$lang.controller.titleBlogEventAdd} {$myBlogEvent->title}{else}{$lang.controller.titleAdd} {/if}</h1>
				<p></p>
				
				
				
				<label>{$lang.controller.type}</label>
				<select name="fshowinhomepage" id="fshowinhomepage" onchange="showinhomepageToggle()">
					<option value="0">{$lang.controller.typeBlog}</option>
					<option value="1" {if $formData.fshowinhomepage == 1}selected="selected"{/if}>{$lang.controller.typeArticle}</option>
				</select> <a href="#" class="tipsy-trigger" title="{$lang.controller.typeArticleHelp}">(?)</a>
				<div class="clear"></div>
				
				<label>{$lang.controller.category}</label>
				<select name="fcategoryid">
					<option value="0">{$lang.controller.categorydefault}</option>
					{foreach item=category from=$categoryList}
						<option value="{$category->id}" {if $category->id == $formData.fcategoryid}selected="selected"{/if}>{$category->name}</option>
					{/foreach}
				</select>
				<div class="clear"></div>
				
                <label>{$lang.controller.image}
					<span class="small"></span>
				</label>
				<input type="file" class="inputwide" name="fimage" id="fimage" />
				<div class="clear"></div>
				
				<label>{$lang.controller.labelTitle}
					<span class="small"></span>
				</label>
				<input type="text" class="inputwide inputbig" name="ftitle" id="ftitle" value="{$formData.ftitle}" />
				<div class="clear"></div>
				                				
				<label>{$lang.controller.contents}
				<br />
					<span class="small"></span>
				</label>
				<div class="clear"></div>
				<textarea name="fcontents" id="fcontents" cols="30" rows="30" class="sampletextbox tinymce" style="font-family:Arial, Helvetica, sans-serif;">{$formData.fcontents}</textarea>
				<div class="clear"></div>
				
				
				
                <br />
			<div id="sourceurlwrapper">
				<label>{$lang.controller.sourceurl}<br /><small>{$lang.controller.sourceurlhelp}</small></label>
				<input type="text" name="fsourceurl" id="fsourceurl" value="{$formData.fsourceurl}" class="inputwide" />
				<div class="clear"></div>
			</div>
			
			<div id="sharemodewrapper">
				<label>{$lang.controller.sharemode}</label>
				<div class="text textwide">
					<select name="fsharemode" id="fsharemode" style="margin:0;" onchange="blogCheckSharemode()">
						<option value="1" {if $formData.fsharemode == 1}selected="selected"{/if}>{$lang.controller.sharemodeEveryone}</option>
						<option value="2" {if $formData.fsharemode == 2}selected="selected"{/if}>{$lang.controller.sharemodeFriend}</option>
						<option value="3" {if $formData.fsharemode == 3}selected="selected"{/if}>{$lang.controller.sharemodePrivate}</option>
						<option value="4" {if $formData.fsharemode == 4}selected="selected"{/if}>{$lang.controller.sharemodeCustom}</option>
					</select>
				
					<div id="shareallowbox" class="hide">
						<div class="text inputwide" style="margin:0; padding:0; width:400px;" id="selectallow"><br  />{$lang.controller.sharetothislistTitle}</div>
						<select id="fshareallow" name="fshareallow[]" multiple="multiple" size="1">
						{if $allowFriendlist|@count > 0}
							{foreach item=friend from=$allowFriendlist}
							<option value="{$friend->id}" class="selected">{$friend->fullname}</option>
							{/foreach}
						{/if}
						</select>
						
					</div>
					
					<div id="sharedenybox" class="hide">
						<div class="text inputwide" style="margin:0; padding:0; width:400px; color:#F30;" id="selectallow"><br  /><big><a href="javascript:void(0)" onclick="$('#sharedenyinput').show();">&raquo; {$lang.controller.sharemodeDeny}</a></big></div>
						<div id="sharedenyinput" class="{if $denyFriendlist|@count == 0}hide{/if}">
						<select id="fsharedeny" name="fsharedeny[]" multiple="multiple" size="1">
						{if $denyFriendlist|@count > 0}
							{foreach item=friend from=$denyFriendlist}
							<option value="{$friend->id}" class="selected">{$friend->fullname}</option>
							{/foreach}
						{/if}
						</select>
						</div>
					</div>
				
				</div>
			</div><!-- end #sharemodewrapper -->
				
				<div class="clear"></div>
				<label>{$lang.controller.tagBook}</label>
				<div class="text textwide">
					<select id="ftagbook" name="ftagbook[]" multiple="multiple" size="1">
					{if $tagbookList|@count > 0}
						{foreach item=tagbook from=$tagbookList}
						<option value="{$tagbook->id}" class="selected">{$tagbook->title}</option>
						{/foreach}
					{/if}
					</select>
				</div>
               
			   	<div class="clear"></div>
				<label>{$lang.controller.setting}</label>
				<input type="checkbox" class="checkbox" name="fimageintext" id="fimageintext" value="1" {if $formData.fimageintext == 1}checked="checked"{/if} /><label style="font-weight:normal; text-align:left;" class="inputwide" for="fimageintext">&nbsp; {$lang.controller.imageintext}</label>
				
               				
				<div class="clear"></div>
				<label>&nbsp;</label>
				<input type="checkbox" class="checkbox" name="fopencomment" id="fopencomment" value="1" {if $formData.fopencomment == 1}checked="checked"{/if} /><label style="font-weight:normal; text-align:left;" class="inputwide" for="fopencomment">&nbsp; {$lang.controller.opencomment}</label>
				
				
				
				
                <div class="clear"></div>	
				
											
				<input type="submit" class="submit" name="fsubmit" value="{$lang.controller.submit}" />
				<div class="spacer"></div>
		
		  </form>
	  </div><!-- end #addbookform -->
	</div><!-- end #panelright -->
	
	
	{include file="tinymce_small.tpl"}
	<script type="text/javascript" src="{$currentTemplate}/js/jquery.fcbkcomplete.min.js"></script>
	
	{literal}
	
	<script type="text/javascript">
	$(document).ready(function()
	{
		
		$("#fshareallow").fcbkcomplete({
					json_url: meurl + "/friend/autocompleteajax",
					addontab: true,                   
					height: 4,
					cache: true,
					maxitems: 10,
					firstselected: true
				});
		
		$("#fsharedeny").fcbkcomplete({
					json_url: meurl + "/friend/autocompleteajax",
					addontab: true,                   
					height: 4,
					cache: true,
					maxitems: 10,
					firstselected: true
				});
		
		
		$("#ftagbook").fcbkcomplete({
					json_url: rooturl + "book/autocompleteajax",
					complete_text : 'Nh&#7853;p t&#234;n s&#225;ch...',
					addontab: true,                   
					height: 6,
					cache: true,
					maxitems: 20,
					firstselected: true
				});
		
		blogCheckSharemode();
		showinhomepageToggle();
	
	});
	
	function blogCheckSharemode()
	{
		var sharemode = $('#fsharemode').val();
		$('#shareallowbox').hide();
		$('#sharedenybox').hide();
		if(sharemode == 2)
		{
			$('#sharedenybox').fadeIn();
		}
		
		if(sharemode == 4)
		{
			$('#shareallowbox').fadeIn();
		}
	}
	
	function showinhomepageToggle()
	{
		var showinhomepage = $('#fshowinhomepage').val();

		if(showinhomepage == '1')
		{
			$('#sharemodewrapper').hide();
			$('#sourceurlwrapper').show();
		}
		else
		{
			$('#sharemodewrapper').show();
			$('#sourceurlwrapper').hide();
		}
	}
	</script>
	{/literal}
	
	
	

