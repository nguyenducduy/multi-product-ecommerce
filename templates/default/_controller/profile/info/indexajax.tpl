<div id="accountcodebadge">
	
	
		<div id="pinfodepartment">
			
			
			
			<ul class="breadcrumb">
				{if $myUser->isStaff()}
					{foreach name="departmentlist" item=department from=$userDepartmentList}
						<li><a href="{$department->getUserPath()}" class="tipsy-trigger" title="{$department->fullname}">{if $smarty.foreach.departmentlist.first}<i class="icon-home"></i>{else}{$department->fullname}{/if}</a> <span class="divider">\\</span></li>
					{/foreach}
					
				{/if}
				
				<li><a href="{$myUser->getUserPath()}" class="tipsy-trigger" style="float:right;" title="{$lang.default.accountcodebadgeLabel}: {$myUser->getCode()}. {$lang.controller.accountType}: {$myUser->getGroupName()}"><span class="label">{$myUser->getCode()}</span></a></li>
				
				<li></li>
			</ul>
			
			
		</div>
	
</div>


{if $myUser->isStaff()}
	
<div id="pinfoimage">
	<img src="{$myUser->getSmallImage(true)}" />
</div><!-- end #pinfoimage -->
{/if}
	
<div id="pinfo">

	<div class="status">{assign var=myuseronlinestatus value=$myUser->getOnlinestatus()} <img class="sp sp16 sp{$myuseronlinestatus}" src="{$imageDir}blank.png" title="{$myuseronlinestatus}" alt="{$myuseronlinestatus}" /></div>
	
	<div class="pinfotop">
		{if $myUser->checkGroupname('department') == false}
			<div class="followbtn">
				{if $userIsFollowed}
					<a href="javascript:void(0)" onclick="user_followtoggle({$myUser->id})" class="btn" id="followbtn-{$myUser->id}"><i class="icon-ok"></i> {if $myUser->checkGroupname('group')}{$lang.default.groupexitBtn}{else}{$lang.default.unfollowBtn}{/if}</a>
				{else}
					<a href="javascript:void(0)" onclick="user_followtoggle({$myUser->id})" class="btn btn-success" id="followbtn-{$myUser->id}"><i class="icon-plus"></i> {if $myUser->checkGroupname('group')}{$lang.default.groupjoinBtn}{else}{$lang.default.followBtn}{/if}</a>
				{/if}
			</div>
		{/if}
		
		<h1 class="head">{$myUser->fullname}
			
		</h1>
		
		{if $birthdayInfo != ''}<div class="subhead">{if $myUser->isStaff() == false}{$lang.controller.datecreated}: {/if}{$birthdayInfo.mday|string_format:"%02d"}/{$birthdayInfo.mon|string_format:"%02d"}/{$birthdayInfo.year}</div>{/if}
		
		
		
		
		
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

       
    