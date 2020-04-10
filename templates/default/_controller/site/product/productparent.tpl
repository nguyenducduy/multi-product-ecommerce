<div class="navbarprod">
    <ul>
        <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ</a> ››</li>
        <li><a href="{$curCategory->getProductcateoryPath()}" title="{$curCategory->name}">{$curCategory->name}</a>{if !empty($myVendors->name)} ››{/if}</li>
        {if !empty($myVendors->name)}
        <li><a href="{$pageCanonical}" title="{$myVendors->name}" id="vendor" rel="{$myVendors->id}">{$myVendors->name}</a></li>
        {/if}
        <li class="lastitem">Tư vấn mua hàng <span>1900 1883</span> hoặc <span>(08) 39.48.6789</span></li>
    </ul>
</div>
{*if !empty($banner)}
<div id="banner">
  {$banner}
  <div class="bn_btom">
    {if $textbanner|@count > 0}
    <ul>
        {foreach from = $textbanner item = txtbanner}
            <li><a href="{$txtbanner->getAdsPath()}" title="{$txtbanner->title}">{$txtbanner->name}<span>{$txtbanner->title}</span></a></li>
        {/foreach}
    </ul>
    {/if}
  </div>
</div>
{/if*}
<div id="container">

	<div class="colleft">
		<div class="colleftbrand">
    		<span>Sản phẩm {$curCategory->name}</span>
	        <ul>        		
        		{foreach from=$listChildCat item=fcat name=topsubcat}
        		{if $smarty.foreach.topsubcat.iteration == 1}{continue}{/if}
        			<li><a href="{$fcat->getProductcateoryPath()}" title="{$fcat->name}">›› Tất cả {$fcat->name}</a></li>
        		{if !empty($listvendors)}
        			{if !empty($curCategory->vendorlist)}
        				{foreach from =$listvendors item = ven}
		                    <li><a href="{$ven->getVendorPath($curCategory->id)}" title="{$ven->name}">›› {*$fcat->name*} {$ven->name}</a></li>
		                {/foreach}
        			{elseif !empty($listvendors[$fcat->id])}
        				{foreach from=$listvendors[$fcat->id] item=myven}
        					{if !empty($myven->name) && $myven->name !='-'}
        					<li><a class="subli" href="{$myven->getVendorPath($fcat->id)}" title="{$myven->name}">›› {*$fcat->name*}{$myven->name}</a></li>
        					{/if}
        				{/foreach}
        			{/if}
        		{/if}	            
	            {/foreach}
	        </ul>
	    </div>
	    <div class="colleftseo">
    		{if !empty($curCategory->titlecol1)}<span>{$curCategory->titlecol1}</span>{/if}
        	{if !empty($curCategory->desccol1)}{$curCategory->desccol1}{/if}
        	
        	{if !empty($curCategory->titlecol2)}<span>{$curCategory->titlecol2}</span>{/if}
        	{if !empty($curCategory->desccol2)}{$curCategory->desccol2}{/if}
        	
        	{if !empty($curCategory->titlecol3)}<span>{$curCategory->titlecol3}</span>{/if}
        	{if !empty($curCategory->desccol3)}{$curCategory->desccol3}{/if}
	    </div>
	</div>

