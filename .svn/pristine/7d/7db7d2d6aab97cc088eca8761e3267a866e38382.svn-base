<div class="articlesbar countcomment"><span>Bình luận sản phẩm {if $productreviewList|@count >
0}(<b>{$total}</b>){/if}</span></div>
<div class="infouser">
    <div class="notifi" style="display:none">
        <p class="error1 error"></p>
        <p class="error2 error"></p>
        <p class="error3 error"></p>
    </div>
    <input name="" type="text" id="reviewfullname" placeholder="Tên của bạn" {if $registry->me->id > 0}readonly style="background:#f1f1f1"{/if} onblur="checkvalidate(this)" onkeyup="checkvalidate(this)" value="{$me->fullname}">
    <input name="" type="text" id= "reviewemail" placeholder="Email" {if $registry->me->id > 0}readonly style="background:#f1f1f1"{/if} onblur="checkvalidate(this)" onkeyup="checkvalidate(this)" value="{$me->email}">
    <textarea name="reviewcontent" id="reviewcontent" cols="" rows="3" onblur="checkvalidate(this)" onkeyup="checkvalidate(this)" placeholder="Ý kiến của bạn" maxlength="1000" style="font-family:arial"></textarea>
    <div class="combtn"><a href="javascript:void(0)" class="btn-blues" onclick="sendReview({$fpid} , 0 , {if $me->id > 0}1{else}0{/if} , -1)">Gửi bình luận</a></div>
</div>
<input type="hidden" value="{$registry->me->id}" id="useridcomment">
<div class="infocoms">
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
    <ul>
        {if $productreviewList|@count > 0}
            {foreach item=productreviews key=parentid from=$productreviewList}
                {foreach item=productreview from=$productreviews name=foo}
                        {if $smarty.foreach.foo.first}
                            <li>
                            <div class="nameuser">{if in_array($productreview->uid , $admindienmayarr)}dienmay.com{else}{$productreview->fullname}{/if}<span style="float:right;font-weight: normal;font-size:11px;"><i style="color:#7F8C8D">{$productreview->datecreated|date_format:"%H:%M Ngày: %d/%m/%Y"}</span></i></div>
                            <div class="contuser">{$productreview->text}</div>
                           {*if $registry->me->id > 0*}
                            <div class="right">
                                <div id="likeproductreview{$productreview->id}">
                                    <a href="javascript:void(0)" {if $smarty.session.productreviewthumb[$productreview->id] != $productreview->id}onclick="likereview({$fpid},{$productreview->id})" {else}style="background:#f1f1f1"{/if}>Thích</a>
                                    <span id="likecom{$productreview->id}">{if $smarty.session.productreviewthumb[$productreview->id] == $productreview->id}{$productreview->countthumbup + 1}{else}{$productreview->countthumbup}{/if}</span>
                                </div>
                                <!-- reply-->
                                <!--
                                <div class="click reply"><a href="javascript:void(0)" onclick="replyopen({$productreview->id})" style="border: none;border-radius: 0;color:#900">Trả lời</a></div>
                                <div class="dropdown_{$productreview->id} wrapreply">
                                    <textarea class="contreply" name="freviewcontentreply{$productreview->id}" id="freviewcontentreply{$productreview->id}"  cols="3" rows="" placeholder="Nội dung"></textarea>
                                      <a href="javascript:void(0)" onclick="sendReview({$fpid} , {$productreview->id} , {if $me->id > 0}1{else}0{/if} , 1)" style="background: #900;border-radius:0;color: #fff;margin-top: 2px;">Gửi</a>
                                </div>
                                -->
                            </div>
                            {*/if*}
                            <!-- Reply-->
                             {else}
                                <div class="listreply">
                                    <ul>
                                        <li>
                                            <div class="nameuser">{if in_array($productreview->uid , $admindienmayarr)}dienmay.com{else}{$productreview->fullname}{/if}<span style="float:right;font-weight: normal;font-size:12px;"><i>{$productreview->datecreated|date_format:"%H:%M Ngày: %d/%m/%Y"}</i></span></div>
                                            <div class="contuser">{$productreview->text}</div>
                                        </li>
                                    </ul>
                                </div>
                                </li>
                            {/if}
                        
                {/foreach}
            {/foreach}
        {/if}
                        
    </ul>
</div>
{if $total > $recordPerPage}
<div class="viewallproducts"><a href="javascript:void(0)" onclick="loadmoreReview({$fpid})">Xem thêm ››</a></div>
{/if}
