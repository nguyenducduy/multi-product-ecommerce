<style type="text/css">
    .priceold{
        position: relative;
    }
</style>
<div class="navbarprod">
    <ul>
        <li><a title="dienmay.com" href="#">Trang chủ</a> ››</li>
        {foreach item=productcategory from=$parentcatlist name=foo}
            {if $smarty.foreach.foo.last}
            <li>{$productcategory.pc_name}</li>
            {else}
            <li><a href="{$productcategory.fullpath}">{$productcategory.pc_name}</a> ››</li>
            {/if}
        {/foreach}
        <li class="lastitem">Tư vấn mua hàng <span>1900 1883</span> hoặc <span>(08) 39.48.6789</span></li>
    </ul>

</div>
<div id="container">
    <div class="rowsp menustick">
        <ul>
            {if $compareProductList|@count < 4}
            <li>
                <div class="compadd"><span>+</span><input class="compinput" id="fsitecompare" name="q" type="text" placeholder="Nhập tên sản phẩm cần so sánh" onkeypress="doSitebooksearchtextpress(event)" /></div>
            </li>
             {/if}
            {if $compareProductList|@count > 0}
            {foreach item=compareProduct from=$compareProductList}
            <li>
                <div class="delsp"><a href="javascript:void(0)" onclick="closecompares({$compareProduct->id} , {$compareProductList|@count})" title="Xóa sản phẩm"><i class="icon-delete"></i></a></div>
                <a target="_blank" href="{$compareProduct->getProductPath()}"><img src="{$compareProduct->getSmallImage()}" alt="{$compareProduct->name}" title="{$compareProduct->name}"></a>
                <div class="marrowsp">
                    <a target="_blank" href="{$compareProduct->getProductPath()}">{$compareProduct->name}</a>
                    {assign var="promotionprices" value=$compareProduct->promotionPrice()}
                    <div rel="{$compareProduct->id}{$compareProduct->barcode|trim|substr:-5}" class="loadprice lp{$compareProduct->id}{$compareProduct->barcode|trim|substr:-5}">
                        <div class="pricenew pricomp-1" style="position: relative; bottom:0"></div>
                   </div>
                </div>
                {assign var="pid" value=$compareProduct->id}
               
                {if $promotionList.$pid|@count > 0 && $promotionList.$pid[0]->description != '.'}
                <div class="comp-promot">
                    <div class="comp-promottext"><i class="icon-gift"></i></div>
                    <div class="comp-promotdes">
                        {foreach item=promotion from=$promotionList.$pid}
                            {if $promotion->descriptionclone != ""}
                                <div class="promotdes">- {$promotion->descriptionclone}.</div>
                            {else}
                                <div class="promotdes">- {$promotion->description}.</div>
                            {/if}
                        {/foreach}
                    </div>
                </div>
                {/if}
            </li>
            {/foreach}
            {/if}
        </ul>
    </div>
    <div class="rownd">
        <div class="contleft">
            {foreach item=groupattr from=$productGroupAttributeList name=foo}
            <div class="rowcont {if $smarty.foreach.foo.index % 2 != 0}gray{/if}">
                <p>{$groupattr->name}</p>

                {foreach item=list from=$productAttributeList name=cp}
                    {if $smarty.foreach.cp.first}
                 <div class="colcont bordot">
                        <ul>
                            {foreach item=attrs key=pgaid from=$list}
                                {if $pgaid == $groupattr->id}
                                {foreach item=attr from=$attrs}
                                    {if $attr->value != ''}
                                    <li>{$attr->name} : </li>
                                    {/if}
                                {/foreach}
                                {/if}
                            {/foreach}
                        </ul>
                    </div>
                    {/if}
                {/foreach}

                {foreach item=list from=$productAttributeList name=cp}
                <div class="colcont {if !$smarty.foreach.cp.last}bordot{/if}">
                    <ul>
                    {foreach item=attrs key=pgaid from=$list}
                    {if $pgaid == $groupattr->id}
                        {foreach item=attr from=$attrs}
                            {if $attr->value != ''}
                                <li>{$attr->value} </li>
                            {else}
                                <li>-</li>
                            {/if}
                        {/foreach}
                        {/if}
                    {/foreach}
                    </ul>
                </div>
                {/foreach}

             </div>

        {/foreach}
        </div>
    </div>
</div>
{literal}
<script type="text/javascript">
var step = {/literal}{$stepdate}{literal}
$(document).ready(function(){
    $('.comp-promot').css('width' , 285);
});
function closecompares(pid , number)
{
  if(pid > 0)
  {
    var newnumber = number -1;
    var datastring = 'pid='+pid;
    $.ajax({
      type : "post",
      dataType : "html",
      url : "/site/productcompare/removeproductajax",
      data : datastring,
      success : function(html){
        if(html == 'success')
        {
          // $('#p'+pid).remove();
          // $('.wi-'+number+'sp').removeClass('wi-'+number+'sp').addClass('wi-'+newnumber+'sp');
            //location.reload();
            window.location = rooturl + 'productcompare';
        }
      }
    });
  }
}
</script>
{/literal}