<<<<<<< .mine
	<div class="listproduct">
	    {if $productlists|@count>0}
	    {foreach from=$productlists item=productcat key=catid name=listproducts}
	    	{if !empty($productcat.product)}	    	
	    	<div id="wrapdepart">
				<div class="barparent">
					<h2 class="titlebarparent"><a href="{$productcat.cat->getProductcateoryPath()}" title="{$productcat.cat->name}">{$productcat.cat->name}</a></h2>
				</div>
				<div class="products">
				  <ul>
				  	{foreach from=$productcat.product item=product name=ProductsByCategory}
				  		{assign var="promotionprices" value=$product->promotionPrice()}
				  		{if !empty($product->productspecial)}
				  			<li class="tagcentertext">
						      {if $product->isbagdehot == 1 || $product->isbagdenew == 1 || $product->isbagdegift == 1}
								<div class="special">
									{if $product->isbagdehot == 1}
										<i class="icon-hot"></i>
									{elseif $product->isbagdenew == 1}
										<i class="icon-new"></i>
									{elseif $product->isbagdegift == 1}
										<i class="icon-gift"></i>
									{/if}				
								</div>
							  {/if}
							  <a class="textafloat" href="{$product->getProductPath()}" title="{$product->name}">{$product->name}</a>
						      <a href="{$product->getProductPath()}" title="{$product->name}"><img src="{$product->productspecial->getImage()}" alt="{$product->name}" /></a>
						      	{if $product->displaysellprice!=1 && !empty($promotionprices.price) && $promotionprices.price<$product->sellprice}
					                <strong>{$promotionprices.price|number_format} đ</strong>
					            {else}
					                <strong>{$product->sellprice|number_format} đ</strong>
					            {/if}
						      <div class="descenter">
						      	{$product->summary}
						      </div>
						      {if !empty($promotionprices.promodescription)}
						      	<div class="giftcenter"><i class="icon-gift"></i>{$promotionprices.promodescription}</div>
						      {/if}
						      <!-- <div class="buynownew"></div>
						      <a  href="{$conf.rooturl}cart/checkout/?id={$product->id}{if !empty($promotionprices.promoid)}&prid={$product->barcode|trim}_{$promotionprices.promoid}{/if}" class="textbuynow">Mua</a> -->
						    </li>
				  		{else}
				  			<li> 
				  			 {if $product->isbagdehot == 1 || $product->isbagdenew == 1 || $product->isbagdegift == 1}
								<div class="special">
									{if $product->isbagdehot == 1}
										<i class="icon-hot"></i>
									{elseif $product->isbagdenew == 1}
										<i class="icon-new"></i>
									{elseif $product->isbagdegift == 1}
										<i class="icon-gift"></i>
									{/if}									
								</div>
							  {/if}
				  			  <a href="{$product->getProductPath()}" title="{$product->name}"><img src="{$product->getSmallImage()}" alt="{$product->name}" /> </a>
			                  <a class="position-a" href="{$product->getProductPath()}">{$product->name} </a>
						      {if $product->displaysellprice!=1 && !empty($promotionprices.price) && $promotionprices.price<$product->sellprice}
				                	<div class="priceold">{$product->sellprice|number_format} đ</div>
			                    	<div class="pricenew">{$promotionprices.price|number_format} đ</div>
				                {else}
				                	<div class="pricenew">{$product->sellprice|number_format} đ</div>
				                {/if}
						      <!-- <div class="buynownew"></div>
						      <a  href="{$conf.rooturl}cart/checkout/?id={$product->id}{if !empty($promotionprices.promoid)}&prid={$product->barcode|trim}_{$promotionprices.promoid}{/if}" class="textbuynow">Mua</a> -->
						    </li>
				  		{/if}
				  	{/foreach}
				  </ul>
				</div>
			</div>
			{/if}
		{/foreach}
	    {/if}
	</div>
