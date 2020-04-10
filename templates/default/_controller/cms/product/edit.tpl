<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Sản phẩm</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_product"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$formData.productpath}?live" target="_blank">Xem sản phẩm trên web</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
<!-- <input type="hidden" name="ftoken" value="{$smarty.session.productEditToken}" /> -->
 <input type="hidden" name="ftab" id="ftab" value="{$formData.ftab}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li {if $formData.ftab ==1}class="active"{/if}><a onclick="changeTab('1')" href="#tab1" data-toggle="tab">{$lang.controller.productInfo}</a></li>
			<li {if $formData.ftab ==2}class="active"{/if}><a onclick="changeTab('2')" href="#tab2" data-toggle="tab">{$lang.controller.attributeInfo}</a></li>
			<li {if $formData.ftab ==3}class="active"{/if}><a onclick="changeTab('3')" href="#tab3" data-toggle="tab">{$lang.controller.mediaInfo}</a></li>
			<li {if $formData.ftab ==4}class="active"{/if} ><a onclick="changeTab('4');activeAcc()" href="#tab4" data-toggle="tab">{$lang.controller.accessories}</a></li>
			<li {if $formData.ftab ==5}class="active"{/if} id="sampletab"><a onclick="changeTab('5');activeRec()" href="#tab5" data-toggle="tab" >{$lang.controller.sample}</a></li>
			<li {if $formData.ftab ==7}class="active"{/if}><a onclick="changeTab('7')" href="#tab7" data-toggle="tab">{$lang.controller.product2}</a></li>
			<li {if $formData.ftab ==8}class="active"{/if}><a onclick="changeTab('8')" href="#tab8" data-toggle="tab">{$lang.controller.product3}</a></li>
			{if $category->parent.0.pc_id == 482}<li {if $formData.ftab ==9}class="active"{/if}><a onclick="changeTab('9')" href="#tab9" data-toggle="tab">Sản phẩm bán kèm</a></li>{/if}
            <li {if $formData.ftab ==6}class="active"{/if}><a onclick="changeTab('6')" href="#tab6" data-toggle="tab">{$lang.controller.color}</a></li>
            <li {if $formData.ftab ==10}class="active"{/if}><a onclick="changeTab('10')" href="#tab10" data-toggle="tab">Khuyến mãi</a></li>
            <li {if $formData.ftab ==11}class="active"{/if}><a onclick="changeTab('11')" href="#tab11" data-toggle="tab">Banner nổi bật</a></li>

		</ul>
		<div class="tab-content">
			<div class="tab-pane {if $formData.ftab ==1}active{/if}" id="tab1">
				<input type="hidden" name="fid" id="fid" value="{$formData.fid}" />
				<div class="control-group">
					<label class="control-label" for="fvid">{$lang.controller.labelVsubid}</label>
					<div class="controls"><select name="fvid" id="fvid">
						<option value="0">----</option>
						{foreach item=vendor from=$vendorList}
							<option value="{$vendor->id}" {if $vendor->id == $formData.fvid}selected="selected"{/if}>{$vendor->name}</option>
						{/foreach}
						</select>
                    </div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fvsubid">{$lang.controller.labelVid}</label>
					<div class="controls">
						<select name="fvsubid" id="fvsubid">
						<option value="0">----</option>
						{foreach item=vendor from=$subVendorList}
							<option value="{$vendor->id}" {if $vendor->id == $formData.fvsubid}selected="selected"{/if}>{$vendor->name}</option>
						{/foreach}
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fpcid">{$lang.controller.labelPcid} <span class="star_require">*</span></label>
					<div class="controls">
						<input type="hidden" name="fpcid" value="{$formData.fpcid}" />
						{foreach from=$productcategoryList item=productCategory}
							{if $formData.fpcid == $productCategory->id}
								<b>{$productCategory->name}</b>&nbsp;&nbsp;&nbsp;
								<a href="javascript:void(0)" onclick="changecategory({$formData.fpcid} , {$formData.fid})">Thay đổi</a>
							{/if}
						{/foreach}
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fbarcode">{$lang.controller.labelBarcode}</label>
					<div class="controls"><input type="text" name="fbarcode" id="fbarcode" value="{$formData.fbarcode|@htmlspecialchars}" class="input-xxlarge"></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fname">{$lang.controller.labelName}</label>
					<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xxlarge"></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fslug">{$lang.controller.labelSlug}</label>
					<div class="controls"><input type="text" name="fslug" id="fslug" value="{$formData.fslug|@htmlspecialchars}" class="input-xxlarge" />
						{if $slugList|@count > 0}
							<div class="">Found item for slug "{$formData.fslug}":</div>
							{foreach item=slug from=$slugList}
								{if $slug->controller != 'product' || $slug->objectid != $formData.fid}<div class="red">&raquo; {$slug->controller} / {$slug->objectid} <a href="{$slug->getSlugSearch()}" title="Go to this slug" class="tipsy-trigger"><i class="icon-share"></i></a></div>{/if}
							{/foreach}
						{/if}
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fname">Màu sản phẩm</label>
					<div class="controls">
						<select id="fpchoosecolor" name="fpchoosecolor">
							<option {if $formData.fpchoosecolor == "kxd"}selected="selected"{/if} value="kxd">Màu không xác định</option>
							<option {if $formData.fpchoosecolor == "-1"}selected="selected"{/if} value="-1">Chọn màu</option>
						</select>
						<div class="btn-group" style="display:none;vertical-align:top;" id="groupcolor">
							<input type="tet" class="input-large" name="fpcolorname" id="fpcolorname" value="{$formData.fpcolorname}" placeholder="Tên màu..." />&nbsp;&nbsp;
							<a class="btn btn-info dropdown-toggle" data-toggle="dropdown">Color</a>
						  	<ul class="dropdown-menu">
						    	<li><div id="colorpalette1"></div></li>
						  	</ul><br/>
						 	<input id="fpcolorstring" name="fpcolorstring" readonly="readonly" value="{if $formData.fpcolorstring != ''}#{/if}{$formData.fpcolorstring}">						  	
						</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fcontent">{$lang.controller.labelContent}</label>
					<div class="controls"><textarea name="fcontent" id="fcontent" rows="7" class="input-xxlarge">{$formData.fcontent}</textarea></div>
					{include file="tinymce.tpl"}
				</div>

				<div class="control-group">
					<label class="control-label" for="fsummary">{$lang.controller.labelSummary}</label>
					<div class="controls"><textarea name="fsummary" id="fsummary" rows="7" class="mceNoEditor input-xxlarge" readonly="readonly">{$formData.fsummary}</textarea></div>
					<br/>
					<div class="controls">
						{if !empty($formData.fsummarynew)}
						{foreach item=summarydata from=$formData.fsummarynew name=foo}
						{if $smarty.foreach.foo.index < 5}
						<input id="fsummarynew_{$smarty.foreach.foo.index}" name="fsummarynew[{$smarty.foreach.foo.index}]" value="{$summarydata}" class="input-xxlarge" /><br/><br/>
						{/if}
						{/foreach}
						{if $formData.fsummarynew|@count < 5}						
							{assign var=enough value=5 - $formData.fsummarynew|@count}
							{section name=foo1 start=0 loop=$enough step=1}
							<input id="fsummarynew_{$smarty.foreach.foo.index}" name="fsummarynew[{$smarty.foreach.foo1.index + $formData.fsummarynew|@count}]" value="" class="input-xxlarge" /><br/><br/>							
							{/section}
						{/if}
						{else}
						{section name=foo start=0 loop=5 step=1}
						<input id="fsummarynew_{$smarty.section.foo.index}" name="fsummarynew[{$smarty.section.foo.index}]" value="{$summarydata}" class="input-xxlarge" /><br/><br/>
						{/section}
						{/if}
					</div>
				</div>				

				<div class="control-group">
					<label class="control-label" for="fsummary">{$lang.controller.labelGood}</label>
					<div class="controls"><textarea name="fgood" id="fgood" rows="7" class="input-xxlarge">{$formData.fgood}</textarea></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fsummary">{$lang.controller.labelBad}</label>
					<div class="controls"><textarea name="fbad" id="fbad" rows="7" class="input-xxlarge">{$formData.fbad}</textarea></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fdienmayreview">{$lang.controller.labelDienmayreview}</label>
					<div class="controls"><textarea name="fdienmayreview" id="fdienmayreview" rows="7" class="input-xxlarge">{$formData.fdienmayreview}</textarea></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="ffullbox">{$lang.controller.labelFullbox}</label>
					<div class="controls"><textarea name="ffullbox" id="ffullbox" rows="7" class="input-xxlarge">{$formData.ffullbox}</textarea></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="ffullboxshort">Tóm tắt bộ báng hàng chuẩn</label>
					<div class="controls"><textarea name="ffullboxshort" id="ffullboxshort" rows="7" class="mceNoEditor input-xxlarge">{$formData.ffullboxshort}</textarea></div>
				</div>

				<!-- <div class="control-group">
					<label class="control-label" for="flaigopauto">{$lang.controller.labellaigopauto}</label>
					<div class="controls">{$formData.flaigop}</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="flaigop">{$lang.controller.labellaigop}</label>
					<div class="controls"><input type="text" name="flaigop" id="flaigop" value="{$formData.flaigop|@htmlspecialchars}" class="input-xlarge"></div>
				</div> -->

				<div class="control-group">
					<label class="control-label" for="fseotitle">{$lang.controller.labelSeotitle}</label>
					<div class="controls"><input type="text" name="fseotitle" id="fseotitle" value="{$formData.fseotitle}" class="input-xxlarge"/></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fseokeyword">{$lang.controller.labelSeokeyword}</label>
					<div class="controls"><textarea name="fseokeyword" id="fseokeyword" rows="7" class="mceNoEditor input-xxlarge">{$formData.fseokeyword}</textarea></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fseodescription">SEO Description</label>
					<div class="controls"><textarea name="fseodescription" id="fseodescription" rows="7" class="mceNoEditor input-xxlarge">{$formData.fseodescription}</textarea></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fseodescription">Keyword</label>
					<div class="controls"><input name="fkeyword" id="tags_keyword" type="text" class="tags" value="{$formData.fkeyword}" /></p></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fcanonical">{$lang.controller.labelCanonical}</label>
					<div class="controls"><input type="text" name="fcanonical" id="fcanonical" value="{$formData.fcanonical}" class="input-xxlarge"/></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fmetarobot">Metarobot</label>
					<div class="controls"><input type="text" name="fmetarobot" id="fmetarobot" value="{$formData.fmetarobot}" class="input-xxlarge"/></div>
				</div>

				<div class="control-group">
			        <label class="control-label" for="ftopseokeyword">Top SEO keyword</label>
			        <div class="controls"><textarea name="ftopseokeyword" id="ftopseokeyword" rows="7" class=" input-xxlarge">{$formData.ftopseokeyword}</textarea>Còn lại <span id="ftopseokeywordcounter">255</span> ký tự</div>
			    </div>

			    <div class="control-group">
			        <label class="control-label" for="ftextfooter">Text footer</label>
			        <div class="controls"><textarea name="ftextfooter" id="ftextfooter" rows="7" class="input-xxlarge">{$formData.ftextfooter}</textarea></div>
			    </div>

				<div class="control-group" id="sellprice">
					<label class="control-label" for="fsellprice">{$lang.controller.labelSellprice}</label>
					<div class="controls"><input type="text" name="fsellprice" id="fsellprice" value="{$formData.fsellprice|@htmlspecialchars}" class="input-medium" readonly>&nbsp;{$lang.controller.labelCurrency}&nbsp;&nbsp;&nbsp;
						<a id="viewsellprice" href="javascript:void(0)" onclick="viewShadowbox('{$conf.rooturl_admin}productprice/index/pbarcode/{$formData.fbarcode}' , '', 'giá')">Xem chi tiết</a>&nbsp;&nbsp;
						<a href="javascript:void(0)" onclick="viewShadowbox('{$conf.rooturl_admin}productprice/index/pbarcode/{$formData.fbarcode}/tab/2' , '', 'giá')">Giá đối thủ</a>
					</div>
				</div>

