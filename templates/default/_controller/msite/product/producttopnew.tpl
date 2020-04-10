{*if !empty($banner)}
<div id="banner">
  {$banner}
</div>
{/if*}

	<div class="colleft">
		{if !empty($listvendors)}
		<div class="colleftbrand">
			<span>Nhà sản xuất</span>
			<ul>
                {if count($listChildCat) == 1}
        			{foreach from =$listvendors[0] item=ven name=vendorlistshow}
		                <li class="{if $smarty.foreach.vendorlistshow.iteration >10}hidden{/if}">
		                	<a href="{$listvendors[2][$smarty.foreach.vendorlistshow.iteration-1]}" title="{$ven}"class =" checkbox-sort {if in_array($listvendors[1][$smarty.foreach.vendorlistshow.iteration-1],explode(',',$smarty.get.vendor)) !== false || ($smarty.get.fvid != "" && $smarty.get.fvid == $listvendors[3][$smarty.foreach.vendorlistshow.iteration-1]) || ($singlevendorname != "" && $singlevendorname == $listvendors[1][$smarty.foreach.vendorlistshow.iteration-1])}active{else}{/if}">{$ven}
		                	</a>
		                </li>
		            {/foreach}
		            {if $smarty.foreach.vendorlistshow.iteration >10 && $smarty.foreach.vendorlistshow.last}
		                <li><a class="subli vendorseemore" href="javascript:void(0)">Xem thêm</a></li>
		            {/if}
        		{elseif !empty($curCategory->id) && !empty($listvendors[$curCategory->id])}
        			{foreach from=$listvendors[$curCategory->id] item=myven name=vendorlistshow}
        				{if !empty($myven->name) && $myven->name !='-'}
        				<li class="{if $smarty.foreach.vendorlistshow.iteration >10}hidden{/if}"><a href="{$myven->getVendorPath($curCategory->id)}" title="{$myven->name}"{if $myVendors->id == $myven->id} class="colorselectedfilter"{/if}>›› {$myven->name} </a></li>
        				{/if}
        			{/foreach}
        			{if $smarty.foreach.vendorlistshow.iteration >10 && $smarty.foreach.vendorlistshow.last}
		                <li><a class="subli vendorseemore" href="javascript:void(0)">Xem thêm</a></li>
		            {/if}
        		{elseif !empty($listvendors)}
        			{foreach from=$listvendors item=myven name=vendorlistshow}
        				{if !empty($myven->name) && $myven->name !='-'}
        				<li class="{if $smarty.foreach.vendorlistshow.iteration >10}hidden{/if}"><a href="{$myven->getVendorPath()}" title="{$myven->name}"{if $myVendors->id == $myven->id} class="colorselectedfilter"{/if}>›› {$myven->name}</a></li>
        				{/if}
        			{/foreach}
        			{if $smarty.foreach.vendorlistshow.iteration >10 && $smarty.foreach.vendorlistshow.last}
		                <li><a class="subli vendorseemore" href="javascript:void(0)">Xem thêm</a></li>
		            {/if}
        		{/if}
            </ul>
        </div>
        {/if}
	    {if !empty($attributeList['LEFT'])}
	    <div class="colleftbrand">
    		<span>Xem theo tiêu chí</span>
		        <ul>
        			{foreach item=attribute from=$attributeList['LEFT'] name=topattributeout}
            			{if $attribute->value|@count > 0}
            				<li>
            					<a href="javascript:void(0)">›› {$attribute->display}</a></li>
            				{if !empty($attribute->value[0])}
		                        {foreach item=attrvalue from=$attribute->value[0] name=attributelistname}                            
		                            {if !empty($attrvalue)}
		                            <li class="{if $smarty.foreach.attributelistname.iteration >10}hidden filter{$smarty.foreach.topattributeout.iteration}{/if}">
		                            	<a class="subli checkbox-sort 
		                            	{if in_array($attribute->value[1][$smarty.foreach.attributelistname.iteration-1],explode(',',$smarty.get.a)) !== false}active{else}{/if}" 
		                            	href=" {if strpos($smarty.get.a,$attribute->value[1][$smarty.foreach.attributelistname.iteration-1]) === false}
		                            		{if !empty($myVendors->name) && !empty($paginateurl)}{$paginateurl}{else}{$curCategory->getProductcateoryPath()}{/if}{if $smarty.get.vendor != ''}?vendor={$smarty.get.vendor}&{else}?{/if}a={$attribute->panameseo},{$attribute->value[1][$smarty.foreach.attributelistname.iteration-1]}{if !empty($attribute->value[2][$smarty.foreach.attributelistname.iteration-1])},{$attribute->value[2][$smarty.foreach.attributelistname.iteration-1]}{/if}
		                            	{else}
		                            		{$attribute->value[3][$smarty.foreach.attributelistname.iteration-1]}
		                            	{/if}" title="{$attrvalue}">{$attrvalue}</a>

		                            </li>
		                            {/if}
		                            {if $smarty.foreach.attributelistname.iteration >10 && $smarty.foreach.attributelistname.last}
		                            	<li><a class="subli filterseemore" href="javascript:void(0)" rel="{$smarty.foreach.topattributeout.iteration}">Xem thêm</a></li>
		                            {/if}
		                        {/foreach}
		                    {/if}
		                {/if}
		            {/foreach}
		        </ul>
	    </div>
	    {/if}
	</div>