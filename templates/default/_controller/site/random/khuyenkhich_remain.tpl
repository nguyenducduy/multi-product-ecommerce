{literal}
<style rel="stylesheet">
	h1{font-size:28px;}
	.randombutton{font-size:24px; padding:20px 100px; margin: 50px 0; background: #f90; color:#fff;border-width:0; border-radius:4px;}
	.randombutton:hover{background:#f30; color:#fff;}
	.giarewinner{margin:30px 0; padding:20px; background:#e9ffe8; border:1px solid #24a321; border-radius: 4px; line-height:2;}
	.giarewinner h2{font-size:28px; color:#087505;margin-top:0; padding-top:0;}
	.giarewinner h2 big{font-family: Courier New, mono;}
	.giarewinner .member{font-size:16px;}
	.giarewinner .memberinfo{padding-left:30px;}
	.giarewinner .memberinfo b{font-weight:normal}
	.giarewinner .memberinfo span{}
	.khuyenkhichlist table td, .khuyenkhichlist table th{padding:4px;}
	.kkcode{font-family: Courier New, mono-space; font-size:16px; font-weight:bold;}
</style>
{/literal}

<div id="wrapper">
    <div class="">
		<div class="giarerandom">
			<span>Quay số chọn giải chính</span> |
			<a href="{$conf.rooturl}random/khuyenkhich">Quay số chọn giải khuyến khích</a>
		</div>
          
		<br /><br />
	    <h1>QUAY SỐ NGẪU NHIÊN</h1>
		
		{if $randomcode != ''}
			<div class="giarewinner">
				<h2>Mã ngẫu nhiên dùng cho các giải còn lại: <big>{$randomcode}</big></h2>
				
				<div class="khuyenkhichlist">
					<h3>Danh sách trúng giải</h3>
					<table width="100%" cellpadding="4" cellspacing="4" border="1">
						<thead>
							<tr>
								<th></th>
								<th>Code</th>
								<th>Họ và Tên</th>
								<th>Email</th>
								<th>Số Điện thoại</th>
								<th>CMND</th>
								<th>Ngày tham gia</th>
							</tr>
						</thead>
						<tbody>
							{foreach item=winner from=$winnerDetailList}
								<tr>
									<td>{counter}</td>
									<td class="kkcode">{$winner.lc_code}</td>
									<td>{$winner.memberinfo->fullname}</td>
									<td>{$winner.memberinfo->email}</td>
									<td>{$winner.memberinfo->phone}</td>
									<td>{$winner.memberinfo->cmnd}</td>
									<td>{$winner.lc_datecreated|date_format:"%H:%M, ngày %d/%m/%Y"}</td>
								</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>
		{/if}
		
		<p>
			<form action="" method="post">
				Số lượng cần lấy: <input type="text" name="total" value="32" />
				<input type="submit" value="Quay Số" name="fsubmit" class="randombutton" />
			</form>
		</p>
        <br/>
        <img src="{$currentTemplate}images/giare/Web_800x450px-nen.jpg"/>
    </div>
</div>
	
