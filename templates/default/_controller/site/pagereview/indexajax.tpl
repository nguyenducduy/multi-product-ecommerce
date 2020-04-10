<span class="titlename">Bình luận{if $pagereviewList|@count >
0}&nbsp;({$total}){/if}</span>
<div class="commentadd">
<div class="writecom"><img src="{$currentTemplate}images/noavatar200.jpg" style="margin-top:-10px;" />
    <div style="float:left;width:43%"><textarea
    class="writepost" name="freviewcontent" id="freviewcontent" cols=""
    placeholder="Ý kiến của bạn" style="height:100px;"></textarea>
    <div class="clr"></div>
    <a href="javascript:void(0)" class="btn-blues" onclick="sendpageReview({$fpid} , 0 , {if $me->id > 0}1{else}0{/if} , -1)">Gửi</a>
    </div>
    <div class="postguide"><div class="tithelppost">HƯỚNG DẪN KHI BÌNH LUẬN:</div>
    <div style="margin-bottom:8px"><i class="helppost">1</i> - Nội dung mang tính chia sẻ hữu ích sẽ được ưu tiên đưa lên đầu cho các thành viên khác tham khảo</div>
    <div style="margin-bottom:8px"><i class="helppost">2</i> - Không:  sử dụng các từ ngữ có tính chất đả kích, tục tĩu, gây phản cảm, châm biếm người đọc hoặc các thành viên khác</div>
<div><i class="helppost">3</i> - Những hành vi spam, trao đổi, mua bán trong mục “Bình luận” Ban Quản trị sẽ xóa mà không cần báo trước.</div>

    </div>
<div class="clr"></div>

{if $pagereviewList|@count > 0}
<div class="sortnav"><select class="reselect" name="forder" id="forder"
    onchange="orderpagereview({$fpid})">
    <option value="">Sắp xếp theo</option>
    <option value="lasted" {if $order== 'lasted'}selected="selected"{/if}>Mới
    nhất</option>
    <option value="like" {if $order== 'like'}selected="selected"{/if}>Thích
    nhất</option>
</select></div>
{/if}
<div class="listcomment">{if $pagereviewList|@count > 0}
<ul>
    {foreach item=pagereviews key=parentid from=$pagereviewList}
    {foreach item=pagereview from=$pagereviews name=foo} {if
    $smarty.foreach.foo.first}
    <li><a href="#"><img style="margin-top: -10px;"
        src="{$currentTemplate}images/noavatar200.jpg" alt="" title="" /></a> <a href="#">{if in_array($pagereview->uid , $admindienmayarr)}dienmay.com{else}{$pagereview->fullname}{/if}</a><span>{$pagereview->datecreated|date_format:"%d/%m/%Y"}</span>
    <p>{$pagereview->text}</p>
    <div class="likecom" id="likecom{$pagereview->id}"><a
        href="javascript:void(0)"
        onclick="likepagereview({$fpid},{$pagereview->id})"><i
        class="icon-likecom"></i></a> <span>Thích (<span
        id="like{$pagereview->id}">{$pagereview->countthumbup}</span>)</div>
    <div class="replay"><a href="javascript:void(0)"
        onclick="relyfunc({$pagereview->id})">Reply</a></div>
    <br />
    <!--reply-->
    <div id="reply{$pagereview->id}" style="display:none;">
        <span style="float:right;"><a title="Đóng" href="javascript:void(0)" onclick="closereply({$pagereview->id})">X</a></span>
        <textarea style="width:99%"
        class="writepost" name="freviewcontentreply{$pagereview->id}" id="freviewcontentreply{$pagereview->id}" cols=""
        placeholder="Ý kiến của bạn"></textarea>
        <div class="clr"></div>
        <a href="javascript:void(0)" class="btn-blues" onclick="sendReview({$fsid} , {$pagereview->id} , {if $me->id > 0}1{else}0{/if} , 1)">Gửi</a>
    </div>
    <!--reply-->
    </li>
    {else}
    <li style="padding-left: 80px;"><a href="#"><img
        style="margin-top: -10px;" src="{$currentTemplate}images/noavatar200.jpg" alt="" title="" /></a>
    <a href="#">{if in_array($pagereview->uid , $admindienmayarr)}dienmay.com{else}{$pagereview->fullname}{/if}</a><span>{$pagereview->datecreated|date_format:"%d/%m/%Y"}</span>
    <p>{$pagereview->text}</p>
    <div class="likecom" id="likecom{$pagereview->id}"><a
        href="javascript:void(0)"
        onclick="likepagereview({$fpid},{$pagereview->id})"><i
        class="icon-likecom"></i></a> <span>Thích (<span
        id="like{$pagereview->id}">{$pagereview->countthumbup}</span>)</span></div>
    <div class="replay"><a href="javascript:void(0)"
        onclick="relyfunc({$pagereview->id})">Reply</a></div>
    <br />
    <!--reply-->
    <div id="reply{$pagereview->id}" style="display:none;">
        <span style="float:right;"><a title="Đóng" href="javascript:void(0)" onclick="closereply({$pagereview->id})">X</a></span>
        <textarea style="width:99%"
        class="writepost" name="freviewcontentreply{$pagereview->id}" id="freviewcontentreply{$pagereview->id}" cols=""
        placeholder="Ý kiến của bạn"></textarea>
        <div class="clr"></div>
        <a href="javascript:void(0)" class="btn-blues" onclick="sendReview({$fsid} , {$pagereview->id} , {if $me->id > 0}1{else}0{/if} , 1)">Gửi</a>
    </div>
    <!--reply-->
    </li>
    {/if} {/foreach} {/foreach}
</ul>
{/if} <!-- <div><a href="#"><button class="login btnfull" type="button">+ Xem thêm</button></a></div> -->
</div>
</div>
