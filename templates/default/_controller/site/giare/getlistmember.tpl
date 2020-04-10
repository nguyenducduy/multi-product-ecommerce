<table width="740" cellspacing="1" cellpadding="5" class='checklistajax'>
    {if $countmember>0}
                            <tr bgcolor="#00a1e6" height="35px" align="center" style="color:#ff0; font-weight:bold">
                              <td width="40">STT</td>
                              <td width="100px">CMND</td>
                              <td width="200px">Họ và Tên</td>
                              <td width="100px">Điện thoại</td>
                              <td width="120">Email</td>
                              <td width="180px">Mã số dự thưởng</td>
                            </tr>
                            {foreach $member as $k=>$v}    
                            <tr align="center" height="35px">
                              <td>{$k+1+(($curPage-1)*10)}</td>
                              <td>{$v->cmnd}</td>
                              <td>{$v->fullname}</td>
                              <td>{$v->phone}</td>
                              <td>{$v->email}</td>
                              <td>{if $v->link!=''}<a  onclick="getcode('{$v->link}',this)" style="cursor: pointer">danh sách mã số</a>{else}Chưa cập nhật mã{/if}</td>
                            </tr>
                            {/foreach}
                          
                            <tr>
                                <td colspan="6">
                                    <div class="pagination">
                                        {assign var="pageurl" value="page/::PAGE::"}
                                             {paginateajax count=$totalPage curr=$curPage lang=$paginateLang max=10 urlformat="getlist('::PAGE::')"}
                                    </div>
                                </td>

                            </tr>  
                            
                            <tr align="center" height="35px" bgcolor="#fff">
                                <td colspan="6" align="right" onclick="showds('hide')"><span class="danh_sach"  style="color:#00a1e6;cursor: pointer" >Đóng danh sách</span></td>
                            </tr>
      {else}
                            <tr align="center" height="35px">
                                <td colspan="6">Hiện tại chưa có người tham gia chương trình</td>
                            </tr>
       
       {/if}
</table>