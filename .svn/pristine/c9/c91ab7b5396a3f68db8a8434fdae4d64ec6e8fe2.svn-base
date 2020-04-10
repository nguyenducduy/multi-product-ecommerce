<div class="commentbar"><h2>{if $productreviewList|@count >
0}Có <span>{$total}</span> nhận xét {else}Bình luận{/if}</h2></div>
<input id="productreviewtotal" value="{$total}" type="hidden" />
<div class="writecom">    
    <div class="notifireview"></div>
    <img src="{$currentTemplate}images/site/user.jpg">
    <textarea class="writepost" rows="" cols="" name="freviewcontent" id="freviewcontent" placeholder="Nhận xét của bạn về sản phẩm"></textarea>
    {if $registry->me->id > 0}
        <input type="hidden" value="{$registry->me->fullname}" id="usernamereview">
    {else}
        <input type="hidden" value="" id="usernamereview">
    {/if}
    <div style="padding-left:70px;">Còn lại <span id="contentcounter">1000</span> ký tự</div>
    {if $productreviewList|@count > 0}
    <div class="sortcomm"><span>Sắp xếp theo</span>
        <select class="choosecomm" name="forder" id="forder" onchange="orderreview({$fpid})">
            <option value="">Sắp xếp theo</option>
            <option value="lasted" {if $order== 'lasted'}selected="selected"{/if}>Mới
                    nhất</option>
            <option value="like" {if $order== 'like'}selected="selected"{/if}>Thích
                    nhất</option>
        </select>
    </div>
    {/if}    
    <div class="combtn">
        <span class="loading"></span>
        {if $registry->me->id > 0}
        <a href="javascript:void(0)" class="btn-blues" onclick="sendReview({$fpid} , 0 , {if $registry->me->id > 0}1{else}0{/if} , -1)">Gửi bình luận &#187;</a>
        {else}
        <a>Bình luận với tư cách là ...</a>
            <input type="hidden" value="{$fpid}" id="reviewid"/>
            <div class="droppost optionreview1">
                <div class="notifireviewthumb"></div>
                <a style="cursor: pointer" class="ismember" rel="false" title="" onclick="ischange()">Đã là thành viên điện máy? Đăng nhập &#187;</a>
                <input name="" type="text" placeholder="Mời bạn nhập tên (bắt buộc)" id="username">
                <input name="" type="text" placeholder="Mời bạn nhập email (bắt buộc)" id="email">
                <input class="check" name="" checked type="checkbox" value="">
                <label>Thông báo cho tôi khi có phản hồi từ dienmay.com</label>
                <a href="javascript:void(0)" class="btn-blues" onclick="sendReview({$fpid} , 0 , 0 , -1)">Gửi bình luận &#187;</a>
            </div>
         {/if}

    </div>
     <div class="clear"></div>  
</div>
<div class="clear"></div>
<!-- Question -->
<div class="review-product">
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
</div>

{/foreach}
{/foreach}
{else}
<div class="wrap-querep"></div>
{/if}
</div>

{if $total > $recordPerPage}
<div class="viewallproducts"><a href="javascript:void(0)" onclick="loadmoreReview({$fpid})">Mời bạn xem thêm ››</a></div>
{/if}
{literal}
<script type="text/javascript">
    $(document).ready(function(){
        $('.writepost').limit(1000 , "#contentcounter");
        //$('.writepostreply').limit(1000 , ".countercontentdata");
    });
</script>
{/literal}
