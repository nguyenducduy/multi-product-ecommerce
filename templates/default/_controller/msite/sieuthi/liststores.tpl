 <div class="conttable">
        <div class="back"><a href="javascript:history.back()">Trở về</a></div>
        <div class="departname">Danh sách siêu thị</div>
    </div>
<ul class="m-accordion m-indicators-css">
   {if !empty($listregions)}
     {foreach from=$listregions item=ritem}
      <li class="m-item">
        <h3 class="m-header">
          <a><i class="icon-map"></i>{$ritem->name} ({assign var="countstore" value=1}{foreach from=$liststores item=str2 key=key name=liststore2}{if $str2->region == $ritem->id}{assign var="countstores" value=$countstore++}{/if}{/foreach}{$countstores})</a>
        </h3>
        <div class="m-content">
          <div class="m-inner-content">
             {if !empty($liststores)}
                <ul>
                {foreach from=$liststores item=str name=liststore}
                    {if $str->region == $ritem->id}
                        <li><span style="padding:5 12px">{$str->name}</span>
                            <ul>
                                <li style=" padding: 0 0 0 25px; ">{$str->storeaddress}</li>
                            </ul>
                        </li>
                    {/if}
                {/foreach}
                 </ul>
            {/if}
           
          </div>
        </div>
      </li>
    {/foreach}
  {/if}
</ul>