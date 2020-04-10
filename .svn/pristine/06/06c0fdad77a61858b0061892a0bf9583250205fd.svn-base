<h2>{$lang.controller.head_edit}</h2>
<div id="page-intro">{$lang.controller.intro_edit}</div>



<form name="manage" action="" method="post">
<div class="content-box"><!-- Start Content Box -->
	<div class="content-box-header">		
		<h3><span style="font-family:'Courier New', Courier, monospace">{$langFolder}{$folder}/{if $subfolder != ''}{$subfolder}/{/if}{$file}</span></h3>
		<ul class="content-box-link">
			<li><a href="{$conf.rooturl_admin}language">{$lang.controllergroup.formBackLabel}</a></li>
		</ul>
		<div class="clear"></div>  
	</div> <!-- End .content-box-header -->
	
	<div class="content-box-content">
		{foreach item=node from=$fileData}
			<fieldset>
				<p>
					<label style="font-family:'Courier New', Courier, monospace">{$node.name} : </label>
					<textarea class="text-input"  rows="1"  name="fname[{$node.name}]">{$node.values}</textarea>
					{if $node.descr != ''}
						<br /><small>{$lang.controller.formDescriptionLabel}:{$node.descr}</small>
					{/if}
				</p>
			</fieldset>
		{/foreach}
		<br />
	
	</div>
	
	<div class="content-box-content">
		<fieldset>
			<p>
				<label><input type="checkbox" name="fsortbyalphabet" value="1"/> {$lang.controller.formReorderAlphabetLabel}</label>
			</p>
			<p>
				<input type="submit" name="fsubmit" value="{$lang.controllergroup.formSaveSubmit}" class="button buttonbig">
			</p>
		</fieldset>
	</div>
	
	
	
	

    	
</div>
</form>

