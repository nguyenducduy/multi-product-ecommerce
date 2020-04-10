<style type="text/css">
    .wrap-advice {
        position: relative;
        padding: 0;
        margin: 0;
        overflow: inherit;
        border-radius: 0;
        box-shadow:none;
    }
    .wrap-advice p{
        background: #00a1e6;
        color: #fff;
        padding: 10px 10px 10px 40px;
        font-size: 15px;
        font-family: arial;
        text-transform: uppercase;
    }
    .icon-advice{
    	background-position: -330px -30px;
		position: absolute;
		left: 5px;
		top: 5px;
    }
    table{
    	padding: 10px;
    }
    .table tbody > tr > td{
		padding: 8px;
		line-height: 1.428571429;
		vertical-align: top;
		border-top: 1px solid #dddddd;
	}
	table> tbody > tr:nth-child(odd) > td, .table > tbody > tr:nth-child(odd) > th {
		background-color: #f9f9f9;
	}
	.table thead > tr > th {
		vertical-align: bottom;
	}
</style>
<div class="wrap-advice">
<p><i class="icon-advice"></i>Danh sách khách hàng tham gia dự đoán</p>
{if !empty($myuserguess)}
	<table class="table">
		<thead><tr>
			<th>Mã số</th>
			<th>Tên Khách Hàng</th>
			<th>Số điện thoại</th>
			<th>Thời gian tham gia</th>
		</tr></thead>
		<tbody>
		{if !empty($userwin)}
			{$userwin->blockuser}
		{/if}
		{foreach item=user from=$myuserguess name=listuserguess}
			<tr>
				<td>{$user->id}</td>
				<td>{$user->fullname}</td>
				<td>{$user->phone}</td>
				<td>{$user->datecreated|date_format:"%d/%m/%Y %T"}</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
{else}
<p align="center">Chưa có người dùng tham gia.</p>
{/if}
	{if $myuserguess|@count > 0}
				
                               {assign var="pageurl" value="page/::PAGE::"}
   				{paginateul count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl`/`$pageurl`"}

                             
			{/if}
</div>