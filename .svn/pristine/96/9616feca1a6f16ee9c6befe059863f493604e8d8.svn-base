      {include file="`$smartyControllerContainer`header.tpl"}
        <div class="list-detail">
                    	<h3 class="navh3"><a href="{$conf.rooturl}product-of-the-year">Top sản phẩm của năm - </a><span><a href="{$conf.rooturl}product-of-the-year/san-pham/{$productDetail->id}">{$productDetail->name}</a></span></h3>
                        <div class="prodetail">
                        	<div class="left-slide">
                        	      <div class="head-left">
							          <div id="zoomslide">
							              {if !empty($galleries)}
							                  {foreach from=$galleries item=gal name=listgallery}
							                      {if $smarty.foreach.listgallery.iteration==2}{break}{/if}
							                      <div class="fixzoom">
							                        <img data-zoom-image="{$gal->getImage()}" src="{if $gal->checkimagevalid($gal->getMediumImage()) == true}{$gal->getMediumImage()}{else}{$gal->getImage()}{/if}" alt="{if !empty($gal->alt)}{$gal->alt}{else}{$gal->alt}{/if}" id="zoom">
							                      </div>
							                  {/foreach}
							                <div id="zoomslides">
							                   {if count($galleries360) >= 36 && !empty($videos)}
							                      {capture assign=numberslider}{4}{/capture}
							                   {else}
							                      {if count($galleries360) >= 36 || !empty($videos)}
							                        {capture assign=numberslider}{5}{/capture}
							                      {else}
							                          {capture assign=numberslider}{6}{/capture}
							                    {/if}
							                  {/if}
							                  {foreach from=$galleries item=gal key=key name=listgallery}
							                      {if $smarty.foreach.listgallery.iteration== $numberslider}{break}{/if}
							                    <a data-zoom-image="{$gal->getImage()}" data-image="{if $gal->checkimagevalid($gal->getMediumImage()) == true}{$gal->getMediumImage()}{else}{$gal->getImage()}{/if}" data-update="" class="elevatezoom-gallery  {if $smarty.foreach.listgallery.iteration==1}active{/if} withumb_{$key}" >
							                      <img class="withumb" src="{$gal->getSmallImage()}" onclick="clickimage(this)" alt="{if !empty($gal->alt)}{$gal->alt}{else}{$gal->alt}{/if}">
							                    </a>
							                  {/foreach}
							                </div>
							                {elseif $productDetail->getImage()!=''}
							                    <div class="fixzoom">
							                      <img data-zoom-image="{$productDetail->getImage()}" src="{$productDetail->getImage()}" id="zoom" >
							                    </div>
							                     <a data-zoom-image="{$productDetail->getImage()}" data-image="{$productDetail->getImage()}" data-update="" class="elevatezoom-gallery  active withumb_0" >
							                      <img class="withumb" src="{$productDetail->getImage()}" onclick="clickimage(this)" alt="{$productDetail->name}">
							                    </a>
							                {/if}
							            </div>
							             <!-- load video -->
							            {if count($galleries360) > 0 || !empty($videos)}
							              {if !empty($videos)}
							                <div id="videothumb"><a style="cursor:pointer">
							                  <span class="iconvideoyoutube"></span>
							                  <img src="http://img.youtube.com/vi/{$videos[0]->youtubeid}/default.jpg" alt="{$productDetail->name}"/></a>
							                </div>
							              {/if}
							              <!-- load hình xoay 360 -->
							              {if count($galleries360) >= 36}
							                <div id="360thumb" class="i360thumb"><a style="cursor:pointer"><i class="icon-img360"></i></a></div>
							              {/if}
							            {/if}
							          <div class="clear"></div>
							      </div>
                        	
                        	
                        	
                        	</div>
                            <div class="right-detail">
                            	<div class="title-detail">
                                	<div class="title-pro-detail">{$productDetail->name}</div>
                                	<div class="box-r">{$productDetail->totalarticle}<span> Bài viết</span>
                                    	
                                    
                                    </div>
                                </div>
                               
                               {if $productDetail->summarynew != ''}
		                            <ul>
		                                {foreach from=$productDetail->summarynew item=summary name=summaryname}
		                                  {if $smarty.foreach.summaryname.iteration == 6}
		                                    {break}
		                                  {/if}
		                                  {if $summary != ""}
		                                    <li>{$summary}</li>
		                                  {/if}
		                                {/foreach}
		                            </ul>
		                          {/if}
                               
                               {if !empty($articles_point)}
                                <div class="bestcore">
                              	<div class="l-core">
                                	<span class="text-333">Bài viết có số điểm cao nhất:</span>
                                    <div class="ava-login"><img src="{$articles_point->avatar}"></div>
                                    <div style="margin-left: 56px;" class="user">{$articles_point->actor}</div>
                                    
                                </div>
                                <div class="r-core">
                                	 
                                     <div class="box-w">
                                            <div class="point">{$articles_point->point} </div>
                                            <div class="point-text"> điểm</div> 
                                            <a href="">
                                            	 <div class="tooltip-score"><i></i>Đây chỉ là 70% số điểm</div>
                                            </a>
                                    </div> 
                                   
                                    
                                </div>
                                <div class="text-blue-s">{$articles_point->title}</div>
                                
                              </div>
                              {/if}
                              	<div class="clear"></div>
                                <div class="button-blue"><a title="Tham gia viết bài" href="{$conf.rooturl}productyear/post?id={$productDetail->id}">Tham gia viết bài</a></div>
                            </div>                        
                              
                        </div>
                        
                    </div>
                     
                     <div class="list-search">
                     {if !empty($listarticle)}