<!--				<div class="control-group">-->
<!--					<label class="control-label" for="fdiscountpercent">{$lang.controller.labelDiscountPercent}</label>-->
<!--					<div class="controls"><input type="text" name="fdiscountpercent" id="fdiscountpercent" value="{$formData.fdiscountpercent|@htmlspecialchars}" class="input-mini" readonly>&nbsp;(%)</div>-->
<!--				</div>-->

				<!--<div class="control-group">
					<label class="control-label" for="fisbagdehot">{$lang.controller.labelIsbagdehot}</label>
					<div class="controls"><input type="checkbox" value="1" name="fisbagdehots" id="fisbagdehot" {if $formData.fisbagdehot > 0}checked="checked"{/if}></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fisbagdenew">{$lang.controller.labelIsbagdenew}</label>
					<div class="controls"><input type="checkbox" value="1" name="fisbagdenews" id="fisbagdenew" {if $formData.fisbagdenew > 0}checked="checked"{/if}></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fisbagdegift">{$lang.controller.labelIsbagdegift}</label>
					<div class="controls"><input type="checkbox" value="1" name="fisbagdegifts" id="fisbagdegift" {if $formData.fisbagdegift > 0}checked="checked"{/if}></div>
				</div>-->

				<div class="control-group">
					<label class="control-label" for="fdisplaysellprice"> Hiển thị giá niêm yết </label>
					<div class="controls"><input type="checkbox" name="fdisplaysellprice" id="fdisplaysellprice" value="1" {if $formData.fdisplaysellprice >0}checked="checked"{/if}></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fwarranty">Bảo hành</label>
					<div class="controls"><input type="text" class="input-mini" name="fwarranty" id="fwarranty" value="{$formData.fwarranty}">&nbsp;Tháng</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fpwidth">Chiều dài x Chiều rộng x Chiều cao</label>
					<div class="controls"><input type="text" class="input-mini" name="fpwidth" id="fpwidth" value="{$formData.fpwidth}"> x <input type="text" class="input-mini" name="fplength" id="fplength" value="{$formData.fplength}"> x <input type="text" class="input-mini" name="fpheight" id="fpheight" value="{$formData.fpheight}">cm</div>					
				</div>

				<div class="control-group">
					<label class="control-label" for="fpweight">Khối lượng</label>
					<div class="controls"><input type="text" class="input-mini" name="fpweight" id="fpweight" value="{$formData.fpweight}">kg</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="ftransporttype">Vận chuyển</label>
					<div class="controls">
						<select name="ftransporttype">
							{html_options options=$transporttypeList selected=$formData.ftransporttype}
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fsetuptype">Lắp đặt</label>
					<div class="controls">
						<select name="fsetuptype">
							{html_options options=$setuptypeList selected=$formData.fsetuptype}
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="finstock">{$lang.controller.labelInstock}</label>
					<div class="controls"><input type="text" name="finstock" id="finstock" value="{$formData.finstock|@htmlspecialchars}" class="input-mini" readonly>&nbsp;
						{if $formData.fbarcode != ''}
							<a href="javascript:void(0)" onclick="viewShadowbox('{$conf.rooturl_admin}productstock/index/pbarcode/{$formData.fbarcode}' , '{$product->name|escape}' , 'tồn kho')">Xem chi tiết</a>
						{/if}
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fdisplayorder">{$lang.controller.labelDisplayorder}</label>
					<div class="controls"><input type="text" name="fdisplayorder" id="fdisplayorder" value="{$formData.fdisplayorder|@htmlspecialchars}" class="input-mini"></div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="fdisplaymanual">Hiển thị manual</label>
					<div class="controls"><input type="text" name="fdisplaymanual" id="fdisplaymanual" value="{$formData.fdisplaymanual|@htmlspecialchars}" class="input-mini"></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fdisplaytype">Loại hiển thị</label>
					<div class="controls">
						<select name="fdisplaytype">
							{html_options options=$displaytypeList selected=$formData.fdisplaytype}
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
					<div class="controls"><select name="fstatus">
							{html_options options=$statusList selected=$formData.fstatus}
						</select></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="fstatus">{$lang.controller.labelOnsiteStatus}</label>
					<div class="controls">
						<select name="fonsitestatus" id="fonsitestatus" onchange="changeonistestatus()">
							{html_options options=$onsitestatusList selected=$formData.fonsitestatus}
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fbusinessstatus">Trạng thái kinh doanh</label>
					<div class="controls">
						<select name="fbusinessstatus" disabled>
							<option value="0">Không xác định</option>
							{html_options options=$businessstatusList selected=$formData.fbusinessstatus}
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fisrequestimei">Yêu cầu IMEI</label>
					<div class="controls">
						<select name="fisrequestimei">
							<option {if $formData.fisrequestimei == 1}selected="selected"{/if} value="1">Có</option>							
							<option {if $formData.fisrequestimei == 0}selected="selected"{/if} value="0">Không</option>							
						</select>
					</div>
				</div>
				<div id="osprepaid" {if $formData.fonsitestatus != 2}style="display: none;"{/if}>
                <div class="control-group"  id="prepaidprice">
                    <label class="control-label" for="fprepaidprice">Giá đặt hàng trước</label>
                    <div class="controls"><input type="text" name="fprepaidprice" id="fprepaidprice" value="{$formData.fprepaidprice|@htmlspecialchars}" class="input-medium">&nbsp;{$lang.controller.labelCurrency}</div>
                </div>
			    <!-- dat hang truoc -->
			    <div class="control-group">
			        <label class="control-label" for="">Thời gian đặt hàng trước</label>
			        <div class="controls">
			        	<lable style="margin-right:20px">Từ</lable>
			        	<div class="input-append bootstrap-timepicker">
				            <input id="fsttime" type="text"  placeholder="H:m:s" name="fsttime" value="{$formData.fsttime}" class="input-small timepicker">
				            <span class="add-on"><i class="icon-time"></i></span>
			        	</div> 
			        	<input class='inputdatepicker' type="text" name="fprepaidstartdate" id="fprepaidstartdate" value="{if $formData.fprepaidstartdate > 0}{$formData.fprepaidstartdate|@htmlspecialchars}{/if}" > 
			        </div>
			        <div class="controls" style="margin-top:10px">
			        	<lable style="margin-right:12px">Đến</lable> 
			        	<div class="input-append bootstrap-timepicker">
				            <input id="fextime" type="text" placeholder="H:m:s" name="fextime" value="{$formData.fextime}" class="input-small timepicker">
				            <span class="add-on"><i class="icon-time"></i></span>
		        		</div>
			        	<input class='inputdatepicker' type="text" name="fprepaidenddate" id="fprepaidenddate" value="{if $formData.fprepaidenddate > 0}{$formData.fprepaidenddate|@htmlspecialchars}{/if}" >
			        </div>
			    </div>
				    <div class="control-group">
				        <label class="control-label" for="">Tên chương trình đặt trước</label>
				        <div class="controls">
				        	<input type="text" value="{$formData.fprepaidname}" name="fprepaidname" class="input input-xxlarge" id="fprepaidname" />
				        </div>
				    </div>
				      <div class="control-group">
				        <label class="control-label" for="">Khuyến mãi</label>
				        <div class="controls">
				        	<textarea name="fprepaidpromotion" id="fprepaidpromotion" class="input input-xxlarge mceNoEditor" rows="5">{$formData.fprepaidpromotion}</textarea>
				        </div>
				    </div>
				    <div class="control-group">
				        <label class="control-label" for="prepaidpolicy">Chính sách bán hàng</label>
				        <div class="controls">
				        	<textarea name="fprepaidpolicy" id="fprepaidpolicy" class="input input-xxlarge mceNoEditor" rows="5">{$formData.fprepaidpolicy}</textarea>
				        </div>
				    </div>

				     <div class="control-group">
				        <label class="control-label" for="">Số lượng hàng đặt được</label>
				        <div class="controls">
				        	<input type="text" value="{$formData.fprepaidrand}" name="fprepaidrand" class="input input-xlarge" id="fprepaidrand" />
				        </div>
				    </div>

				    <div class="control-group">
				        <label class="control-label" for="">Yêu cầu đặt cọc</label>
				        <div class="controls">
				        	<input type="text" value="{$formData.fprepaiddepositrequire|@htmlspecialchars}" name="fprepaiddepositrequire" class="input input-xlarge" id="fprepaiddepositrequire" />
				        </div>
				    </div>
			    </div>


			    <!-- End dat truoc -->

			    <div class="control-group" id="importtime" {if ($formData.fonsitestatus != 10) || ($formData.fonsitestatus == 6 && $formData.finstock <= 0 && $formData.fsellprice > 0)}style="display: none;"{/if}>
			        <label class="control-label" for="">Thời gian dự kiến nhập hàng</label>
			        <div class="controls"><input class='inputdatepicker' type="text" name="fimportdate" id="fimportdate" value="{if $formData.fimportdate > 0}{$formData.fimportdate|@htmlspecialchars}{/if}" ></div>
			    </div>

			    <div id="commingsoon" {if $formData.fonsitestatus != 10}style="display:none;"{/if}>
					<div class="control-group" id="fcomingsoondate">
			        	<label class="control-label" for="">Thời gian dự kiến</label>
			        	<div class="controls"><input type="text" name="fcomingsoondate" id="fcomingsoodate" value="{$formData.fcomingsoondate}" />(DD/MM/YYYY)</div>
				    </div>

				    <div class="control-group" id="fcomingsoonprice">
				        <label class="control-label" for="">Giá dự kiến</label>
				        <div class="controls"><input type="text" name="fcomingsoonprice" id="fcomingsoonprice" value="{$formData.fcomingsoonprice}" /></div>
				    </div>
				</div>

                {if !empty($formData.fbarcode)}
				<div class="control-group">
					<div class="controls">
						<a href="javascript:void(0)" onclick="updatepromotionforproduct('{$formData.fbarcode|trim}')" id="buttonupdatepromotion" class="btn btn-large btn-primary btn-warning">Cập nhật khuyến mãi</a>
						<a href="javascript:void(0)" onclick="clearcacheproduct();" id="clearcache" class="btn btn-large btn-primary btn-warning">Clear cache</a>
					</div>
				</div>				
                {/if}
				{if $ischangeproductcolor}
				<div class="control-group" style="float:right;">
					<div class="controls">
						<a href="javascript:void(0)" id="changeproductcolor">Chuyển sản phẩm thành sản phẩm màu</a>
					</div>					
				</div>
				<div class="control-group" style="float:right;display:none;" id="datacolor">
					<div class="controls">
						<input type="hidden" id="fiddestination" value="{$formData.fid}" />
						Id của sản phẩm chính mà bạn muốn chuyển : <input type="text" id="fidsource" class="input-large"/><br/><br/>
						<div style="margin:0px 0px 0px 228px;">
							Màu: <div class="btn-group" style="vertical-align:top;" id="groupcolor">
								<input type="tet" class="input-large" name="fpcolornamechange" id="fpcolornamechange" value="" placeholder="Tên màu..." />&nbsp;&nbsp;
								<a class="btn btn-info dropdown-toggle" data-toggle="dropdown">Color</a>
							  	<ul class="dropdown-menu">
							    	<li><div id="colorpalette2"></div></li>
							  	</ul><br/>
							 	<input id="fpcolorchange" name="fpcolorchange" readonly="readonly" value="">						  	
							</div>
						</div>
						<br/><br/>
						<input style="float:right;" type="button" class="btn btn-primary" id="fsubmitchangeproductcolor" value="Chuyển" />
					</div>
				</div>
				{/if}
			</div><!--end of tab1-->
			<div class="tab-pane {if $formData.ftab ==2}active{/if}" id="tab2" style="overflow:hidden">
				<img src="{$currentTemplate}images/ajax_indicator.gif" />
				<!--load ajax-->
			</div><!--end of tab2-->
			<div class="tab-pane {if $formData.ftab ==3}active{/if}" id="tab3">
				<h1>Hình đại diện</h1>
				{$lang.controller.iamgeLabel}&nbsp;:&nbsp;
				{if $formData.fimage != ''}
				<a href="{$formData.fimage}" rel="shadowbox"><img src="{$formData.fimage}" width="50px" height="50px" /></a>
				{/if}
				<input type="file" name="fimage" /><br/>
				<span {if $formData.fimage != ''}style="padding-left:120px;"{else}style="padding-left:47px;"{/if}></span><br/><br/>
				<h1>Gallery</h1>
				<table class="table" id="gallery">
					{foreach item=media from=$productmediaList}
					{if $media->type ==1}
					<tr id="{$media->id}">						
						<td><input type="checkbox" name="fdeletegallerys[{$media->id}]" value="1" />&nbsp;&nbsp;<input type="text" class="input-mini" name="fdisplaygallery[{$media->id}]" value="{$media->displayorder}" />&nbsp;&nbsp;<input type="hidden" name="fmediaId[]" value="{$media->id}" />{$media->getMediaName()}</td>						
						<td>
							<a href="{$media->getSmallImage()}" rel="shadowbox"><img src="{$media->getSmallImage()}" width="50px" height="50px" /></a>
						</td>
						<td><input type="text" name="fcaptionmedia[{$media->id}]" value="{$media->caption}" {if $media->caption == ''}placeholder="Caption..."{/if} /></td>
						<td><input type="text" name="faltmedia[{$media->id}]" value="{$media->alt}" {if $media->alt == ''}placeholder="Alt..."{/if} /></td>
						<td><input type="text" name="ftitleseomedia[{$media->id}]" value="{$media->titleseo}" {if $media->titleseo == ''}placeholder="Title SEO..."{/if} /></td>
						<td><a title="{$lang.default.formActionDeleteTooltip}" class="btn btn-mini btn-danger" href="javascript:void(0)" onclick="deleteMedia('{$media->id}')"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
					</tr>
					{/if}
					{/foreach}
					{foreach item=media from=$productmediaList}
					{if $media->type ==3}
					<tr id="{$media->id}">
						<td><input type="hidden" name="fmediaId[]" value="{$media->id}" />{$media->getMediaName()}</td>
						<td>
							<input type="text" name="fmoreurlold[{$media->id}]" value="{$media->moreurl}" />
						</td>
						<td><input type="text" name="fcaptionmedia[{$media->id}]" value="{$media->caption}" {if $media->caption == ''}placeholder="Caption..."{/if} /></td>
						<td><input type="text" name="faltmedia[{$media->id}]" value="{$media->alt}" {if $media->alt == ''}placeholder="Alt..."{/if} /></td>
						<td><input type="text" name="ftitleseomedia[{$media->id}]" value="{$media->titleseo}" {if $media->titleseo == ''}placeholder="Title SEO..."{/if} /></td>
						<td><a title="{$lang.default.formActionDeleteTooltip}" class="btn btn-mini btn-danger" href="javascript:void(0)" onclick="deleteMedia('{$media->id}')"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
					</tr>
					{/if}
					{/foreach}
					<tr>
						<td><input type="submit" class="btn btn-mini btn-danger" value="Xóa hình ảnh" name="fdeletegallery" /></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>Hình sản phẩm</td>
						<td><input type="file" name="ffile[]" multiple /></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>YouTube URL</td>
						<td><input type="text" id="urlvalue-2" name="furl[2]" placeholder="URL..."></span></td>
						<td><span id="caption-2"><input type="text" name="fcaption[2]" value="" placeholder="Caption..." /></span></td>
						<td><span id="alt-2"><input type="text"  name="falt[2]" value="" placeholder="Alt..." /></span></td>
						<td><span id="titleseo-2"><input type="text"  name="ftitleseo[2]" value="" placeholder="Title..." /></span></td>
						<td></td>
					</tr>
				</table>
				<input style="float:right;" class="btn btn-small btn-success" type="button" id="faddbutton" value="+" onclick="addRow('gallery')" /><br/><br/><br/>
				<h1>{$lang.controller.image360}</h1>
				<table class="table" id="t360">
					<tr>
						<td colspan="6"><input type="checkbox" id="checkall360gallery" /></td>
					</tr>
					{foreach item=media from=$productmediaList}
					{if $media->type == 5}					
					<tr id="{$media->id}">
						<td><input class="checkgallery360" type="checkbox" name="fdeletegallerys360[{$media->id}]" value="1" /><input type="hidden" name="fmediaId[]" value="{$media->id}" />{$media->getMediaName()}</td>
						<td>
							<a href="{$media->getSmallImage()}" rel="shadowbox"><img src="{$media->getSmallImage()}" width="50px" height="50px" /></a>
						</td>
						<td><input type="text" name="fcaptionmedia[{$media->id}]" value="{$media->caption}" /></td>
						<td><input type="text" name="faltmedia[{$media->id}]" value="{$media->alt}" /></td>
						<td><input type="text" name="ftitleseomedia[{$media->id}]" value="{$media->titleseo}" /></td>
						<td><a title="{$lang.default.formActionDeleteTooltip}" class="btn btn-mini btn-danger" href="javascript:void(0)" onclick="deleteMedia('{$media->id}')"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
					</tr>
					{/if}
					{/foreach}
                    <tr>
                        <td><input type="submit" class="btn btn-mini btn-danger" value="Xóa hình ảnh 360" name="fdeletegallery360" /></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
					<tr id="image360_1">
						<td style="width:101px;">Upload hình 360 : </td>
						<td><input type="file" name="ffile360[]" multiple="multiple" max="100"/></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>
				<input style="float:right;" class="btn btn-small btn-success" type="button" id="faddbutton" value="+" onclick="addRow('t360')" />
				<h1>Thông số kỹ thuật</h1>
				<table>
					<tr>
						<td style="width:155px;">{foreach item=media from=$productmediaList}
				{if $media->type == 7}<div id="{$media->id}"><input type="hidden" name="ftypespecial" value="{$media->id}"/><img src="{$media->getSmallImage()}" />&nbsp; <a title="{$lang.default.formActionDeleteTooltip}" class="btn btn-mini btn-danger" href="javascript:void(0)" onclick="deleteSpecialMedia('{$media->id}')"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>{/if}</div>
				{/foreach}</td>
						<td><input type="file" name="ftypespecialimg[0]" style="width:200px;" /></td>
						<td><input type="text" name="ftypespecialcaption" value="" placeholder="Caption..." value="{$formData.ftypespecialcaption}" /></td>
						<td><input type="text" name="ftypespecialalt" value="" placeholder="Alt..." value="{$formData.ftypespecialalt}" /></td>
						<td><input type="text" name="ftypespecialtitle" value="" placeholder="Titlte..."  /></td>
						<td></td>
					</tr>
				</table>
			</div><!--end of tab3-->
		{*	<div class="tab-pane {if $formData.ftab ==4}active{/if}" id="tab4"><!--end of tab4-->
				{if $accessoriesList|@count > 0}
					<table class="table">
						<thead>
							<tr>
								<th>{$lang.controller.labelDisplayorder}</th>
								<th></th>
								<th>Id</th>
						        <th>Barcode</th>
								<th>{$lang.controller.labelPcid}</th>
								<th>{$lang.controller.labelName}</th>
								<th>{$lang.controller.labelInstock}</th>
								<th>{$lang.controller.labelSellprice}</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						{foreach item=accessories from=$accessoriesList key=key}
							<tr id="row_{$key}">
								<td>
									<input typpe="text" name="faccessoriesdisplayorder[{$key}]" value="{$accessories->rppdisplayorder}" class="input-mini" />
								</td>
								<td>
									{if $accessories->image != ''}
									<a href="{$accessories->getSmallImage()}" rel="shadowbox"><img src="{$accessories->getSmallImage()}" width="50px" height="50px" /></a>
									{/if}
								</td>
								<td>{$accessories->id}</td>
								<td>{$accessories->barcode}</td>
								<td><span class="label label-info">{$accessories->categoryactor->name}</span></td>
								<td>{$accessories->name}</td>
								<td>{$accessories->instock}</td>
								<td>{$accessories->sellprice}&nbsp;{$lang.controller.labelCurrency}</td>
								<td><a class="btn btn-mini btn-danger" href="javascript:void(0)" id="removeAccessories_{$key->id}" onclick="removeProduct('#row_{$key}', '{$key}')"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
							</tr>
						{/foreach}
						</tbody>
					</table>
				{/if}
				{$lang.default.filterLabel} <input type="text" name="fsearchaccessories" id="fsearchaccessories"/>
				<input type="button" name="fsearchButton" id="fsearchButton" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="searchProductAccessories()" />
				<div id="resultAccessories">

				</div>
				<div id="accessoriesproduct" style="display:none"><h1>Product Choose</h1><table class="table" id="chooseaccessories"><thead>
					<tr>
						<th></th>
						<th>Id</th>
						<th>Barcode</th>
						<th>Danh mục</th>
						<th>Tên sản phẩm</th>
						<th>Số lượng</th>
						<th>Giá</th>
						<th></th>
					</tr>
				</thead><tbody></tbody></table></div>
			</div>*}


            <div class="tab-pane {if $formData.ftab ==4}active{/if}" id="tab4"><!--end of tab5-->
                {if $accessoriesList|@count > 0}
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{$lang.controller.labelDisplayorder}</th>
                            <th></th>
                            <th>Id</th>
                            <th>Barcode</th>
                            <th>{$lang.controller.labelPcid}</th>
                            <th>{$lang.controller.labelName}</th>
                            <th>{$lang.controller.labelInstock}</th>
                            <th>{$lang.controller.labelSellprice}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach item=accessories from=$accessoriesList key=key}
                        <tr id="row_{$key}">
                            <td>
                                <input typpe="text" name="faccessoriesdisplayorder[{$key}]" value="{$accessories->rppdisplayorder}" class="input-mini" />
                            </td>
                            <td>
                                {if $accessories->image != ''}
                                    <a href="{$accessories->getSmallImage()}" rel="shadowbox"><img src="{$accessories->getSmallImage()}" width="50px" height="50px" /></a>
                                {/if}
                            </td>
                            <td>{$accessories->id}</td>
                            <td>{$accessories->barcode}</td>
                            <td><span class="label label-info">{$accessories->categoryactor->name}</span></td>
                            <td>{$accessories->name}</td>
                            <td>{$accessories->instock}</td>
                            <td>{$accessories->sellprice}&nbsp;{$lang.controller.labelCurrency}</td>
                            <td><a class="btn btn-mini btn-danger" href="javascript:void(0)" id="removeAccessories_{$key->id}" onclick="removeProduct('#row_{$key}', '{$key}')"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
                        </tr>
                        {/foreach}
                        </tbody>
                    </table>
                {/if}

                <div id="accessoriesproduct" style=""><h1>Product Choose</h1>
                    <table class="table" id="chooseaccessories">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Id</th>
                            <th>Barcode</th>
                            <th>Danh mục</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id='acctab'>
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a onclick="" href="#stab5" data-toggle="tab">Manual</a></li>
                    <li class=""><a onclick="" href="#stab4" data-toggle="tab">Goi y</a></li>
                </ul>
                <div id="myTabContent" class="tab-content ">
                    <div class="tab-pane fade in active" id="stab5">
                        {$lang.default.filterLabel} <input type="text" name="fsearchaccessories" id="fsearchaccessories"/>
                        <input type="button" name="fsearchButton" id="fsearchButton" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="searchProductAccessories()" />
                        <div id="resultAccessories">

                        </div>
                    </div>
                    <div class="tab-pane fade in" id="stab4">
                        <div>
                            {$formData.access}
                        </div>
                    </div>


                </div>
            </div>







            <!--end of tab4-->
            <div class="tab-pane {if $formData.ftab ==5}active{/if}" id="tab5"><!--end of tab5-->
                {if $sampleList|@count > 0}
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{$lang.controller.labelDisplayorder}</th>
                            <th></th>
                            <th>Id</th>
                            <th>Barcode</th>
                            <th>{$lang.controller.labelPcid}</th>
                            <th>{$lang.controller.labelName}</th>
                            <th>{$lang.controller.labelInstock}</th>
                            <th>{$lang.controller.labelSellprice}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach item=sample from=$sampleList key=key}
                            <tr id="rows_{$key}">
                                <td><input name="fsampledisplayorder[{$key}]" value="{$sample->rppdisplayorder}"
                                           class="input-mini"/></td>
                                <td>
                                    {if $sample->image != ''}
                                        <a href="{$sample->getSmallImage()}" rel="shadowbox"><img
                                                    src="{$sample->getSmallImage()}" width="50px" height="50px"/></a>
                                    {/if}
                                </td>
                                <td>{$sample->id}</td>
                                <td>{$sample->barcode}</td>
                                <td><span class="label label-info">{$sample->categoryactor->name}</span></td>
                                <td>{$sample->name}</td>
                                <td>{$sample->instock}</td>
                                <td>{$sample->sellprice}&nbsp;{$lang.controller.labelCurrency}</td>
                                <td><a class="btn btn-mini btn-danger" href="javascript:void(0)"
                                       id="removeSample_{$key}" onclick="removeProduct('#rows_{$key}' , '{$key}')"><i
                                                class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                {/if}

                <div id="sampleproduct" style=""><h1>Product Choose</h1>
                    <table class="table" id="choosesample">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Id</th>
                            <th>Barcode</th>
                            <th>Danh mục</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach $formData.recommendSample as $key=>$value}
                            <tr id="rowsample_{$value->id}">
                                <td>
                                    <a href="{$value->image}"
                                       rel="shadowbox"><img
                                                src="{$value->image}"
                                                width="100px" height="100px"></a></td>
                                <td>{$value->id}</td>
                                <td>{$value->barcode}</td>
                                <td><span class="label label-info"><span
                                                class="label label-info">{$value->productCategory}</span></span></td>
                                <td><input type="hidden" name="sample[]" value="{$value->id}"
                                           id="sample_{$value->id}">{$value->name}
                                </td>
                                <td>{$value->sellprice}</td>
                                <td>{$value->instock}</td>
                                <td><input type="button" class="btn btn-danger" id="fclear_{$value->id}"
                                           onclick="clearFunction({$value->id},2)" value="Remove"></td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id='retab'>
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a onclick="" href="#stab1" data-toggle="tab">Manual</a></li>
                    <li class=""><a onclick="" href="#stab2" data-toggle="tab">Mua cung</a></li>
                    <li class=""><a onclick="" href="#stab3" data-toggle="tab">Tuong tu</a></li>
                </ul>
                <div id="myTabContent" class="tab-content ">
                    <div class="tab-pane fade in active" id="stab1">
                        {$lang.default.filterLabel} <input type="text" name="fsearchsample" id="fsearchsample"/>
                        <input type="button" name="fsearchButton" id="fsearchButton"
                               value="{$lang.default.filterSubmit}" class="btn btn-primary"
                               onclick="searchProductSample()"/>

                        <div id="resultSample">

                        </div>
                    </div>
                    <div class="tab-pane fade active in" id="stab2">
                        <div>
                            {$formData.recommendationf2}
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="stab3">
                        <div>
                            {$formData.recommendationf3}
                        </div>

                    </div>

                </div>
            </div>
				<!--end of tab5-->

			<div class="tab-pane {if $formData.ftab ==7}active{/if}" id="tab7"><!--end of tab7-->
				{if $product2List|@count > 0}
					<table class="table">
						<thead>
							<tr>
								<th>{$lang.controller.labelDisplayorder}</th>
								<th></th>
								<th>Id</th>
						        <th>Barcode</th>
								<th>{$lang.controller.labelPcid}</th>
								<th>{$lang.controller.labelName}</th>
								<th>{$lang.controller.labelInstock}</th>
								<th>{$lang.controller.labelSellprice}</th>
								<th>{$lang.controller.labelStartdate}</th>
								<th>{$lang.controller.labelEnddate}</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						{foreach item=product2 from=$product2List key=key}
							<tr id="rows_{$key}">
								<td><input name="fproduct2displayorder[{$key}]" value="{$product2->rppdisplayorder}" class="input-mini" /></td>
								<td>
									{if $product2->image != ''}
									<a href="{$product2->getSmallImage()}" rel="shadowbox"><img src="{$product2->getSmallImage()}" width="50px" height="50px" /></a>
									{/if}
								</td>
								<td>{$product2->id}</td>
								<td>{$product2->barcode}</td>
								<td><span class="label label-info">{$product2->categoryactor->name}</span></td>
								<td><span {if $product2->enddate < $smarty.now}style="color:red"{/if}>{$product2->name}</span></td>
								<td>{$product2->instock}</td>
								<td>{$product2->sellprice}&nbsp;{$lang.controller.labelCurrency}</td>
								<td>{$product2->datecreated|date_format:"%d/%m/%Y"}</td>
								<td>{$product2->enddate|date_format:"%d/%m/%Y"}</td>
								<td><a class="btn btn-mini btn-danger" href="javascript:void(0)" id="removeSample_{$key}" onclick="removeProduct('#rows_{$key}' , '{$key}')"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
							</tr>
						{/foreach}
						</tbody>
					</table>
				{/if}
				{$lang.default.filterLabel} <input type="text" name="fsearchproduct2" id="fsearchproduct2"/>
				<input type="button" name="fsearchButton" id="fsearchButton" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="searchProduct2()" />
				<div id="resultProduct2">

				</div>
				<div id="product2" style="display:none"><h1>Product Choose</h1><table class="table" id="chooseproduct2"><thead>
					<tr>
						<th></th>
						<th>Id</th>
						<th>Barcode</th>
						<th>Danh mục</th>
						<th>Tên sản phẩm</th>
						<th>Số lượng</th>
						<th>Giá</th>
						<th></th>
					</tr>
				</thead><tbody></tbody></table></div>
			</div><!--end of tab7-->

			<div class="tab-pane {if $formData.ftab ==8}active{/if}" id="tab8"><!--end of tab8-->
				{if $product3List|@count > 0}
					<table class="table">
						<thead>
							<tr>
								<th>{$lang.controller.labelDisplayorder}</th>
								<th></th>
								<th>Id</th>
        						<th>Barcode</th>
								<th>{$lang.controller.labelPcid}</th>
								<th>{$lang.controller.labelName}</th>
								<th>{$lang.controller.labelInstock}</th>
								<th>{$lang.controller.labelSellprice}</th>
								<th>{$lang.controller.labelStartdate}</th>
								<th>{$lang.controller.labelEnddate}</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						{foreach item=product3 from=$product3List key=key}
							<tr id="rows_{$key}">
								<td><input name="fproduct3displayorder[{$key}]" value="{$product3->rppdisplayorder}" class="input-mini" /></td>
								<td>
									{if $product3->image != ''}
									<a href="{$product3->getSmallImage()}" rel="shadowbox"><img src="{$product3->getSmallImage()}" width="50px" height="50px" /></a>
									{/if}
								</td>
								<td>{$product3->id}</td>
								<td>{$product3->barcode}</td>
								<td><span class="label label-info">{$product3->categoryactor->name}</span></td>
								<td><span {if $product3->enddate < $smarty.now}style="color:red"{/if}>{$product3->name}</span></td>
								<td>{$product3->instock}</td>
								<td>{$product3->sellprice}&nbsp;{$lang.controller.labelCurrency}</td>
								<td>{$product3->datecreated|date_format:"%d/%m/%Y"}</td>
								<td>{$product3->enddate|date_format:"%d/%m/%Y"}</td>
								<td><a class="btn btn-mini btn-danger" href="javascript:void(0)" id="removeSample_{$key}" onclick="removeProduct('#rows_{$key}' , '{$key}')"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
							</tr>
						{/foreach}
						</tbody>
					</table>
				{/if}
				{$lang.default.filterLabel} <input type="text" name="fsearchproduct3" id="fsearchproduct3"/>
				<input type="button" name="fsearchButton" id="fsearchButton" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="searchProduct3()" />
				<div id="resultProduct3">

				</div>
				<div id="product3" style="display:none"><h1>Product Choose</h1><table class="table" id="chooseproduct3"><thead>
					<tr>
						<th></th>
						<th>Id</th>
						<th>Barcode</th>
						<th>Danh mục</th>
						<th>Tên sản phẩm</th>
						<th>Số lượng</th>
						<th>Giá</th>
						<th></th>
					</tr>
				</thead><tbody></tbody></table></div>
			</div><!--end of tab8-->

			{if $category->parent.0.pc_id == 482}  <!--tinh nang danh rieng cho nganh hang phu kien-->
			<div class="tab-pane {if $formData.ftab ==9}active{/if}" id="tab9">
				{if $product4List|@count > 0}
					<table class="table">
						<thead>
							<tr>
								<th>{$lang.controller.labelDisplayorder}</th>
								<th></th>
								<th>Id</th>
        						<th>Barcode</th>
								<th>{$lang.controller.labelPcid}</th>
								<th>{$lang.controller.labelName}</th>
								<th>{$lang.controller.labelInstock}</th>
								<th>{$lang.controller.labelSellprice}</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						{foreach item=product4 from=$product4List key=key}
							<tr id="rows_{$key}">
								<td><input name="fproduct4displayorder[{$key}]" value="{$product4->rppdisplayorder}" class="input-mini" /></td>
								<td>
									{if $product4->image != ''}
									<a href="{$product4->getSmallImage()}" rel="shadowbox"><img src="{$product4->getSmallImage()}" width="50px" height="50px" /></a>
									{/if}
								</td>
								<td>{$product4->id}</td>
								<td>{$product4->barcode}</td>
								<td><span class="label label-info">{$product4->categoryactor->name}</span></td>
								<td>{$product4->name}</td>
								<td>{$product4->instock}</td>
								<td>{$product4->sellprice}&nbsp;{$lang.controller.labelCurrency}</td>
								<td><a class="btn btn-mini btn-danger" href="javascript:void(0)" id="removeSample_{$key}" onclick="removeProduct('#rows_{$key}' , '{$key}')"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
							</tr>
						{/foreach}
						</tbody>
					</table>
				{/if}
				{$lang.default.filterLabel} <input type="text" name="fsearchproduct4" id="fsearchproduct4"/>
				<input type="button" name="fsearchButton" id="fsearchButton" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="searchProduct4()" />
				<div id="resultProduct4">

				</div>
				<div id="product4" style="display:none"><h1>Product Choose</h1><table class="table" id="chooseproduct4"><thead>
					<tr>
						<th></th>
						<th>Id</th>
						<th>Barcode</th>
						<th>Danh mục</th>
						<th>Tên sản phẩm</th>
						<th>Giá</th>
						<th>Số lượng</th>						
						<th></th>
					</tr>
				</thead><tbody></tbody></table></div>
			</div><!--end of tab9-->
			{/if}

            <div class="tab-pane {if $formData.ftab ==6}active{/if}" id="tab6">
                <div>
                    <h1 style="display:inline;">{$lang.controller.colorTitle}</h1>
                     <a href="{$conf.rooturl_cms}product/addProductColor/pid/{$formData.fid}" rel="shadowbox;height=400;width=1000" style="display:inline;float:right"><span class="label label-info">{$lang.controller.labelAddColor}</span></a>
                </div>
                <div style="height:30px;"></div>
				<table>
					{foreach item=productcolor from=$formData.fcolorList}
					{if $productcolor.id != $formData.fid}
					<tr id="rows{$productcolor.id}">
						<td><span class="label label-info">{$productcolor.colorname}</span></td>
						<td></td>
						<td><a href="{$conf.rooturl_cms}product/editProductColor/pid/{$productcolor.id}/value/{$productcolor.colorcode|substr:1}/pidsource/{$formData.fid}" rel="shadowbox;height=500;width=1000">{$lang.controller.labelEdit}</a>&nbsp;&nbsp;&nbsp;
                                <a href="javascript:void(0)" onclick="deleteProductColorFunction({$formData.fid},{$productcolor.id},'{$productcolor.colorcode}')">{$lang.controller.labelDelete}</a>
                        </td>
					</tr>
					{/if}
					{/foreach}
				</table>   
				<div style="height:30px;"></div>
				<div>Màu mặc định : </div>
				<table>	
					<tr>				
					{foreach item=productcolor from=$formData.fcolorList}
					<td id="fdefaultcolor{$productcolor.id}">
						<label class="radio inline">
							<input type="hidden" id="hcolor{$productcolor.id}" name="fdefaultcolor[{$productcolor.id}]" value="1" />
							<input type="radio" value="{$productcolor.default}" {if $productcolor.default == "1"}checked="checked"{/if} name="fdefaultcolormain[{$productcolor.id}]" class="fpcolor">&nbsp;{$productcolor.colorname}
						</label>					
					</td>
					{/foreach}
					</tr>
				</table>             
            </div><!--end of tab 6-->

            <div class="tab-pane {if $formData.ftab ==10}active{/if}" id="tab10">
            	<!--load ajax-->
            	<img src="{$currentTemplate}images/ajax_indicator.gif" />
            </div><!--end of tab 10 -->

            <div class="tab-pane {if $formData.ftab ==11}active{/if}" id="tab11">
            	<h3>Banner ngang</h3>
            	<div id="horizonbanner">
            		{if $horizonalbanners|@count > 0}
	            	<table class="table" id="horizon">
	            		{foreach item=horizonalbanner from=$horizonalbanners}
	            		<tr>
	            			<td><input type="hidden" name="fhbanner[]" value="{$horizonalbanner->id}"><a href="{$horizonalbanner->getImage()}"><img src="{$horizonalbanner->getSmallImage()}"></a>&nbsp;&nbsp;<a class="btn btn-mini btn-danger" href="javascript:void(0)" id="" onclick="deletebanner({$horizonalbanner->id} , 'h')"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
	            		</tr>
	            		{/foreach}
	            	</table>
	            	{else}
	            	<input type="file" name="fhorizonbanner" />
	            	{/if}
            	</div>
            	<h3>Banner dọc</h3>
            	<div id="verticalbanner">
            		{if $verticalbanners|@count > 0}
	            	<table class="table" id="vertical">
	            		{foreach item=verticalbanner from=$verticalbanners}
	            		<tr>
	            			<td><input type="hidden" name="fvbanner[]" value="{$verticalbanner->id}"><a href="{$verticalbanner->getImage()}"><img src="{$verticalbanner->getSmallImage()}"></a>&nbsp;&nbsp;<a class="btn btn-mini btn-danger" href="javascript:void(0)" id="" onclick="deletebanner({$verticalbanner->id} , 'v')"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
	            		</tr>
	            		{/foreach}
	            	</table>
	            	{else}
	            	<input type="file" name="fverticalbanner" />
	            	{/if}
            	</div>
            	<div class="control-group" id="timebanner">
			        <label class="control-label" for="">Thời gian hiển thị</label>
			        <div class="controls">Từ <input class='inputdatepicker' type="text" name="fbannerstartdate" id="fbannerstartdate" value="{$formData.fbannerstartdate|date_format:"%d/%m/%Y"}" > Đến <input class='inputdatepicker' type="text" name="fbannerendate" id="fbannerendate" value="{$formData.fbannerendate|date_format:"%d/%m/%Y"}" ></div>
			    </div>
            </div><!--end of tab 11-->
		</div>
	</div>
	<div class="form-actions" id="submitallbutton">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>
