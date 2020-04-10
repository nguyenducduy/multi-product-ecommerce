<div id="panelleft">
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		{include file="`$smartyControllerGroupContainer`panel-profileinfo.tpl"}
            
		
         <br class="clear" />
       
		
		
				
	</div><!-- end #panelleft -->
	
	<div id="panelright">
		

				
			
		<div id="pinfo">
		
			<div class="status">{assign var=myuseronlinestatus value=$myUser->getOnlinestatus()} <img class="sp sp16 sp{$myuseronlinestatus}" src="{$imageDir}blank.png" title="{$myuseronlinestatus}" alt="{$myuseronlinestatus}" /></div>
			
			<div class="pinfotop">
				<h1 class="head">{$myUser->fullname}</h1>
				<div class="subhead">{if $myUser->gender == 1}{$lang.controller.male}{elseif $myUser->gender == 2}{$lang.controller.female}{/if} &middot; {if $myUser->region > 0}{$myUser->getRegionName()}{/if}</div>
				{if $birthdayInfo != ''}<div class="subhead">{$birthdayInfo.mday|string_format:"%02d"}/{$birthdayInfo.mon|string_format:"%02d"}/{$birthdayInfo.year}</div>{/if}
				
			</div>
			<div class="line"></div>
			{if $myUser->bio != ''}
				<div class="bio">{$myUser->bio|nl2br}</div>
				<div class="line"></div>
			{/if}
			{if $myProfileList.1|@count > 0}
			<div class="group">
				<div class="groupleft">{$lang.controller.groupWork}</div>
				<div class="groupright">
					{foreach item=profile from=$myProfileList.1}
						<div class="ginfo">
							<div class="title">{$profile->text1}</div>
							
							<div class="titlesub">{$profile->text2|nl2br}</div>
							<div class="time">
								{$profile->getText3Region()}, {if $profile->date1_month > 0 && $profile->date1_year > 0}{$profile->date1_month}/{/if}{if $profile->date1_year > 0}{$profile->date1_year}{/if}
								
								{if $profile->date2_year > 0}
								 	- {if $profile->date2_month > 0}{$profile->date2_month}/{/if}{$profile->date2_year}
								{else}
									- {$lang.controller.now}
								{/if}
								
							</div>
						</div>
					{/foreach}
				</div>
			</div>
			{/if}
			
			{if $myProfileList.2|@count > 0 || $myProfileList.3|@count > 0}
			<div class="group">
				<div class="groupleft">{$lang.controller.groupEducation}</div>
				<div class="groupright">
					{foreach item=profile from=$myProfileList.2}
						<div class="ginfo">
							<div class="title">{$profile->text1}</div>
							<div class="titlesub">{$profile->text2|nl2br}</div>
							<div class="time">
								{$profile->getText3Region()}, {if $profile->date1_month > 0 && $profile->date1_year > 0}{$profile->date1_month}/{/if}{if $profile->date1_year > 0}{$profile->date1_year}{/if}
								
								{if $profile->date2_year > 0}
								 	- {if $profile->date2_month > 0}{$profile->date2_month}/{/if}{$profile->date2_year}
								{else}
									- {$lang.controller.now}
								{/if}
								
							</div>
						</div>
					{/foreach}
					
					{foreach item=profile from=$myProfileList.3}
						<div class="ginfo">
							<div class="title">{$profile->getText2Schooltype()} {$profile->text1}</div>
							<div class="time">
								{$profile->getText3Region()}, {if $profile->date1_month > 0 && $profile->date1_year > 0}{$profile->date1_month}/{/if}{if $profile->date1_year > 0}{$profile->date1_year}{/if}
								
								{if $profile->date2_year > 0}
								 	- {if $profile->date2_month > 0}{$profile->date2_month}/{/if}{$profile->date2_year}
								{else}
									- {$lang.controller.now}
								{/if}
								
							</div>
						</div>
					{/foreach}
				</div>
			</div>
			{/if}
			
			{if $myUser->phone != '' || $myUser->address != '' || $myUser->website != 'http://'}
			<div class="group">
				<div class="groupleft">{$lang.controller.groupContact}</div>
				<div class="groupright">
					{if $myUser->phone != ''}
					<div class="ginfo">
						<div class="title">{$lang.controller.phone}</div>
						<div class="titlesub">{$myUser->phone}</div>
					</div>
					{/if}
					
					{if $myUser->address != ''}
					<div class="ginfo">
						<div class="title">{$lang.controller.address}</div>
						<div class="titlesub">{$myUser->address}{if $myUser->region > 0}, {$myUser->getRegionName()}{/if}</div>
					</div>
					{/if}
					
					{if $myUser->website != 'http://'}
					<div class="ginfo">
						<div class="title">Website</div>
						<div class="titlesub">{$myUser->website}</div>
					</div>
					{/if}
				</div>
			</div>
			{/if}
			
			{if $myProfileList.4|@count > 0}
			<div class="group">
				<div class="groupleft">{$lang.controller.groupOther}</div>
				<div class="groupright">
					{foreach item=profile from=$myProfileList.4}
						<div class="ginfo">
							<div class="title">{$profile->text1}</div>
							<div class="titlesub">{$profile->text2}</div>
						</div>
					{/foreach}
				</div>
			</div>
			{/if}
			<div class="clear"></div>
		
		</div><!-- end #profileinfo -->
 
        
       
		
		
	</div><!-- end #panelright -->
    
    {literal}
    <script type="text/javascript">
	$(document).ready(function()
	{
		
		
	
		
	});
	
	
	</script>
    {/literal}
    
    
    