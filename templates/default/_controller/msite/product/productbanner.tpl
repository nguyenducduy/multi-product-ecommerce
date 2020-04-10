
<div class="bn_right" style="float:right; width:160px; height:160px;">
    {if $rightbanner|@count > 0}
        {foreach from=$rightbanner item=rbanner name=rightbannername}
            <a href="{$rbanner->getAdsPath()}"  title="{$rbanner->title}">
                <img src="{$rbanner->getImage()}" alt="{$rbanner->title}" width="160" height="160" title="{$rbanner->title}" />
            </a>
            {if $smarty.foreach.rightbannername.iteration==1}{break}{/if}
        {/foreach}        
    {/if}
</div>
  <div class="bn_left" style="width:780px; height:160px;">
    {if $slidebanner|@count > 0}
      <!-- Tabs -->
        <div class="feature" style="float:left; width:380px; height:160px;"> 
            {foreach from=$slidebanner item =slide name =slideshowbanner}
                {if $smarty.foreach.slideshowbanner.first}
                    <a href="{$slide->getAdsPath()}" id="{$smarty.foreach.slideshowbanner.iteration}" title="{$slide->title}" style="display: inline;">
                        <img src="{$slide->getImage()}" width="380" height="160" alt="{$slide->title}" title = "{$slide->title}" border="0"/>
                    </a>
                {else}
                    <a href="{$slide->getAdsPath()}" id="{$smarty.foreach.slideshowbanner.iteration}" title="{$slide->title}">
                        <img src="{$slide->getImage()}" width="380" height="160" alt="{$slide->title}" title = "{$slide->title}" border="0"/>
                    </a>
                {/if}
                
                {if $smarty.foreach.slideshowbanner.iteration==6}{break}{/if}
            {/foreach}
        </div>
      {/if}
      {if $slidebanner2|@count > 0}
      <!-- Tabs -->
        <div class="feature" style="float:right; width:380px; height:160px;"> 
            {foreach from=$slidebanner2 item =slide name =slideshowbanner}
                {if $smarty.foreach.slideshowbanner.first}
                    <a href="{$slide->getAdsPath()}" id="{$smarty.foreach.slideshowbanner.iteration}" title="{$slide->title}" style="display: inline;">
                        <img src="{$slide->getImage()}" width="380" height="160" alt="{$slide->title}" title = "{$slide->title}" border="0"/>
                    </a>
                {else}
                    <a href="{$slide->getAdsPath()}" id="{$smarty.foreach.slideshowbanner.iteration}" title="{$slide->title}">
                        <img src="{$slide->getImage()}" width="380" height="160" alt="{$slide->title}" title = "{$slide->title}" border="0"/>
                    </a>
                {/if}
                
                {if $smarty.foreach.slideshowbanner.iteration==6}{break}{/if}
            {/foreach}
        </div>
      {/if}
  </div>