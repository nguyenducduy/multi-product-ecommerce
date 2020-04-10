<!-- Content -->
    <section>
    	<div class="navibarlist">
        	<ul>
            	{foreach from=$fullPathCategory item=fcat}
            	<li><a href="{$fcat['fullpath']}" title="{$fcat['pc_name']|escape}">{$fcat['pc_name']} »</a></li>
            	{/foreach}
                <li>
                {if isset($smarty.get.fvid) || isset($smarty.get.vendor) || isset($smarty.get.a)}
                <a href="{$curCategory->getProductcateoryPath()}" title="{$curCategory->name|escape}">{$curCategory->name} »</a>
                {else}
        			{$curCategory->name}
        		{/if}{if !empty($myVendors->name)}{/if}
                </li>
            </ul>
        </div>
    	<div class="filter">
        	<div class="filtertop">
            	<div class="btnback"><a href="listproduct.html">Trở về</a></div>
                <h3>Xem theo tiêu chí</h3>
            </div>
            <div class="filterrow"><input class="checkbox" name="" type="checkbox" value=""><label>Chỉ hiển thị những sản phẩm có khuyến mãi (Giảm giá hoặc tặng quà)</label></div>
            <!-- list filter -->
            <div class="listfilter">
            	<div class="viewfilter"><a href="listproduct.html">Xem</a></div>

                {foreach from=$listChildCat item=fcat name=topsubcat}
        		{if $smarty.foreach.topsubcat.iteration == 1}{continue}{/if}
        			<h3>Tất cả {$fcat->name}</h3>
        		{if !empty($listvendors)}
        			{if !empty($listvendors[$fcat->id])}
        				{foreach from=$listvendors[$fcat->id] item=myven name=vendorlistshow}
        					{if !empty($myven->name) && $myven->name !='-'}
        					
        					 <div class="filterrow bgwhite"><a class="subli{if $myVendors->id == $myven->id} colorselectedfilter{/if}" href="{$myven->getVendorPath($fcat->id)}" title="{$myven->name|escape}"><label>{*$fcat->name*}{$myven->name}</label></a></div>
        					{/if}
        				{/foreach}
        			{/if}
        		{/if}	            
	            {/foreach}
                
               
            </div>
        </div>
    </section>
<!-- End content -->