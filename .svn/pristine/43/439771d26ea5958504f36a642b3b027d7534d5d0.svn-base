<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Internallink</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_internallink"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.internallinkAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	
	<div class="control-group">
		<label class="control-label" for="fisarticle">Bài viết</label>
		<div class="controls">
			<label class="checkbox" style="float: left;">
                <input type="checkbox" name="fisarticle" id="fisarticle" value="1"> Bật
            </label>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fispage">Page</label>
		<div class="controls">
			<label class="checkbox" style="float: left;">
                <input type="checkbox" name="fispage" id="fispage" value="1"> Bật
            </label>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fisproduct">Sản phẩm</label>
		<div class="controls">
			<label class="checkbox" style="float: left;">
                <input type="checkbox" name="fisproduct" id="fisproduct" value="1"> Bật
            </label>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fisevent">Event</label>
		<div class="controls">
			<label class="checkbox" style="float: left;">
                <input type="checkbox" name="fisevent" id="fisevent" value="1"> Bật
            </label>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fiscategoy">Danh mục</label>
		<div class="controls">
			<label class="checkbox" style="float: left;">
                <input type="checkbox" name="fiscategoy" id="fiscategoy" value="1"> Bật
            </label>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fisvendor">Thương hiệu</label>
		<div class="controls">
			<label class="checkbox" style="float: left;">
                <input type="checkbox" name="fisvendor" id="fisvendor" value="1"> Bật
            </label>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fisuppercase">Phân biệt hoa thường</label>
		<div class="controls">
			<label class="checkbox" style="float: left;">
                <input type="checkbox" name="fisuppercase" id="fisuppercase" value="1"> Bật
            </label>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fmaxlinkarticle">Số link tối đa trong 1 bài viết</label>
		<div class="controls"><input type="text" name="fmaxlinkarticle" id="fmaxlinkarticle" value="{$formData.fmaxlinkarticle}" class="input-mini"></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fmaxlinkkey">Số link tối đa cho mỗi từ khóa</label>
		<div class="controls"><input type="text" name="fmaxlinkkey" id="fmaxlinkkey" value="{$formData.fmaxlinkkey}" class="input-mini"></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fmaxurlsame">Số URL giống nhau tối đa</label>
		<div class="controls"><input type="text" name="fmaxurlsame" id="fmaxurlsame" value="{$formData.fmaxurlsame}" class="input-mini"></div>
	</div>
	
	
	
	<div class="control-group">
		<label class="control-label" for="ftarget">Target</label>
		<div class="controls">
		<label class="checkbox" style="float: left;">
			<input type="checkbox" name="ftarget" id="ftarget" value="1"> Bật
			</label>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fisheading">Không đặt ở các thẻ heading</label>
		<div class="controls">
			<label class="checkbox" style="float: left;">
                <input type="checkbox" name="fisheading" id="fisheading" value="1"> Bật
            </label>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fkeylink">Keyword và link</label>
		<div class="controls"><textarea name="fkeylink" id="fkeylink" rows="7" class="input-xxlarge">{$formData.fkeylink}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fexception">Ngoại trừ</label>
		<div class="controls"><textarea name="fexception" id="fexception" rows="7" class="input-xxlarge">{$formData.fexception}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls"><select class="" name="fstatus" id="fstatus">{html_options options=$statusOptions selected=$formData.fstatus}</select></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


