<div id="container"{if !empty($themeEvent->classidentifier)} class="{$themeEvent->classidentifier}"{/if}>
	<div class="pagecont" id="mainpagenew">
		<div class="barpage">
			<h2 class="titlepage">{$EventDetail->title}</h2>
		</div>
	    <div class="pagecontent"{if $EventDetail->blank == 1} style="width: 100%;"{/if}>
	        {$EventDetail->content}
	        
	        <div class="clear" align="center">
	            
	            <!-- Place this tag where you want the +1 button to render. -->
	            <div class="g-plusone" data-size="medium" data-href="{$EventDetail->getPagePath()}"></div>

	            <!-- Place this tag after the last +1 button tag. -->
	            <script type="text/javascript">
	              (function() {
	                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	                po.src = 'https://apis.google.com/js/plusone.js';
	                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	              })();
	            </script>
	            <iframe src="//www.facebook.com/plugins/like.php?href={$EventDetail->getPagePath()|escape}&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
	        </div>

	        {if $keywordList|@count > 0}
	        <!-- tags -->
	        <div id="tag-list">
	          <span>Tags :</span> 
	          {foreach item=mykeyword from=$keywordList name=wordname}
	              <a href="{$mykeyword->getKeywordPath(ispage)}">{$mykeyword->text}</a>
	          {/foreach}
	        </div>
	        {/if}

	           <!-- comment -->
	          <div id="comments" class="wrap-one">
	                    
	          </div>
	    </div>
	    
	</div>

{literal}
<script type="text/javascript">
  var pid = "{/literal}{$EventDetail->id}{literal}";
  var isblank = "{/literal}{$EventDetail->blank}{literal}";
  	$(document).ready(function(){
      	loadpageReview(pid , '');   
      	if(isblank == 1){
      		$('.pageleft').css('display' , 'none');
      		$('.barpage').css('display' , 'none');
      		$('#mainpagenew').css('width' , '100%');
      		$('.specialproductsegment').css('width' , '18.2%');
      	}
  	});
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