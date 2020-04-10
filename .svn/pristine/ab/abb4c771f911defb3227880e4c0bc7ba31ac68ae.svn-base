<a class="first-child" href="#"><i class="icon-cartnew"></i>Giỏ hàng <span class="numbercartnew">({$totalproduct})</span> <span class="arrheadnav"></span></a>
            	<div class="subnavhead">
                	<span class="arrsubnav arrcart2"></span>
                	{if !empty($cartItems)}
                    <ul>
                      {foreach from=$cartItems item=item}
                        <li>
                        	<div class="removecart"><a href="{$conf.rooturl}cart/checkout/?deleteid={$item->product->id}" title="Xóa">X</a></div>
                        	<a href="{$item->product->getProductPath()}"><img src="{$item->product->getSmallImage()}" title="{$item->product->name}" alt="{$item->product->name}" /></a>
                            <a class="cuttext" href="{$item->product->getProductPath()}" title="{$item->product->name}">{$item->product->name}</a>
                            
                            <span>Số lượng: <span class="redhead">{$item->quantity}</span></span>
                            <span>Giá: <span class="redhead">{$item->pricesell|number_format}đ</span></span>
                        </li>
                        {/foreach}
                      <li class="cartsum">
                        	<span class="sumsum">Tổng: <strong>{$cartpricetotal|number_format}đ</strong></span>
                            <a href="{$conf.rooturl}cart/checkout" id="paymenttop" rel="nofollow"><span class="btnbuynew">Thanh toán</span></a>
                        </li>
                        
                    </ul>
                    {else}
                     <ul>
                        <li>
                        	Chưa có sản phẩm nào trong giỏ hàng của bạn.
                        </li>
                         
                    </ul>
                    {/if}
                </div>