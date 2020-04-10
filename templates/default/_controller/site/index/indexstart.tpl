{strip}
<div id="banner">    
    {$banner}
    <div class="bn_btom">
        {if $textbanner|@count > 0}
        <ul>
            {foreach from = $textbanner item = txtbanner name=bannersmall}
            <li><a href="{$txtbanner->getAdsPath()}" title="{$txtbanner->name}"><img alt="{$txtbanner->title}" src="{$txtbanner->getImage()}"  width="213" height="90"></a></li>
            {if $smarty.foreach.bannersmall.iteration==7}{break}{/if}
            {/foreach}
        </ul>
        {/if}
    </div><!--end of banner left-->    
</div><!--end of banner-->

<div id="container">
    <!-- promotion, recommendation -->
    <div id="depart">
        <div class="tabscontainer" id="promo">
            <div class="tabs">  
                <div class="tagnoelone"></div>                                             
                {if $me->id > 0 && $listproductrecommend|@count > 0}
                <div class="tab selected" id="tab_menu_1">
                    <h3 class="link">Gợi ý cho bạn từ dienmay.com</h3>
                </div>
                {/if}
                <div class="tab {if $me->id == 0 || $listproductrecommend|@count == 0}selected{/if}" {if $me->id > 0 && $listproductrecommend|@count > 0}id="tab_menu_2"{else}id="tab_menu_1"{/if}>
                    <h3 class="link">Top sản phẩm bán chạy tại dienmay.com</h3>
                </div>
                <div class="tab" id="tab_menu_3">
                    <h3 class="link">Khuyến mãi hôm nay</h3>
                </div>
            </div>
            <div class="clear"></div>
            <div class="curvedContainer">
                {if $me->id > 0 && $listproductrecommend|@count > 0}
                <div class="tabcontent tab_content_1 bortoptabs display">
                    <div class="m-carousel m-fluid m-carousel-photos m-list-product">
                        <!-- the slider -->
                        <div class="m-carousel-inner">
                            <!-- the items -->	 
                            {assign var=numrow value=$listproductrecommend|@count / 5}              
                            {assign var=numrow value=$numrow|ceil}

                            {if $numrow > 1}
                            {section name=row loop=$numrow start=0 step=1}  
                             <div class="m-item">
                                <div class="products">
                                    <ul>
                                        {section name=col loop=5 start=0 step=1}
                                        {assign var=index value=5*$smarty.section.row.index +$smarty.section.col.index}
                                        {assign var=recommendpro value=$listproductrecommend.$index}
                                        
                                        {if !empty($recommendpro)}

                                        <li>
                                            {if $recommenditemcolorlist[$recommendpro->id]|count > 1}           
                                                <div class="lg">
                                                    <ul>
                                                        {foreach from=$recommenditemcolorlist[$recommendpro->id] item=recommendlistcolor name=recommendlistcolorname}
                                                         {if $recommendlistcolor[0] > 0}
                                                            {if $smarty.foreach.recommendlistcolorname.index > 4}{break}{/if}
                                                            <li><a class="qtootip" href="{if $recommendlistcolor[4] == 1}{$recommendpro->getProductPath()}{else}{$recommendpro->getProductPath()}?color={$recommendlistcolor[0]}{/if}" title="{$recommendlistcolor[2]}" style="background:#{$recommendlistcolor[3]}"></a></li>
                                                            {/if}
                                                        {/foreach}
                                                    </ul>
                                                </div>                         
                                            {/if}                                         
                                            {if $recommendpro->onsitestatus == $OsERPPrepaid}<div class="special"><i class="icon-preorder"></i></div>
                                            {elseif $recommendpro->onsitestatus == $OsCommingSoon}<div class="special"><i class="icon-hsapve"></i></div>
                                            {elseif $recommendpro->onsitestatus == $OsHot}<div class="special"><i class="icon-hot"></i></div>
                                            {elseif $recommendpro->onsitestatus == $OsNew}<div class="special"><i class="icon-new"></i></div>
                                            {elseif $recommendpro->onsitestatus == $OsBestSeller}<div class="special"><i class="icon-bestsale"></i></div>
                                            {elseif $recommendpro->onsitestatus == $OsCrazySale}<div class="special"><i class="icon-crazydeal"></i></div>
                                            {elseif $recommendpro->onsitestatus == $OsDoanGia}<div class="special"><i class="icon-betting"></i></div>
                                            {elseif $recommendpro->onsitestatus == $OsNoSell}<div class="special"><i class="icon-theend"></i></div>
                                            {/if}      
                                                                                                                            
                                            <a href="{$recommendpro->getProductPath()}" title="{$recommendpro->name|escape}">{if $smarty.section.row.index==0}<img alt="{$recommendpro->name|escape}" src="{$recommendpro->getSmallImage()}" />{else}<span class="pro_img" rel="{$recommendpro->getSmallImage()}" title="{$recommendpro->name}"></span>{/if} </a> <a class="position-a" href="{$recommendpro->getProductPath()}" title="{$recommendpro->getProductPath()}"><h4>{$recommendpro->name}</h4></a>
                                            {if $recommendpro->sellprice > 0 || $recommendpro->onsitestatus == $OsERPPrepaid}
                                            <div class="loadprice lp{$recommendpro->id}{$recommendpro->barcode|trim|substr:-5}" rel="{$recommendpro->id}{$recommendpro->barcode|trim|substr:-5}">
                                                {if $recommendpro->displaysellprice!=1 && $recommendpro->sellprice>0 && !empty($recommendpro->promotionprice) && $recommendpro->onsitestatus == $OsERP && $recommendpro->promotionprice < $recommendpro->sellprice}
                                                <div class="priceold">{if $recommendpro->sellprice > 1000}{$recommendpro->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                <div class="pricenew">{if $recommendpro->promotionprice > 1000}{$recommendpro->promotionprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                {elseif $recommendpro->onsitestatus == $OsERPPrepaid && $recommendpro->prepaidstartdate <= $currentTime && $recommendpro->prepaidenddate >= $currentTime}
                                                <div class="pricenew">{if $recommendpro->prepaidprice > 1000}{$recommendpro->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                {elseif $recommendpro->sellprice > 0}
                                                <div class="pricenew">{if $recommendpro->sellprice > 1000}{$recommendpro->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                {/if}
                                                <div class="salepercent">%</div>
                                            </div>
                                            {/if}                                   
                                        </li>

                                        {/if}
                                        
                                        {/section}
                                    </ul>
                                </div>
                            </div>
                            {/section}
                            {/if}
                            <!--product recommandation-->
                            
                        </div>
                        <!-- the controls -->
                        <div class="m-carousel-controls m-carousel-pagination">
                            <div class="prev"><a href="javascript:void(0)" data-slide="prev">«</a></div>
                            <div class="next"><a href="javascript:void(0)" onclick="clicknext('promo')" data-slide="next">»</a></div>
                        </div>
                    </div>
                </div>
                {/if}

                <div class="tabcontent tab_content_{if $me->id > 0 && $listproductrecommend|@count > 0}2{else}1{/if} bortoptabs {if $me->id == 0 || $listproductrecommend|@count == 0}display{/if}">
                    <div class="m-carousel m-fluid m-carousel-photos m-list-product">
                        <!-- the slider -->
                        <div class="m-carousel-inner">
                            <!-- the items -->     
                            {if $topitemlist}
                            {assign var=numrow value=$topitemlist|@count / 5}
                            {assign var=numrow value=$numrow|ceil}  
                            
                            {if $numrow > 1}
                            {section name=row loop=$numrow start=0 step=1}                            
                            <div class="m-item">
                                <div class="products">
                                    <ul>
                                        {section name=col loop=5 start=0 step=1}
                                        {assign var=index value=5*$smarty.section.row.index +$smarty.section.col.index}
                                        {assign var=toppro value=$topitemlist.$index}  

                                        {if !empty($toppro)}
                                        <li>        
                                            {if $topitemcolorlist[$toppro->id]|count > 1}           
                                                <div class="lg">
                                                    <ul>
                                                        {foreach from=$topitemcolorlist[$toppro->id] item=toplistcolor name=toplistcolorname}
                                                         {if $toplistcolor[0] >0}
                                                            {if $smarty.foreach.toplistcolorname.index > 4}{break}{/if}
                                                            <li><a class="qtootip" href="{if $toplistcolor[4] == 1}{$toppro->getProductPath()}{else}{$toppro->getProductPath()}?color={$toplistcolor[0]}{/if}" title="{$toplistcolor[2]}" style="background:#{$toplistcolor[3]}"></a></li>
                                                            {/if}
                                                        {/foreach}
                                                    </ul>
                                                </div>                         
                                            {/if}  
                                            {if $toppro->onsitestatus == $OsERPPrepaid}<div class="special"><i class="icon-preorder"></i></div>
                                            {elseif $toppro->onsitestatus == $OsCommingSoon}<div class="special"><i class="icon-hsapve"></i></div>
                                            {elseif $toppro->onsitestatus == $OsHot}<div class="special"><i class="icon-hot"></i></div>
                                            {elseif $toppro->onsitestatus == $OsNew}<div class="special"><i class="icon-new"></i></div>
                                            {elseif $toppro->onsitestatus == $OsBestSeller}<div class="special"><i class="icon-bestsale"></i></div>
                                            {elseif $toppro->onsitestatus == $OsCrazySale}<div class="special"><i class="icon-crazydeal"></i></div>
                                            {elseif $toppro->onsitestatus == $OsDoanGia}<div class="special"><i class="icon-betting"></i></div>
                                            {elseif $toppro->onsitestatus == $OsNoSell || $toppro->instock == 0}<div class="special"><i class="icon-theend"></i></div>
                                            {/if}                                                                                        
                                            <a href="{$toppro->getProductPath()}" title="{$toppro->name|escape}">{if $smarty.section.row.index==0}<img alt="{$toppro->name|escape}" src="{$toppro->getSmallImage()}" />{else}<span class="pro_img" rel="{$toppro->getSmallImage()}" title="{$toppro->name}"></span>{/if} </a> <a class="position-a" href="{$toppro->getProductPath()}" title="{$toppro->getProductPath()}"><h4>{$toppro->name}</h4></a>
                                            {if $toppro->sellprice > 0 || $toppro->onsitestatus == $OsERPPrepaid}
                                            <div class="loadprice lp{$toppro->id}{$toppro->barcode|trim|substr:-5}" rel="{$toppro->id}{$toppro->barcode|trim|substr:-5}">
                                                {if $toppro->displaysellprice!=1 && $toppro->sellprice>0 && !empty($toppro->promotionprice) && $toppro->onsitestatus == $OsERP && $toppro->promotionprice < $toppro->sellprice}
                                                <div class="priceold">{if $toppro->sellprice > 1000}{$toppro->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                <div class="pricenew">{if $toppro->promotionprice > 1000}{$toppro->promotionprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                {elseif $toppro->onsitestatus == $OsERPPrepaid && $toppro->prepaidstartdate <= $currentTime && $toppro->prepaidenddate >= $currentTime}
                                                <div class="pricenew">{if $toppro->prepaidprice > 1000}{$toppro->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                {elseif $toppro->sellprice > 0}
                                                <div class="pricenew">{if $toppro->sellprice > 1000}{$toppro->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                {/if}
                                                <div class="salepercent">%</div>
                                            </div>
                                            {/if}                                   
                                        </li>
                                        {/if}

                                        {/section}
                                    </ul>
                                </div>
                            </div>
                            {/section}
                            {else}
                             <div class="m-item">
                                <div class="products">
                                    <ul>
                                        {foreach item=toppro from=$topitemlist}

                                        {if !empty($toppro)}
                                        <li>             
                                         {if $topitemcolorlist[$toppro->id]|count > 1}           
                                                <div class="lg">
                                                    <ul>
                                                        {foreach from=$topitemcolorlist[$toppro->id] item=toplistcolor name=toplistcolorname}
                                                            {if $toplistcolor[0] >0}
                                                             {if $smarty.foreach.toplistcolorname.index > 4}{break}{/if}
                                                            <li class="qtooltip"><a class="qtootip"  href="{if $toplistcolor[4] == 1}{$toppro->getProductPath()}{else}{$toppro->getProductPath()}?color={$toplistcolor[0]}{/if}" title="{$toplistcolor[2]}" style="background:#{$toplistcolor[3]}"></a></li>
                                                            {/if}
                                                        {/foreach}
                                                    </ul>
                                                </div>                         
                                            {/if}                                 
                                            {if $toppro->onsitestatus == $OsERPPrepaid}<div class="special"><i class="icon-preorder"></i></div>
                                            {elseif $toppro->onsitestatus == $OsCommingSoon}<div class="special"><i class="icon-hsapve"></i></div>
                                            {elseif $toppro->onsitestatus == $OsHot}<div class="special"><i class="icon-hot"></i></div>
                                            {elseif $toppro->onsitestatus == $OsNew}<div class="special"><i class="icon-new"></i></div>
                                            {elseif $toppro->onsitestatus == $OsBestSeller}<div class="special"><i class="icon-bestsale"></i></div>
                                            {elseif $toppro->onsitestatus == $OsCrazySale}<div class="special"><i class="icon-crazydeal"></i></div>
                                            {elseif $toppro->onsitestatus == $OsDoanGia}<div class="special"><i class="icon-betting"></i></div>
                                            {elseif $toppro->onsitestatus == $OsNoSell || $toppro->instock == 0}<div class="special"><i class="icon-theend"></i></div>
                                            {/if}                                            
                                                                                                                                                                
                                            <a href="{$toppro->getProductPath()}" title="{$toppro->name|escape}"><img alt="{$toppro->name|escape}" src="{$toppro->getSmallImage()}" /> </a> <a class="position-a" href="{$toppro->getProductPath()}" title="{$toppro->getProductPath()}"><h4>{$toppro->name}</h4></a>
                                            {if $toppro->sellprice > 0 || $toppro->onsitestatus == $OsERPPrepaid}
                                            <div class="loadprice lp{$toppro->id}{$toppro->barcode|trim|substr:-5}" rel="{$toppro->id}{$toppro->barcode|trim|substr:-5}">
                                                {if $toppro->displaysellprice!=1 && $toppro->sellprice>0 && !empty($toppro->promotionprice) && $toppro->onsitestatus == $OsERP && $toppro->promotionprice < $toppro->sellprice}
                                                <div class="priceold">{if $toppro->sellprice > 1000}{$toppro->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                <div class="pricenew">{if $toppro->promotionprice > 1000}{$toppro->promotionprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                {elseif $toppro->onsitestatus == $OsERPPrepaid && $toppro->prepaidstartdate <= $currentTime && $toppro->prepaidenddate >= $currentTime}
                                                <div class="pricenew">{if $toppro->prepaidprice > 1000}{$toppro->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                {elseif $toppro->sellprice > 0}
                                                <div class="pricenew">{if $toppro->sellprice > 1000}{$toppro->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                {/if}
                                                <div class="salepercent">%</div>
                                            </div>
                                            {/if}                                   
                                        </li>
                                        {/if}

                                        {/foreach}
                                    </ul>
                                </div>
                             </div>
                            {/if}
                            
                            {/if}             
                            <!--product recommandation-->
                        </div>
                        <!-- the controls -->
                            <div class="m-carousel-controls m-carousel-pagination">
                            <div class="prev"><a href="javascript:void(0)" data-slide="prev">«</a></div>
                            <div class="next"><a href="javascript:void(0)" onclick="clicknext('promo')" data-slide="next">»</a></div>
                        </div>
                    </div>
                </div>
                
                <div class="tabcontent tab_content_3 bortoptabs">
                    <div class="m-carousel m-fluid m-carousel-photos m-list-product">
                        <!-- the slider -->
                        <div class="m-carousel-inner">
                            <!-- the items -->	   
                            {if $listPromotions}
                            {assign var=numrow value=$listPromotions|@count / 5}
                            {assign var=numrow value=$numrow|ceil}	
                            
                            {if $numrow > 1}
							{section name=row loop=$numrow start=0 step=1}                            
                            <div class="m-item">
                                <div class="products">
                                    <ul>
                                        {section name=col loop=5 start=0 step=1}
                                        {assign var=index value=5*$smarty.section.row.index +$smarty.section.col.index}
                                        {assign var=hpromo value=$listPromotions.$index}	                				                			
                                        
                                        {if !empty($hpromo)}
                                        <li>     
                                             {if $listPromotionColor[$hpromo->id]|count > 1}           
                                                <div class="lg">
                                                    <ul>
                                                        {foreach from=$listPromotionColor[$hpromo->id] item=promotionlistcolor name=promotionlistcolorname}
                                                            {if $promotionlistcolor[0] > 0}
                                                             {if $smarty.foreach.promotionlistcolorname.index > 4}{break}{/if}
                                                            <li class="qtooltip"><a class="qtootip"  href="{if $promotionlistcolor[4] == 1}{$hpromo->getProductPath()}{else}{$hpromo->getProductPath()}?color={$promotionlistcolor[0]}{/if}" title="{$promotionlistcolor[2]}" style="background:#{$promotionlistcolor[3]}"></a></li>
                                                            {/if}
                                                        {/foreach}
                                                    </ul>
                                                </div>                         
                                            {/if}                                         
                                            {if $hpromo->onsitestatus == $OsERPPrepaid}<div class="special"><i class="icon-preorder"></i></div>
                                            {elseif $hpromo->onsitestatus == $OsCommingSoon}<div class="special"><i class="icon-hsapve"></i></div>
                                            {elseif $hpromo->onsitestatus == $OsHot}<div class="special"><i class="icon-hot"></i></div>
                                            {elseif $hpromo->onsitestatus == $OsNew}<div class="special"><i class="icon-new"></i></div>
                                            {elseif $hpromo->onsitestatus == $OsBestSeller}<div class="special"><i class="icon-bestsale"></i></div>
                                            {elseif $hpromo->onsitestatus == $OsCrazySale}<div class="special"><i class="icon-crazydeal"></i></div>
                                            {elseif $hpromo->onsitestatus == $OsDoanGia}<div class="special"><i class="icon-betting"></i></div>
                                            {elseif $hpromo->onsitestatus == $OsNoSell || $hpromo->instock == 0}<div class="special"><i class="icon-theend"></i></div>{/if}                                                                                   
                                            <a href="{$hpromo->getProductPath()}" title="{$hpromo->name|escape}">{if $smarty.section.row.index == 0}<img alt="{$hpromo->name|escape}" src="{$hpromo->getSmallImage()}" />{else}<span class="pro_img" rel="{$hpromo->getSmallImage()}" title="{$hpromo->name}"></span>{/if} </a> <a class="position-a" href="{$hpromo->getProductPath()}" title="{$hpromo->getProductPath()}"><h4>{$hpromo->name}</h4></a>
                                            {if $hpromo->sellprice > 0 || $hpromo->onsitestatus == $OsERPPrepaid}
                                            <div class="loadprice lp{$hpromo->id}{$hpromo->barcode|trim|substr:-5}" rel="{$hpromo->id}{$hpromo->barcode|trim|substr:-5}">
                                                {if $hpromo->displaysellprice!=1 && $hpromo->sellprice>0 && !empty($hpromo->promotionprice) && $hpromo->onsitestatus == $OsERP && $hpromo->promotionprice < $hpromo->sellprice}
                                                <div class="priceold">{if $hpromo->sellprice > 1000}{$hpromo->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                <div class="pricenew">{if $hpromo->promotionprice > 1000}{$hpromo->promotionprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                {elseif $hpromo->onsitestatus == $OsERPPrepaid && $hpromo->prepaidstartdate <= $currentTime && $hpromo->prepaidenddate >= $currentTime}
                                                <div class="pricenew">{if $hpromo->prepaidprice > 1000}{$hpromo->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                {elseif $hpromo->sellprice > 0}
                                                <div class="pricenew">{if $hpromo->sellprice > 1000}{$hpromo->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                {/if}
                                                <div class="salepercent">%</div>
                                            </div>
                                            {/if}                                   
                                        </li>  
                                        {/if}

                                        {/section}
                                    </ul>
                                </div>
                            </div>
                            {/section}
							{else}
							 <div class="m-item">
                                <div class="products">
                                    <ul>
										{foreach item=hpromo from=$listPromotions}
										<li>               
                                             {if $listPromotionColor[$hpromo->id]|count > 1}           
                                                <div class="lg">
                                                    <ul>
                                                        {foreach from=$listPromotionColor[$hpromo->id] item=promotionlistcolor name=promotionlistcolorname}
                                                            {if $promotionlistcolor[0] > 0}
                                                             {if $smarty.foreach.promotionlistcolorname.index > 4}{break}{/if}
                                                            <li class="qtooltip"><a class="qtootip" href="{if $promotionlistcolor[4] == 1}{$hpromo->getProductPath()}{else}{$hpromo->getProductPath()}?color={$promotionlistcolor[0]}{/if}" title="{$promotionlistcolor[2]}" style="background:#{$promotionlistcolor[3]}"></a></li>
                                                            {/if}
                                                        {/foreach}
                                                    </ul>
                                                </div>                         
                                            {/if}                                    
                                            {if $hpromo->onsitestatus == $OsERPPrepaid}<div class="special"><i class="icon-preorder"></i></div>
                                            {elseif $hpromo->onsitestatus == $OsCommingSoon}<div class="special"><i class="icon-hsapve"></i></div>
                                            {elseif $hpromo->onsitestatus == $OsHot}<div class="special"><i class="icon-hot"></i></div>
                                            {elseif $hpromo->onsitestatus == $OsNew}<div class="special"><i class="icon-new"></i></div>
                                            {elseif $hpromo->onsitestatus == $OsBestSeller}<div class="special"><i class="icon-bestsale"></i></div>
                                            {elseif $hpromo->onsitestatus == $OsCrazySale}<div class="special"><i class="icon-crazydeal"></i></div>
                                            {elseif $hpromo->onsitestatus == $OsDoanGia}<div class="special"><i class="icon-betting"></i></div>
                                            {elseif $hpromo->onsitestatus == $OsNoSell || $hpromo->instock == 0}<div class="special"><i class="icon-theend"></i></div>{/if}                                            
                                            
                                            <a href="{$hpromo->getProductPath()}" title="{$hpromo->name|escape}"><img alt="{$hpromo->name|escape}" src="{$hpromo->getSmallImage()}" /> </a> <a class="position-a" href="{$hpromo->getProductPath()}" title="{$hpromo->getProductPath()}"><h4>{$hpromo->name}</h4></a>
                                            {if $hpromo->sellprice > 0 || $hpromo->onsitestatus == $OsERPPrepaid}
                                            <div class="loadprice lp{$hpromo->id}{$hpromo->barcode|trim|substr:-5}" rel="{$hpromo->id}{$hpromo->barcode|trim|substr:-5}">
                                                {if $hpromo->displaysellprice!=1 && $hpromo->sellprice>0 && !empty($hpromo->promotionprice) && $hpromo->onsitestatus == $OsERP && $hpromo->promotionprice < $hpromo->sellprice}
                                                <div class="priceold">{if $hpromo->sellprice > 1000}{$hpromo->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                <div class="pricenew">{if $hpromo->promotionprice > 1000}{$hpromo->promotionprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                {elseif $hpromo->onsitestatus == $OsERPPrepaid && $hpromo->prepaidstartdate <= $currentTime && $hpromo->prepaidenddate >= $currentTime}
                                                <div class="pricenew">{if $hpromo->prepaidprice > 1000}{$hpromo->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                {elseif $hpromo->sellprice > 0}
                                                <div class="pricenew">{if $hpromo->sellprice > 1000}{$hpromo->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                {/if}
                                                <div class="salepercent">%</div>
                                            </div>
                                            {/if}	                			  	
                                        </li>       
										{/foreach}
									</ul>
								</div>
							 </div>
							{/if}
                            
                            {/if}             
                            <!--product recommandation-->
                        </div>
                        <!-- the controls -->
                            <div class="m-carousel-controls m-carousel-pagination">
                            <div class="prev"><a href="javascript:void(0)" data-slide="prev">«</a></div>
                            <div class="next"><a href="javascript:void(0)" onclick="clicknext('promo')" data-slide="next">»</a></div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
     <!-- sản phẩm trang chủ -->
    <div class="clear"></div>
    {if !empty($listProductsByCategory)}
	{foreach from=$listProductsByCategory item=category key=categoryid}
	{if !empty($category) && !empty($listCategoriesIcon[$categoryid]) && !empty($listCategories[$categoryid])}	
	<div id="depart">		
		<div class="mobile">
			<div class="titledepart"><span>▼</span>
				<div class="smallnav">
				<ul>										
					{foreach item=subcatedata key=subcateid from=$subcatdatalist[$categoryid]}
						<li><a href="{$subcatedata.link}" title="{$subcatedata.name}">{$subcatedata.name}</a></li>
					{/foreach}            	
				</ul>
				</div>
			</div>
		</div>
		
		<div class="tabscontainer" id="{$listCategoriesIcon[$categoryid].id}">
			<div class="tabs">
                <div class="{cycle values="tagnoeltwo,tagnoelone"}"></div>				
				{foreach from=$category key=subcatid name=subcategorylist item=subcate}
				<div class="tab {if $smarty.foreach.subcategorylist.first}selected{/if}" id="tab_menu_{$smarty.foreach.subcategorylist.index+1}">
					<h2 class="link">{$subcate.category->name}</h2>
				</div>
				{/foreach}
			</div>
			<div class="clear"></div>
			<!-- banner right -->
			<div class="tagrightimg">
				{$blockbannerrightlist[$categoryid]}
			</div>
			
			<!-- content tab -->
			<div class="curvedContainer">
				{foreach from=$category key=subcatid name=subcategorylist item=subcate}
				<div class="tabcontent tab_content_{$smarty.foreach.subcategorylist.index+1} bortoptabs {if $smarty.foreach.subcategorylist.first}display{/if}">
					<div class="m-carousel m-fluid m-carousel-photos m-list-product">
						<!-- the slider -->
						<div class="m-carousel-inner" style="-webkit-transform: translate3d(-985px, 0, 0);">
							<!-- the items -->							
                            {assign var=numrow value=$subcate.products|@count / 4}
							{assign var=numrow value=$numrow|ceil + 1}
							{section name=row loop=$numrow-1 start=0 step=1}							
							<div class="m-item">
								<div class="products">
									<ul>
										{section name=col loop=4 start=0 step=1}
										{assign var=index value=4*$smarty.section.row.index +$smarty.section.col.index}
                                        {assign var=product value=$subcate.products.$index}
										
										{if !empty($product)}
										<li>
                                            {if $listProductColor[$product->id]|count > 1}           
                                                <div class="lg">
                                                    <ul>
                                                        {foreach from=$listProductColor[$product->id] item=productcatlistcolor name=productcatlistcolorname}
                                                            {if $productcatlistcolor[0] > 0}
                                                                 {if $smarty.foreach.productcatlistcolorname.index > 4}{break}{/if}
                                                                <li class="qtooltip"><a class="qtootip" href="{if $productcatlistcolor[4] == 1}{$product->getProductPath()}{else}{$product->getProductPath()}?color={$productcatlistcolor[0]}{/if}" title="{$productcatlistcolor[2]}" style="background:#{$productcatlistcolor[3]}"></a></li>
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
                                            {elseif $hpromo->onsitestatus == $OsDoanGia}<div class="special"><i class="icon-betting"></i></div>
                                            {elseif $product->onsitestatus == $OsNoSell || $product->instock == 0}<div class="special"><i class="icon-theend"></i></div>
                                            {/if}                                            
                                                                                        
                                                                                                                                                                           
											<a class="img_link" href="{$product->getProductPath()}" title="{if !empty($product->seotitle)}{$product->seotitle}{else}{$product->name}{/if}">{if $smarty.section.row.index == 0}<img src="{$product->getSmallImage()}" alt="{$product->name}">{else}<span class="pro_img" rel="{$product->getSmallImage()}" title="{$product->name}"></span>{/if} </a> <a class="position-a" href="{$product->getProductPath()}" title="{if !empty($product->seotitle)}{$product->seotitle}{else}{$product->name}{/if}"><h4>{$product->name}</h4></a>
											<div class="loadprice lp{$product->id}{$product->barcode|trim|substr:-5}" rel="{$product->id}{$product->barcode|trim|substr:-5}">
												{if $product->displaysellprice!=1 && $product->sellprice>0 && $product->onsitestatus == $OsERP && !empty($promotionprices.price) && $promotionprices.price<$product->sellprice}
                                                    
													<div class="pricenew">{if $promotionprices.price > 1000}{$promotionprices.price|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                                    <div class="priceold">{if $product->sellprice > 1000}{$product->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
													{if $product->sellprice > 1000}<div class="th_left">{$product->sellprice|number_format} đ</div>{else}<div class="th_center">{$lang.default.promotionspecial} đ</div>{/if}
												{elseif $product->onsitestatus == $OsERPPrepaid && $product->prepaidstartdate <= $currentTime && $product->prepaidenddate >= $currentTime}
													<div class="pricenew">{if $product->prepaidprice > 1000}{$product->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
												{elseif $product->sellprice >0}
													<div class="pricenew">{if $product->sellprice > 1000}{$product->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
												{/if}
												<div class="salepercent">%</div>
											</div>	
										</li>
										{/if}
										
										{/section}
									</ul>
								</div>
							</div>
							{/section}							
						</div>
						<!-- the controls -->
                        {if $subcate.products|@count > 4}
						<div class="m-carousel-controls m-carousel-pagination">
							<div class="prev"><a href="javascript:void(0)" data-slide="prev">«</a></div>
							<div class="next"><a href="javascript:void(0)" onclick="clicknext('{$listCategoriesIcon[$categoryid].id}')" data-slide="next">»</a></div>
						</div>
                        {/if}
                        <div class="linkmore">
                            <a title="{$subcate.category->name}" href="{$subcate.category->getProductcateoryPath()}">&raquo; Xem thêm sản phẩm {$subcate.category->name}</a>
                        </div><br/><br/>
					</div>
				</div>
				{/foreach}
			</div>
			
			<!-- brand , banner -->		
            <div class="listlogo">	
            {if !empty($blockhomepagelist[$categoryid])}
            {$blockhomepagelist[$categoryid]}
            {/if}
			</div>
		</div>
		
		
	</div>		
	{/if}
	{/foreach}
	{/if}
</div>
<!--trai nghiem, cam nang -->
<div id="experiencehandbook">
    {$experince->content}
    <div class="handbook">
        <div class="titlehandbook">Cẩm nang dienmay.com</div>
        <div class="latesthome-list">
            {if !empty($listnews.normal)}
            <ul>
                {section name=counternews loop=4}
                    {if !empty($listnews.normal[$smarty.section.counternews.index])}
                    <li><a href="{$listnews.normal[$smarty.section.counternews.index]->getNewsPath()}" title="{$listnews.normal[$smarty.section.counternews.index]->title|escape}"><img src="{$listnews.normal[$smarty.section.counternews.index]->getImage()}" alt="{$listnews.normal[$smarty.section.counternews.index]->title|escape}" /></a>
                    <a href="{$listnews.normal[$smarty.section.counternews.index]->getNewsPath()}" title="{$listnews.normal[$smarty.section.counternews.index]->title|escape}">{$listnews.normal[$smarty.section.counternews.index]->title|escape}</a><br />
                    <span>Ngày đăng: {$listnews.normal[$smarty.section.counternews.index]->datecreated|date_format:"%d/%m/%Y %H:%m:%S"}</span>
                    </li>                    
                    {/if}
                {/section}
                <li><a class="seeall" href="{$conf.rooturl}san-pham-cong-nghe" title="Xem tất cả tin công nghệ">Xem tất cả tin công nghệ  ››</a></li>
            </ul>
            {/if}
        </div>
    </div>
</div>
{/strip}
{literal}
    <script type="text/javascript">
    $(document).ready(function(){
        var mySwiper = new Swiper('.swiper-container',{
            pagination: '.pagination',
            loop:true,
            grabCursor: true,
            paginationClickable: true,
            autoplay: 5000,
        })
        $('.arrow-left').on('click', function(e){
            e.preventDefault()
            mySwiper.swipePrev()
        })
        $('.arrow-right').on('click', function(e){
            e.preventDefault()
            mySwiper.swipeNext()
        })
    })
    </script>
{/literal}