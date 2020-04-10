<div class="page-header"><h1>{$lang.controller.head_employeeedit}</h1></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.hrmdepartmentemployeeEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	
	<div class="control-group">
		<label class="control-label" for="fuserid"></label>
		<div class="controls">
			<span class="label label-success">A{$myUser->id}</span> {$myUser->fullname}
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
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
		<a class="pull-right help-inline btn btn-danger" href="javascript:void(0)" onclick="delm('{$conf.rooturl_erp}hrmdepartment/employeeremove/id/{$myUserEdge->id}?ftoken={$smarty.session.securityToken}')"><i class="icon-remove"></i> {$lang.controller.removeEmployee}</a>
	</div>	
	
</form>