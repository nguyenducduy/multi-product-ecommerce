<span class="titlename">Bình luận{if $giarereviewList|@count >
0}&nbsp;({$total}){/if}</span>
<div class="commentadd">
<div class="writecom"><img src="{$currentTemplate}images/noavatar200.jpg" />
	<div class="width-writecom"><textarea
	class="writepost" name="freviewcontent" id="freviewcontent" cols=""
	placeholder="Ý kiến của bạn"></textarea>
	<div class="clr"></div>
	<a href="javascript:void(0)" class="btn-blues" onclick="sendgiareReview(0 , 0 , {if $me->id > 0}1{else}0{/if} , -1)">Gửi</a>
	</div>
	<div class="postguide"><div class="tithelppost">HƯỚNG DẪN KHI BÌNH LUẬN:</div>
	<div style="margin-bottom:8px"><i class="helppost">1</i> - Nội dung mang tính chia sẻ hữu ích sẽ được ưu tiên đưa lên đầu cho các thành viên khác tham khảo</div>
 	<div style="margin-bottom:8px"><i class="helppost">2</i> - Không sử dụng các từ ngữ có tính chất đả kích, tục tĩu, gây phản cảm, châm biếm người đọc hoặc các thành viên khác</div>
<div><i class="helppost">3</i> - Những hành vi spam, trao đổi, mua bán trong mục “Bình luận” Ban Quản trị sẽ xóa mà không cần báo trước.</div>

	</div>
<div class="clr"></div>
{if $giarereviewList|@count > 0}
<div class="sortnav"><select class="reselect" name="forder" id="forder"
	onchange="orderreviewgiare(0)">
	<option value="">Sắp xếp theo</option>
	<option value="lasted" {if $order== 'lasted'}selected="selected"{/if}>Mới
	nhất</option>
	<option value="like" {if $order== 'like'}selected="selected"{/if}>Thích
	nhất</option>
</select></div>
{/if}
<div class="listcomment">{if $giarereviewList|@count > 0}
<ul>
	{foreach item=giarereviews key=parentid from=$giarereviewList}
	{foreach item=giarereview from=$giarereviews name=foo} {if
	$smarty.foreach.foo.first}
	<li><a href="#"><img style="margin-top: -10px; width:70px !important"
		src="{if in_array($giarereview->uid , $dienmayadmin)}{$currentTemplate}images/site/logo_1024.jpg{else}{$currentTemplate}images/noavatar200.jpg{/if}" alt="" title="" /></a> <a href="#">{if in_array($giarereview->uid , $dienmayadmin)}dienmay.com{else}{$giarereview->fullname}{/if}</a><span>{$giarereview->datecreated|date_format:"%d/%m/%Y"}</span>
	<p>{$giarereview->text}</p>
	<div class="likecom" id="likecom{$giarereview->id}"><a
		href="javascript:void(0)"
		onclick="likegiarereview(0,{$giarereview->id})"><i
		class="icon-likecom"></i></a> <span>Thích (<span
		id="like{$giarereview->id}">{$giarereview->countthumbup}</span>)</div>
	<div class="replay"><a href="javascript:void(0)"
		onclick="relyfunc({$giarereview->id})">Reply</a></div>
	<br />

	<!--reply-->
	<div id="reply{$giarereview->id}" style="display:none;">
		<span style="float:right;"><a title="Đóng" href="javascript:void(0)" onclick="closereply({$giarereview->id})">X</a></span>
		<textarea style="width:99%"
		class="writepost" name="freviewcontentreply{$giarereview->id}" id="freviewcontentreply{$giarereview->id}" cols=""
		placeholder="Ý kiến của bạn"></textarea>
		<div class="clr"></div>
		<a href="javascript:void(0)" class="btn-blues" onclick="sendgiareReview(0 , {$giarereview->id} , {if $me->id > 0}1{else}0{/if} , 1)">Gửi</a>
	</div>
	<!--reply-->

	</li>
	{else}
	<li style="padding-left: 80px;"><a href="#"><img
		style="margin-top: -10px;  width:70px !important;" src="{if in_array($giarereview->uid , $dienmayadmin)}{$currentTemplate}images/site/logo_1024.jpg{else}{$currentTemplate}images/noavatar200.jpg{/if}" alt="" title="" /></a>
	<a href="#">{if in_array($giarereview->uid , $dienmayadmin)}dienmay.com{else}{$giarereview->fullname}{/if}</a><span>{$giarereview->datecreated|date_format:"%d/%m/%Y"}</span>
	<p>{$giarereview->text}</p>
	<div class="likecom" id="likecom{$giarereview->id}"><a
		href="javascript:void(0)"
		onclick="likegiarereview(0,{$giarereview->id})"><i
		class="icon-likecom"></i></a> <span>Thích (<span
		id="like{$giarereview->id}">{$giarereview->countthumbup}</span>)</span></div>
	<div class="replay"><a href="javascript:void(0)"
		onclick="relyfunc({$giarereview->id})">Reply</a></div>
	<br />
	<!--reply-->
	<div id="reply{$giarereview->id}" style="display:none;">
		<span style="float:right;"><a title="Đóng" href="javascript:void(0)" onclick="closereply({$giarereview->id})">X</a></span>
		<textarea style="width:99%"
		class="writepost" name="freviewcontentreply{$giarereview->id}" id="freviewcontentreply{$giarereview->id}" cols=""
		placeholder="Ý kiến của bạn"></textarea>
		<div class="clr"></div>
		<a href="javascript:void(0)" class="btn-blues" onclick="sendgiareReview(0 , {$giarereview->id} , {if $me->id > 0}1{else}0{/if} , 1)">Gửi</a>
	</div>
	<!--reply-->
	</li>
	{/if} {/foreach} {/foreach}
</ul>
<div class="pagination">
	<a href="javascript:void(0)" onclick="loadgiareReviewPage({$page})" style="float:right">Xem thêm</a>
</div>
{/if} <!-- <div><a href="#"><button class="login btnfull" type="button">+ Xem thêm</button></a></div> -->
</div>
</div>
