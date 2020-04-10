<link href="{$currentTemplate}css/site/hop-qua-mm.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="{$currentTemplate}js/jquery.min.js"></script>
{literal}
<style type="text/css">
  .clear{clear: both;}
  #sb-container #sb-nav-close{right: 20px;}
  .noi-dung-the-le{padding:10px;font-family:Arial, Helvetica, sans-serif;font-size:12px;line-height:20px;background-color:#fff;}
  .titpop{position: fixed;}
  .popup_auc_1 .cont_auc {display: block;margin: 40px 20px 0px 20px;overflow: hidden;}
  .popup_auc_1 .titpop {background: #00a1e6;font: bold 14px Arial;text-transform: uppercase;color: white;padding: 4px 10px;border-radius: 4px 4px 0 0;width: 96.5%;position: fixed !important;line-height: 30px;}
</style>
{/literal}
{include file="googleanalytic.tpl"}

<div class="popup_auc_1">
  <div class="titpop"><span class="gift-tip"></span>Chọn hộp quà may mắn của bạn</div>
    <div class="popup-gift12">
      <p>Cám ơn bạn đã mua hàng tại <strong>dienmay.com</strong><br>
      <strong>dienmay.com</strong> rất vui được gửi đến bạn món quà tặng ý nghĩa nhân dịp giáng sinh<br><br>
      Vui lòng click vào 1 trong 3 hộp quà dưới đây để chọn món quà như ý!
      </p>
      <input type="hidden" value="{$giftOrder->pricefrom}-{$giftOrder->priceto}" id="priceorder"/>
        <ul>
          {if $giftProduct|count > 0}
            {foreach from=$giftProduct key=key item=giftpro}  
              <li class="quatang" rel="OpenGift{$key+1}">
                <div class="img-gift"></div>
                <span style="cursor:pointer"> Hộp quà {$key+1}</span>
              </li>
            {/foreach}
          {/if}
        </ul>
    </div>
</div>
{literal}
  <script type="text/javascript">
    var rooturl = "{/literal}{$registry->conf.rooturl}{literal}";
    $('.quatang').click(function() {
        var OpenGiftName = $(this).attr('rel');
        var priceorder = $('#priceorder').val();
        _gaq.push(['_trackEvent', 'GiftLucky', OpenGiftName, priceorder]);
        //var product = $('.quatang > span').attr('rel');
        var invoice = "{/literal}{$invoiceid}{literal}";
        $.ajax({
          url: rooturl +'site/cart/updatecheckoutgift',
          type: 'POST',
          dataType: 'html',
          data: {invoicedid: invoice/*,productid:product*/},
          success: function(data) {
              if (data > 0) {
                parent.location.href= rooturl+'site/cart/success?o='+invoice+'&p='+data;
              } else {
                parent.location.href= rooturl+'site/cart/success?o='+invoice;
              }
          }
        });
    });
  </script>
{/literal}
{include file="`$smartyControllerGroupContainer`../analytic.tpl"}