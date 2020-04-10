<div class="page-header"><h1>{$lang.controller.head_employeeadd}</h1></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.hrmdepartmentemployeeAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	
	
	<div class="control-group">
		<label class="control-label" for="fuserid">{$lang.controller.labelEmployee}</label>
		<div class="controls">
			<select id="fuidstart" name="fuidstart[]" multiple="multiple" size="4" class="autocompletestaff">
				{foreach item=selectedUser from=$selectedUsers}
					<option value="{$selectedUser->id}" selected="selected" class="selected">{$selectedUser->fullname}</option>
				{/foreach}
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fdepartmentid">{$lang.controller.labelDepartment}</label>
		<div class="controls">
			<select name="fdepartmentid" id="fdepartmentid" class="input-xxlarge">
				{foreach item=department from=$departmentList}
					<option value="{$department->id}" {if $department->id == $formData.fdepartmentid}selected="selected"{/if}>{$department->title}</option>
				{/foreach}
			</select>
		</div>
	</div>
	
	
	<div class="control-group">
		<label class="control-label" for="fjobtitle">{$lang.controller.labelJobtitle}</label>
		<div class="controls">
			<select name="fjobtitle" id="fjobtitle" class="input-xxlarge">
				<option value="0">- - - - - - - - - - - - -</option>
				{foreach item=jobtitle from=$jobtitleList}
					<option value="{$jobtitle->id}" {if $jobtitle->id == $formData.fjobtitle}selected="selected"{/if}>{$jobtitle->name}</option>
				{/foreach}
			</select>
		</div>
	</div>
	

	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>
