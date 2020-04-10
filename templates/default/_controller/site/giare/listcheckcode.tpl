<table width="740" cellspacing="1" cellpadding="5" class='checkcodeajax'>
    {if $countmember==1}
        
                           {foreach $member as $k=>$v} 
                            <tbody style="width: 100%">
                                <tr>
                                    <td colspan="3" width="" style="font-size: 24px;font-weight: bolder;text-align: center">Thông tin của bạn trong chương trình : </td>
                                </tr>
                                <tr>
                                    <td width="" style="height: 32px"><b>Tên</b> : {$v->fullname}</td>
                                    <td width=""><b>Số điện thoại</b> : {$v->phone}</td>
                                    <td width=""><b>Email</b> : {$v->email}</td>
                                </tr>
                                <tr>
                                    <td width="" style="height: 32px"><b>CMND</b> : {$v->cmnd}</td>
                                    <td width="" colspan="2"><b>Link chia sẻ</b> : {$formData.link}</td>
                                </tr>
                            </tbody>
                            <tr bgcolor="#00a1e6" height="35px" align="center" style="color:#ff0; font-weight:bold">
                              <td width="" style="padding-left: 50px;text-align: left">Mã số</td>
                              <td width="" >Mã số của bạn đến từ</td>
                              <td width="">Thời gian tạo</td>
                            </tr>
                           {/foreach}
                           {foreach $mycode as $k=>$v}    
                            <tr align="center" height="35px">
                              <td style="padding-left: 50px;text-align: left">{$v->code}</td>
                              <td >{$v->typename}</td>
                              <td>{$v->timecreate}</td>
                            </tr>
                            {/foreach}
                          
                           
                            
                            <tr align="center" height="35px" bgcolor="#fff">
                                <td colspan="6" align="right" onclick="showds('hide')"><span class="danh_sach"  style="color:#00a1e6;cursor: pointer" >Đóng danh sách</span></td>
                            </tr>
      {else}
                            <tr align="center" height="35px">
                                <td colspan="6">Hiện tại chưa có người tham gia chương trình</td>
                            </tr>
       
       {/if}
</table>