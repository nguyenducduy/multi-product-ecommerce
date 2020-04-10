<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Customer Invoice">
    <meta name="author" content="5marks">

    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
      .invoice-head td {
        padding: 0 8px;
      }
      .container {
      	padding-top:30px;
      }
      .invoice-body{
      	background-color:transparent;
      }
      .invoice-thank{
      	margin-top: 60px;
      	padding: 5px;
      }
      address{
      	margin-top:15px;
      }
    </style>


  </head>

  <body>
    <div class="container">
    	<div class="row">
    		<div class="span5 ">
    			<img src="http://www.dienmay.com/Themes/dienmay.com/images/logo.png" title="logo">
          <table class="invoice-head">
            {foreach $saleorder_info as $k=>$V}
            <tbody>
              <tr>
                <td class="pull-right"><strong>Loại đơn hàng</strong></td>
                <td>{$V->orderTypeName}</td>
              </tr>
            <tr>
                <td class="pull-right"><strong>Người Lập</strong></td>
                <td>{$V->inputUser}</td>
              </tr>
              <tr>
                <td class="pull-right"><strong>Người xử lý</strong></td>
                <td>{$V->reviewedUser}</td>
              </tr>
            <tr>
                <td class="pull-right"><strong>Người giao hàng</strong></td>
                <td>{$V->deliveryUser}</td>
              </tr>
              <tr>
                <td class="pull-right"><strong>Ngày lập</strong></td>
                <td>{$V->inputTime}</td>
              </tr>
              <tr>
                <td class="pull-right"><strong>Ngày giao</strong></td>
                <td>{$V->deliveryTime}</td>
              </tr>
             

            </tbody>
            {/foreach}
          </table>
    		</div>
    		<div class="span5 well">
    			<table class="invoice-head">
    				{foreach $customer as $k=>$V}
    				<tbody>
    					<tr>
    						<td class="pull-right"><strong>Customer #</strong></td>
    						<td><a href="{$conf.rooturl_crm}customer/detail/group/{$smarty.session.customerGroup}/id/{$V.CUSTOMERID}">{$V.CUSTOMERID}</a></td>
    					</tr>
						<tr>
    						<td class="pull-right"><strong>Customer Email</strong></td>
    						<td>{$V.MAINEMAIL}</a></td>
    					</tr>
    					<tr>
    						<td class="pull-right"><strong>Phone</strong></td>
    						<td>{$V.MAINMOBILE}</td>
    					</tr>
						<tr>
    						<td class="pull-right"><strong>Full Name</strong></td>
    						<td>{$V.FULLNAME}</a></td>
    					</tr>
    					
    				</tbody>
    				{/foreach}
    			</table>
    		</div>
    	</div>
    	<div class="row">
    		<div class="span10">
    			<h1><big>Invoice #{$formData.saleid}</big></h1>
    		</div>
    	</div>
    	<div class="row">
		  	<div class="span10 well invoice-body">
		  		<table class="table table-bordered">
					<thead>
						<tr>
							<th width="30">Thứ tự</th>
							<th width="60">Hình</th>
							<th>Tên sản phẩm</th>
							<th>Số lượng</th>
							<th width="164" style="text-align:center;">Giá bán</th>
							<th width="140">Sync</th>
						</tr>
					</thead>
					<tbody>
						{foreach $saleorder as $k=>$V}
						<tr>
							<td style="text-align:center;">{$k+1}</td>
							<td><img src="{$V->img}" width="50" /></td>
							<td>
               <b> {$V->strProductName} </b></br>
                [{if {$V->strImei}!=""}{$V->strImei}{elseif {$V->strImei}==""}Empty{/if}]
              </td>
							<td>{$V->strQuantity}</td>
							<td style="text-align:center;">{$V->strTotalCost|number_format:0:",":"."} VND</td>
							<td style="align:center"><span class="label {if {$V->sync} == "V"}label-success{elseif {$V->sync} == "X"}label-important{/if}">{$V->sync}</span></td>
						</tr>
						{/foreach}
						
						<tr>
							<td colspan="4" style="text-align:right;">Tổng cộng</td>
							<td><strong>{$formData.totalorder|number_format:0:",":"."} VNĐ</strong></td>
              <td></td>
						</tr>
						<tr>
							<td colspan="4" style="text-align:right;">Khuyến mãi</td>
							<td><strong>{$formData.promotionmoney|number_format:0:",":"."} VNĐ</strong></td>
              <td></td>
						</tr>
						<tr>
							<td colspan="4" style="text-align:right;">Tổng thanh toán</td>
							<td><strong style="color:#03f;"><big>{$formData.totalpayment|number_format:0:",":"."} VNĐ</big></strong></td>
              <td></td>
						</tr>

					</tbody>
				</table>
				
				<div id="saleordernote">Ghi chú: <em>N/A</em></div>
				<div id="saleorderpromotion">Thông tin khuyến mãi: <em>{$formData.discountname}</em></div>
		  	</div>
  		</div>
  		
    </div>

  </body>
</html>
