<!--<link type="text/css" rel="stylesheet" href="{$currentTemplate}css/site/startproductcategory.css" media="screen" />-->
<link type="text/css" rel="stylesheet" href="{$currentTemplate}css/site/startproductcategory.css" media="screen" />
<link type="text/css" rel="stylesheet" href="{$currentTemplate}css/site/jquery.handsontable.full.css" media="screen" />
<script type="text/javascript" src="{$currentTemplate}js/site/jquery.handsontable.full.js"></script>
<script type="text/javascript" src="{$currentTemplate}js/site/numeral.js"></script>
<script type="text/javascript" src="{$currentTemplate}js/stat/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="{$currentTemplate}js/stat/jquery.handsontable-excel.js"></script>

<div id="forecastlist"{if empty($isajax)} style="height: auto;margin-top: 0px;"{/if}>{$fvid}
    <p class="clear">&nbsp;</p>
    <input type="button" id="save_0" onclick="saveall()" value="Save" class="savebutton" />
    <ul id="tab" style="display: inline-block;">
    	<li {if $sheet == 0}class="active"{/if} id="s0"><a {if $isajax == 1}href="javascript:void(0)" onclick="changesheet(0)"{elseif $linkshareurl != '' && $sheet == 0}href="{$linkshareurl}"{else}href="{$conf.rooturl}stat/product/info?id={$fpcid}&fsheet=0&type=productcategory{if !empty($fvid)}&fvid={$fvid}{/if}"{/if}>Sheet 1</a></li>
    	<li {if $sheet == 2}class="active"{/if} id="s2"><a {if $isajax == 1}href="javascript:void(0)" onclick="changesheet(2)"{elseif $linkshareurl != '' && $sheet == 2}href="{$linkshareurl}"{else}href="{$conf.rooturl}stat/product/info?id={$fpcid}&fsheet=2&type=productcategory{if !empty($fvid)}&fvid={$fvid}{/if}"{/if}>Sheet 2</a></li>
    	<li {if $sheet == 3}class="active"{/if} id="s3"><a {if $isajax == 1}href="javascript:void(0)" onclick="changesheet(3)"{elseif $linkshareurl != '' && $sheet == 3}href="{$linkshareurl}"{else}href="{$conf.rooturl}stat/product/info?id={$fpcid}&fsheet=3&type=productcategory{if !empty($fvid)}&fvid={$fvid}{/if}"{/if}>Sheet 3</a></li>
    	<li {if $sheet == 5}class="active"{/if} id="s5"><a {if $isajax == 1}href="javascript:void(0)" onclick="changesheet(5)"{elseif $linkshareurl != '' && $sheet == 5}href="{$linkshareurl}"{else}href="{$conf.rooturl}stat/product/info?id={$fpcid}&fsheet=5&type=productcategory{if !empty($fvid)}&fvid={$fvid}{/if}"{/if}>Sheet 5</a></li>
    	<li><a href="javascript:void(0)" onclick="refreshallparam({$sheet})">REFRESH</a></li>
    </ul>
    <a id="exporttoexcel" target="_blank" href="{if $excelurl != ''}{$excelurl}{else}{$conf.rooturl}stat/product/exportexcel?id={$fpcid}&fsheet={$sheet}{/if}">Export</a>
    <a id="sharelink" target="_blank" href="{if $linkshareurl != ''}{$linkshareurl}{else}{$conf.rooturl}stat/product/info?id={$fpcid}&fsheet={$sheet}&type=productcategory{/if}">Link</a>
    <a id="refreshbutton" class="statformatdate" href="javascript:void(0)" onclick="refreshdatasheet({$sheet},{$isajax})">VIEW</a>
    <input type="text" class="inputdatepicker statformatdate" name="enddate" id="enddate" placeholder="End date" value="{$enddate}" />
    <input type="text" class="inputdatepicker statformatdate" name="fromdate" id="fromdate" placeholder="Start date" value="{$fromdate}" />

    <div id="dataTable" class="handsontable" style="{if $isajax==1}height:440px; overflow: scroll;{/if}clear: both;"></div>
    <div id="sheetshow" style="clear: both;"></div>
    {if !empty($vendorlist)}
    {section name=numsheet start=0 loop=6 step=1}
    <ul id="dropdownlist{$smarty.section.numsheet.index}" rel="{$smarty.section.numsheet.index}" class="uldropdownlist">
    	{foreach item=vendor from=$vendorlist}
            {if $vendor->type == 0}
    			<li><input type="checkbox" value="{$vendor->id}" {if is_array($newfvid)} {if in_array($vendor->id , $newfvid)}checked="checked"{/if} {/if} name="fvid{$vendor->id}" />{$vendor->name}</li>
    		{/if}
    	{/foreach}
    </ul>
    {/section}
    {/if}
    {if !empty($categorylist)}
    {section name=numsheet start=0 loop=6 step=1}
    <ul id="dropsubcategories{$smarty.section.numsheet.index}" rel="{$smarty.section.numsheet.index}" class="uldropdownlist">
    	{foreach item=cat from=$categorylist}
    		<li><input type="checkbox" value="{$cat->id}" name="fpcid{$cat->id}" {if is_array($newchildcategory)} {if in_array($cat->id , $newchildcategory)}checked="checked"{/if} {/if}  />{$cat->name}</li>
    	{/foreach}
    </ul>
    {/section}
    {/if}
    {if !empty($listslugpricesegment)}
    {section name=numsheet start=0 loop=6 step=1}
    <ul id="droppricesegment{$smarty.section.numsheet.index}" rel="{$smarty.section.numsheet.index}" class="uldropdownlist">
    	{foreach item=pricename key=priceslug from=$listslugpricesegment}
    		<li><input type="checkbox" value="{$priceslug}" name="fpriceslug[]" />{$pricename}</li>
    	{/foreach}
    </ul>
    {/section}
    {/if}
