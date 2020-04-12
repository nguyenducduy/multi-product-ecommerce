{strip}
<div class="navbarprod">
    <ul>
        <li><a href="{$conf.rooturl}">Trang chủ</a> ››</li>
        <li><a href="{$curCategory->getProductcateoryPath()}" title="{if !empty($curCategory->seotitle)}{$curCategory->seotitle|escape}{else}{$curCategory->name|escape}{/if}">{$curCategory->name} </a> ››</li>        
        {if !empty($myVendor)}
        	<li><a href="{$registry.conf.rooturl}{$slugcategory}?vendor={$smarty.get.vendor}" title="{$myVendor->name|escape}">{$myVendor->name} </a> ››</li>
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
                        <li><a href="{$bnProduct->link}">
                                <img src="{$bnProduct->getImage()}" alt="{$bnProduct->title|escape}" title="{$bnProduct->title|escape}">
                            </a>
                        </li>
                    {/foreach}
                </ul>
            </div>
        </div>
    {/if}
	{$producttop}
	<!-- Box html trắng -->
<!--<div id="wrapdepart"> Box html trắng, chổ để Lê Bảo Trung và ngành hàng múa lửa</div>-->
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
{else}
	{$curCategory->getProductcateoryPath()}{$myVendors->slug}
	{if $myVendors->arrslug}
		?vendor={$myVendors->arrslug}
		{if $attributeList['VALUE']}
			&a={$attributeList['VALUE']}
		{/if}
	{else}
		{if $attributeList['VALUE']}
			?a={$attributeList['VALUE']}
		{/if}
	{/if}
{/if}">Xem sản phẩm {$curCategory->name} đang khuyến  mãi</a></div>
    <div class="sortprice">
    	<label>Sắp xếp sản phẩm theo</label>
         <select class="listmenu" onchange="window.location.href = this.value;">
        	<option value="{$curCategory->getProductcateoryPath()}{$myVendors->slug}{if $myVendors->arrslug}?vendor={$myVendors->arrslug}{if $attributeList['VALUE']}&a={$attributeList['VALUE']}{/if}&o=gia-cao-den-thap{elseif $attributeList['VALUE']}?a={$attributeList['VALUE']}&o=gia-cao-den-thap{else}?o=gia-cao-den-thap{/if}" {if $order == 'gia-cao-den-thap'} selected="selected" {/if}>Giá từ cao đến thấp</option>
              <option value="{$curCategory->getProductcateoryPath()}{$myVendors->slug}{if $myVendors->arrslug}?vendor={$myVendors->arrslug}{if $attributeList['VALUE']}&a={$attributeList['VALUE']}{/if}&o=gia-thap-den-cao{elseif $attributeList['VALUE']}?a={$attributeList['VALUE']}&o=gia-thap-den-cao{else}?o=gia-thap-den-cao{/if}" {if $order == 'gia-thap-den-cao'} selected="selected" {/if}>Giá từ thấp đến cao</option>
              <option value="{$curCategory->getProductcateoryPath()}{$myVendors->slug}{if $myVendors->arrslug}?vendor={$myVendors->arrslug}{if $attributeList['VALUE']}&a={$attributeList['VALUE']}{/if}&o=moi-nhat{elseif $attributeList['VALUE']}?a={$attributeList['VALUE']}&o=moi-nhat{else}?o=moi-nhat{/if}" {if $order == 'moi-nhat'} selected="selected" {/if}>Mới nhất</option>
              <option value="{$curCategory->getProductcateoryPath()}{$myVendors->slug}{if $myVendors->arrslug}?vendor={$myVendors->arrslug}{if $attributeList['VALUE']}&a={$attributeList['VALUE']}{/if}&o=ban-chay-nhat{elseif $attributeList['VALUE']}?a={$attributeList['VALUE']}&o=ban-chay-nhat{else}?o=ban-chay-nhat{/if}" {if $order == 'ban-chay-nhat'} selected="selected" {/if}>Bán chạy nhất</option>
              <option value="{$curCategory->getProductcateoryPath()}{$myVendors->slug}{if $myVendors->arrslug}?vendor={$myVendors->arrslug}{if $attributeList['VALUE']}&a={$attributeList['VALUE']}{/if}&o=duoc-quan-tam-nhat{elseif $attributeList['VALUE']}?a={$attributeList['VALUE']}&o=duoc-quan-tam-nhat{else}?o=duoc-quan-tam-nhat{/if}" {if $order == 'duoc-quan-tam-nhat'} selected="selected" {/if}>Được quan tâm nhất</option>
        </select>
    </div>
