{strip}
<div class="navbarprod">
    <ul>
        <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ</a> ››</li>
        {if !empty($myVendors->name) || !empty($attributeList['DELETEDURL'])}
        	<li><a href="{$curCategory->getProductcateoryPath()}" title="{if !empty($curCategory->seotitle)}{$curCategory->seotitle|escape}{else}{$curCategory->name|escape}{/if}">{$curCategory->name} </a> ››</li>
        {else}
        <li>{$curCategory->name}</li>
        {/if}
        
        {if !empty($myVendors->name)}
        	{if !empty($attributeList['DELETEDURL'])}
        		<li><a href="{$pageCanonical}" title="{$myVendors->name|escape}" id="vendor" rel="{$myVendors->id}">{$myVendors->name}</a> ››</li>
        	{else}
        	<li>{$myVendors->name}</li>
        	{/if}
        {/if}
         <li> 
        	{if !empty($attributeList['DELETEDURL'])}
        		{foreach from=$attributeList['DELETEDURL'] item=delurl name=namedelurl}
        			{$delurl.name}
        			{if $smarty.foreach.namedelurl.last}{else},{/if}
        		{/foreach}
        	{/if}
        </li>
    </ul>
    <div class="socialbar">
  	<div class="likepage">
    	<label>Bạn thích trang này?</label>
        <span><iframe src="https://www.facebook.com/plugins/like.php?href={$curCategory->getProductcateoryPath()}&width=120&height=21&colorscheme=light&layout=button_count&action=like&show_faces=true&send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px; float:left" allowTransparency="true"></iframe></span>
    </div>
    <div class="sharepage">
    	<label>Chia sẻ</label>
        <span><a href="https://www.facebook.com/sharer/sharer.php?u={$curCategory->getProductcateoryPath()}"><i class="icon-face"></i></a></span>
        <span><a href="https://plus.google.com/share?url={$curCategory->getProductcateoryPath()}"><i class="icon-goog"></i></a></span>
        <span><a href="http://twitthis.com/twit?url={$curCategory->getProductcateoryPath()}"><i class="icon-twitter"></i></a></span>
    </div>
  </div>
</div>

