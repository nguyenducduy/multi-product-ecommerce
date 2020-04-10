{include file="`$smartyControllerContainer`header.tpl"}
                    <div class="list-sp">
                    <ul class="sp">
                    {foreach item="product" from="$listproducts"}
                            <li class="pro-hover">
                            <div class="box-shadow">
                                  <div class="title-pro"><a title="{$product->name}" href="{$conf.rooturl}product-of-the-year/san-pham/{$product->id}">{$product->name}</a></div>
                                  <div class="box-r">{$product->countarticle}<span> Bài viết</span></div>
                                   <a href="{$conf.rooturl}product-of-the-year/san-pham/{$product->id}"><div class="bginfo">
                                       {if $product->summarynew != ''}
		                            <ul>
		                                {foreach from=$product->summarynew item=summary name=summaryname}
		                                  {if $smarty.foreach.summaryname.iteration == 6}
		                                    {break}
		                                  {/if}
		                                  {if $summary != ""}
		                                    <li>{$summary}</li>
		                                  {/if}
		                                {/foreach}
		                            </ul>
		                          {/if}
                                  </div></a>
                                  <a href="{$conf.rooturl}product-of-the-year/san-pham/{$product->id}"><img src="{$product->image}"></a>
                                </div>
                                <div class="button-blue"><a title="Tham gia viết bài" href="{$conf.rooturl}productyear/post?id={$product->id}">Tham gia viết bài</a></div>
                            </li>
                          {/foreach}
                        </ul>
                    </div>
{include file="`$smartyControllerContainer`footer.tpl"}