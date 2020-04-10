<div id="container">
<div class="brandindex">
    <span>Danh mục thương hiệu</span>
    <ul>
        <li><a {if $keyword == 'all'} class="active" {/if} href="?q=all">All</a>
        <li><a {if $keyword == 'a'} class="active" {/if} href="?q=a">A</a></li>
        <li><a {if $keyword == 'b'} class="active" {/if} href="?q=b">B</a></li>
        <li><a {if $keyword == 'c'} class="active" {/if} href="?q=c">C</a></li>
        <li><a {if $keyword == 'd'} class="active" {/if} href="?q=d">D</a></li>
        <li><a {if $keyword == 'e'} class="active" {/if} href="?q=e">E</a></li>
        <li><a {if $keyword == 'f'} class="active" {/if} href="?q=f">F</a></li>
        <li><a {if $keyword == 'g'} class="active" {/if} href="?q=g">G</a></li>
        <li><a {if $keyword == 'h'} class="active" {/if} href="?q=h">H</a></li>
        <li><a {if $keyword == 'i'} class="active" {/if} href="?q=i">I</a></li>
        <li><a {if $keyword == 'j'} class="active" {/if} href="?q=j">J</a></li>
        <li><a {if $keyword == 'k'} class="active" {/if} href="?q=k">K</a></li>
        <li><a {if $keyword == 'l'} class="active" {/if} href="?q=l">L</a></li>
        <li><a {if $keyword == 'm'} class="active" {/if} href="?q=m">M</a></li>
        <li><a {if $keyword == 'n'} class="active" {/if} href="?q=n">N</a></li>
        <li><a {if $keyword == 'o'} class="active" {/if} href="?q=o">O</a></li>
        <li><a {if $keyword == 'p'} class="active" {/if} href="?q=p">P</a></li>
        <li><a {if $keyword == 'q'} class="active" {/if} href="?q=q">Q</a></li>
        <li><a {if $keyword == 's'} class="active" {/if} href="?q=s">S</a></li>
        <li><a {if $keyword == 't'} class="active" {/if} href="?q=t">T</a></li>
        <li><a {if $keyword == 'u'} class="active" {/if} href="?q=u">U</a></li>
        <li><a {if $keyword == 'v'} class="active" {/if} href="?q=v">V</a></li>
        <li><a {if $keyword == 'w'} class="active" {/if} href="?q=w">W</a></li>
        <li><a {if $keyword == 'x'} class="active" {/if} href="?q=x">X</a></li>
        <li><a {if $keyword == 'y'} class="active" {/if} href="?q=y">Y</a></li>
        <li><a {if $keyword == 'z'} class="active" {/if} href="?q=z">Z</a></li>
    </ul>
</div>
{if !empty($brand)}
<div class="bralist"> <span>{$brand->title}</span>
    <div class="line">
        <div class="col1of52">
           {$brand->content}
        </div>
    </div>
</div>
{else}
<div class="bralist"> <span>Lọc nhãn hiệu theo "{$keyword}"</span>
    <div class="line">
        <div class="col1of52">
                <div class="box"><span></span>
                    <ul>
                        {foreach from=$vendorbykey item=vendor name=vendorbykey}
                            <li><a title="{$vendor->name}" href="{$conf.rooturl}{$vendor->slug}">{$vendor->name}</a></li>

                        {if $smarty.foreach.vendorbykey.iteration % 5 == 0}
                            </ul></div><div class="box"><span></span>
                        {/if}
                    {/foreach}
                    </ul>
                </div>
        </div>
    </div>
</div>
{/if}

</div>