<div id="container">
    {if $bannerProduct|@count > 0}

        <div class="bn_depart" >
            <div id="bannerProduct">
                <ul class="bjqs">
                {foreach item=bnProduct from=$bannerProduct}
                    <li><a href="{$bnProduct->link}" title="{$bnProduct->title|escape}">
                        <img src="{$bnProduct->getImage()}" alt="{$bnProduct->title|escape}" title="{$bnProduct->title|escape}">
                    </a>
                    </li>
                {/foreach}
                </ul>
            </div>
        </div>
    {/if}

	<div class="colleft">
		<div class="colleftbrand">
    		<h3 class="titlenav">{$curCategory->name}</h3>
	        <ul style="max-height: none;">        		
        		{foreach from=$listChildCat item=fcat name=topsubcat}
        		{if {$fcat->name} == {$curCategory->name}}{continue}{/if}
        			<li><a href="{$fcat->getProductcateoryPath()}" title="{$fcat->name|escape}">{$fcat->name}</a></li>
        	            
	            {/foreach}
	            {$curCategory->categoryreference}
	        </ul>
	    </div>
{if count($arrVendorselect) > 0  || !empty($smarty.get.a)}
	<div class="colleftbrand"> <h3>Bộ lọc hiện tại</h3>
		
		    <ul>
		    {foreach from =$arrVendorselect item=vendorselect name=vendor}
	        	{foreach from =$listvendors[0] item=ven name=vendorlistshow}
	        		{if $listvendors[1][$smarty.foreach.vendorlistshow.iteration-1] == $vendorselect}
	                <li><a class="subli" title="{$ven}" href="javascript:;">{$ven}</a>
			      	  <div class="clearfilter"><a title="Xóa" href="{$listvendors[2][$smarty.foreach.vendorlistshow.iteration-1]}">&#215;</a></div>
			      </li>
			      {/if}
	            {/foreach}
            {/foreach}
		      {if !empty($attributeList['LEFT'])}
        			{foreach item=attribute from=$attributeList['LEFT'] name=topattributeout}
            			{if $attribute->value|@count > 0}
            				{if !empty($attribute->value[0])}
		                        {foreach item=attrvalue from=$attribute->value[0] name=attributelistname}                            
		                            {if !empty($attrvalue)}
			                            {if in_array($attribute->value[1][$smarty.foreach.attributelistname.iteration-1],explode(',',$smarty.get.a)) !== false}
				                            
				                             <li><a class="subli" title="{$attrvalue|trim}" href="javascript:;">{$attrvalue|trim}</a>
										      	  <div class="clearfilter"><a title="Xóa" href="{if strpos($smarty.get.a,$attribute->value[1][$smarty.foreach.attributelistname.iteration-1]) === false}{if !empty($myVendors->name) && !empty($pageCanonical)}{$pageCanonical|trim}{else}{$curCategory->getProductcateoryPath()}{/if}{if $smarty.get.vendor != ''}?vendor={$smarty.get.vendor|trim}&{else}?{/if}a={$attribute->panameseo|trim},{$attribute->value[1][$smarty.foreach.attributelistname.iteration-1]|trim}{if !empty($attribute->value[2][$smarty.foreach.attributelistname.iteration-1])},{$attribute->value[2][$smarty.foreach.attributelistname.iteration-1]|trim}{/if}{else}{$attribute->value[3][$smarty.foreach.attributelistname.iteration-1]|trim}{/if}">&#215;</a></div>
										     </li>
			                            {/if}
		                            {/if}
		                        {/foreach}
		                    {/if}
		         
		                {/if}
		            {/foreach}
	    		{/if}
		    </ul>
	</div>
{/if}
<div class="colleftbrand"> <h3>Nhà sản xuất</h3>
  	<div class="searchbrand">
    	<input class="inputbrand" name="" id="autosearchtextbrand" type="text" placeholder="Tìm theo thương hiệu ..." />
        <input class="btnseabrand" type="button" value="Tìm" />
    </div>
    <ul class="textbrand">
    {foreach from =$listvendors[0] item=ven name=vendorlistshow}
      <li> <a class="subli checkbox-sort {if in_array($listvendors[1][$smarty.foreach.vendorlistshow.iteration-1],explode(',',$smarty.get.vendor)) !== false || ($smarty.get.fvid != "" && $smarty.get.fvid == $listvendors[3][$smarty.foreach.vendorlistshow.iteration-1]) || ($singlevendorname != "" && $singlevendorname == $listvendors[1][$smarty.foreach.vendorlistshow.iteration-1])}active{else}{/if}" title="{$ven}" href="{$listvendors[2][$smarty.foreach.vendorlistshow.iteration-1]}">{$ven}</a></li>
    {/foreach}
    </ul>
  </div>

	    {if !empty($attributeList['LEFT'])}
        			{foreach item=attribute from=$attributeList['LEFT'] name=topattributeout}
        			{if $smarty.foreach.topattributeout.iteration ==1}
            			{if $attribute->value|@count > 0}
            		<div class="colleftbrand">
            			<h3>Lọc theo giá</h3>
		       				<ul>
            				{if !empty($attribute->value[0])}
		                        {foreach item=attrvalue from=$attribute->value[0] name=attributelistname}                            
		                            {if !empty($attrvalue)}
		                            <li class="{if $smarty.foreach.attributelistname.iteration >10}hidden filter{$smarty.foreach.topattributeout.iteration}{/if}">
		                            	<a class="subli checkbox-sort {if in_array($attribute->value[1][$smarty.foreach.attributelistname.iteration-1],explode(',',$smarty.get.a)) !== false}active{else}{/if}" href="{if strpos($smarty.get.a,$attribute->value[1][$smarty.foreach.attributelistname.iteration-1]) === false}{if !empty($myVendors->name) && !empty($paginateurl)}{$paginateurl|trim}{else}{$curCategory->getProductcateoryPath()}{/if}{if $smarty.get.vendor != ''}?vendor={$smarty.get.vendor|trim}&{else}?{/if}a={$attribute->panameseo|trim},{$attribute->value[1][$smarty.foreach.attributelistname.iteration-1]|trim}{if !empty($attribute->value[2][$smarty.foreach.attributelistname.iteration-1])},{$attribute->value[2][$smarty.foreach.attributelistname.iteration-1]|trim}{/if}{else}{$attribute->value[3][$smarty.foreach.attributelistname.iteration-1]|trim}{/if}" title="{$attrvalue|trim}">{$attrvalue|trim}</a>
		                            </li>
		                            {/if}
		                            {if $smarty.foreach.attributelistname.iteration >10 && $smarty.foreach.attributelistname.last}
		                            	<li><a class="subli filterseemore" href="javascript:void(0)" rel="{$smarty.foreach.topattributeout.iteration}">Xem thêm</a></li>
		                            {/if}
		                        {/foreach}
		                    {/if}
		                   </ul>
		               	<div class="searchprice">
					    	<span>Hoặc</span>
						        <input class="inputprice" id="pricefrom" value="{$smarty.get.pricefrom|substr:0:-3}" name="pricefrom" type="text" placeholder="Từ" /><label>.000</label>
						        <input class="inputprice" id="priceto" value="{$smarty.get.priceto|substr:0:-3}" name="priceto" type="text" placeholder="Đến" /><label>.000</label>
						        <div class="clear"></div>
						        <input onclick="detectprice('{$curCategory->getProductcateoryPath()}');" class="btnseaprice" id="btnfilter" name="btnfilter" type="button" value="Tìm" />
						        <p id="pricenotify"></p>
					    </div>
	   				 </div>
		                {/if}
		             {/if}
		            {/foreach}
	    {/if}
 
