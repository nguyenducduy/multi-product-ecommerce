      {include file="`$smartyControllerContainer`header.tpl"}
<div class="list-search">
                    	<h3 class="navh3"><a href="{$conf.rooturl}product-of-the-year">Top sản phẩm của năm - </a><span><a href="{$conf.rooturl}product-of-the-year/san-pham/{$article->pid}">{$article->productname}</a></span></h3>
                                               
                        <ul>
                        	<li>
                            	<div class="p-left">
                                	<div class="ava-review"> <img src="{$article->avatar}"></div>
                                    <div class="ct-review">
                                    	<div class="user">{$article->actor} <br><span>đã tham gia viết bài về {$article->productname}</span></div>
                                     </div>                               
                                   
                                </div>
                                <div class="p-right">
                                	<div class="box-w">
                                    	<div class="point">{$article->point} </div>
                                        <div class="point-text"> điểm</div>
                                    </div>
                                </div>
                                 <div class="review-review">
                                        <span><b>{$article->title}</b></span>
                                        <p>{$article->content}</p>
                                    
                                   <div class="label-like"><iframe src="https://www.facebook.com/plugins/like.php?href={$article->slug}&colorscheme=light&layout=button_count&action=like&show_faces=true&send=true" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:140px; height:21px; float:left" class="likepage"></iframe></div>
                                   <div class="label-like"><g:plusone data-href="{$article->slug}" size='medium'></g:plusone></div>
<!--                                   <div class="label-invite">Số bạn đã mời</div>-->
                                    <div class="bt-back"><a href="{$conf.rooturl}productyear/detail?id={$article->pid}"> Quay về</a></div>
                                </div>
                                
                                <div class="fb-comments" width="865" data-href="{$article->slug}" data-numposts="5" data-colorscheme="light"></div>                 
                            </li>
                            
                            
                        </ul>   
                        
                        
                        
                        
                    </div>
                    {include file="`$smartyControllerContainer`footer.tpl"}