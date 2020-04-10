

<div class="navbarprod">
	<li><a href="{$conf.rooturl}">Trang chủ</a> ››</li>
	<li>Thông tin tài khoản</li>
</div>

<!-- Profiles -->
<div class="wr-profile">

    <div class="profiles_left">
        <ul>
            <li class="bar-l">Tài khoản của tôi</li>
            <li><a href="{$conf.rooturl}account/detail"  ><e class="ic-pr-user"></e>Thông tin cá nhân</a></li>
            <li><a href="#" class="active"><e class="ic-pr-bill"></e>Đơn hàng của tôi</a></li>
            <li><a href="{$conf.rooturl}account/bookmark/id/{$codeuser}"><e class="ic-pr-list"></e>Sản phẩm tôi yêu thích</a></li>
            <li><a href="{$conf.rooturl}account/checksaleorder"><e class="ic-pr-check"></e>Kiểm tra đơn hàng</a></li>
        </ul>
    </div>
    <div class="Pr-invoice">
        <h3>Đơn hàng của tôi ({count($formData.saleorder)})</h3>
        <div class="table-pr">
            {if !empty($formData)}
            <table style="width: 100%">
                <tr class="Pr-orderth">
                    <th class="tb-th " >Mã Đơn hàng</th>
                    <th class="tb-th " >Ngày đặt</th>
                    <th class="tb-th " >Tổng giá trị</th>
                    <th class="tb-th " >Tình trạng đơn hàng</th>
                    <th class="tb-th " >Chi tiết đơn hàng</th>
                </tr>

                    {foreach from=$formData.saleorder key=key item=giatri}
                    <tr id='tr_sale_{$key}'>
                        <td class="tb-td-num">{$giatri.SALEORDERID}</td>
                        <td class="tb-td">{$giatri.INPUTTIME}</td>
                        <td class="tb-td">{$giatri.TOTALAMOUNT|number_format}</td>
                        <td class="tb-td">Thành công</td>
                        <td class="tb-td"><span style="cursor: pointer" onclick="viewdetail('{$giatri.SALEORDERID}','{$key+1}')">Xem chi tiết</span></td>
                    </tr>
                    <tr style="display: none" id="tr_{$giatri.SALEORDERID}" class='detailtr'>

                        <td colspan="5" class="Pr-orderrowdetail">
                            <div class="bill-detail " >

                                <div class="tb-detail">
                                    <div class=" dtail-header">
                                        <div class="dtail-th">Sản Phẩm</div>
                                        <div class="dtail-th">Số lượng</div>
                                        <div class="dtail-th">Thành tiền</div>
                                    </div>
                                     {foreach from=$formData.saleorderdetail  key=k item=v}
                                        {if $k == $key}
                                            {foreach $v as $khoa=>$value}
                                            <div class="dtail-tr">
                                                <div class="dtail-td">
                                                    <img src="{$value->img}" class="image-sp">
                                                    <span class="name-sp">{$value->strProductName}</span>
                                                </div>
                                                <div class="dtail-td">{$value->strQuantity}</div>
                                                <div class="dtail-td tb-price">{$value->strSalePrice|number_format} vnđ</div>
                                            </div>
                                            {/foreach}
                                         {/if}
                                     {/foreach}
                                </div>
                                <div class="bottom">
                                    <strong>Tổng cộng </strong>(Đã bao gồm thuế VAT): <span class="tb-price">{$giatri.TOTALAMOUNT|number_format} vnđ</span><br>
                                    <em>* Chưa bao gồm phí vận chuyển hàng hóa</em>
                                </div>
                            </div>
                        </td>
                    </tr>
                    {/foreach}

            </table>
            {else}
                Bạn chưa mua hàng tai <span style="color: #00a1e6;"><b>dienmay.com</b></span>
            {/if}

        </div>

    </div>
</div>

{literal}
    <script>
        function viewdetail(id,key)
        {
            $('.detailtr').hide();
            $('#tr_'+id).show();
            $('#tr_sale_'+key).addClass('Pr-ordertrbelow');
        }

    </script>
{/literal}
