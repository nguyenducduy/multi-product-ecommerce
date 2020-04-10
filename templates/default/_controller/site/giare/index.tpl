<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$pageTitle}</title>
<script type="text/javascript">
    var rooturl = "{$conf.rooturl}";
    var imageDir = "{$imageDir}";
    var rootindexgiare = rooturl+'giare/indexajax';
    var rootresult = rooturl+'giare/showresult';
</script>
<link type="text/css" rel="stylesheet" href="{$currentTemplate}/min/?g=css&ver={$setting.site.cssversion}" media="screen" />
<link type="text/css" rel="stylesheet" href="{$currentTemplate}css/site/pro-multi-css.css" media="screen" />
<script src="{$currentTemplate}/js/jquery.js"></script>
<script  type="text/javascript" src="{$currentTemplate}/min/?g=js&ver={$setting.site.jsversion}"></script>
 <script>
	function tick(){
	
		$('#ticker_02frt li:first').slideUp( function () { 
		//alert("show test");
		$(this).appendTo($('#ticker_02frt')).slideDown(); 
		
		});
	}
	setInterval(function(){ tick () }, 3000);
</script>

</head>

<body>
{echodebug($pageTitle)}
<div id="wrapper-promotion-ver2">
	<div id="pro-top-ver2">
    	<div class="pro-logo"><a href="{$registry.conf['rooturl']}giare"><img src="{$registry->conf['rooturl']}templates/default/images/giare/giarenew/logo-pro-multi2.jpg" alt="" title="" width="220" height="70" /></a></div>
        <div class="pro-header">
        	<div class="top-nav">
                    <div class="topleft">
                        <ul>
                            <li><i class="icon-visit-v2"></i> <span class="number"> <a href="#">1256</a></span> lượt xem</li>
                            <li style="color:#e1e1e1">|</li>
                            <li><i class="icon-cart-v2"></i> <span class="number"> <a href="#">{$orders}</a></span> KH mua được giá tôt  </li>
                        </ul>
                    </div>
                    <div class="top-right-hot" >
                     
                        <ul id="ticker_02frt"  class="ticker2">
                            {if $productorder|@count > 0}
                              {foreach from=$productorder item=porder}
                               <li>
                                  <a href="{$porder.path}" rel="nofollow">{$porder.name} </a> vừa được mua {$porder.timeago} trước  
                               </li>
                             {/foreach}
                            {/if}
                           
                        </ul>
                 </div>
               
            </div>
            
            <div class="nav-main">
            	<ul>
                	<li class="current"><a href="#menu-qdinh-v2">qui định chương trình</a></li>
                    <li><a href="#menu-ktra-v2">Kiểm tra đơn hàng</a></li>
                    <li><a href="#comments" >bình luận</a></li>
                </ul>
            </div>
        
        </div>
    </div>
    
    <div class="banner-multpro-v2">
        {if $bannerHeader|@count}
          <a href="{$bannerHeader[0]->link}" title="{$bannerHeader[0]->name}">
          <img src="{$bannerHeader[0]->getImage()}" alt="{$bannerHeader[0]->name}" title ="{$bannerHeader[0]->name}" />
          </a>
        {/if}
    </div>
    
    <div class="content-multpro-v2">
    	<div class="filter-multpro-v2">
        	<ul>
            	 <li> <i class=" icon-arr-v2"></i> Tìm theo</li>
            	 <li> <select name="optionSelect" id="optionSelect">
           				 <option value="nganh-hang" {if $smarty.get.fillter == 'nganh-hang'}selected='selected'{/if}>Chọn theo nghành hàng</option>
          				  <option value="gia" {if $smarty.get.fillter == 'gia'}selected='selected'{/if}>Chọn theo giá</option>
          				  
         			 </select>
           	   </li>
           		<li>
                	<label class="radio">
					<input type="radio" name="optionsRadios" id="optionsRadios1" value="giam-gia" {if $smarty.get.fillter == 'giam-gia'}checked{/if}>
						Sản phẩm có giảm giá
                    </label>
                </li>
                <li>
                	<label class="radio">    
                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="qua-tang" {if $smarty.get.fillter == 'qua-tang'}checked{/if} >
						Sản phẩm có quà tặng
                     </label>
                </li>
        
            </ul>
        </div>
        
        <div class="box-product-ver2">
        	<div class="pro-ver2">
                {assign var="numproduct" value=count($listproductapply)}
                <ul>
                {if $listproductapply|@count > 0}
                    {foreach item=listproduct from=$listproductapply}
                    	<li>
                        	<div class="special-label-v2"> 
                                {if $listproduct->isbagdegift == 1}
                                    <img src="{$registry->conf['rooturl']}templates/default/images/giare/giarenew/label-gift2.png"  width="45" height="45"/>
                                {else}
                                  <div class="percent-giare">
                                      -{$listproduct->discountpercent}%
                                  </div>
                                  <div class="images-giare">
                                    <img src="{$registry->conf['rooturl']}templates/default/images/giare/giarenew/label-discount2.png"  width="45" height="45"/>
                                  </div>
                                {/if}
                            </div> 
                        	<div class="pro-name">
                                <a href="{$listproduct->getProductPath()}">{$listproduct->name}</a> </div>
                            <div class='productimagegr' style='width:210px; height:225px'>
                                <img src="{$listproduct->getSmallImage()}" alt="{$listproduct->name}" title="{$listproduct->name}" />
                            </div>
                            <div class="pro-bottom"> 
                            	<div class="price-button"><a href="{$registry->conf['rooturl']}cart/giare/?id={$listproduct->id}"> mua</a></div>
                                <div class="price-dis">{if $listproduct->promotionprice > 0}
                                                            {$listproduct->promotionprice|number_format}
                                                          {else}
                                                            {$listproduct->sellprice|number_format}
                                                        {/if} vnd</div>
                                <div class="price-main">{if $listproduct->promotionprice > 0}
                                                            {$listproduct->sellprice|number_format} vnd
                                                        {else}

                                                        {/if}
                                </div>
                            </div>
                        </li>  
                    {/foreach}
                 {else}
                    <li>Khong co san pham nao</li>
       
                {/if}
                </ul>
                    <!--{if $product->isbagdehot == 1 || $product->isbagdenew == 1 || $product->isbagdegift == 1}
                                    <div class="special">
                                        {if $product->isbagdehot == 1}
                                            <i class="icon-hot"></i>
                                        {elseif $product->isbagdenew == 1}
                                            <i class="icon-new"></i>
                                        {elseif $product->isbagdegift == 1}
                                            <i class="icon-gift"></i>
                                        {/if}                                   
                                    </div>
                                    {/if} -->
            </div>
        </div>
       
       <div id="menu-qdinh-v2" class="box-priciple-ver2">
            {if $regulations|@count > 0}
           	<div class="priciple-v2-title"><i class="icon-princ-v2"></i>{$regulations[0]->title}</div>
            <div class="priciple-v2-ctent">
            	{$regulations[0]->content}
            </div>
            {/if}
       </div>
       
      <div class="box-sale-ver2">
       		<div class="sale-v2-title"><i class="icon-sale-v2"></i> Các chương trình khuyến mãi khác</div>
            <div class="clear"></div>
            <ul>
              <li>
                {if $bannerFooter1|@count}
                  <a href="{$bannerFooter1[0]->link}" title="{$bannerFooter1[0]->name}">
                  <img src="{$bannerFooter1[0]->getImage()}" alt="{$bannerFooter1[0]->name}" title ="{$bannerFooter1[0]->name}" />
                  </a>
                  <span class="sale-v2-name"><a href="{$bannerFooter1[0]->link}">{$bannerFooter1[0]->name}</a></span>
                {/if}
              </li>
              <li>
                {if $bannerFooter2|@count}
                  <a href="{$bannerFooter2[0]->link}" title="{$bannerFooter2[0]->name}">
                  <img src="{$bannerFooter2[0]->getImage()}" alt="{$bannerFooter2[0]->name}" title ="{$bannerFooter2[0]->name}" />
                  </a>
                  <span class="sale-v2-name"><a href="{$bannerFooter2[0]->link}">{$bannerFooter2[0]->name}</a></span>
                {/if}
              </li>
               <li>
                {if $bannerFooter3|@count}
                  <a href="{$bannerFooter3[0]->link}" title="{$bannerFooter3[0]->name}">
                  <img src="{$bannerFooter3[0]->getImage()}" alt="{$bannerFooter3[0]->name}" title ="{$bannerFooter3[0]->name}" />
                  </a>
                  <span class="sale-v2-name"><a href="{$bannerFooter3[0]->link}">{$bannerFooter3[0]->name}</a></span>
                {/if}
              </li>
            </ul>
       </div>
       
       <div id="menu-ktra-v2" class="box-support-ver2">
        	<div class="left-support-v2">
            	<div class="l-support-v2-title"><i class="icon-check-v2"></i> kiểm tra đơn hàng</div>
                <div class="search-bill-v2">
                	<input type="text" placeholder="Nhập mã đơn hàng" id='ordercode' />  
         		   <span class="btn-search" id="searchgiare"><i class="icon-search-v2"></i></span>
                 <div class="user-v2"><i class="icon-user-v2"></i>Đã có <span style="color:#ff0000; font-weight:bold;">{$orders}</span> KH đặt mua giá tốt</div>
                </div>
                
            </div>
            
            <div class="right-support-v2">
            	<div class=" r-support-v2-title"><i class="icon-phone-v2"></i> hỗ trợ & đặt hàng</div>
                <div class="hotline-support-v2">1900 1883 -  08.39.48.6789</div>
                <div class="date-v2">Từ 8h - 20h hàng ngày</div>
            </div>
       </div>
       
       <div class="box-footer-ver2">
    	   <div class="footer-v2-ctent">
       			<ul>
            		<li class="f-ter-col1"><i class="icon-thumb-v2"></i> 
                		<div class=" title-f-v2"> HÀNG MỚI CHÍNH HÃNG<br /> chất lượng</div>
                   		<div class="text-f-v2">Visit our shop to see big discounts for our products. You will save big time </div>
                	</li>
                
                	<li class="f-ter-col2"><i class=" icon-delivery-v2"></i> 
                		<div class=" title-f-v2"> 50km giao hàng <br />miễn phí</div>
                    	<div class="text-f-v2">Visit our shop to see big discounts for our products. You will save big time </div>
                	</li>
                
                	<li class="f-ter-col3"><i class=" icon-calendar-v2"></i> 
                		<div class=" title-f-v2"> 10 ngày đổi trả miễn phí<br /> chất lượng</div>
                    	<div class="text-f-v2">Visit our shop to see big discounts for our products. You will save big time </div>
                	</li>
            	</ul>
       		</div>
       </div>
        <div id="mainpagenew">
            <div id="comments"></div>
        </div>
       {literal}
        <script type="text/javascript">
             $(document).ready(function(){
                  loadgiareReview(0 , '');   
              });
            $("#optionsRadios1,#optionsRadios2").change(function () {
                if ($("#optionsRadios1").is(":checked")) {
                    window.location.href = rooturl+'giare?fillter='+$(this).val();
                }else{
                    window.location.href = rooturl+'giare?fillter='+$(this).val();
                }
            });  
            $( "#optionSelect" ).change(function() {
                window.location.href = rooturl+'giare?fillter='+$(this).val();
            });     
            $('#searchgiare').click(function(){
                var ordercode = $('#ordercode').val();
                if(ordercode != '')
                {
                    window.location.href = rooturl+'account/checksaleorder?id='+$('#ordercode').val();
                }else{
                    alert('Vui long nhap ma don hang');
                }
            })
        </script>
        {/literal}
    
    </div>
</div>
</body>
</html>