{strip}
	<div class="colleft">
		<div class="colleftbrand">
    		<h3 class="titlenav">{$fullPathCategory[0]['pc_name']|escape}</h3>
	        <ul style="max-height: none;">        	
        		{foreach from=$allChildCategory item=fcat name=topsubcat}
        			<li><a {if $fpcid == $fcat->id} class="active" {/if} href="{$fcat->getProductcateoryPath()}" title="{$fcat->name|escape}">{$fcat->name}</a></li>
        	        {if $fpcid == $fcat->id || $fcat->parentcurrent == $fcat->id}
        	        	{foreach from=$fcat->subsubcate item=fsubcate name=subsubcat}

        	        	<li><a class="subli {if $fpcid == $fsubcate->id} active {/if}" href="{$fsubcate->getProductcateoryPath()}" title="{$fsubcate->name|escape}"><sup style="font-size: 8px">|_</sup> {$fsubcate->name}</a></li>
        	        	{/foreach}
        	        {/if}
	            {/foreach}
	            {$fullPathCategory[0]['pc_categoryreference']}
	        </ul>
	    </div>
	    {if count($arrVendorselect) > 0 || !empty($smarty.get.a)}
	    <div class="colleftbrand"> <h3>Bộ lọc hiện tại</h3>
		
		    <ul>
		    {foreach from =$arrVendorselect item=vendorselect name=vendor}
	        	{foreach from =$listvendors[0] item=ven name=vendorlistshow}
	        		{if $listvendors[1][$smarty.foreach.vendorlistshow.iteration-1] == $vendorselect}
	                <li><a class="subli" title="{$ven}" href="javascript:;">{$ven}</a>
			      	  <div class="clearfilter"><a title="Xóa" href="{$listvendors[2][$smarty.foreach.vendorlistshow.iteration-1]}">&#215;</a></div>
			      	</li>
			      	{/if}
	            {/foreach}
            {/foreach}
            
            	    {if !empty($attributeList['LEFT'])}
        			{foreach item=attribute from=$attributeList['LEFT'] name=topattributeout}
            			{if $attribute->value|@count > 0}
            				{if !empty($attribute->value[0])}
		                        {foreach item=attrvalue from=$attribute->value[0] name=attributelistname}                            
		                            {if !empty($attrvalue)}
			                            {if in_array($attribute->value[1][$smarty.foreach.attributelistname.iteration-1],explode(',',$smarty.get.a)) !== false}
				                            
				                             <li><a class="subli" title="{$attrvalue|trim}" href="javascript:;">{$attrvalue|trim}</a>
										      	  <div class="clearfilter"><a title="Xóa" href="{if strpos($smarty.get.a,$attribute->value[1][$smarty.foreach.attributelistname.iteration-1]) === false}{if !empty($myVendors->name) && !empty($paginateurl)}{$paginateurl|trim}{else}{$curCategory->getProductcateoryPath()}{/if}{if $smarty.get.vendor != ''}?vendor={$smarty.get.vendor|trim}&{else}?{/if}a={$attribute->panameseo|trim},{$attribute->value[1][$smarty.foreach.attributelistname.iteration-1]|trim}{if !empty($attribute->value[2][$smarty.foreach.attributelistname.iteration-1])},{$attribute->value[2][$smarty.foreach.attributelistname.iteration-1]|trim}{/if}{else}{$attribute->value[3][$smarty.foreach.attributelistname.iteration-1]|trim}{/if}">&#215;</a></div>
										     </li>
			                            {/if}
		                            {/if}
		                        {/foreach}
		                    {/if}
		         
		                {/if}
		            {/foreach}
	    		{/if}
	    
	       
		    </ul>
		  </div>
		  {/if}
		{if !empty($listvendors)}
		<div class="colleftbrand">
			<h3>Nhà sản xuất</h3>
			<ul>
                {if count($listChildCat) == 1 || count($listChildCat) > 1}
        			{foreach from =$listvendors[0] item=ven name=vendorlistshow}
		                <li class="{if $smarty.foreach.vendorlistshow.iteration >10}hidden{/if}">
		                	<a href="{$listvendors[2][$smarty.foreach.vendorlistshow.iteration-1]}" title="{$ven}" class ="subli checkbox-sort {if in_array($listvendors[1][$smarty.foreach.vendorlistshow.iteration-1],explode(',',$smarty.get.vendor)) !== false || ($smarty.get.fvid != "" && $smarty.get.fvid == $listvendors[3][$smarty.foreach.vendorlistshow.iteration-1]) || ($singlevendorname != "" && $singlevendorname == $listvendors[1][$smarty.foreach.vendorlistshow.iteration-1])}active{else}{/if}">{$ven}
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
        			{foreach item=attribute from=$attributeList['LEFT'] name=topattributeout}
            			{if $attribute->value|@count > 0}
            		<div class="colleftbrand">
            			<h3>{$attribute->display}</h3>
		       				<ul>
            				{if !empty($attribute->value[0])}
		                        {foreach item=attrvalue from=$attribute->value[0] name=attributelistname}                            
		                            {if !empty($attrvalue)}
		                            <li class="{if $smarty.foreach.attributelistname.iteration >10}hidden filter{$smarty.foreach.topattributeout.iteration}{/if}">
		                            	<a class="subli checkbox-sort {if in_array($attribute->value[1][$smarty.foreach.attributelistname.iteration-1],explode(',',$smarty.get.a)) !== false}active{else}{/if}" href="{if strpos($smarty.get.a,$attribute->value[1][$smarty.foreach.attributelistname.iteration-1]) === false}{if !empty($myVendors->name) && !empty($paginateurl)}{$paginateurl|trim}{else}{$curCategory->getProductcateoryPath()}{/if}{if $smarty.get.vendor != ''}?vendor={$smarty.get.vendor|trim}&{else}?{/if}a={$attribute->panameseo|trim},{$attribute->value[1][$smarty.foreach.attributelistname.iteration-1]|trim}{if !empty($attribute->value[2][$smarty.foreach.attributelistname.iteration-1])},{$attribute->value[2][$smarty.foreach.attributelistname.iteration-1]|trim}{/if}{else}{$attribute->value[3][$smarty.foreach.attributelistname.iteration-1]|trim}{/if}" title="{$attrvalue|trim}">{$attrvalue|trim}</a>
		                            </li>
		                            {/if}
		                            {if $smarty.foreach.attributelistname.iteration >10 && $smarty.foreach.attributelistname.last}
		                            	<li><a class="subli filterseemore" href="javascript:void(0)" rel="{$smarty.foreach.topattributeout.iteration}">Xem thêm</a></li>
		                            {/if}
		                        {/foreach}
		                    {/if}
		                   </ul>
		               		   
	   				 </div>
		                {/if}
		            {/foreach}
	    {/if}
	</div>
{/strip}