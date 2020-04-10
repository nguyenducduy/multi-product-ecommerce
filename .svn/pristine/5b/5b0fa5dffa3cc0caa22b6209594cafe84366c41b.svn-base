<div class="nav-news">
	<li><a href="{$conf.rooturl}tuyendung?p=0"{if $id == 0} class="selectnews"{/if} title="Tất cả tin tuyển dụng">Tất cả tin tuyển dụng</a></li>
    {foreach item=jmenu from=$jobmenu}
        <li><a href="{$conf.rooturl}tuyendung?p={$jmenu->id}"{if $jmenu->id == $id} class="selectnews"{/if} title="{$jmenu->name}">{$jmenu->name}</a></li>
    {/foreach}
</div>

<!-- News -->
<div id="wrap-news">
    {if $getdocpid|@count > 0}
        {foreach item=job from=$getdocpid name="myjob"}
        <div class="everyrow">

            <a href="{$job->getJobPath()}" title="{$job->title}"><img src="{if $job->image != ''}{$job->getImage()}{else}{$currentTemplate}images/default.jpg{/if}" alt="{$job->title}" /> </a>

            <a href="{$job->getJobPath()}" title="{$job->title}">{$job->title}</a><span>{$job->datecreated|date_format:$lang.default.dateFormatSmarty}</span>
            <p>{$job->content|strip_tags|truncate:155}</p>
        </div>
        {/foreach}
    {else}
        {foreach item=list from=$myJobcategoryList}
            <p class="generalname">
                <a href="{$conf.rooturl}tuyendung?c={$list->id}" title="{$list->name}">{$list->name}</a>
                {if $list->countitem > 5}
                <span style="float: right;text-transform:none;"><a href="{$conf.rooturl}tuyendung/index?c={$list->id}" rel="nofollow">Xem thêm ››</a></span>
                {/if}
            </p>
            {if $list->job|@count > 0}
            {foreach item=job from=$list->job}
            <div class="everyrow">

                <a href="{$job->getJobPath()}" title="{$job->title}"><img src="{if $job->image != ''}{$job->getImage()}{else}{$currentTemplate}images/default.jpg{/if}" alt="{$job->title}" /> </a>

                <a href="{$job->getJobPath()}" title="{$job->title}">{$job->title}</a><span>{$job->datecreated|date_format:$lang.default.dateFormatSmarty}</span>
                <p>{$job->content|strip_tags|truncate:155}</p>
            </div>
            {/foreach}
            {/if}
        {/foreach}
    {/if}
</div>
<!-- End news -->
