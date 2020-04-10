{*if !empty($banner)}
<div id="banner">
  {$banner}
</div>
<<<<<<< .mine
{/if*}

	<div class="colleft">
		{if !empty($listvendors)}
		<div class="colleftbrand">
			<span>Nhà sản xuất</span>
			<ul>
                {if !empty($curCategory->vendorlist)}
        			{foreach from =$listvendors item = ven}
		                <li><a href="{$ven->getVendorPath($curCategory->id)}" title="{$ven->name}">›› {$ven->name}</a></li>
		            {/foreach}
        		{elseif !empty($listvendors[$curCategory->id])}
        			{foreach from=$listvendors[$curCategory->id] item=myven}
        				{if !empty($myven->name) && $myven->name !='-'}
        				<li><a href="{$myven->getVendorPath($fcat->id)}" title="{$myven->name}">›› {$myven->name}</a></li>
        				{/if}
        			{/foreach}
        		{/if}
=======
{/if}
<div id="wrapper">
<div class="colleft">
<div class="colchoi"></div>
    {if $listChildCat|@count>0}

    <div class="navproduct">
        <a class="collapse" href="#" title="Sản phẩm liên quan">Sản phẩm liên quan<span class="arrow-fil3"></span><span class="arrow-fildown"></span></a>

            <ul class="panel">
                {foreach from = $listChildCat item = cat}
                    <li><a href="{$conf.rooturl}{$cat->slug}" title="{$cat->name}">›› {$cat->name}</a></li>
                {/foreach}
>>>>>>> .r2367
            </ul>
<<<<<<< .mine
=======

   </div>
   {/if}
   {if !empty($listvendors)}
    <div class="navproduct">
        <a class="collapse3" href="#" title="Nhà sản xuất">Nhà sản xuất <span class="arrow-fil3"></span><span class="arrow-fildown"></span></a>

            <ul class="panel3">
                {foreach from =$listvendors item = ven}
                	{if !empty($ven->name)}
                    <li><a href="{$ven->getVendorPath($curCategory->id)}" title="{$ven->name}">›› {$ven->name}</a></li>
                    {/if}
                {/foreach}
            </ul>

   </div>
   {/if}
   {if !empty($attributeList['LEFT'])}
   <div class="navproduct" style="display: none;">
        <a class="collapse4" href="#" rel="nofollow">Tiêu chí<span class="arrow-fil3"></span><span class="arrow-fildown"></span></a>
        <ul class="panel4">
        {foreach item=attribute from=$attributeList['LEFT']}
            {if $attribute->value|@count > 0}

                <li class="filter"><span>›› {$attribute->display}</span>
                    {if !empty($attribute->value[0])}
                    <ul>
                        {foreach item=attrvalue from=$attribute->value[0] name=attributelistname}
                            {if !empty($attrvalue)}
                            <li class="filter"><a href="{$curCategory->getProductcateoryPath()}?a={$attribute->panameseo},{$attribute->value[1][$smarty.foreach.attributelistname.iteration-1]}" title="{$attrvalue}">›› {$attrvalue}</a></li>
                            {/if}
                        {/foreach}
                    </ul>
                    {/if}
                </li>
            {/if}
        {/foreach}
        </ul>
   </div>
   {/if}

  <div class="latest">
    {if !empty($listnews.promotion)}
    <div class="title">TIN KHUYẾN MÃI</div>

    <div class="cont">
       {if !empty($listnews.promotion[0])}
      <div class="rownews"><a href="{$listnews.promotion[0]->getNewsPath()}" title="{$listnews.promotion[0]->title}"><img src="{$listnews.promotion[0]->getImage()}" width="195" alt="{$listnews.promotion[0]->title}" /></a>
        <div class="bgtitle"><a href="{$listnews.promotion[0]->getNewsPath()}" title="{$listnews.promotion[0]->title}"> <span>{$listnews.promotion[0]->title} </span></a> </div>
      </div>
      {/if}{if !empty($listnews.promotion[1])}
      <div class="rownews">
        <div class="col-1"><a href="{$listnews.promotion[1]->getNewsPath()}" title="{$listnews.promotion[1]->title}"><img src="{$listnews.promotion[1]->getImage()}" width="195" height="120" alt="{$listnews.promotion[1]->title}" /></a>
          <div class="bgtitle2"><a href="{$listnews.promotion[1]->getNewsPath()}" title="{$listnews.promotion[1]->title}"> <span>{$listnews.promotion[1]->title}</span></a> </div>