</div>
    <div id="wrapdepart">
{if !empty($listproductcat)}
			<div class="products">
				
			      <ul>
			       {foreach from=$listproductcat item=product name=ProductsByCategory}
            			{assign var="promotionprices" value=$product->promotionPrice()}
							
			      	<li>
                {if $listNewProColor[$product->id]|count > 1}           
                    <div class="lg">
                        <ul>
                            {foreach from=$listNewProColor[$product->id] item=productListColor name=productListColorName}
                             {if $productListColor[0] > 0}
                                {if $smarty.foreach.productListColorName.index > 4}{break}{/if}
                                <li><a class="qtootip" href="{if $productListColor[4] == 1}{$product->getProductPath()}{else}{$product->getProductPath()}?color={$productListColor[0]}{/if}" title="{$productListColor[2]}" style="background:#{$productListColor[3]}"></a></li>
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
			          <a href="{$product->getProductPath()}" title="{$product->name}"><img src="{$product->getSmallImage()}" alt="{$product->name}" title="{$product->name}" /> </a> <a class="position-a" href="{$product->getProductPath()}"><h3>{$product->name}</h3>
			          </a>
			          <div class="{if $product->onsitestatus != $OsCommingSoon}loadprice{/if} lp{$product->id}{$product->barcode|trim|substr:-5}" rel="{$product->id}{$product->barcode|trim|substr:-5}">
			           {if $product->displaysellprice!=1 && $product->sellprice>0 && $product->onsitestatus == $OsERP && !empty($promotionprices.price) && $promotionprices.price<$product->sellprice}
			           	<div class="priceold price1">{if $product->sellprice > 1000}{$product->sellprice|number_format} đ{/if}</div>
                       	<div class="pricenew price2">{if $promotionprices.price > 1000}{$promotionprices.price|number_format} đ{/if}</div>
                       	<span class="salepercent">-{(($product->sellprice - $promotionprices.price)/$product->sellprice * 100)|floor}%</span>
			   		   {elseif $product->onsitestatus == $OsERPPrepaid && $product->prepaidstartdate <= $currentTime && $product->prepaidenddate >= $currentTime}
                         <div class="pricenew price2">{if $product->prepaidprice > 1000}{$product->prepaidprice|number_format} đ{/if}</div>
                       {elseif $product->onsitestatus == $OsCommingSoon}  
					   	 <div class="pricenew price2">{if $product->comingsoonprice > 1000}{$product->comingsoonprice|number_format} đ{/if}</div>
                       {elseif $product->sellprice >0}
                         <div class="pricenew price2">{if $product->sellprice > 1000}{$product->sellprice|number_format} đ{/if}</div>
                       {/if} 
                       </div>
			        </li>
			        {/foreach}
			      </ul>
			      
			    </div>
			    
			    {assign var="pageurl" value="page-::PAGE::"}
   	{paginateul count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl`/`$pageurl`"}
	{else}
      <span>Không tìm thấy sản phẩm theo tiêu chí.</span>
	{/if}
	</div>
</div>

{if !empty($curBrand->titlecol1) || !empty($curBrand->titlecol2) || !empty($curBrand->titlecol3)}
<!--trai nghiem, cam nang -->
<div id="experiencehandbook">
	<div class="experience" style="width:100%">
    	<div class="titleexper">Trải nghiệm mua sắm online cùng dienmay.com</div>
        <!-- SEO text -->
        <div class="ac-container">
          <div>
            <input type="radio" checked="" name="accordion-1" id="ac-1">
            <label for="ac-1">{if !empty($curBrand->titlecol1)}{$curBrand->titlecol1}{else}{$curCategory->titlecol1}{/if}</label>
            <article class="ac-small">
              <p>{if !empty($curBrand->desccol1)}{$curBrand->desccol1}{else}{$curCategory->desccol1}{/if}</p>
            </article>
          </div>
          <div>
            <input type="radio" name="accordion-1" id="ac-2">
            <label for="ac-2">{if !empty($curBrand->titlecol2)}{$curBrand->titlecol2}{else}{$curCategory->titlecol2}{/if}</label>
            <article class="ac-small">
              <p>{if !empty($curBrand->desccol2)}{$curBrand->desccol2}{else}{$curCategory->desccol2}{/if}</p>
            </article>
          </div>
          <div>
            <input type="radio" name="accordion-1" id="ac-3">
            <label for="ac-3">{if !empty($curBrand->titlecol3)}{$curBrand->titlecol3}{else}{$curCategory->titlecol3}{/if}</label>
            <article class="ac-small">
              <p>{if !empty($curBrand->desccol3)}{$curBrand->desccol3}{else}{$curCategory->desccol3}{/if}</p>
            </article>
          </div>
          
        </div>
    </div>
    {/if}

{/strip}
{literal}
<script type="text/javascript">
var fpcid = "{/literal}{$curCategory->id}{literal}";
$(document).ready(function(){
    //initEditCategoryInline(fpcid);
});
</script>
{/literal}