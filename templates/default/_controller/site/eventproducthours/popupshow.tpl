 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Campaign 29</title>
<link type="text/css" rel="stylesheet" href="http://dienmay.myhost/templates/default/min/?g=css&ver=196-02112012" media="screen" />
<link type="text/css" rel="stylesheet" href="{$currentTemplate}css/site/style29.css" media="screen" />
<script src="{$currentTemplate}/js/jquery.js"></script>
</head>
<style type="text/css">
  .pagination{
    position: relative;
  }
  .paginate_dot{
    float: left;
  }
  .inlinepopup292 td{
    text-align: left;
  }
</style> 
<body>
 <div>
                   <div id='inline_content292' class="inlinepopup292" >
                        <div class="rowpopup292">Danh sách khách hàng tham gia mua sản phẩm {$eventProduct->name} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div>
                    	<p><i>Lưu ý:</i> Chỉ duy nhất khách hàng thứ 33 mới được quyền MUA SẢN PHẨM VỚI GIÁ 33.000đ.</p>
                        <table bgcolor="#ccc" width="100%" border="0" cellspacing="1" cellpadding="0">
                       
                          <tr bgcolor="#fff" style="font-weight: bold">
                            <td>STT</td>
                            <td>Họ và tên</td>
                            <td>SĐT</td>
                            <td>Email</td>
                          </tr>
                         
                         {if $eventUserHoursList|@count > 0}
                            {foreach from=$eventUserHoursList item=euserlist key=key}
                              <tr bgcolor="#fff">
                                <td><span {if $key == 33}class="red29"{/if}>{$key}</span></td>
                                <td><span {if $key == 33}class="red29"{/if}>{$euserlist[0]->fullname}</span></td>
                                <td><span {if $key == 33}class="red29"{/if}>{substr_replace($euserlist[0]->phone,'xxxx',3,4)}</span></td>
                                <td><span {if $key == 33}class="red29"{/if}>{substr_replace($euserlist[0]->email,'xxxx',strpos($euserlist[0]->email,'@')-4,4)}</span></td>
                              </tr>
                            {/foreach}
                          {else}
                               <tr bgcolor="#fff">
                                  <td colspan="4">
                                      Dang cap nhat
                                  </td>
                              </tr>
                          {/if}
			{if $eventUserHoursList|@count > 0}
				 <tfoot>
                        <tr>
                            <td colspan="9" style="background:#f1f1f1">
                                <div class="pagination">
                                    {assign var="pageurl" value="page/::PAGE::"}
                                    {paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
                                </div> <!-- End .pagination -->

                                <div class="clear"></div>
                            </td>
                        </tr>
                        </tfoot>
			{/if}
                        </table>

                 </div>
                                
            </div>
</body>
</html>
