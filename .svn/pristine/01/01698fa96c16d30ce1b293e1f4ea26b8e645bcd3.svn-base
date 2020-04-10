<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Sản phẩm</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_product"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="ftoken" value="{$smarty.session.productAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.productInfo}</a></li>
			<li><a href="#tab2" data-toggle="tab">{$lang.controller.attributeInfo}</a></li>
			<li><a href="#tab3" data-toggle="tab">{$lang.controller.mediaInfo}</a></li>
			<li><a href="#tab4" data-toggle="tab">{$lang.controller.accessories}</a></li>
			<li><a href="#tab5" data-toggle="tab">{$lang.controller.sample}</a></li>
			<li><a href="#tab6" data-toggle="tab">{$lang.controller.product2}</a></li>
			<li><a href="#tab7" data-toggle="tab">{$lang.controller.product3}</a></li>
			{if $category->parent.0.pc_id == 482}<li><a href="#tab8" data-toggle="tab">Sản phẩm bán kèm</a></li>{/if}
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab1">
				<div class="control-group">
					<label class="control-label" for="fvid">{$lang.controller.labelVid}</label>
					<div class="controls" style="width:200xp;">
						<select name="fvid" id="fvid">
						<option value="0">----</option>
						{foreach item=vendor from=$vendorList}
							<option value="{$vendor->id}" {if $vendor->id == $formData.fvid}selected="selected"{/if}>{$vendor->name}</option>
						{/foreach}
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fvsubid">{$lang.controller.labelVsubid}</label>
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
						<b>{$category->name}</b>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fbarcode">{$lang.controller.labelBarcode}</label>
					<div class="controls"><input type="text" name="fbarcode" id="fbarcode" value="{$formData.fbarcode|@htmlspecialchars}" class="input-xxlarge"></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
					<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xxlarge"></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fslug">{$lang.controller.labelSlug}</label>
					<div class="controls"><input type="text" name="fslug" id="fslug" value="{$formData.fslug|@htmlspecialchars}" class="input-xxlarge" />
						{if $slugList|@count > 0}
							<div class="">Found item for slug "{$formData.fslug}":</div>
							{foreach item=slug from=$slugList}
								<div class="red">&raquo; {$slug->controller} / {$slug->objectid} <a href="{$slug->getSlugSearch()}" title="Go to this slug" class="tipsy-trigger"><i class="icon-share"></i></a></div>
							{/foreach}
						{/if}
						Còn lại <span id="slugcounter">50</span> ký tự
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
							<input type="tet" class="input-large" name="fpcolorname" id="fpcolorname" value="{$formData.fpcolorname}" placeholder="Tên màu..." /><br/>							
						  	<select name="fpcolor" id="fpcolor">
						  		{foreach item=productcolor from=$productcolors}
						  		<option {if $productcolor->code==$formData.fpcolor}selected{/if} value="{$productcolor->code}">{$productcolor->name}</option>
						  		{/foreach}
						  	</select>
						  	<div id="datacolor" style="width:25px;height:20px;border:1px solid #000"></div>			  	
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
							{if $smarty.foreach.foo.index < 6}
							<input id="fsummarynew_{$smarty.foreach.foo.index}" name="fsummarynew[{$smarty.foreach.foo.index}]" value="{$summarydata}" class="input-xxlarge" /><br/><br/>
							{/if}
							{/foreach}
							{if $formData.fsummarynew|@count < 5}
							{assign var=enough value=5 - $formData.fsummarynew|@count}
							{section name=foo1 start=0 loop=$enough step=1}
							<input id="fsummarynew_{$smarty.foreach.foo.index}" name="fsummarynew[{$smarty.foreach.foo1.index + $formData.fsummarynew|@count}]" value="{$summarydata}" class="input-xxlarge" /><br/><br/>							
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

				<!-- <div class="control-group">
					<label class="control-label" for="fbarcode">{$lang.controller.labellaigop}</label>
					<div class="controls"><input type="text" name="flaigop" id="flaigop" value="{$formData.flaigop|@htmlspecialchars}" class="input-xlarge"></div>
				</div> -->

				<div class="control-group">
					<label class="control-label" for="fseotitle">{$lang.controller.labelSeotitle}</label>
					<div class="controls"><input type="text" name="fseotitle" id="fseotitle" value="{$formData.fseotitle}" class="input-xxlarge"/>Còn lại <span id="seotitlecounter">70</span> ký tự</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fseokeyword">{$lang.controller.labelSeokeyword}</label>
					<div class="controls"><textarea name="fseokeyword" id="fseokeyword" rows="7" class="mceNoEditor input-xxlarge">{$formData.fseokeyword}</textarea></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fseodescription">{$lang.controller.labelSeodescription}</label>
					<div class="controls"><textarea name="fseodescription" id="fseodescription" rows="7" class="mceNoEditor input-xxlarge">{$formData.fseodescription}</textarea>Còn lại <span id="seodescriptioncounter">160</span> ký tự</div>
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
			        <div class="controls"><textarea name="ftopseokeyword" id="ftopseokeyword" rows="7" class="mceNoEditor input-xxlarge">{$formData.ftopseokeyword}</textarea>Còn lại <span id="ftopseokeywordcounter">255</span> ký tự</div>
			    </div>

			    <div class="control-group">
			        <label class="control-label" for="ftextfooter">Text footer</label>
			        <div class="controls"><textarea name="ftextfooter" id="ftextfooter" rows="7" class="input-xxlarge">{$formData.ftextfooter}</textarea></div>
			    </div>

				<!--<div class="control-group">
					<label class="control-label" for="fisbagdehot">{$lang.controller.labelIsbagdehot}</label>
					<div class="controls"><input type="checkbox" name="fisbagdehot" id="fisbagdehot" {if isset($formData.fisbagdehot)}checked="checked"{/if}></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fisbagdenew">{$lang.controller.labelIsbagdenew}</label>
					<div class="controls"><input type="checkbox" name="fisbagdenew" id="fisbagdenew" {if isset($formData.fisbagdenew)}checked="checked"{/if}></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fisbagdegift">{$lang.controller.labelIsbagdegift}</label>
					<div class="controls"><input type="checkbox" name="fisbagdegift" id="fisbagdegift" {if isset($formData.fisbagdegift)}checked="checked"{/if}></div>
				</div>-->

				<div class="control-group">
					<label class="control-label" for="fdisplaysellprice"> Hiển thị giá niêm yết</label>
					<div class="controls"><input type="checkbox" name="fdisplaysellprice" id="fdisplaysellprice" {if isset($formData.fdisplaysellprice)}checked="checked"{/if}></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fwarranty">Bảo hành</label>
					<div class="controls"><input type="text" name="fwarranty" id="fwarranty" class="input-mini" value="{$formData.fwarranty}">&nbsp;Tháng</div>
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
					<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
					<div class="controls">
						<select name="fstatus">
							{html_options options=$statusList selected=$formData.fstatus}
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fstatus">{$lang.controller.labelOnsiteStatus}</label>
					<div class="controls">
						<select name="fonsitestatus" id="fonsitestatus">
							{html_options options=$onsitestatusList selected=$formData.fonsitestatus}
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fbusinessstatus">Trạng thái kinh doanh</label>
					<div class="controls">
						<select name="fbusinessstatus">
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
					<div class="control-group" id="prepaidprice">
	                    <label class="control-label" for="fprepaidprice">Giá đặt hàng trước</label>
	                    <div class="controls"><input type="text" name="fprepaidprice" id="fprepaidprice" value="{$formData.fprepaidprice|@htmlspecialchars}" class="input-medium">&nbsp;{$lang.controller.labelCurrency}</div>
	                </div>
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
				        <label class="control-label" for="">Giá Yêu cầu đặt cọc</label>
				        <div class="controls">
				        	<input type="text" value="{$formData.fprepaiddepositrequire|number_format}" name="fprepaiddepositrequire" class="input input-xlarge" id="fprepaiddepositrequire" />
				        </div>
				    </div>
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

			</div><!-- end of tab1 -->
			<div class="tab-pane" id="tab2">
				<table class="table">
					{foreach item=attributes key=groupattr from=$productAttributeList}
						{assign var="checker" value="true"}
						{if $attributes|@count > 0}
						{foreach item=attr from=$attributes}
						<tr>
							{if $checker == "true"}
							<td><b>{$groupattr}</b></td>
							{assign var="checker" value="false"}
							{else}
							<td></td>
							{/if}
							<td>{$attr->name}</td>
							{assign var=attrid value=$attr->id}
							<td>{if $attr->values|@count > 0}
								<select id="valuechoose{$attr->id}" name="fattr[{$attr->id}]" onchange="changevalueattr({$attr->id})" class="valuechoose">
									<option selected="" value="-1">Giá trị khác</option>
									{foreach item=valuedata from=$attr->values}
									<option {if $formData.fattr.$attrid == $valuedata}selected="selected"{/if} value="{$valuedata}">{$valuedata}</option>
									{/foreach}
								</select>
								{/if}<input id="valueoption{$attr->id}" type="text" name="fattropt[{$attr->id}]" placeholder="Hoặc nhập giá trị khác" value="{$formData.fattropt.$attrid}">&nbsp;&nbsp;{$attr->unit}</td>
							<td><input type="text" name="fweight[{$attr->id}]" placeholder="Trọng số" class="input-mini" value="{$formData.fweight.$attrid}"/></td>
							<td><input type="text" name="fattrdescription[{$attr->id}]" placeholder="Mô tả" class="input-medium" value="{$formData.fattrdescription.$attrid}"/></td>
							<td style="width:250px;"></td>
						<tr/>
						{/foreach}
						{else}
						<tr>
							<td><b>{$groupattr}</b></td>
							<td></td>
							<td></td>
							<td style="width:250px;"></td>
						<tr/>
						{/if}
					{/foreach}
				</table>
			</div><!-- end of tab2 -->
			<div class="tab-pane" id="tab3">
				<h1>Hình đại diện</h1>
				{$lang.controller.iamgeLabel}&nbsp;:&nbsp;<input type="file" name="fimage" /><br/>


				<br/><br/>
				<h1>Gallery</h1>
				<table class="table" id="gallery">
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
					<tr id="image360_1">
						<td style="width:101px;">Upload hình 360 : </td>
						<td><input type="file" name="ffile360[]" multiple/></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
                </table>
				<h1>Thông số kỹ thuật</h1>
				<table>
					<tr>
						<td><input type="file" name="ftypespecialimg[0]" style="width:200px;" /></td>
						<td width="15px;"></td>
						<td><input type="text" name="ftypespecialcaption" value="" placeholder="Caption..." /></td>
						<td><input type="text" name="ftypespecialalt" value="" placeholder="Alt..." /></td>
						<td><input type="text" name="ftypespecialtitle" value="" placeholder="Titlte..." /></td>
						<td></td>
					</tr>
				</table>
			</div><!-- end of tab3 -->
			<div class="tab-pane" id="tab4"><!--end of tab4-->
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
			</div><!--end of tab4-->
			<div class="tab-pane" id="tab5"><!--end of tab5-->
				{$lang.default.filterLabel} <input type="text" name="fsearchsample" id="fsearchsample"/>
				<input type="button" name="fsearchButton" id="fsearchButton" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="searchProductSample()" />
				<div id="resultSample">

				</div>
				<div id="sampleproduct" style="display:none"><h1>Product Choose</h1><table class="table" id="choosesample"><thead>
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
			</div><!--end of tab5-->
			<div class="tab-pane" id="tab6">
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
			</div><!--end of tab6-->
			<div class="tab-pane" id="tab7">
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
			</div><!--end of tab7-->
			{if $category->parent.0.pc_id == 482}
			<div class="tab-pane" id="tab8">
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
						<th>Số lượng</th>
						<th>Giá</th>
						<th></th>
					</tr>
				</thead><tbody></tbody></table></div>
			</div><!--end of tab8-->
			{/if}
		</div>
	</div>
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>
</form>
{literal}
<script type="text/javascript" language="JavaScript">
	$(document).ready(function(){
		$("form").bind("keypress", function (e) {
		    if (e.keyCode == 13) {
		        return false;
		    }
		});
		$('#fvid').select2();
		$('#fvsubid').select2();
		$('.valuechoose').select2();
		$('.select2-choice').css('width' , '200px');
		$('#fslug').limit(50 , '#slugcounter');
		$('#fseotitle').limit(70 , '#seotitlecounter');
		$('#fseodescription').limit(160 , '#seodescriptioncounter');
		$('#ftopseokeyword').limit(255, '#ftopseokeywordcounter');
		$('#tags_keyword').tagsInput({width:'532px'});		

		$("#fpcolor").change(function(event){
			$("#datacolor").css('background-color' , $(this).val());
		});


		$("#datacolor").css('background-color' , $("#fpcolor").val());

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
			$('#urlvalue-'+id).val('');
		}
		else
		{
			$('#url-'+id).fadeIn(10);
			$('#file-'+id).fadeOut(10);
			$('#file-'+id).html($('#file-'+id).html());
		}
	}


	function searchProductAccessories()
	{
		if($('#fsearchaccessories').val() != '')
		{
			var dataString = "pname=" + $('#fsearchaccessories').val() + "&type=accessories";
			$.ajax({
				type : "post",
				dataType : "html",
				url : "/cms/product/searchProductAjax",
				data : dataString,
				success : function(html){
					if(html != ''){
						$('#resultAccessories').html(html);
						if($('#accessoriesproduct').attr('display') != 'none'){
							$('#accessoriesproduct').fadeIn(10);
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
			var dataString = "pname=" + $('#fsearchsample').val() + "&type=sample";
			$.ajax({
				type : "post",
				dataType : "html",
				url : "/cms/product/searchProductAjax",
				data : dataString,
				success : function(html){
					if(html != ''){
						$('#resultSample').html(html);
						if($('#sampleproduct').attr('display') != 'none'){
							$('#sampleproduct').fadeIn(10);
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
				var productInstock = $("#instocks_"+id).html();
				var productPrice = $('#prices_'+id).html();
				var data = '<tr id="row'+type+'_'+id+'">';
				data += '<td>';
				if(imgSource != undefined)
				{
					data += '<a href="'+imgSource+'" rel="shadowbox" ><img src="'+imgSource+'" width="100px" height="100px" /></a>';
				}
				data += '</td>';
				data += '<td>'+pid+'</td>';
				data += '<td>'+barcode+'</td>';
				data += '<td><span class="label label-info">'+category+'</span></td>';
				data += '<td><input type="hidden" name="'+type+'[]" value="'+id+'" id="'+type+'_'+id+'" />'+productName+'</td>';
				data += '<td>'+productInstock+'</td>';
				data += '<td>'+productPrice+'</td>';
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
				$('#rows'+type+'_'+id).fadeOut(10);
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
			$('#rowsaccessories_'+id).fadeIn(10);
		}
		else if(type == 2)
		{
			$('#rowsample_'+id).remove();
			$('#rowssample_'+id).fadeIn(10);
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
	$('#fsttime').timepicker({defaultTime:false,showMeridian:false,showSeconds:true});
     $('#fextime').timepicker({defaultTime:false,showMeridian:false,showSeconds:true});
</script>
{/literal}

