{if $header == ''}
{include file="`$smartyControllerGroupContainer`header.tpl"}
{else}
{$header}
{/if}
{$EventDetail->content}


{literal}
<script type="text/javascript">
  var pid = "{/literal}{$EventDetail->id}{literal}";
 	$(window).load(function(){
  		Number.prototype.toCurrencyString = function() { return Math.floor(this).toLocaleString() + (this % 1).toFixed(0).toLocaleString().replace(/^0/,''); }
		$('.productsegmentprice').each(function(index, el) {
			var pricenew = 0;
			var priceold = 0;
			
			if($(this).find('.pricenew').html() != null){
				pricenew = parseFloat($(this).find('.pricenew').html().replace(/[^0-9.]/g, ""));														
			}			

			if($(this).find('.priceold').html() != null){
				console.log($(this).find('.priceold').html());
				priceold = parseFloat($(this).find('.priceold').html().replace(/[^0-9.]/g, ""));
				var discount = priceold - pricenew;
				console.log(discount);
				$(this).append('<span class="productsegmentolddiscountnum">-'+discount.toCurrencyString()+' đ</span>');
			}	

		});
  	});
</script>
{/literal}

{if $footer == ''}
{include file="`$smartyControllerGroupContainer`footer.tpl"}
{else}
{$footer}
{/if}
