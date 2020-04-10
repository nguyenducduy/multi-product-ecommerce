{if !empty($fullPathCategory)}
<ul class="navbarprod">
    <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ</a> ››</li>
  <li>{$pageDetail->name}</li>
</ul>
{/if}

<div id="container"{if !empty($themePage->classidentifier)} class="{$themePage->classidentifier}"{/if}>
	<div class="pageleft">
		<div class="pagedepart">
    		<span>Hỗ trợ khách hàng</span>
	        <ul>
        		<li><a href="{$conf.rooturl}gioi-thieu-ve-dienmaycom" title="Giới thiệu">Giới thiệu</a></li>
	            <li><a href="{$conf.rooturl}huong-dan-mua-online" title="Hướng dẫn mua hàng online">Hướng dẫn mua hàng online</a></li>
	            <li><a href="{$conf.rooturl}huong-dan-mua-tra-gop-tai-dienmaycom" title="Hướng dẫn mua trả góp">Hướng dẫn mua trả góp</a></li>
	            <li><a href="{$conf.rooturl}bao-hanh-doi-tra" title="Bảo hành đổi trả">Bảo hành đổi trả</a></li>
	            <li><a href="{$conf.rooturl}account/checksaleorder" title="Kiểm tra đơn hàng">Kiểm tra đơn hàng</a></li>
	            <li><a href="{$conf.rooturl}danh-cho-doanh-nghiep" title="Dành cho doanh nghiệp">Dành cho doanh nghiệp</a></li>
	            <li><a href="{$conf.rooturl}vip" title="Thành viên VIP">Thành viên VIP</a></li>
	            <li><a href="{$conf.rooturl}chinh-sach-giao-hang-lap-dat-50-km" title="Chính sách giao hàng">Chính sách giao hàng</a></li>
	            <li><a href="{$conf.rooturl}tuyendung" title="Tuyển dụng">Tuyển dụng</a></li>
	        </ul>
	    </div>
	    
	</div>
	<div class="pagecont" id="mainpagenew">
		<div class="barpage">
			<h2 class="titlepage">{$pageDetail->title}</h2>
		</div>
	    <div class="pagecontent"{if $pageDetail->blank == 1} style="width: 100%;"{/if}>
	        {$pageDetail->content}
	        
	        <div class="clear" align="center">
	            
	            <!-- Place this tag where you want the +1 button to render. -->
	            <div class="g-plusone" data-size="medium" data-href="{$pageDetail->getPagePath()}"></div>

	            <!-- Place this tag after the last +1 button tag. -->
	            <script type="text/javascript">
	              (function() {
	                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	                po.src = 'https://apis.google.com/js/plusone.js';
	                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	              })();
	            </script>
	            <iframe src="//www.facebook.com/plugins/like.php?href={$pageDetail->getPagePath()|escape}&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
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
	    {*if $pageDetail->blank != 1}
	    <div class="page_right">
	        {if !empty($barnerPage)}
	            {foreach item=barner from=$barnerPage}
	                <p>
	                    <a href="{$barner->getAdsPath()}" title="{$barner->title}">
	                        <img src="{$barner->getImage()}" width="320" alt="{$barner->title}" title = "{$barner->title}" border="0"/>
	                    </a>
	                </p>
	            {/foreach}
	        {/if}
	        <!--banner 320x250px-->
	    </div>
	    {/if*}
	</div>

{literal}
<script type="text/javascript">
  var pid = "{/literal}{$pageDetail->id}{literal}";
  var isblank = "{/literal}{$pageDetail->blank}{literal}";
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