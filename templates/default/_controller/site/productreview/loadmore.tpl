{if $productreviewList|@count > 0}
{foreach item=productreviews key=parentid from=$productreviewList}
{foreach item=productreview from=$productreviews name=foo}

<div class="wrap-querep">
    {if $smarty.foreach.foo.first}
    <div class="question">
        <img src="{$currentTemplate}images/site/user.jpg">
        <div class="questiontext">
            <span>{if in_array($productreview->uid , $admindienmayarr)}dienmay.com{else}{$productreview->fullname}{/if}</span>
            <p>{$productreview->text}</p>
            <ul>
                <li id="likeproductreview{$productreview->id}"><a href="javascript:void(0)" onclick="likereview({$fpid},{$productreview->id})">Thích</a></li>
                <li id="likecom{$productreview->id}"><i class="icon-likecom"></i><span id="like{$productreview->id}">{$productreview->countthumbup}</span></li>
                <li>{$productreview->datecreated|date_format:"%d/%m/%Y"}</li>
            </ul>
        </div>
    </div>
    {else}
    <div class="reply">
        <div class="arrowcomm"></div>
        <img src="{$currentTemplate}images/user.jpg">
        <div class="replytext">
            <span>{if in_array($productreview->uid , $admindienmayarr)}dienmay.com{else}{$productreview->fullname}{/if}</span>
            <p>{$productreview->text}</p>
            <ul>
                <li id="likeproductreview{$productreview->id}"><a href="javascript:void(0)" onclick="likereview({$fpid},{$productreview->id})">Thích</a></li>
                <li id="likecom{$productreview->id}"><i class="icon-likecom"></i><span id="like{$productreview->id}">{$productreview->countthumbup}<span></li>
                <li>{$productreview->datecreated|date_format:"%d/%m/%Y"}</li>
            </ul>
        </div>
    </div>
    {/if}
{/foreach}
{/foreach}
{/if}