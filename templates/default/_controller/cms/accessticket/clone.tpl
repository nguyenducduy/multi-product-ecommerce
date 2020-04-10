<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">AccessTicket</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_clone}</li>
</ul>

<div class="page-header" rel="menu_accessticket"><h1>{$lang.controller.head_clone}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.accessticketEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	<div class="control-group">
		<label class="control-label" for="fuidsoruce">{$lang.controller.labelUid} Soruce</label>
		<div class="controls">
			<select name="fuidsoruce" id="fuidsoruce" class="autocompletestaff"></select><br>
			<input type="button" class="btn btn-primary" id="searchdata" value="Search" />
		</div>
	</div>	
	<div class="page-header" rel="menu_accessticket"></div>
	<div class="control-group">
		<label class="control-label" for="fuiddes">{$lang.controller.labelUid} Destination</label>
		<div class="controls">
			<select name="fuiddes" id="fuiddes" class="autocompletestaff"></select>		
		</div>
	</div>	
	<div class="control-group" id="searchresult">			
	</div>

	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />		
	</div>	
</form>
{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$("#searchdata").click(function(e){
			var uidsoruce = $("#fuidsoruce").val();
			if(uidsoruce === undefined || uidsoruce === '')
			{
				bootbox.alert('Please choose input soruce uid .');
			}
			else
			{
				datastring = "uidsoruce=" + uidsoruce;
				$.ajax({
					url : rooturl_cms + 'accessticket/getaccessticketajax',
					type : "POST",
					dataType : "html",
					data : datastring,
					success : function(html){
						$("#searchresult").html(html);
					}
				});
			}
		});
		
		$("#checkallticket").live('click' , function(e){
			if($(this).is(':checked'))
			{
				$(".checkticket").each(function(){
					$(this).attr("checked",true);
				});
			}
			else
			{
				$(".checkticket").each(function(){
					$(this).attr("checked",false);
				});
			}
		});		
	});
</script>
{/literal}