</form>

{literal}
<script type="text/javascript" language="JavaScript">
    var myclass = $('#sampletab').attr('class');
    if(typeof myclass != "undefined" )
      $('#retab').attr('class', $('#retab').attr('class') + 'active');

	var pcid = {/literal}{$formData.fpcid}{literal}
	var pid = {/literal}{$formData.fid}{literal}
	var pbarcode = {/literal}{$formData.fbarcode}{literal}
	$(document).ready(function(){
		$("form").bind("keypress", function (e) {
		    if (e.keyCode == 13) {
		        return false;
		    }

		});

		loadAttribute();
		loadPromotion();
		$('#fvid').select2();
		$('#fvsubid').select2();
		$('#fpcid').select2();
		$('.select2-choice').css('width' , '200px');
		$('#fslug').limit(50 , '#slugcounter');
		$('#fseotitle').limit(70 , '#seotitlecounter');
		$('#fseodescription').limit(160 , '#seodescriptioncounter');
		$('#ftopseokeyword').limit(255, '#ftopseokeywordcounter');
		$('#tags_keyword').tagsInput({width:'532px'});
		
		$("#checkall360gallery").live('click' , function(e){
			if($(this).is(':checked'))
			{
				$(".checkgallery360").each(function(){
					$(this).attr("checked",true);
				});
			}
			else
			{
				$(".checkgallery360").each(function(){
					$(this).attr("checked",false);
				});
			}
		});

		$('.fpcolor').on("click" , function(){
			$('.fpcolor').attr('checked', false);						
			$(this).attr('checked' , true);
		});	

		$("#fpcolor").change(function(event){
			$("#datacolor").css('background-color' , $(this).val());
		});


		$("#datacolor").css('background-color' , $("#fpcolor").val());
		
		$('#changeproductcolor').click(function(){
			$('#datacolor').toggle();
		});
		
		$('#fsubmitchangeproductcolor').live('click' , function(){
			var pidsource = $('#fidsource').val();
			var piddestination = $('#fiddestination').val();
			var colornamechange = $("#fpcolornamechange").val();
			var colorchange = $("#fpcolorchange").val();
			
			if(pidsource === '' || pidsource === undefined || colornamechange === '' || colorchange === '')
			{
				bootbox.alert('Vui lòng nhập đầy đủ thông tin của sản phẩm mà bạn muốn chuyển đến.');
			}
			else
			{
				$.ajax({
					type : "POST",
					datatype : "html",
					url : "/cms/product/changedatacolor",
					data : "pidsource=" + pidsource + "&piddestination=" + piddestination+"&colornamechange="+colornamechange+"&colorchange="+colorchange,
					success : function(html){
						if(html === '1'){
							window.location.href = '/cms/product/edit/id/'+pidsource;
						}else{
							bootbox.alert('Không thể chuyển sản phẩm hiện tại thành sản phẩm màu. Xin vui lòng thử lại.');
						}
					}
				});
			}
		});

		//xu ly KM
		$('#fsubmitpromotion').live('click', function(){
			var val = $('.promotionstatus').serializeArray();//Array();
			$.post('/cms/product/updateproductpromotionstatus', {promo: val, pid: pid}, function(data){
				if(data && data.success)
				{
					if(data.success == 1)
					{
						showGritterSuccess('Khuyến mãi đã được cập nhật.');
					}
				}
			},'json');
		});

		$('#colorpalette1').colorPalette()
          .on('selectColor', function(e) {
            $('#fpcolorstring').val(e.color);            
            //var color = $('#fpcolor').val(e.color);            
        });
        
        $('#colorpalette2').colorPalette()
          .on('selectColor', function(e) {
            $('#fpcolorchange').val(e.color);            
            //var color = $('#fpcolor').val(e.color);            
        });

        if($('#fpchoosecolor').val() === '-1')
        {
        	$("#groupcolor").show();
        }

        $("#fpchoosecolor").change(function(event) {
        	/* Act on the event */
        	if($(this).val() === '-1'){
        		$("#groupcolor").show();
        	}else{
        		$("#groupcolor").hide();
        	}
        });

        $(".btn-color").click(function(event) {
        	/* Act on the event */        	
        	event.preventDefault();
        });

       $("#fonsitestatus").change(function(){
        	var onsitestatus = $(this).val();        	
        	if(onsitestatus === '10'){
        		$("#commingsoon").show();
        	}else{
        		$("#commingsoon").hide();
        	}
        	if(onsitestatus === '2')
        	{
        		$("#osprepaid").show();
        	}
        	else
        	{
        		$("#osprepaid").hide();
        	}
        }); 

	});

    /*Shadowbox.init({
        onClose: function(){ window.location.reload(); }
    });*/

	function loadAttribute()
	{		
		$.ajax({
			type : "post",
			dataType : "html",
			url : "/cms/product/getproductattributeajax",
			data : "pcid=" + pcid+"&pid="+pid ,
			success :  function(html){
				$('#tab2').html('');
				$('#tab2').html(html);
			}
		});
	}

	function loadPromotion()
	{
		$.ajax({
			type : "post",
			dataType : "html",
			url : "/cms/product/getpromotionajax",
			data : "pid=" + pid,
			success :  function(html){
				$('#tab10').html('');
				$('#tab10').html(html);
			}
		});
	}

	function changevalueattr(attrid)
	{
		var value = $('#valuechoose'+attrid).val();
		if(value == -1)
		{
			$('#valueoption'+attrid).fadeIn();
		}
		else
		{
			$('#valueoption'+attrid).fadeOut();
		}
	}

	function changeType(id)
	{
		if($('#ftype-'+id).val() == 1)
		{
			$('#file-'+id).fadeIn(10);
			$('#url-'+id).fadeOut(10);
			$('#url-'+id).val('');
			$('#urlvalue-'+id).val('');
		}
		else
		{
			$('#url-'+id).fadeIn(10);
			$('#file-'+id).fadeOut(10);
			$('#file-'+id).html($('#file-'+id).html());
		}
	}
	function changeFunction()
	{
		if(confirm('{/literal}{$lang.controller.warningChangeCategory}{literal}'))
		{
			//load all new group attribute and attribute
			var pcid = $('#fpcid').val();
			var pid = $('#fid').val();
			var dataString = "fpcid=" +  pcid + "&fpid="+pid;
			$.ajax({
				type : "post",
				dataType : "html",
				url : '/cms/product/getAttributeAjax',
				data : dataString,
				success : function(html){
					if(html != '')
					{
						$('#tab2').html(html);
					}
					else
					{
						bootbox.alert('{/literal}{$lang.controller.errAttributeGroup}{literal}');
					}
				}
			});
		}
	}
	function deleteMedia(id)
	{
		bootbox.confirm("{/literal}{$lang.controller.deleteMediaConfirm}{literal}",function(confirm){
			if(confirm){
				var dataString = "id=" + id;
				$.ajax({
					type : 'post',
					dataType : "html",
					url : '/cms/product/deleteMediaAjax',
					data : dataString,
					success : function(html){
						if(html == 'success'){
							$('#'+id).fadeOut(10);
						}
					}
				});
			}
		});
	}
	function deleteSpecialMedia(id)
	{
		bootbox.confirm("{/literal}{$lang.controller.deleteMediaConfirm}{literal}",function(confirm){
			if(confirm){
				var dataString = "id=" + id;
				$.ajax({
					type : 'post',
					dataType : "html",
					url : '/cms/product/deleteMediaAjax',
					data : dataString,
					success : function(html){
						if(html == 'success'){
							$('#'+id).remove();

						}
					}
				});
			}
		});
	}
	function searchProductAccessories()
	{
		if($('#fsearchaccessories').val() != '')
		{
			var dataString = "pname=" + $('#fsearchaccessories').val() + "&type=accessories&pid=" + {/literal}{$formData.fid}{literal};
			$.ajax({
				type : "post",
				dataType : "html",
				url : "/cms/product/searchProductAjax",
				data : dataString,
				success : function(html){
					if(html != ''){
						$('#resultAccessories').html(html);
						if($('#accessoriesproduct').attr('display') != 'none'){
							$('#accessoriesproduct').fadeIn();
						}
					}else{
						$('#resultAccessories').html('{/literal}{$lang.controller.errNotFound}{literal}');
					}
				}
			});
		}
		else
		{
			bootbox.alert('{/literal}{$lang.controller.errNameNotEmpty}{literal}');
		}
	}

	function searchProductSample()
	{
		if($('#fsearchsample').val() != '')
		{
			var dataString = "pname=" + $('#fsearchsample').val() + "&type=sample&pid=" + {/literal}{$formData.fid}{literal};
			$.ajax({
				type : "post",
				dataType : "html",
				url : "/cms/product/searchProductAjax",
				data : dataString,
				success : function(html){
					if(html != ''){
						$('#resultSample').html(html);
						if($('#sampleproduct').attr('display') != 'none'){
							$('#sampleproduct').fadeIn();
						}
					}else{
						$('#resultSample').html('{/literal}{$lang.controller.errNotFound}{literal}');
					}
				}
			});
		}
		else
		{
			bootbox.alert('{/literal}{$lang.controller.errNameNotEmpty}{literal}');
		}
	}

	function searchProduct2()
	{
		if($('#fsearchproduct2').val() != '')
		{
			var dataString = "pname=" + $('#fsearchproduct2').val() + "&type=product2";
			$.ajax({
				type : "post",
				dataType : "html",
				url : "/cms/product/searchProductAjax",
				data : dataString,
				success : function(html){
					if(html != ''){
						$('#resultProduct2').html(html);
						if($('#product2').attr('display') != 'none'){
							$('#product2').fadeIn();
						}
					}else{
						$('#fsearchproduct2').html('{/literal}{$lang.controller.errNotFound}{literal}');
					}
				}
			});
		}
		else
		{
			bootbox.alert('{/literal}{$lang.controller.errNameNotEmpty}{literal}');
		}
	}

	function searchProduct3()
	{
		if($('#fsearchproduct3').val() != '')
		{
			var dataString = "pname=" + $('#fsearchproduct3').val() + "&type=product3";
			$.ajax({
				type : "post",
				dataType : "html",
				url : "/cms/product/searchProductAjax",
				data : dataString,
				success : function(html){
					if(html != ''){
						$('#resultProduct3').html(html);
						if($('#product3').attr('display') != 'none'){
							$('#product3').fadeIn();
						}
					}else{
						$('#resultProduct3').html('{/literal}{$lang.controller.errNotFound}{literal}');
					}
				}
			});
		}
		else
		{
			bootbox.alert('{/literal}{$lang.controller.errNameNotEmpty}{literal}');
		}
	}

	function searchProduct4()
	{
		if($('#fsearchproduct4').val() != '')
		{
			var dataString = "pname=" + $('#fsearchproduct4').val() + "&type=product4";
			$.ajax({
				type : "post",
				dataType : "html",
				url : "/cms/product/searchProductAjax",
				data : dataString,
				success : function(html){
					if(html != ''){
						$('#resultProduct4').html(html);
						if($('#product4').attr('display') != 'none'){
							$('#product4').fadeIn();
						}
					}else{
						$('#resultProduct4').html('{/literal}{$lang.controller.errNotFound}{literal}');
					}
				}
			});
		}
		else
		{
			bootbox.alert('{/literal}{$lang.controller.errNameNotEmpty}{literal}');
		}
	}

        function chooseFunction(id,type)
	{
		if(id > 0)
		{
			//kiem tra xem san pham nay da duoc chon hay chua ?
			if($('#'+type+'_'+id).length == 0)
			{
				var imgSource = $('#images_'+id).attr('src');
				var pid = $('#pid').html();
                var barcode = $('#barcode').html();
				var category = $('#categorys_'+id).html();
				var productName = $('#names_'+id).html();
				var productPrice = $('#prices_'+id).html();
				var productInstock = $('#instocks_'+id).html();
				var data = '<tr id="row'+type+'_'+id+'">';
				data += '<td>';
				if(imgSource != undefined)
				{
					data += '<a href="'+imgSource+'" rel="shadowbox"><img src="'+imgSource+'" width="100px" height="100px" /></a>';
				}
				data += '</td>';
				data += '<td>'+pid+'</td>';
				data += '<td>'+barcode+'</td>';
				data += '<td><span class="label label-info">'+category+'</span></td>';
				data += '<td><input type="hidden" name="'+type+'[]" value="'+id+'" id="'+type+'_'+id+'" />'+productName+'</td>';
				data += '<td>'+productPrice+'</td>';
				data += '<td>'+productInstock+'</td>';
				if(type =='accessories')
				{
					data += '<td><input type="button" class="btn btn-danger" id="fclear_'+id+'" onclick="clearFunction('+id+',1)" value="Remove" /></td>';
				}
				if(type == 'sample')
				{
					data += '<td><input type="button" class="btn btn-danger" id="fclear_'+id+'" onclick="clearFunction('+id+',2)" value="Remove" /></td>';
				}
				if(type == 'product2')
				{
					data += '<td><input type="button" class="btn btn-danger" id="fclear_'+id+'" onclick="clearFunction('+id+',3)" value="Remove" /></td>';
				}
				if(type == 'product3')
				{
					data += '<td><input type="button" class="btn btn-danger" id="fclear_'+id+'" onclick="clearFunction('+id+',4)" value="Remove" /></td>';
				}
				if(type == 'product4')
				{
					data += '<td><input type="button" class="btn btn-danger" id="fclear_'+id+'" onclick="clearFunction('+id+',5)" value="Remove" /></td>';
				}
				data += '</tr>';
				$('#choose'+type).find('tbody').append(data);
				$('#rows'+type+'_'+id).fadeOut();
			}
			else
			{
				bootbox.alert('{/literal}{$lang.controller.errProductChoose}{literal}');
			}
		}
	}
	function clearFunction(id, type)
	{
		if(type == 1)
		{
			$('#rowaccessories_'+id).remove();
			$('#rowsaccessories_'+id).fadeIn();
		}
		else if(type == 2)
		{
			$('#rowsample_'+id).remove();
			$('#rowssample_'+id).fadeIn();
		}
		else if(type == 3)
		{
			$('#rowproduct2_'+id).remove();
			$('#rowsproduct2_'+id).fadeIn(10);
		}
		else if(type == 4)
		{
			$('#rowproduct3_'+id).remove();
			$('#rowsproduct3_'+id).fadeIn(10);
		}

		else if(type == 5)
		{
			$('#rowproduct4_'+id).remove();
			$('#rowsproduct4_'+id).fadeIn(10);
		}
	}

	function removeProduct(selector, id)
	{
		bootbox.confirm("{/literal}{$lang.controller.deleteProductConfirm}{literal}",function(confirm){
			if(confirm)
			{
				if(id > 0)
				{
					var dataString = 'id=' + id;
					$.ajax({
						type : "post",
						dataType : "html",
						url : "/cms/product/deleteRelProductAjax",
						data : dataString,
						success : function(html){
							if(html == 'success'){
								$(selector).fadeOut();
							}else{
								bootbox.alert('Can not delete this product !');
							}
						}
					});
				}
			}
		});

	}

    function deleteProductColorFunction(pidsource, piddestination, colorCode)
    {
        if(pidsource > 0 && piddestination > 0)
        {
            bootbox.confirm("{/literal}{$lang.controller.deleteMediaConfirm}{literal}",function(confirm){
			if(confirm)
			{
				var dataString = 'pidsource=' + pidsource + '&piddestination='+piddestination + '&colorcode=' + colorCode;
				$.ajax({
				    type : "post",
					dataType : "html",
					url : "/cms/product/deleteProductColorAjax",
					data : dataString,
					success : function(html){
						if(html == 'success'){
							$('#rows'+piddestination).remove();
							$('#fdefaultcolor' + piddestination).remove();							
						}else{
								bootbox.alert("{/literal}{$lang.controller.deleteError}{literal}");
						}
					}
				});
			}
		    });
        }
    }

    function addRow(tbname)
	{
		rowCount = $('#'+ tbname +' tr').length;
		rowCount +=1 ;
		//alert(rowCount);
		if(tbname == 't360')
		{
			data = '<tr id="image360_'+rowCount+'"><td style="width:155px;"><input type="hidden" name="ftypeimage360['+rowCount+']" value="5"/></td><td><input type="file" name="ffile360['+rowCount+']" style="width:200px;" /></td><td><span id="caption360-'+rowCount+'"><input type="text" name="fcaption360['+rowCount+']" value="" placeholder="Caption..." /></td><td><span id="alt360-'+rowCount+'"><input type="text" name="falt360['+rowCount+']" value="" placeholder="Alt..." /></td><td><span id="titleseo360-'+rowCount+'"><input type="text" name="ftitlesep360['+rowCount+']" value="" placeholder="Title..." /></td><td></td></tr>'
		}
		else
		{
			data = '<tr><td>YouTube URL</td><td><span id="url-'+rowCount+'" ><input type="text" id="urlvalue-'+rowCount+'" name="furl['+rowCount+']" placeholder="URL..."></span></td><td><span id="caption-'+rowCount+'"><input type="text" name="fcaption['+rowCount+']" value="" placeholder="Caption..." /></span></td><td><span id="alt-'+rowCount+'"><input type="text" name="falt['+rowCount+']" value="" placeholder="Alt..." /></span></td><td><span id="titleseo-'+rowCount+'"><input type="text" name="ftitleseo['+rowCount+']" value="" placeholder="Title..." /></span></td><td></td></tr>';
		}
		$('#'+tbname).append(data);
	}

	function viewShadowbox(url , name, type)
	{
		if(url.length > 0)
		{
			Shadowbox.open({
                    content:    url,
                    title : 	'Chi tiết '+type+' của sản phẩm ' + name,
                    player:     "iframe",
                });
		}
	}

    function updatepromotionforproduct(barcode)
    {
        if(barcode.length > 0)
        {
            var path = rooturl + controllerGroup + "/product/updatepromotionajax";
            path += '/barcode/' + barcode;
            $("#buttonupdatepromotion").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
            $("#buttonupdatepromotion").hide();
            $.post(path,{}, function(data){
                if(data && data.success==1)
                {
                    showGritterSuccess('Khuyến mãi đã được cập nhật.');
                }
                else
                    showGritterError('Khuyến mãi đã có hoặc lỗi trong quá trình đồng bộ.');
                $("img.tmp_indicator").remove();
                $("#buttonupdatepromotion").show();
            }, 'json');
        }
        else
            showGritterError('Không có barcode để đồng bộ');
    }

    function changecategory(pcid , pid)
    {
    		url = rooturl_cms + 'product/changecategory/pcid/'+pcid+'/pid/'+pid;
    		Shadowbox.open({
                    content:    url,
                    //title : 	'Chi tiết '+type+' của sản phẩm ' + name,
                    player:     "iframe",
                    height:     480,
                    width:      1400
         });
    }

    function changeonistestatus()
    {
    	var onsitestatus = $('#fonsitestatus').val();

    	if(onsitestatus == 2)
    	{
    		$('#sellprice').hide();
    		$('#importtime').hide();
            $('#viewsellprice').hide();
    		$('#prepaidprice').show();
    		$('#timeprepaid').show();
    	}
    	else if(onsitestatus == 10)
    	{
    		//$('#importtime').show();
    		$("#commingsoon").show();
    	}
    	else
    	{
    		$('#prepaidprice').hide();
    		$("#commingsoon").hide();
    		$('#timeprepaid').hide();
    		$('#importtime').hide();
    		$('#sellprice').show();
            $('#viewsellprice').show();
    	}
    }

    function changeTab(tab)
    {

        $('#ftab').val(tab);
        if(tab == 10 ) $('#submitallbutton').css('display', 'none');
        else  $('#submitallbutton').css('display', 'block');
        $('#retab').attr('class','tab-pane');
        $('#acctab').attr('class','tab-pane');
    }

    function activeRec()
    {
        $('#retab').attr('class', $('#retab').attr('class') + 'active');
    }

    function activeAcc()
    {
        $('#acctab').attr('class', $('#acctab').attr('class') + 'active');
    }

    function deletebanner(id,type)
    {
    	if(id > 0)
    	{
    		bootbox.confirm("Bạn có muốn xóa banner này ?",function(confirm){
    			if(confirm)
    			{
    				$.ajax({
		    			type : "post",
		    			dataType : "html",
		    			url : rooturl_cms + 'ads/deletebannerajax',
		    			data : 'id='+id,
		    			success : function(html){
		    				if(html == 1){
		    					if(type == 'h'){
		    						$('#horizon').remove();
		    						$('#horizonbanner').append('<input type="file" name="fhorizonbanner" />');
		    					} else if(type == 'v'){
		    						$('#vertical').remove();
		    						$('#verticalbanner').append('<input type="file" name="fverticalbanner" />');
		    					}
		    				} else {
		    					bootbox.alert('Không thể xóa banner này.');
		    				}
		    			}
		    		});
    			}
    		});
    	}
    }

    function clearcacheproduct() {
    	var productpath = "{/literal}{$formData.fproductlink}{literal}"
    	if(productpath !== '') {
    		$.ajax({
	    		url: productpath,
	    		type: 'get',
	    		dataType: 'html',
	    		data: {"live": 1},
	    		success : function(html) {
	    			if(html !== '') {
	    				showGritterSuccess('Clear cache sản phẩm thành công.');
	    			} else {
	    				showGritterError('Có lỗi trong quá trình xóa cache . Xin vui lòng thử lại.');
	    			}
	    		}
	    	}); 
    	}   	
    	
    }
</script>
{/literal}

