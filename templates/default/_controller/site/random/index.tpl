{literal}
<style rel="stylesheet">
	h1{font-size:28px;}
	.randombutton{font-size:24px; padding:20px 100px; margin-top: 50px; background: #f90; color:#fff;border-width:0; border-radius:4px;}
	.randombutton:hover{background:#f30; color:#fff;}
	.giarewinner{margin:30px 0; padding:20px; background:#e9ffe8; border:1px solid #24a321; border-radius: 4px; line-height:2;}
	.giarewinner h2{font-size:28px; color:#087505;margin-top:0; padding-top:0;}
	.giarewinner .member{font-size:16px;}
	.giarewinner .memberinfo{padding-left:30px;}
	.giarewinner .memberinfo b{font-weight:normal}
	.giarewinner .memberinfo span{}
    
</style>
{/literal}

<div id="wrapper">    
    <div class="listproduct">
		<div class="giarerandom">
			<span>Quay số chọn giải chính</span> |
			<a href="{$conf.rooturl}random/khuyenkhich">Quay số chọn giải khuyến khích</a>
		</div>       
          
		<br /><br />
	    <h1>QUAY SỐ NGẪU NHIÊN CHỌN NGƯỜI TRÚNG GIẢI &AMP; NGƯỜI GIỚI THIỆU</h1>
		
		<p>
			<form action="" method="post" id="myform">
				<input type="submit" value="Quay Số" name="fsubmit" class="randombutton" />
			</form>
		</p>
		
		{if $winner.lc_id > 0}
			<div class="giarewinner">
				<h2>Code: <big>{$winner.lc_code}</big></h2>
				<div class="member">
					<h3> NGƯỜI TRÚNG GIẢI: </h3>
					<p class="memberinfo">
						<b><span>Họ và tên:</span> {$winner.memberinfo->fullname}</b><br />
						<b><span>Email:</span> {$winner.memberinfo->email}</b><br />
						<b><span>Số Điện Thoại:</span> {$winner.memberinfo->phone}</b><br />
						<b><span>CMND:</span> {$winner.memberinfo->cmnd}</b><br />
						<b><span>Tỉnh/Thành phố:</span> {$winner.memberinfo->regionname}</b><br />
					</p>
				</div>
				<br />
				<hr />
				<br />
				<div class="referer">
					{if $winner.memberinfo->referermemberid > 0}
						{assign var=winnerreferer value=$winner.referer}
						
						<h3> NGƯỜI GIỚI THIỆU: </h3>
						<p class="memberinfo">
							<b><span>Họ và Tên:</span> {$winnerreferer->fullname}</b><br />
							<b><span>Email:</span> {$winnerreferer->email}</b><br />
							<b><span>Số điện thoại:</span> {$winnerreferer->phone}</b><br />
							<b><span>CMND:</span> {$winnerreferer->cmnd}</b><br />
							<b><span>Tỉnh/Thành phố:</span> {$winnerreferer->regionname}</b><br />
						</p>
					{else}
						Không có ai giới thiệu người trúng giải này.
					{/if}
				</div>
			</div>
		{/if}
	<br/>
    <img src="{$currentTemplate}images/giare/Web_800x450px-nen.jpg"/>	
    </div>
</div>
	