<!--<div class="wrapnavcate">
    <span>{$curCategory->name}</span>
    <ul id="navcate">
    
    {foreach from=$listChildCat item=fcat name=topsubcat}
    {if $smarty.foreach.topsubcat.iteration == 1}{continue}{/if}
      <li><a title="{$fcat->name|escape}" href="{$fcat->getProductcateoryPath()}" class="sub" tabindex="1">{$fcat->name|escape}</a><img style="top:0" src="images/up.gif" alt="" />
       {if !empty($listvendors)}
        <ul class="marleftnavcate">
        {if !empty($listvendors[$fcat->id])}
        	{foreach from=$listvendors[$fcat->id] item=myven name=vendorlistshow}
        		{if !empty($myven->name) && $myven->name !='-'}
          		<li><a title="{*$fcat->name*}{$myven->name}" href="{$myven->getVendorPath($fcat->id)}">{*$fcat->name*}{$myven->name}</a></li>
          		{/if}
          	{/foreach}
        {/if}
         
        </ul>
        {/if}
      </li>
     {/foreach}
      
    </ul>
  </div>
	    -->
	</div>
	

<!-- Box html trắng -->
{if !empty($curCategory->blockcategory)}
<div id="wrapdepart"> {$curCategory->blockcategory}</div>
{/if}
<!-- slide khuyến mãi -->
{if !empty($listtopprouct)} 
<div id="wrapdepart">
	<div class="bartopsale"><h2 class="titlehot">Top {count($listtopprouct)} sản phẩm bán chạy nhất</h2></div>
    <div class="m-carousel m-fluid m-carousel-photos m-top-product"> 
  <!-- the slider -->
      <div class="m-carousel-inner "> 
        <!-- the items -->
        <div class="m-item m-active">
         {foreach from=$listtopprouct item=topproduct name=listtopproduct}
         {assign var="promotionprices" value=$topproduct->promotionPrice()}
        	<div class="tagcentertext">
             {if $topproduct->onsitestatus == $OsERPPrepaid}<div class="tagtopsale"><i class="icon-preorder"></i></div>
              {elseif $topproduct->onsitestatus == $OsCommingSoon}<div class="tagtopsale"><i class="icon-hsapve"></i></div>
              {elseif $topproduct->onsitestatus == $OsHot}<div class="tagtopsale"><i class="icon-hot"></i></div>
              {elseif $topproduct->onsitestatus == $OsNew}<div class="tagtopsale"><i class="icon-new"></i></div>
              {elseif $topproduct->onsitestatus == $OsBestSeller}<div class="tagtopsale"><i class="icon-bestsale"></i></div>
              {elseif $topproduct->onsitestatus == $OsCrazySale}<div class="tagtopsale"><i class="icon-crazydeal"></i></div>
              {elseif $topproduct->onsitestatus == $OsDoanGia}<div class="tagtopsale"><i class="icon-betting"></i></div>
              {elseif $topproduct->onsitestatus == $OsNoSell || $topproduct->instock == 0}<div class="tagtopsale"><i class="icon-theend"></i></div>
              {/if}    
 			<!--<div class="bghover"></div>-->
               <a href="{$topproduct->getProductPath()}" title="{$topproduct->name}">{$topproduct->name}</a>
               <a href="{$topproduct->getProductPath()}" title="{$topproduct->name}"><img src="{$topproduct->getSmallImage()}" alt="{$topproduct->name}" title="{$topproduct->name}" /> </a> 
              
	           <div class="loadprice lp{$topproduct->id}{$topproduct->barcode|trim|substr:-5}" rel="{$topproduct->id}{$topproduct->barcode|trim|substr:-5}">
	           {if $topproduct->displaysellprice!=1 && $topproduct->sellprice>0 && $topproduct->onsitestatus == $OsERP && !empty($promotionprices.price) && $promotionprices.price<$topproduct->sellprice}
	           <strong class="pricenew">{if $promotionprices.price > 1000}{$promotionprices.price|number_format}{else}{$lang.default.promotionspecial}{/if} đ</strong>
	   		   <div class="th_center">{if $topproduct->sellprice > 1000}{$topproduct->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
	   		   {elseif $topproduct->onsitestatus == $OsERPPrepaid && $topproduct->prepaidstartdate <= $currentTime && $topproduct->prepaidenddate >= $currentTime}
	           <strong class="pricenew">{if $topproduct->prepaidprice > 1000}{$topproduct->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</strong>
	           {elseif $topproduct->sellprice >0}
	           <strong class="pricenew">{if $topproduct->sellprice > 1000}{$topproduct->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</strong>
	           {/if}
	           </div>
               
               
               <div class="descenter">
                  {foreach item=summary from=$topproduct->summarynew name=summarynew}
                   <span>›› {$summary}</span>
                  {/foreach}
                </div>  
                 {if !empty($promotionprices.promodescription) && $promotionprices.promodescription|strip_tags|trim != '.' && $promotionprices.promodescription|strip_tags|trim != '-'}
		      		<div class="giftcenter"><i class="icon-gift"></i>{$promotionprices.promodescription}</div>
			      {/if}   
			   
              </div>
              {if $smarty.foreach.listtopproduct.iteration % 2 == 0}
                	{if $smarty.foreach.listtopproduct.iteration < count($listtopprouct)}
               			</div><div class="m-item">
               		{/if}
            {/if} 
           {/foreach}
              
        </div>

      </div>
      <!-- the controls -->
      {if count($listtopprouct)> 2}
      <div class="m-carousel-controls m-carousel-pagination">
        <div class="prev"><a href="#" data-slide="prev">«</a></div>
        <div class="next"><a href="#" data-slide="next">»</a></div>
      </div>
      {/if}
    </div>
</div>
{/if}
<!-- filter center -->
<div id="rowview">
	<div class="viewpromo"><a class="checkpromotion checkbox-sort {if $promotion == 'khuyen-mai'}active{/if}" title="Xem sản phẩm {$curCategory->name} đang khuyến  mãi" href="
	{if $promotion != 'khuyen-mai'}
	{$curCategory->getProductcateoryPath()}{$myVendors->slug}
		{if $myVendors->arrslug}
			?vendor={$myVendors->arrslug}
			{if $attributeList['VALUE']}
				&a={$attributeList['VALUE']}
			{/if}
			&f=khuyen-mai
		{else}
			{if $attributeList['VALUE']}
				?a={$attributeList['VALUE']}&f=khuyen-mai
			{else}
				?f=khuyen-mai
			{/if}
			
		{/if}
		{if !empty($smarty.get.pricefrom) || !empty($smarty.get.priceto)}
			&pricefrom={$smarty.get.pricefrom}&priceto={$smarty.get.priceto}
		{/if}
{else}
	{$curCategory->getProductcateoryPath()}
	{if $myVendors->arrslug}
		?vendor={$myVendors->arrslug}
		{if $attributeList['VALUE']}
			&a={$attributeList['VALUE']}
		{/if}
		{if !empty($smarty.get.pricefrom) || !empty($smarty.get.priceto)}
			&pricefrom={$smarty.get.pricefrom}&priceto={$smarty.get.priceto}
		{/if}
	{else}
		{if $attributeList['VALUE']}
			?a={$attributeList['VALUE']}
			{if !empty($smarty.get.pricefrom) || !empty($smarty.get.priceto)}
				&pricefrom={$smarty.get.pricefrom}&priceto={$smarty.get.priceto}
			{/if}
		{else}
			{if !empty($smarty.get.pricefrom) || !empty($smarty.get.priceto)}
				?pricefrom={$smarty.get.pricefrom}&priceto={$smarty.get.priceto}
			{/if}
		{/if}
	{/if}
	
{/if}">Xem sản phẩm {$curCategory->name} đang khuyến  mãi</a></div>
    <div class="sortprice">
    	<label>Sắp xếp sản phẩm theo</label>
        <select class="listmenu" onchange="window.location.href = this.value;">
        	<option value="{$curCategory->getProductcateoryPath()}">Mặc định</option>
            <option value="{$curCategory->getProductcateoryPath()}{if !empty($urlsort)}{$urlsort}&o=gia-cao-den-thap{else}?o=gia-cao-den-thap{/if}" {if $order == 'gia-cao-den-thap'} selected="selected" {/if}>Giá từ cao đến thấp</option>
			<option value="{$curCategory->getProductcateoryPath()}{if !empty($urlsort)}{$urlsort}&o=gia-thap-den-cao{else}?o=gia-thap-den-cao{/if}" {if $order == 'gia-thap-den-cao'} selected="selected" {/if}>Giá từ thấp đến cao</option>
			<option value="{$curCategory->getProductcateoryPath()}{if !empty($urlsort)}{$urlsort}&o=moi-nhat{else}?o=moi-nhat{/if}" {if $order == 'moi-nhat'} selected="selected" {/if}>Mới nhất</option>
			<option value="{$curCategory->getProductcateoryPath()}{if !empty($urlsort)}{$urlsort}&o=duoc-quan-tam-nhat{else}?o=duoc-quan-tam-nhat{/if}" {if $order == 'duoc-quan-tam-nhat'} selected="selected" {/if}>Được quan tâm nhất</option>
         </select>
    </div>
</div>
<!-- danh sách sản phẩm ngành hàng -->
<div id="wrapdepart">
	<div class="products">
	{if $productlists|@count>0}    
      <ul>
        {foreach from=$productlists item=product name=ProductsByCategory}
			{assign var="promotionprices" value=$product->promotionPrice()}
      	<li>
            {if $listProductColor[$product->id]|count > 1}           
                <div class="lg">
                    <ul>
                        {foreach from=$listProductColor[$product->id] item=toplistcolor name=toplistcolorname}
                         {if $toplistcolor[0] >0}
                            {if $smarty.foreach.toplistcolorname.index > 4}{break}{/if}
                            <li><a class="qtootip" href="{if $toplistcolor[4] == 1}{$product->getProductPath()}{else}{$product->getProductPath()}?color={$toplistcolor[0]}{/if}" title="{$toplistcolor[2]}" style="background:#{$toplistcolor[3]}"></a></li>
                            {/if}
                        {/foreach}
                    </ul>
                </div>                         
            {/if}  
            {if $product->onsitestatus == $OsERPPrepaid}<div class="special"><i class="icon-preorder"></i></div>
            {elseif $product->onsitestatus == $OsCommingSoon}<div class="special"><i class="icon-hsapve"></i></div>
            {elseif $product->onsitestatus == $OsHot}<div class="special"><i class="icon-hot"></i></div>
            {elseif $product->onsitestatus == $OsNew}<div class="special"><i class="icon-new"></i></div>
            {elseif $product->onsitestatus == $OsBestSeller}<div class="special"><i class="icon-bestsale"></i></div>
            {elseif $product->onsitestatus == $OsCrazySale}<div class="special"><i class="icon-crazydeal"></i></div>
            {elseif $product->onsitestatus == $OsDoanGia}<div class="special"><i class="icon-betting"></i></div>
            {elseif $product->onsitestatus == $OsNoSell || $product->instock == 0}<div class="special"><i class="icon-theend"></i></div>
            {/if}     
          <a href="{$product->getProductPath()}" title="{$product->name}"><img src="{$product->getSmallImage()}" alt="{$product->name|escape}" title="{$product->name}" /> </a> <a class="position-a" href="{$product->getProductPath()}"><h3>{$product->name}</h3>
          </a>
          <div class="{if $product->onsitestatus != $OsCommingSoon}loadprice{/if} lp{$product->id}{$product->barcode|trim|substr:-5}" rel="{$product->id}{$product->barcode|trim|substr:-5}">
           {if $product->displaysellprice!=1 && $product->sellprice>0 && $product->onsitestatus == $OsERP && !empty($promotionprices.price) && $promotionprices.price<$product->sellprice}
           	<div class="priceold price1">{if $product->sellprice > 1000}{$product->sellprice|number_format} đ{/if}</div>
           <div class="pricenew price2">{if $promotionprices.price > 1000}{$promotionprices.price|number_format} đ{/if}</div>
           <span class="salepercent">-{(($product->sellprice - $promotionprices.price)/$product->sellprice * 100)|floor}%</span>
   		   {elseif $product->onsitestatus == $OsERPPrepaid && $product->prepaidstartdate <= $currentTime && $product->prepaidenddate >= $currentTime}
            <div class="pricenew price2">{if $product->prepaidprice > 1000}{$product->prepaidprice|number_format} đ{/if}</div>
           {elseif $product->onsitestatus == $OsCommingSoon}  
			<div class="pricenew price2">{if $product->comingsoonprice > 1000}{$product->comingsoonprice|number_format} đ{/if} </div>
           {elseif $product->sellprice >0}
           <div class="pricenew price2">{if $product->sellprice > 1000}{$product->sellprice|number_format} đ{/if} </div>
           {/if} 
           </div>
        </li>
        {/foreach}
      </ul>
      
     
    </div>
    
    {assign var="pageurl" value="page-::PAGE::"}
   				{paginateul count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl`/`$pageurl`"}
   				{if $totalproductpage > 0}
  			 		<div class="seecontinue">Mời bạn xem tiếp ( còn {$totalproductpage} sản phẩm )</div>
  			 	{/if}
  			 	
  			 	 {else}
      <span>Không tìm thấy sản phẩm theo tiêu chí.</span>
      {/if}
    
</div>
<!-- pagnation -->

</div>
{if !empty($curCategory->titlecol1) || !empty($curCategory->titlecol2) || !empty($curCategory->titlecol3)}
<!--trai nghiem, cam nang -->
<div id="experiencehandbook">
	<div class="experience" {if $newslist|@count <= 0}style="width:100%"{/if}>
    	<div class="titleexper">Trải nghiệm mua sắm online cùng dienmay.com</div>
        <!-- SEO text -->
        <div class="ac-container">
          <div>
            <input type="radio" checked="" name="accordion-1" id="ac-1">
            <label for="ac-1">{if !empty($curCategory->titlecol1)}{$curCategory->titlecol1}{/if}</label>
            <article class="ac-small">
              <p>{if !empty($curCategory->desccol1)}{$curCategory->desccol1}{/if}</p>
            </article>
          </div>
          <div>
            <input type="radio" name="accordion-1" id="ac-2">
            <label for="ac-2">{if !empty($curCategory->titlecol2)}{$curCategory->titlecol2}{/if}</label>
            <article class="ac-small">
              <p>{if !empty($curCategory->desccol2)}{$curCategory->desccol2}{/if}</p>
            </article>
          </div>
          <div>
            <input type="radio" name="accordion-1" id="ac-3">
            <label for="ac-3">{if !empty($curCategory->titlecol3)}{$curCategory->titlecol3}{/if}</label>
            <article class="ac-small">
              <p>{if !empty($curCategory->desccol3)}{$curCategory->desccol3}{/if}</p>
            </article>
          </div>
          
        </div>
    </div>
{/if}
    {if $newslist|@count > 0}
	<div class="handbook">
    	<div class="titlehandbook">Cẩm nang dienmay.com dành cho {$curCategory->name|lower}</div>
        <div class="latesthome-list">
            <ul>
                {foreach item=news from=$newslist} 
                <li>
                    <a title="{$news->title}" href="{$news->getNewsPath()}"><img alt="{$news->slug}" src="{$news->getSmallImage()}"></a>
                    <a title="{$news->title}" href="{$news->getNewsPath()}">{$news->title}</a><br>
                    <span>Ngày đăng: {$news->datecreated|date_format:"%d/%m/%Y %H:%M:%S"}</span>
                </li>
                {/foreach}
            <li><a title="Cẩm nang dienmay.com dành cho {$curCategory->name|lower}" href="{$myNewscategory->getNewscategoryPath()}" class="seeall">Xem thêm cẩm nang cho {$curCategory->name|lower}  ››</a></li>
            </ul>
        </div>
    </div>
    {/if}
</div>
{/strip}
{literal}
<script type="text/javascript">
var fpcid = "{/literal}{$curCategory->id}{literal}";
$(document).ready(function(){
//    initEditCategoryInline(fpcid);
});
</script>
{/literal}