=======
            <ul class="panel3">
                {foreach from =$listvendors item = ven}
                    <li><a href="{$ven->getVendorPath($curCategory->id)}" title="{$ven->name}">›› {$ven->name}</a></li>
                {/foreach}
            </ul>

   </div>
   {/if}
   {if !empty($attributeList['LEFT'])}
   <div class="navproduct" style="display: none;">
        <a class="collapse" href="#" rel="nofollow">Tiêu chí<span class="arrow-fil3"></span></a>
        <ul class="panel">
        {foreach item=attribute from=$attributeList['LEFT']}
            {if $attribute->value|@count > 0}

                <li class="filter"><span>›› {$attribute->display}</span>
                    {if !empty($attribute->value)}
                    <ul class="panel">
                        {foreach item=attrvalue from=$attribute->value}
                            {if !empty($attrvalue)}
                            <li class="filter"><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/search/?fattribute[{$attribute->paid}]={$attrvalue}&pcid={$curCategory->id}" title="{$attrvalue}">›› {$attrvalue}</a></li>
                            {/if}
                        {/foreach}
                    </ul>
                    {/if}
                </li>
            {/if}
        {/foreach}
        </ul>
   </div>
   {/if}
  <div class="latest">
    {if !empty($listnews.promotion)}
    <div class="title">TIN KHUYẾN MÃI</div>

    <div class="cont">
       {if !empty($listnews.promotion[0])}
      <div class="rownews"><a href="{$listnews.promotion[0]->getNewsPath()}" title="{$listnews.promotion[0]->title}"><img src="{$listnews.promotion[0]->getImage()}" width="195" alt="{$listnews.promotion[0]->title}" /></a>
        <div class="bgtitle"><a href="{$listnews.promotion[0]->getNewsPath()}" title="{$listnews.promotion[0]->title}"> <span>{$listnews.promotion[0]->title} </span></a> </div>
      </div>
      {/if}{if !empty($listnews.promotion[1])}
      <div class="rownews">
        <div class="col-1"><a href="{$listnews.promotion[1]->getNewsPath()}" title="{$listnews.promotion[1]->title}"><img src="{$listnews.promotion[1]->getImage()}" alt="{$listnews.promotion[1]->title}" width="195" height="120" /></a>
          <div class="bgtitle2"><a href="{$listnews.promotion[1]->getNewsPath()}" title="{$listnews.promotion[1]->title}"> <span>{$listnews.promotion[1]->title}</span></a> </div>
        </div>
        {if !empty($listnews.promotion[2])}
        <div class="col-2"><a href="{$listnews.promotion[2]->getNewsPath()}" title="{$listnews.promotion[0]->title}"><img src="{$listnews.promotion[2]->getImage()}" alt="{$listnews.promotion[2]->title}" width="195" height="120" /></a>
          <div class="bgtitle2"><a href="{$listnews.promotion[2]->getNewsPath()}" title="{$listnews.promotion[0]->title}"> <span>{$listnews.promotion[2]->title}</span></a> </div>
        </div>
        {/if}
      </div>
      {/if}
      {if !empty($listnews.promotion[3])}
      <div class="rownews"><a href="{$listnews.promotion[3]->getNewsPath()}" title="{$listnews.promotion[3]->title}"><img src="{$listnews.promotion[3]->getImage()}" alt="{$listnews.promotion[3]->title}" width="195" /></a>
        <div class="bgtitle"><a href="{$listnews.promotion[3]->getNewsPath()}" title="{$listnews.promotion[3]->title}"> <span>{$listnews.promotion[3]->title} </span></a> </div>
      </div>
      {/if}
    </div>

    {/if}
  </div>
  <div class="latest">
  {if !empty($listnews.normal)}
    <div class="title2">TIN CÔNG NGHỆ</div>
    <div class="cont">
    {if !empty($listnews.normal[0])}
      <div class="rownews"><a href="{$listnews.normal[0]->getNewsPath()}" title="{$listnews.normal[0]->title}"><img src="{$listnews.normal[0]->getImage()}" alt="{$listnews.normal[0]->title}" width="195" /></a>
        <div class="bgtitle"><a href="{$listnews.normal[0]->getNewsPath()}" title="{$listnews.normal[0]->title}"> <span>{$listnews.normal[0]->title} </span></a> </div>
      </div>
    {/if}
    {if !empty($listnews.normal[1])}
      <div class="rownews">
        <div class="col-1"><a href="{$listnews.normal[1]->getNewsPath()}" title="{$listnews.normal[1]->title}"><img src="{$listnews.normal[1]->getImage()}" alt="{$listnews.normal[1]->title}" width="195" height="120" /></a>
          <div class="bgtitle2"><a href="{$listnews.normal[1]->getNewsPath()}" title="{$listnews.normal[1]->title}"> <span>{$listnews.normal[1]->title}</span></a> </div>
        </div>
        {if !empty($listnews.normal[2])}
        <div class="col-2"><a href="{$listnews.normal[2]->getNewsPath()}" title="{$listnews.normal[2]->title}"><img src="{$listnews.normal[2]->getImage()}" alt="{$listnews.normal[2]->title}" width="195" height="120" /></a>
          <div class="bgtitle2"><a href="{$listnews.normal[2]->getNewsPath()}" title="{$listnews.normal[2]->title}"> <span>{$listnews.normal[2]->title}</span></a> </div>
        </div>
        {/if}
      </div>
    {/if}
    {if !empty($listnews.normal[3])}
      <div class="rownews"><a href="{$listnews.normal[3]->getNewsPath()}" title="{$listnews.normal[3]->title}"><img src="{$listnews.normal[3]->getImage()}" alt="{$listnews.normal[3]->title}" width="195" /></a>
        <div class="bgtitle"><a href="{$listnews.normal[3]->getNewsPath()}" title="{$listnews.normal[3]->title}"> <span>{$listnews.normal[3]->title}</span></a> </div>
      </div>
    {/if}
    </div>
   {/if}
  </div>
  {if !empty($sidebarhome)}
  <ul>
  {foreach item=absad from=$sidebarhome}
    <li><a href="{$absad->getAdsPath()}" title="{$absad->title}"><img alt="{$absad->title}" src="{$absad->getImage()}" width="200" height="200" style="margin-top:25px" /></a></li>
  {/foreach}
  </ul>
  {/if}
>>>>>>> .r2367
</div>
<<<<<<< .mine
=======

