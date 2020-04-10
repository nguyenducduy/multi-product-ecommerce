<a href="#" title="Siêu thị còn hàng"><i class="icon-chart"></i>Có {if $havestorestock|count > 0}{$havestorestock|count}{/if} siêu thị sẵn hàng</a>
<div class="dropsthi">
  <ul>
      {foreach from=$havestorestock item=str}
        <li>
            <a href="{$registry->conf.rooturl}sieuthi/{$str.slug}" target="_blank" id="{$str.lat}_{$str.lng}" title="{$str.name}">{$str.name}
            <span>{$str.storeaddress}</span>
              </a>
        </li>
      {/foreach}
    </ul>
</div>