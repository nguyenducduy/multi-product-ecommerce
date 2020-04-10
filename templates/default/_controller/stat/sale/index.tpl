<div id="chartsale_filter">
	<div id="filterlist">
		<div class="filterhead">
			<div>
				<span class="filtergrouphead">DOANH THU</span>
				<div class="filtergroup">
					<span id="filter_originateregionbtn"><a href="javascript:void(0)" onclick="filter_by('originateregion', 'Xem theo từng tỉnh/thành phố..')" class="btn btn-mini"><i class="icon-plus"></i> Tỉnh/Thành phố</a></span><br />
					<span id="filter_originatestorebtn"><a href="javascript:void(0)" onclick="filter_by('originatestore', 'Xem theo từng Kho tạo..')" class="btn btn-mini"><i class="icon-plus"></i> Kho tạo</a></span><br />
					<span id="filter_outputstorebtn"><a href="javascript:void(0)" onclick="filter_by('outputstore', 'Xem theo từng Kho xuất..')" class="btn btn-mini"><i class="icon-plus"></i> Kho xuất</a></span><br />
					<span id="filter_vendorbtn"><a href="javascript:void(0)" onclick="filter_by('vendor', 'Xem theo từng Nhà cung cấp..')" class="btn btn-mini tipsy-trigger" title="Không lọc chung với Sản phẩm cụ thể"><i class="icon-plus"></i> Nhà cung cấp</a></span><br />
					<span id="filter_categorybtn"><a href="javascript:void(0)" onclick="filter_by('category', 'Xem theo từng Ngành hàng..')" class="btn btn-mini tipsy-trigger" title="Không lọc chung với Sản phẩm cụ thể"><i class="icon-plus"></i> Ngành hàng</a></span><br />
				</div>
				<div class="filtergroup">
					<span id="filter_ordertypebtn"><a href="javascript:void(0)" onclick="filter_by('ordertype', 'Xem theo từng Hình thức xuất..')" class="btn btn-mini"><i class="icon-plus"></i> Hình thức xuất</a></span><br />
					<span id="filter_pidbtn"><a href="javascript:void(0)" onclick="filter_by('pid', 'Xem theo một Sản phẩm cụ thể..')" class="btn btn-mini tipsy-trigger" title="Không lọc chung với Nhà sản xuất và Danh mục"><i class="icon-plus"></i> Sản phẩm cụ thể</a></span>
				</div>
				<div class="cl">&nbsp;</div>
			</div>
			
		</div>
		
		<div id="filterlistselected"></div>
		
		<div class="filterbutton">
			
			
			<a href="javascript:void(0)" onclick="chartsale_refresh()" class="btn btn-primary"><i class="icon-refresh"></i> Refresh Chart</a>
			<span class="filteroutputtip_wrapper">Dự đoán kết quả sẽ xuất ra: <span id="filteroutputtip"></span></span>
		</div>
	</div>
</div>



<!-- ORIGINATEREGION -->
<div id="filteroption_originateregionwrapper" class="hide">
	<div class="filteroption" id="filteroption_originateregion">
		<ul class="">
			<li class="filterall"><a href="javascript:void(0)"><label><input type="radio" value="-1" onchange="filterpopup_select('originateregion', 'all')" title="Xem theo từng Tỉnh/Thành phố" /> Xem theo tất cả Tỉnh/Thành phố ({$regionList|@count})</label></a></li>
			{foreach item=region key=regionid from=$regionList}
				<li><label><input type="checkbox" name="foriginateregionoption" value="{$regionid}" onchange="filterpopup_select('originateregion', '')" title="{$region}" /> {$region}</label></li>
			{/foreach}
		</ul>
	</div><!-- end #filteroption_originateregion -->
</div>


<!-- ORIGINATE STORE -->
<div id="filteroption_originatestorewrapper" class="hide">
	<div class="filteroption" id="filteroption_originatestore">
		<ul class="">
			<li class="filterall"><a href="javascript:void(0)"><label><input type="radio" value="-1" onchange="filterpopup_select('originatestore', 'all')" title="Xem theo từng Kho tạo" /> Xem theo tất cả Kho tạo ({$storeList|@count})</label></a></li>
			{foreach item=store from=$storeList}
				<li><span>{$store->getRegionName()}</span><label><input type="checkbox" name="foriginatestoreoption" value="{$store->id}" onchange="filterpopup_select('originatestore', '')" title="{$store->name}" /> {$store->name}</label></li>
			{/foreach}
		</ul>
	</div><!-- end #filteroption_originatestore -->