<div class="listproduct">
    {if $productlists|@count>0}
    {foreach from=$productlists item=productcat key=catid name=listproducts}
    <div class="products">
        <div class="products_name"><a href="{$productcat['cat']->getProductcateoryPath()}" title="{$productcat['cat']->name}">{$productcat['cat']->name}</a>        </div>
        <ul>
        {foreach from=$productcat['product'] item=product name=ProductsByCategory}
            {assign var="promotionprices" value=$product->promotionPrice()}
            <li{if $smarty.foreach.ProductsByCategory.iteration % 5 == 0 AND $smarty.foreach.ProductsByCategory.iteration !=1} class="showhide"{/if}{if !empty($promotionprices.promoid)} rel="{$product->barcode|trim}_{$promotionprices.promoid}"{/if} >
                <div class="special" id="{$product->id}" rel="{$product->pcid}">
                    {if $product->isbagdehot == 1 && $product->isbagdegift == 1}
                    <img src="{$currentTemplate}images/site/icon_hot_gif.png" alt="{$product->name} đang hot, có quà tặng" width="35" height="35" id="iconspecialimg" />
                    {elseif $product->isbagdenew == 1 && $product->isbagdegift == 1}
                    <img src="{$currentTemplate}images/site/icon_new_gif.png" alt="{$product->name} mới về, có quà tặng" width="35" height="35" id="iconspecialimg" />
                    {elseif $product->isbagdehot == 1}
                    <img src="{$currentTemplate}images/site/icon_hot.png" alt="{$product->name} đang hot" width="35" height="35" id="iconspecialimg" />
                    {elseif $product->isbagdenew == 1}
                    <img src="{$currentTemplate}images/site/icon_new.png" alt="{$product->name} mới về" width="35" height="35" id="iconspecialimg" />
                    {elseif $product->isbagdegift == 1}
                    <img src="{$currentTemplate}images/site/icon_gif.png" alt="{$product->name} có quà tặng" width="35" height="35" id="iconspecialimg" />
                    {/if}
                </div>

                <a href="{$product->getProductPath()}" class="imageprod" title="{$product->name}">
                    {if $product->image!=''}
                    <img src="{$product->getSmallImage()}" alt="{$product->name}" />
                    {else}
                    <img src="{$currentTemplate}images/site/default/default.jpg" alt="{$product->name}"  />
                    {/if}
                </a>

                <a href="{$product->getProductPath()}" class="title" title="{$product->name}">{$product->name} </a>
                <p class="submmary">{$product->summary}</p>
                {if $product->sellprice > 0 && $product->onsitestatus != $OsCommingSoon}
                    {if $product->onsitestatus == $OsERP && $product->displaysellprice!=1 && !empty($promotionprices.price) && $promotionprices.price<$product->sellprice}
                        <div class="priceold">{$product->sellprice|number_format} VND</div>
                        <div class="pricenew">{$promotionprices.price|number_format} VND</div>
                    {elseif $product->onsitestatus == $OsERPPrepaid}
                    	<div class="pricenew">{$product->prepaidprice|number_format} VND</div>
                    {else}
                        <div class="pricenew">{$product->sellprice|number_format} VND</div>
                    {/if}
                    {if $product->onsitestatus == $OsERP && $product->instock > 0}
                    <a href="#" title="Mua hàng" class="buynow" rel="{$product->id}">Mua hàng</a>
                    {elseif $product->onsitestatus == $OsERPPrepaid}
                    <a href="#" title="Đặt trước" class="buyprepaid" rel="{$product->id}">Đặt trước</a>
                    {elseif $product->onsitestatus == $OsCommingSoon}
			  			<a href="javascript:void(0)" title="Hàng sắp về" class="outofstock3">Hàng sắp về</a>
					  {else}
                    <a href="#" title="Hết hàng" class="outofstock3">Hết hàng</a>
                    {/if}
                {elseif $product->onsitestatus == $OsCommingSoon}
			  			<a href="javascript:void(0)" title="Hàng sắp về" class="outofstock3">Hàng sắp về</a>
				{else}
                    <a href="#" title="Hết hàng" class="outofstock3">Hết hàng</a>
                {/if}
                {if !empty($product->listgallery)}
                <ul class="circlegallery">
                    {foreach from=$product->listgallery item=lgal}
                        <li>{$lgal->getSmallImage()}</li>
                    {/foreach}
                    {if $product->image!=''}
                    <li>{$product->getSmallImage()}</li>
                    {else}
                    <li>{$currentTemplate}images/site/default/default.jpg"</li>
                    {/if}
                </ul>
                {/if}
            </li>
            {if $smarty.foreach.ProductsByCategory.iteration % 5 == 0 AND $smarty.foreach.ProductsByCategory.iteration !=1}
                {if !$smarty.foreach.ProductsByCategory.last}
                    </ul><div class="space-space"><p class="linebox"></p></div><ul>
                {else}
                    </ul>
                {/if}
            {/if}
        {/foreach}
        </ul>
    </div>
    {/foreach}
    {/if}
</div>
</div>
>>>>>>> .r2367
{literal}
<script type="text/javascript">
var fpcid = "{/literal}{$curCategory->id}{literal}";
$(document).ready(function(){
    initEditCategoryInline(fpcid);
});
</script>
{/literal}