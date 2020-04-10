<h3>Danh sách sản phẩm đồng giá 29.000đ được bán ngẫu nhiên từ 8h đến 20h ngày 2/9/2013 tại dienmay.com</h3>
    <ul>
     {foreach from=$listproduct name=listproduct item=product}
    	<!-- Đang bán -->
	    {if $product->status == 3}
	    	<li class="trt1">
	        <div class="selling29">Đang bán</div>
	        <div class="buy29"><a class="inline291" href="#inline_content291">Mua ngay</a></div>
	        <a href="javascript:;"><img src="{$product->images}" title="{$product->name}" alt="{$product->name}" /></a>
	        <a href="javascript:;" title="{$product->name}">{$product->name}</a>
	        <div class="price29b bortop291">Giá thị trường: <strong>{$product->currentprice|number_format}đ</strong></div>
	        <div class="price29n">Giá bán tại dienmay.com ngày 02/09: <strong class="pricetrt1">{$product->discountprice|number_format}đ</strong></div>
	        </li>
	    {elseif ($product->status == 1)}
		    <!-- Đã bán -->
	        <li class="trt2">
	        <div class="selled29">Đã bán</div>
	        <div class="infoselled29">
	        	{if !empty($product->customerwinner)}            	
	        	<p>Khách hàng may mắn thứ 29 được mua sản phẩm với giá 29.000đ<br />
	             	{$product->customerwinner->fullname} <br />
	                Số ĐT: {$product->customerwinner->phone}<br />
	                Email: {$product->customerwinner->email}
	            </p>
	            <a class="inline292" href="#inline_content292">Danh sách khách hàng tham gia mua sản phẩm</a>
	            {/if}
	        </div>
	        <a href="javascript:;"><img src="{$product->images}" title="{$product->name}" alt="{$product->name}" /></a>
	        <a href="javascript:;" title="{$product->name}">{$product->name}</a>
	        <div class="price29b bortop292">Giá thị trường: <strong>{$product->currentprice|number_format}đ</strong></div>
	        <div class="price29n">Giá bán tại dienmay.com ngày 02/09: <strong class="pricetrt1">{$product->discountprice|number_format}đ</strong></div>
	        </li>
        {else}
        <!-- Chờ bán -->
        <li>
        <a href="javascript:;"><img src="{$product->images}" title="{$product->name}" alt="{$product->name}" /></a>
	    <a href="javascript:;" title="{$product->name}">{$product->name}</a>
        <div class="price29b">Giá thị trường: <strong>{$product->currentprice|number_format}đ</strong></div>
        <div class="price29n">Giá bán tại dienmay.com ngày 02/09: <strong class="pricetrt1">{$product->discountprice|number_format}đ</strong></div>
	        </li>
         {/if}
        {/foreach}
    </ul>