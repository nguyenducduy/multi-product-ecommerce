                  {include file="`$smartyControllerContainer`header.tpl"}
                    <div class="list-search">
                    	<h3 class="navh3"><a href="{$conf.rooturl}product-of-the-year">Top sản phẩm của năm - </a><span>{$product->name} </span></h3>
                                               
                        <ul>
                        	<li>
                        	{if !empty($user_profile)}
                            	<div class="p-left">
                                	<div class="ava-review"> <img width="50" src="{$user_profile['avatar']}"></div>
                                    <div class="ct-review">
                                    	<div class="user">{$user_profile['name']}<br><span>đã tham gia viết bài về {$product->name}</span></div>
                                     </div>                               
                                   
                                </div>
                               
                                 <div class="review-review">
                                 {include file="notify.tpl" notifyError=$error notifySuccess=$success}
                                    <form action="" method="post" name="myform" class="form-horizontal">
                                    	<div class="ctrl-form">
                                    	<label class="label-review">Tiêu đề:</label> 
                                        <input name="ftitle" class="input-review">
                                        </div>
                                        <div class="ctrl-form">
                                        <label class="label-review">Nội dung:</label>
                                        <textarea name="fcontent" class="textarea-review"></textarea>
                                        </div>
                                        <div class="ctrl-form">
                                        	<input type="submit" name="fsubmit" class="bt-send" value="Gửi bài viết">
                                            <input type="button" class="bt-cancel" value="Hủy">
                                        </div>
                                        <input type="hidden" name="ftoken" value="{$smarty.session.PostToken}" />
                                    </form>
                                    
                                </div>
                                {else}
                                <div class="review-review">
                                	<h1>Vui lòng đăng nhập để viết bài.</h1>
                                </div>
                                 {/if}
                            </li>
                            
                            
                        </ul>                    
                        
                        
                    </div>
                   {include file="`$smartyControllerContainer`footer.tpl"}