>>>>>>> .r2367
        </div>
        {/if}
<<<<<<< .mine
        {if !empty($attributeList['DELETEDURL'])}
		<div class="colleftbrand">
    		<span>Bạn đã chọn</span>
    		{foreach item=deletedurl from=$attributeList['DELETEDURL']}
            	{if !empty($deletedurl)}
		        	<div class="choose">
		        		<i class="choosedelete">
		        			<a title="Xóa chọn" href="{$deletedurl.url}">x</a>
		        		</i>›› {$deletedurl.name}
		        	</div>
		        {/if}
	        {/foreach}
	        <!--<div class="choose"><i class="choosedelete"><a title="Xóa chọn" href="#">x</a></i>›› Giá từ 20 - 25 triệu</div>
	        <div class="choose"><i class="choosedelete"><a title="Xóa chọn" href="#">x</a></i>›› Độ phân giải Full HD (1920x1080)</div>-->
	    </div>
	    {/if}
	    {if !empty($attributeList['LEFT'])}
	    <div class="colleftbrand">
    		<span>Xem theo tiêu chí</span>
		        <ul>
        			{foreach item=attribute from=$attributeList['LEFT']}
            			{if $attribute->value|@count > 0}
            				<li><a href="javascript:void(0)">›› {$attribute->display}</a></li>
            				{if !empty($attribute->value[0])}
		                        {foreach item=attrvalue from=$attribute->value[0] name=attributelistname}                            
		                            {if !empty($attrvalue)}
		                            <li><a class="subli" href="{$curCategory->getProductcateoryPath()}?a={$attribute->panameseo},{$attribute->value[1][$smarty.foreach.attributelistname.iteration-1]}{if !empty($attribute->value[2][$smarty.foreach.attributelistname.iteration-1])},{$attribute->value[2][$smarty.foreach.attributelistname.iteration-1]}{/if}" title="{$attrvalue}">{$attrvalue}</a></li>
		                            {/if}
		                        {/foreach}
		                    {/if}
		                {/if}
		            {/foreach}
		        </ul>
	    </div>
	    {/if}
	</div>=======
      </div>
      {/if}
      {if !empty($listnews.promotion[3])}
      <div class="rownews"><a href="{$listnews.promotion[3]->getNewsPath()}" title="{$listnews.promotion[3]->title}"><img src="{$listnews.promotion[3]->getImage()}" width="195" alt="{$listnews.promotion[3]->title}" /></a>
        <div class="bgtitle"><a href="{$listnews.promotion[3]->getNewsPath()}" title="{$listnews.promotion[3]->title}"> <span>{$listnews.promotion[3]->title} </span></a> </div>
      </div>
      {/if}
    </div>

    {/if}
  </div>
  <div class="latest">
  {if !empty($listnews.normal)}
    <div class="title2">TIN CÔNG NGHỆ</div>
    <div class="cont">
    {if !empty($listnews.normal[0])}
      <div class="rownews"><a href="{$listnews.normal[0]->getNewsPath()}" title="{$listnews.normal[0]->title}"><img src="{$listnews.normal[0]->getImage()}" width="195" alt="{$listnews.normal[0]->title}" /></a>
        <div class="bgtitle"><a href="{$listnews.normal[0]->getNewsPath()}" title="{$listnews.normal[0]->title}"> <span>{$listnews.normal[0]->title} </span></a> </div>
      </div>
    {/if}
    {if !empty($listnews.normal[1])}
      <div class="rownews">
        <div class="col-1"><a href="{$listnews.normal[1]->getNewsPath()}" title="{$listnews.normal[1]->title}"><img src="{$listnews.normal[1]->getImage()}" alt="{$listnews.normal[1]->title}" width="195" height="120" /></a>
          <div class="bgtitle2"><a href="{$listnews.normal[1]->getNewsPath()}" title="{$listnews.normal[1]->title}"> <span>{$listnews.normal[1]->title}</span></a> </div>
        </div>
        {if !empty($listnews.normal[2])}
        <div class="col-2"><a href="{$listnews.normal[2]->getNewsPath()}" title="{$listnews.normal[2]->title}"><img src="{$listnews.normal[2]->getImage()}" alt="{$listnews.normal[2]->title}" width="195" height="120" /></a>
          <div class="bgtitle2"><a href="{$listnews.normal[2]->getNewsPath()}" title="{$listnews.normal[2]->title}"> <span>{$listnews.normal[2]->title}</span></a> </div>
        </div>
        {/if}
      </div>
    {/if}
    {if !empty($listnews.normal[3])}
      <div class="rownews"><a href="{$listnews.normal[3]->getNewsPath()}" title="{$listnews.normal[3]->title}"><img src="{$listnews.normal[3]->getImage()}" alt="{$listnews.normal[3]->title}" width="195" /></a>
        <div class="bgtitle"><a href="{$listnews.normal[3]->getNewsPath()}" title="{$listnews.normal[3]->title}"> <span>{$listnews.normal[3]->title}</span></a> </div>
      </div>
    {/if}
    </div>
   {/if}
  </div>
  {if !empty($sidebarhome)}
  <ul>
  {foreach item=absad from=$sidebarhome}
    <li><a href="{$absad->getAdsPath()}" title="{$absad->title}"><img alt="{$absad->title}" src="{$absad->getImage()}" width="200" height="200" style="margin-top:25px" /></a></li>
  {/foreach}
  </ul>
  {/if}
