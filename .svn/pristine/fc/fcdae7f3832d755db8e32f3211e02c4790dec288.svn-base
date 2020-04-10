
<div id="panelleft">
	<h3>{$lang.controller.yourcartHeading}</h3>
	
	<table class="cartsmall" cellspacing="0">
		{foreach item=item from=$items}
			<tr>
				<td>{$item->book->title} (&times; {$item->quantity})</td>
				<td width="5"></td>
				<td width="60" align="right">{$item->subtotal|formatprice}</td>
			</tr>
		{/foreach}
		
		<tfoot class="bold">
			<tr>
				<td align="right"><em>{$lang.default.cartTotal}: </em></td>
				<td></td>
				<td class="total" align="right">{$pricetotal|formatprice}<br />
					
				</td>
			</tr>
		</tfoot>
	</table>
		
	<br /><br />
		
	<div class="freeshiprule">
		<p><img src="{$imageDir}store/freeship.png" /><br /><br /></p>
		<p>{$lang.default.cartfreeshiprule}</p>
	</div>
		
</div><!-- end #panelleft -->


<div id="panelright">
	
	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	<div class="checkoutindicator">
		<div class="bar"><span style="width:120px;"></span></div>
		<ul>
			<li><a href="{$conf.rooturl}cart" class="done"><strong>1</strong><span>{$lang.controller.progressCart}</span></a></li>
			<li><a href="{$conf.rooturl}checkout" class="active"><strong>2</strong><span>{$lang.controller.progressBilling}</span></a></li>
			<li><a {if $smarty.session.checkoutStep3Enable == 1}href="{$conf.rooturl}checkout/payment" class="activenext" {else}href="javascript:void(0)"{/if}><strong>3</strong><span>{$lang.controller.progressPayment}</span></a></li>
			<li><a {if $smarty.session.checkoutStep4Enable == 1}href="{$conf.rooturl}checkout/review" class="activenext" {else}href="javascript:void(0)"{/if}><strong>4</strong><span>{$lang.controller.progressReview}</span></a></li>
			<li><a href="javascript:void(0)"><strong>5</strong><span>{$lang.controller.progressFinish}</span></a></li>
		</ul>
		<div class="cl"></div>
	</div>
	
	<div id="loginform" class="myform myformwide stylizedform">
		
		
		
		<form id="form1" name="form1" method="post" action="">
			<h1>{$lang.controller.title}</h1>
			<p></p>
			
			
			
			<label>{$lang.controller.fullname}</label>
			<input type="text" name="ffullname" value="{$formData.ffullname}" id="ffullname" />
			<div class="clear"></div>
			
			<label>{$lang.controller.email}</label>
			<input type="text" name="femail" id="femail" value="{$formData.femail}" />
			<div class="clear"></div>
			
			<label>{$lang.controller.phone}</label>
			<input type="text" name="fphone" id="fphone" value="{$formData.fphone}" />
			<div class="clear"></div>
			
			<label>{$lang.controller.address}</label>
			<input type="text" name="faddress" id="faddress" class="inputwide" value="{$formData.faddress}" />
			<div class="clear"></div>
			
			<label>&nbsp;</label>
			<select name="fregion" id="fregion" onchange="region_loadsub()">
				<option value="0">{$lang.controller.regionDefault}</option>
				{foreach item=region from=$regionList}
					<option value="{$region->id}" {if $region->id == $formData.fregion}selected="selected"{/if}>{$region->name}</option>
				{/foreach}
			</select> <input type="hidden" id="fsubregiondefault" value="{$formData.fsubregion}" />
			<select name="fsubregion" id="fsubregion">
				<option value="0">{$lang.controller.subregiondefault}</option>
			</select>
			<div class="clear"></div>
			
			<label>{$lang.controller.note}</label>
			<textarea title="" name="fnote" id="fnote" cols="30" rows="4" class="inputwide" placeholder="{$lang.controller.notePlaceholder}">{$formData.fnote}</textarea>
			<div class="clear"></div>
			
			{if $me->id == 0}
			<h1>{$lang.controller.titleRegister}</h1>
			<p>{$lang.controller.registerHelp}</p>
			
			<label>{$lang.controller.password}</label>
			<input type="password" name="fpassword1" id="fpassword1" />
			<div class="clear"></div>
			
			<label>{$lang.controller.password2}</label>
			<input type="password" name="fpassword2" id="fpassword2" />
			<div class="clear"></div>
			<p></p>
			{elseif $me->isGroup('administrator')}
				<div style="background:#fffaee"><label>Book For User ID #</label>
				<input type="text" name="fbookforuserid" class="inputshort" value="{$formData.fbookforuserid}" />
				<div class="clear"></div>
				</div>
			{/if}
			
			<input type="submit" class="submit" name="fsubmit" value="{$lang.controller.submitLabel}" />
			<div class="spacer"></div>
			
	  </form>
  </div>
	
</div><!-- end #panelright -->

<script type="text/javascript">
	$(document).ready(function()
	{
		region_loadsub();
	});

</script>


		