</div>


<!-- OUTPUT STORE -->
<div id="filteroption_outputstorewrapper" class="hide">
	<div class="filteroption" id="filteroption_outputstore">
		<ul class="">
			<li class="filterall"><a href="javascript:void(0)"><label><input type="radio" value="-1" onchange="filterpopup_select('outputstore', 'all')" title="Xem theo từng Kho xuất" /> Xem theo tất cả Kho xuất ({$storeList|@count})</label></a></li>
			{foreach item=store from=$storeList}
				<li><span>{$store->getRegionName()}</span><label><input type="checkbox" name="foutputstoreoption" value="{$store->id}" onchange="filterpopup_select('outputstore', '')" title="{$store->name}" /> {$store->name}</label></li>
			{/foreach}
		</ul>
	</div><!-- end #filteroption_outputstore -->
</div>


<!-- ORDER TYPE -->
<div id="filteroption_ordertypewrapper" class="hide">
	<div class="filteroption" id="filteroption_ordertype">
		<ul class="">
			<li class="filterall"><a href="javascript:void(0)"><label><input type="radio" value="-1" onchange="filterpopup_select('ordertype', 'all')" title="Xem theo từng Hình thức xuất" /> Xem theo tất cả Hình thức xuất ({$ordertypeList|@count})</label></a></li>
			{foreach item=ordertype from=$ordertypeList}
				<li><label><input type="checkbox" name="fordertypeoption" value="{$ordertype->ordertypeid}" onchange="filterpopup_select('ordertype', '')" title="{$ordertype->name}" /> {$ordertype->name}</label></li>
			{/foreach}
		</ul>
	</div><!-- end #filteroption_ordertype -->
</div>



<!-- VENDOR -->
<div id="filteroption_vendorwrapper" class="hide">
	<div class="filteroption" id="filteroption_vendor">
		<ul class="">
			<li class="filterall"><a href="javascript:void(0)"><label><input type="radio" value="-1" onchange="filterpopup_select('vendor', 'all')" title="Xem theo từng Nhà cung cấp" /> Xem theo tất cả Nhà cung cấp ({$vendorList|@count})</label></a></li>
			{foreach item=vendor from=$vendorList}
				<li><label><input type="checkbox" name="fvendoroption" value="{$vendor->id}" onchange="filterpopup_select('vendor', '')" title="{$vendor->name}" /> {$vendor->name}</label></li>
			{/foreach}
		</ul>
	</div><!-- end #filteroption_vendor -->
</div>

<!-- CATEGORY -->
<div id="filteroption_categorywrapper" class="hide">
	<div class="filteroption" id="filteroption_category">
		<ul class="">
			<li class="filterall"><a href="javascript:void(0)"><label><input type="radio" value="-1" onchange="filterpopup_select('category', 'all')" title="Xem theo từng Ngành hàng" /> Xem theo tất cả Ngành hàng ({$categoryList|@count})</label></a></li>
			{assign var=parentcategoryid value=0}
			{foreach item=category from=$categoryList}
				{if $parentcategoryid != $category->parentid}
					<li class="categoryseperator"></li>
					{assign var=parentcategoryid value=$category->parentid}
				{/if}
				<li><span>{$category->parentcategory->name}</span><label><input type="checkbox" name="fcategoryoption" value="{$category->id}" onchange="filterpopup_select('category', '')" title="{$category->name}" /> {$category->name}</label></li>
			{/foreach}
		</ul>
	</div><!-- end #filteroption_vendor -->
</div>

<!-- PID -->
<div id="filteroption_pidwrapper" class="hide">
	<div class="filteroption" id="filteroption_pid">
		<form class="form-inline">
			<input type="text" id="filteroption_pid_keyword" placeholder="Nhập Mã hoặc Tên sản phẩm..." class="input-xlarge" />
			<input type="button" class="btn btn-primary" onclick="filterpopup_pid_search()" value="Search" />
		</form>
		<div id="filteroption_pidlist"></div>
	</div><!-- end #filteroption_pid -->
</div>