<!--                     	<div class="pager">-->
<!--                          -->
<!--                          <div class="filter">-->
<!--                              <label class="label-filter"> Sắp xếp theo</label>-->
<!--                              <select class="select-filter">-->
<!--                                  <option>Xem Nhiều</option>-->
<!--                                  <option>Mới Nhất</option>-->
<!--                                  <option>Mua Nhiều</option>-->
<!--                              </select>-->
<!--                          </div>-->
<!--                         </div>-->
                       
                        <ul>
                        {foreach item="article" from="$listarticle"}
                        	<li>
                            	<div class="p-left">
                                	<div style="border: 1px solid #ddd;" class="ava-review"> <img src="{$article->avatar}"></div>
                                    <div class="ct-review">
                                    	<div class="user">{$article->actor} <span>đã tham gia viết bài {$productDetail->name}</span></div>
                                        <div class="nd-review">
                                        	<a href="{$article->slug}" title="{$article->title}"><span><b>{$article->title}</b></span></a>
                                            <p>
                                            	{$article->content}
                                            </p>
                                        </div>
                                        <div class="label-like"><div style="margin-right: 10px;" class="fb-like" data-href="{$article->slug}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                                        </div>
                                        <div class="label-like"><g:plusone href="{$article->slug}" size='medium'></g:plusone></div>
<!--                                        <div class="label-invite">Số bạn đã mời</div>-->
                                    </div>
                                </div>
                                <div class="p-right">
                                	<div class="box-w">
                                    	<div class="point">{$article->point} </div>
                                        <div class="point-text"> điểm</div>
                                    </div>
                                </div>
                            </li>
                        {/foreach}
                        </ul>
                        
                  
                        {else}
                        <div class="pager">
							<p style="padding-left: 10px;">Chưa có bài viết cho sản phẩm này.</p>
                         </div>
                        {/if}
                        
                    </div>
                    
                    {literal}
<script type="text/javascript">
  var fpcid = "{/literal}{$productDetail->pcid}{literal}";
  var pid = "{/literal}{$productDetail->id}{literal}";
  var image360path = "{/literal}{$pathimage360}{literal}";
  var countimagepath = "{/literal}{count($galleries360)}{literal}";
  if($('#360thumb').length > 0) {
    var framess = [];
    for(var i = 1 ; i<=countimagepath ; i++)
    {
        framess.push(image360path.replace('#',i));
    }
  }
  $(document).ready(function(){

      $('.cell360px').bind('click',function(event) {
          $('#360sprite').addClass('loadingframe');
          $('.slider > img').css('display','none');
          $('.actived').removeClass('actived');
          $(this).addClass('actived');
          $('#360frames').remove();
          var doubleslider = $('.doubleSlider-1');
          doubleslider.prepend('<div id="360frames"></div>');
          xoay360(framess);
          $('.loadingframe').removeClass('loadingframe');
      });
      $('.thumnail > img').click(function(event) {
        $('.slider > img').css('display','block');
          $('#360frames').remove();
      });
      $('#360thumb a').bind("click",function(){
          $('.active').removeClass('active');
          $(this).parent().addClass('active');
          $('#zoomslide > .fixzoom ').css("display","none");
          if($('#zoomslide .fixzoomvideo > iframe').length > 0)
              $('#zoomslide .fixzoomvideo').remove();
          if($('#360sprite').length > 0)
              $('#360sprite').remove();
          $('#zoomslide').prepend('<div id="360sprite" class="image360">');
          $('.zoomContainer').css("display","none");
          xoay360thumb(framess);
      });
      $('#videothumb a').bind('click',function() {
          $('.active').removeClass('active');
          $(this).parent().addClass('active');
          $('#zoomslide > .fixzoom').css("display","none");
          if($('#360sprite').length > 0)
              $('#360sprite').remove();
          if($('#zoomslide .fixzoomvideo > iframe').length > 0)
              $('#zoomslide .fixzoomvideo').remove();
          var url = $('.contentvideo').val();
          $('#zoomslide').prepend('<div class="fixzoomvideo"><iframe width="400" height="380" frameborder="0" allowfullscreen="" src="'+url+'"></iframe></div>');
          $('.zoomContainer').css("display","none");
      });

      $('#fcitydetail').change(function(){
        $.post(rooturl + '', {rid: $(this).val()}, function(){

        });
      });
  });
  setTimeout(addfullsumary,1000);
  function addfullsumary()
  {
    $('.articlesdetail .main .scroll-nav .scroll-nav__wrapper li:last-child a').attr('href','javascript:void(0)');
    $('.articlesdetail .main .scroll-nav .scroll-nav__wrapper li:last-child a').attr('onclick','readfullsumary()');
  }

  



</script>
{/literal}
          
    {include file="`$smartyControllerContainer`footer.tpl"}