</div>

<div class="listproduct">
    {if empty($listproductsegments) && !empty($curCategory)}
    <div class="products_name"><a href="{$curCategory->getProductcateoryPath()}" title="{$curCategory->name}">{$curCategory->name}</a></div>
    {/if}
    {if $attributeList.CENTER|@count > 0}
    <div class="filter_01">
        <p><a class="collapse2" href="#" rel="nofollow"> Lựa chọn mẫu {$curCategory->name} nào cho phù hợp!  <span class="arrow-fil"></span><span class="arrow-fildown"></span></a></p>
       <div class="rowfil panel2">

        <form action="{$curCategory->getProductcateoryPath()}" method="get">
            <input type="hidden" name="search" value="1" />
            <input type="hidden" name="live" value="1" />
            {foreach item=attribute from=$attributeList.CENTER name=attributecenter}
                <label class="wi_label">{$attribute->paname}</label>
                {if $attribute->value[0]|@count > 0}
                <select name="fattribute[{$smarty.foreach.attributecenter.iteration-1}]" class="selectfil">
                    <option value=""></option>
                        {foreach item=attrvalue from=$attribute->value[0] name=attributelistname}
                            <option value="{$attribute->panameseo},{$attribute->value[1][$smarty.foreach.attributelistname.iteration-1]}" {if $formData.fattribute|@count >0 && !empty($formData.fattribute[$attribute->paid]) && $formData.fattribute[$attribute->paid]==$attribute->value[1][$smarty.foreach.attributelistname.iteration-1]}selected="selected"{/if}>{$attrvalue}</option>
                        {/foreach}
                </select>
                {/if}
            {/foreach}


            <label class="wi_label">&nbsp;</label>
            <input type="button" class="submitbtn" name="fsubmit" id="ffiltersubmit" value="Xem" />
        </form>
        </div>

    </div>
    {/if}
    {include file="notify.tpl" notifyError=$error notifySuccess=$success}
    {*if !empty($pricesegment)}
    <div class="filter_02 sticky_navigation">
        <ul>
            <li><span class="pricelimit">Mức giá</span><span class="arrow-fil2"></span></li>
            {foreach item=sp from=$pricesegment}
                <li>
                {if $sp.to > 0 && $sp.from > 0}
                    <input class="radiospace" name="pricesegment" type="radio" {if !empty($frompricesegment) && $frompricesegment==$sp.from && !empty($topricesegment) && $topricesegment==$sp.to}checked="checked"{/if} value="{$curCategory->getProductcateoryPath()}?fps={$sp.from}&tps={$sp.to}&live=1" />{$sp.text} ({$sp.from|number_format} - {$sp.to|number_format})
                {elseif $sp.to <=0 && !empty($sp.from)}
                    <input class="radiospace" name="pricesegment" type="radio" {if !empty($frompricesegment) && $frompricesegment==$sp.from}checked="checked"{/if} value="{$curCategory->getProductcateoryPath()}?fps={$sp.from}&live=1" />{$sp.text} (từ {$sp.from|number_format})
                {elseif !empty($sp.to) && $sp.from <=0}
                    <input class="radiospace" name="pricesegment" type="radio" {if !empty($topricesegment) && $topricesegment==$sp.to}checked="checked"{/if} value="{$curCategory->getProductcateoryPath()}?fps={$sp.from}&live=1" />{$sp.text} (dưới {$sp.to|number_format})
                {/if}
                </li>
            {/foreach}
        </ul>

    </div>
    {/if*}>>>>>>> .r2367