</div>{$listsparklineid}
{literal}
    <script type="text/javascript">
    var priceRender = function (instance, td, row, col, prop, value, cellProperties) {
                                var price = numeral(value).format('0,0');
                                td.innerHTML = price;
                                $(td).addClass('celleditor');
                                $(td).css({
                                    /*background : 'yellow',*/
                                    borderRightWidth: '11px',
                                    textAlign : 'right'
                                });
                                return td;
                            };

    var yellowRender = function (instance, td, row, col, prop, value, cellProperties) {
                                td.innerHTML = value;
                                $(td).addClass('celleditor');
                                /*$(td).css({
                                    background : 'yellow'
                                });*/
                                return td;
                            };

    var productRender = function (instance, td, row, col, prop, value, cellProperties) {
                                td.innerHTML = value;
                                $(td).addClass('cellreadonly');
                                /*$(td).css({
                                    background : '#af9ec3'
                                });*/
                                return td;
                            };
    var categoryRender = function (instance, td, row, col, prop, value, cellProperties) {
                                td.innerHTML = value;
                                $(td).addClass('cellreadonly');
                                /*$(td).css({
                                    background : '#ccc0da'
                                });*/
                                return td;
                            };

    var timeRender = function (instance, td, row, col, prop, value, cellProperties) {
                                td.innerHTML = value;
                                $(td).addClass('cellreadonly');
                                /*$(td).css({
                                    background : '#e5e0ec'
                                });*/
                                return td;
                            };
    var costpriceRender = function (instance, td, row, col, prop, value, cellProperties) {
                                td.innerHTML = value;
                                $(td).addClass('celleditor');
                                $(td).css({
                                    fontWeight : 'bold',
                                    textAlign : 'right',
                                });
                                return td;
                            };

    var productnameRender = function (instance, td, row, col, prop, value, cellProperties) {
                                td.innerHTML = value;
                                $(td).addClass('cellreadonly');
                                $(td).css({
                                    fontWeight : 'bold'
                                });
                                return td;
                            };
    var formularcellRender = function (instance, td, row, col, prop, value, cellProperties) {
                            td.innerHTML = value;
                            $(td).addClass('cellformular');
                            return td;
                        };

    var data = {/literal}{$outputdataproduct}{literal}
    var pcid = {/literal}{$fpcid}{literal}
    var isajax = {/literal}{$isajax}{literal}
    var columns = {/literal}{$schema.columns}{literal}
    var colHeaders = {/literal}{$schema.colHeaders}{literal}
    var colWidths = {/literal}{$schema.colWidths}{literal}
    var sheetnum = {/literal}{$sheet}{literal}
    var first = {/literal}{$first}{literal}
    </script>
{/literal}
<script type="text/javascript" src="{$currentTemplate}js/stat/forecastproductcategory.js"></script>