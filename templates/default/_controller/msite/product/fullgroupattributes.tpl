 <section>
    	<div class="navibarlist">
        	<ul>
            	 <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ ››</a> </li>
                <li><a href="{$currentCategory->getProductcateoryPath()}" title="{$currentCategory->name}">{$currentCategory->name} ››</a> </li>
                <li><a><span>Thông số kỹ thuật</span></a></li>
            </ul>
        </div>
    	<h1 class="nameproduct">{$productDetail->name}</h1>
        <!-- Thông số kỹ thuật -->    
        <div class="conttable">

    {assign var="parentpromotionprices" value=$productDetail->promotionPrice()}
   
		<div class="conttitle"><div class="back"><a href="{$registry->conf.rooturl}{$currentCategory->slug}/{$productDetail->slug}">&#171;Trở về</a></div>Tính năng sản phẩm</div>
         {if $productGroupAttributes|@count>0 && $productAttributes|@count>0 && $relProductAttributes|@count>0}
            <table cellspacing="0" width="100%" cellpadding="0">
            {foreach item=groupattributes from=$productGroupAttributes}
            {if !empty($productAttributes[$groupattributes->id])}
              <tr>
                <td colspan="2" align="center" class="colspan">{$groupattributes->name}</td>
            </tr>
            
            <tr>
                <td class="generaltd-2">
                    <table width="100%" cellspacing="10" cellpadding="0">
                    {foreach from=$productAttributes[$groupattributes->id] item=attribute name=listproattr}
                        {if !empty($relProductAttributes[$attribute->id][$productDetailId])}
                            <tr>
                                <td width="150">{$attribute->name}</td>
                                <td>{$relProductAttributes[$attribute->id][$productDetailId]->value} {$productAttributes[$groupattributes->id][$attribute->id]->unit}</td>
                              </tr>
                        {/if}
                    {/foreach}
                </table>
                </td>
            </tr>
            {/if}
            {/foreach}
            </table>
        {/if}
		{if $productDetail->onsitestatus != $OsDoanGia}   
        <div style="display:none">
            <div class="areagift" style="display: none;" id="loadpromotionlist">  
            </div>
        </div>
        {if $productDetail->onsitestatus == $OsERPPrepaid && $productDetail->prepaidstartdate <= $currentTime && $productDetail->prepaidenddate >= $currentTime}
                 <div class="btnbuynow">
                  <a href="{$registry->conf.rooturl}cart/dattruoc?id={$productDetail->id}{if !empty($parentpromotionprices.promoid)}&prid={$productDetail->barcode|trim}_{$parentpromotionprices.promoid}{/if}" class="buyprepaid" rel="{$productDetail->id}"{if !empty($parentpromotionprices) && $parentpromotionprices.promoid >0} id="{$productDetail->barcode}_{$parentpromotionprices.promoid}"{/if} title="Đặt hàng trước">Đặt trước &#187;</a>
                </div>
        {elseif $productDetail->instock > 0 && $productDetail->onsitestatus > 0 && $productDetail->sellprice > 0}
               <div class="btnbuynow"><a onclick="eventclick('event', 'button_buynow_detail','click','button_buynow_detail','{if !empty($listprices.online) && $listprices.online > 1000}{(float)$listprices.online}{elseif !empty($listprices.offline) && $listprices.offline > 1000}{(float)$listprices.offline}{elseif  $productDetail->sellprice > 1000}{(float)$productDetail->sellprice}{else}{$lang.default.promotionspecial}{/if}');" href="{$conf.rooturl}cart/{if $productDetail->slug != ""}mua-{$productDetail->slug}{else}checkout?id={$productDetail->id}{/if}{if !empty($parentpromotionprices.promoid)}{if $productDetail->slug != ""}?{else}&{/if}prid={$productDetail->barcode|trim}_{$parentpromotionprices.promoid}{/if}{if !empty($parentpromotionprices.promoid) && $productDetail->slug != ""}&{else}?{/if}po=p{substr($productDetail->barcode|trim, -5, 5)}41" title="Mua ngay" id="buyonline"> Mua ngay &#187;</a></div>
        {elseif $productDetail->onsitestatus == $OsCommingSoon}
              <!-- COMMING SOON -->
              <div class="btnbuynow"><a href="#">Comming Soon</a></div>
        {else}
            <div class="btnbuynow"><a href="#">Hết hàng</a></div>
            <!-- HET HANG -->

        {/if}
    	  
        <div class="callme">Hoặc gọi cho chúng tôi: <a href="tel:+19001883" style="text-decoration: none"><strong>1900 1883</strong></a></div>
        <div class="back-bottom" style=" margin-bottom: 10px; margin-left: 20px;"><a href="{$registry->conf.rooturl}{$currentCategory->slug}/{$productDetail->slug}" style="text-decoration: none;
color: #fff;
background: #00a1e6;
padding: 10px 20px;
border-radius: 5px;">&#171;Trở về</a>
    </div>       
     {/if}   
</section>
{literal}
<script type="text/javascript">
var fpcid = "{/literal}{$productDetail->pcid}{literal}";
var pid = "{/literal}{$productDetail->id}{literal}";
var fgpa = "{/literal}{$gpa}{literal}";
var fpa = "{/literal}{$pa}{literal}";
var prel = "{/literal}{$prel}{literal}";
</script>
{/literal}