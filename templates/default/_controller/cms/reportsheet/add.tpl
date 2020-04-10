<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ReportSheet</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_reportsheet"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.reportsheetAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftype">{$lang.controller.labelType}</label>
		<div class="controls">
            <select name="ftype" id="ftype">
                {html_options options=$typeList selected=$formData.ftype}
            </select>            
        </div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fdescription">{$lang.controller.labelDescription}</label>
		<div class="controls"><textarea name="fdescription" id="fdescription" rows="7" class="input-xxlarge">{$formData.fdescription}</textarea></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls">
            <select name="fstatus" id="fstatus">
            {html_options options=$statusList selected=$formData.fstatus}
            </select>
        </div>
	</div>

    <div class="control-group">
        <label class="control-label" for="fcolumn">Column</label>
        <div class="controls">
            <a id="checkall" href="javascript:void(0)">Check All</a>
            <a id="uncheckall" href="javascript:void(0)">Uncheck All</a>
            <table class="table table-condensed">
            {foreach item=rows from=$columnList}
                <tr>
                {foreach item=row from=$rows}
                    <td>
                        {if $row->id > 0}
                         <label class="checkbox">
                            <input class="datacolumn" {if is_array($formData.fcolumns) && in_array($row->id , $formData.fcolumns)}checked="checked"{/if} type="checkbox" name="fcolumns[]" value="{$row->id}">{$row->name}
                        </label>
                        {/if}
                    </td>                   
                {/foreach}
                </tr>
            {/foreach}
            </table>
        </div>
    </div>

	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

{literal}
<script type="text/javascript">
    $(document).ready(function(){
        $('#checkall').click(function(){
            $('.datacolumn').attr('checked' , 'checked');
        });

        $('#uncheckall').click(function(){
            $('.datacolumn').removeAttr('checked');
        });
    });
</script>
{/literal}
