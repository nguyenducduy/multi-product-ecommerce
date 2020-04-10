<div class="page-header" rel="menu_productcategory"><h1>Chuyển sản phẩm vào danh mục mới</h1></div>

{if $productlist|@count > 0}
<div class="tabbable">
<form method="POST" action="">
	<input type="hidden" name="ftoken" value="{$smarty.session.productcategoryEditToken}" />
	<input type="hidden" name="fid" value="{$formData.fid}" />
	<div class="tab-content">		
		<div class="tabbable">
			<div class="tab-content">
				{include file="notify.tpl" notifyError=$error notifySuccess=$success}
				
				<div>		        
			        <div>Tên danh mục hiện tại : <b>{$myProductcategory->name}</b></div>
			    </div>
				<br/>
				<div class="control-group">
			        <label class="control-label" for="fname">Tên danh mục mới <span class="star_require">*</span></label>
			        <div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xxlarge"></div>
			    </div>

			    <div class="control-group">
			        <label class="control-label" for="fname">Slug danh mục mới<span class="star_require">*</span></label>
			        <div class="controls"><input type="text" name="fslug" id="fslug" value="{$formData.fslug|@htmlspecialchars}" class="input-xxlarge"></div>
			    </div>

			    <div class="control-group">
			        <label class="control-label" for="fparentid">{$lang.controller.labelParentid}</label>
			        <div class="controls"><select name="fparentid" id="fparentid" style="width:200px;">
			                {if $me->isGroup('administrator') || $me->isGroup('developer')}
			                <option value="0">------</option>
			                {/if}
			                {foreach from=$productcategoryList item=category}
			                    <option value="{$category->id}" {if $category->id == $formData.fparentid}selected="selected"{/if}>{section name=foo start=1 loop=$category->level step=1}&nbsp;&nbsp;{/section}{$category->name}</option>
			                {/foreach}
			            </select></div>
			    </div>

			    <div>
			    	<h3>Danh sách sản phẩm</h3>
			    	<table class="table">
			    		<thead>
			    			<tr>
			    				<th></th>
			    				<th>Id</th>
			    				<th>Barcode</th>
			    				<th>Tên sản phẩm</th>
			    				<th></th>
			    			</tr>
			    		</thead>
			    		<tbody>
			    			{foreach item=product from=$productlist}
			    			<tr>
			    				<td><input type="checkbox" name="fbulkid[]" value="{$product->id}" /></td>
			    				<td><b>{$product->id}</b></td>
			    				<td><span class="label label-info">{$product->barcode}</span></td>
			    				<td><a target="_blank" title="{$product->name}" href="{$product->getProductPath()}"><span class="label label-success">{$product->name}</span></a></td>
			    				<td></td>
			    			</tr>
			    			{/foreach}
			    		</tbody>
			    	</table>
			    </div>
			</div>
		</div>
	</div>
	<div class="form-actions" style="text-align:center;">
        <input type="submit" name="fsubmit" value="Tạo danh mục mới" class="btn btn-large btn-primary" />
        <span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
    </div>
</form>

{else}
<div>Danh mục này hiện thời chưa có sản phẩm.</div>
{/if}
{literal}
<script type="text/javascript">
    $(document).ready(function(){       
        $('#fparentid').select2();        
    });    
</script>
{/literal}