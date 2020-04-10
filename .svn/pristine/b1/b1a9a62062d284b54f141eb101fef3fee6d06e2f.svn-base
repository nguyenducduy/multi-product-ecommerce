<div class="nav-news">
    {foreach item=jmenu from=$jobmenu}
        <li><a href="{$conf.rooturl}tuyendung?p={$jmenu->id}"{if $jmenu->id == $myJobcategory->parentid} class="selectnews"{/if} title="{$jmenu->name}">{$jmenu->name}</a></li>
    {/foreach}
</div>

<!-- News -->
<div id="wrap-news">
        <p class="generalname">
            <a href="{$conf.rooturl}tuyendung?c={$myJobcategory->id}" title="{$myJobcategory->name}">{$myJobcategory->name}</a>
        </p>
        {if $myJob|@count > 0}
            {foreach item=job from=$myJob}
                <div class="everyrow">

                    <a href="{$job->getJobPath()}" title="{$job->title}"><img src="{if $job->image != ''}{$job->getImage()}{else}{$currentTemplate}images/default.jpg{/if}" alt="{$job->title}" /> </a>

                    <a href="{$job->getJobPath()}" title="{$job->title}">{$job->title}</a><span>{$job->datecreated|date_format:$lang.default.dateFormatSmarty}</span>
                    <p>{$job->content|strip_tags|truncate:155}</p>
                </div>
            {/foreach}
        {/if}
</div>
<!-- End news -->
