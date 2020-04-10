<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">Password Generator</a> <span class="divider">/</span></li>
	<li class="active">Form</li>
</ul>

<div class="page-header" rel="menu_passwordgenerator"><h1>Password Generator</h1></div>

<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.default.formFormLabel}</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
			<form method="post" action="" class="form-inline">
			Password: <input type="text" name="fpassword" /> <input type="submit" name="fsubmit" value="Generate!" class="btn btn-primary" />
			
			</form>	
			
			{if $encodedPass!= ''}<br /><br /><h3>Encoded Password of "{$smarty.post.fpassword}" is : <br /><textarea readonly="readonly" style="width:90%; height:50px;">{$encodedPass}</textarea></h3>{/if}
		</div><!-- end #tab 1 -->
		
	</div>
</div>




