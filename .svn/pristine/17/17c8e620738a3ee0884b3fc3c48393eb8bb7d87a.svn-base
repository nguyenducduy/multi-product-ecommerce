<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">User</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_user_list"><h1>{$lang.controller.head_edit}</h1></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.userEditToken}" />

	{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}

	{if $myUser->avatar != ''}
	<div class="control-group">
		<label class="control-label">Avatar</label>
		<div class="controls">
			<a href="{$conf.rooturl}{$setting.avatar.imageDirectory}{$myUser->avatar}" target="_blank"><img src="{$conf.rooturl}{$setting.avatar.imageDirectory}{$myUser->thumbImage()}" width="100" border="0" /></a><input type="checkbox" name="fdeleteimage" value="1" />Delete<br />
		</div>
	</div>
	{/if}

	{if $me->id != $myUser->id}
	<div class="control-group">
		<label class="control-label" for="fgroupid">Group</label>
		<div class="controls">
			<select id="fgroupid" name="fgroupid">
			<option value="">- - - -</option>
			{foreach item=groupname key=key from=$userGroups}
					<option value="{$key}" {if $formData.fgroupid == $key}selected="selected"{/if}>{$groupname}</option>
			{/foreach}
			</select>
		</div>
	</div>
	{/if}
		
		
	<div class="control-group">
		<label class="control-label" for="femail">Email <span class="star_require">*</span></label>
		<div class="controls">
			<input type="text" name="femail" id="femail" disabled="disabled" value="{$formData.femail|@htmlspecialchars}" class="">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fpassword">Password <span class="star_require">*</span></label>
		<div class="controls">
			<a href="javascript:delm('{$conf.rooturl_admin}user/resetpass/id/{$myUser->id}')">Reset Password</a>
		</div>
	</div>
		
				
				
	<div class="control-group">
		<label class="control-label" for="ffullname">Fullname <span class="star_require">*</span></label>
		<div class="controls">
			<input type="text" name="ffullname" id="ffullname" value="{$formData.ffullname|@htmlspecialchars}" class="">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fscreenname">Screen Name <span class="star_require">*</span></label>
		<div class="controls">
			<input type="text" name="fscreenname" id="fscreenname" value="{$formData.fscreenname|@htmlspecialchars}" class="">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="ffacebookid">Facebook ID</label>
		<div class="controls">
			<input type="text" disabled="disabled" id="ffacebookid" value="{$formData.facebookid|@htmlspecialchars}" class="">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fgender">Gender <span class="star_require">*</span></label>
		<div class="controls">
			<select id="fgender" name="fgender">
				<option value="">- - - -</option>
				<option value="m" {if $formData.fgender == 'm'}selected="selected"{/if}>Male</option>
                <option value="fm" {if $formData.fgender == 'fm'}selected="selected"{/if}>Female</option>
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fbirthday">Birthday</label>
		<div class="controls">
			<input type="text" name="fbirthday" id="fbirthday" value="{$formData.fbirthday|@htmlspecialchars}" class="">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fphone">Phone</label>
		<div class="controls">
			<input type="text" name="fphone" id="fphone" value="{$formData.fphone|@htmlspecialchars}" class="">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="faddress">Address</label>
		<div class="controls">
			<input type="text" name="faddress" id="faddress" value="{$formData.faddress|@htmlspecialchars}" class="input-xlarge">
			<select  name="fregion" id="fregion">
				{foreach item=region key=regionid from=$setting.region}
				<option {if $regionid == $formData.fregion}selected="selected" {/if} value="{$regionid}">{$region}</option>
				{/foreach}
				
			</select>
			<input type="text" name="fcountry" id="fcountry" size="2" value="{$formData.fcountry|@htmlspecialchars}" class="input-mini">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fwebsite">Website</label>
		<div class="controls">
			<input type="text" name="fwebsite" id="fwebsite" value="{$formData.fwebsite|@htmlspecialchars}" class="input-xlarge">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fbio">Bio</label>
		<div class="controls">
			<textarea name="fbio" row="6" cols="80" class="input-xxlarge">{$formData.fbio}</textarea>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fcategory">Favourite Category</label>
		<div class="controls">
			<select id="fcategory" name="fcategory[]" multiple="multiple" size="5">
				{foreach item=staticshelf from=$formData.fstaticshelves}
                	<option value="{$staticshelf->id}" {if isset($formData.fcategory) && in_array($staticshelf->id, $formData.fcategory)}selected="selected"{/if} >{$staticshelf->name}</option> 
                {/foreach}
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fdateregister">Date Registered</label>
		<div class="controls">
			{$myUser->datecreated|date_format:"%H:%M:%S - %A, %B %e, %Y"} (IP AddressL {$myUser->ipaddress})
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fdatemodified">Date Modified</label>
		<div class="controls">
			 {if $myUser->datemodified > 0}{$myUser->datemodified|date_format:"%H:%M:%S - %A, %B %e, %Y"}{else}n/a{/if}
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fdatelastlogin">Date Last Login</label>
		<div class="controls">
			{if $myUser->datelastlogin > 0}{$myUser->datelastlogin|date_format:"%H:%M:%S - %A, %B %e, %Y"}{else}n/a{/if}
		</div>
	</div>
			
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<a href="javascript:delm('{$conf.rooturl_admin}user/resetpass/id/{$myUser->id}')" class="btn btn-info pull-right">Reset Password</a>
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>
           
		
</form>

