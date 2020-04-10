<!-- banner -->
<div id="m-carousel-example-4" class="m-carousel m-fluid m-carousel-photos">
    {if $slidebannermobile|@count > 0}
    <div class="m-carousel-inner" style="transform: translate(-2309px, 0px);">
        {foreach from=$slidebannermobile item =slide name =slideshowbanner}
            {*if $smarty.foreach.slideshowbanner.first*}
                <div class="m-item {if $smarty.foreach.slideshowbanner.first}m-active{/if}">
                   <a href="{$slide->getAdsPath()}" title="{$slide->title|escape}" style="display: inline;">
                       <img src="{$slide->getImage()|replace:'//m.':'//'}" alt="{$slide->title|escape}" title = "{$slide->title|escape}"/>
                    </a>
                </div>
        {/foreach}
    </div>
    <!-- bullet -->
    <div class="m-carousel-controls m-carousel-bulleted">
        {foreach from=$slidebannermobile item =slide name =slideshowbanner}
            <a data-slide="{$smarty.foreach.slideshowbanner.iteration}" href="#"  {if $smarty.foreach.slideshowbanner.first}class="m-active"{/if}>{$smarty.foreach.slideshowbanner.iteration}</a>
        {/foreach}
    </div>
    {/if}
</div>