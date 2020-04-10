<h4>Xác thực thông tin của bạn để gửi bình luận</h4>
		<table style="width:100%;margin-top:12px;background-color:#f6f7f8">
			<tr>
				<td style="width:30%;padding-left:105px;">Tên</td>
				<td><input type="text" id="freviewname" /></td>
			</tr>
			<tr>
				<td style="width:30%;padding-left:90px;">Email</td>
				<td><input type="text" id="freviewemail" />
					<textarea id="freviewcontent" style="display:none;">{$content}</textarea>
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="float:left;"><a href="javascript:void(0)" class="btn-blues" onclick="sendpageReview({$fpid} , {$fparentid} , 2, 0)">Gửi</a></td>
			</tr>
		</table>
