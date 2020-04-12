<link type="text/css" rel="stylesheet" href="https://ecommerce.kubil.app/templates/default/css/site/giare.css" media="screen" />
<div class="pop_up_tham_gia" style="display: block;height: 90px;">
    <div>
            <div class="font24">Bạn đã {$formData.msg} thành công chương trình mua sản phẩm giá 1000đ.</div> <br />
            <div>Mã số dự thưởng của bạn là:
                {foreach $code as $k=>$v}
                    <span class="font12"> {$v->code}</span>{if count($code)>1},{/if}
                {/foreach}
                <div>
                	<p>Để nhận thêm mã dự thưởng, hãy mời bạn bè tham gia bằng cách gửi link <a href="javascript:parent.location.href='{$conf.rooturl}giare/{$formData.id}'">{$conf.rooturl}giare/{$formData.id}</a> tại</p>
					<p>o Facebook của bạn hoặc bạn bè </p>
					<p>o Fanpage của bạn đang quản lý hoặc tham gia</p>
					<p>o Các thảo luận trên forum hoặc chữ ký của bạn.</p>
					<p>o Chat với bạn bè trên yahoo messenger, skype hoặc gửi email.</p>
					...
					<p>Càng nhiều mã số, càng nhiều cơ hội trúng thưởng, chúc bạn may mắn.</p>
				</div>
            </div>
    </div>
</div>   
    
