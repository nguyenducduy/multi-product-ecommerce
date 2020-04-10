<div class="page-header" rel="menu_sessionmanager"><h1>Nhân viên Điện máy</h1></div>
<div class="tabbable">
   
    <div class="tab-content" >
       
        <form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
            <table style="margin: 8px 0 8px 0">
                <tr>

                    <td><input type="text" name="faccdmid" id="faccdmid" value="{$formData.faccdmid|@htmlspecialchars}" placeholder="Mã số nhân viên DM" style="width: 135px"/></td>

                    <td><input type="text" name="ffullname" id="ffullname" value="{$formData.ffullname|@htmlspecialchars}" placeholder="Họ Tên" style="width: 155px"/></td>

                    <td>
{*                        <input type="text" name="fdepartment" id="fdepartment" value="{$formData.fdepartment|@htmlspecialchars}" placeholder="Phòng ban"/>*}
                        <div class="controls">
			<select name="fdepartment" id="fdepartment"  style="width:250px;">
                        <option value="all">Tất cả phòng ban</option>
			{$strop}
			</select>
                        </div>
                    </td>

                    <td><input type="text" name="fphone" id="fphone" value="{$formData.fphone|@htmlspecialchars}" placeholder="Phone" style="width: 100px"/></td>

                    <td><input type="text" name="femail" id="femail" value="{$formData.femail|@htmlspecialchars}" placeholder="Email" style="width: 134px"/></td>

                    <td><input type="text" name="faccddid" id="faccddid" value="{$formData.faccddid|@htmlspecialchars}" placeholder="Mã số nhân viên TGDD" style="width: 150px"/></td>

                    <td><input type="button" class="btn" name="fsubmitbulk" class="btn" value="Search" style="width: 70px" onclick="gosearch()"/></td>

                </tr>


            </table>

        </form>
                <span id="divloadtab">
            <div><h3>Kết quả tìm kiếm</h3></div>
            {if {$countuser}>0}
                <table class="table table-condensed">
                    <tr>

                        <th>dienmay ID</th>

                        <th>Avatar</th>

                        <th>Fullname</th>

                        <th>Department </th>

                        <th>Phone</th>

                        <th>Email</th>

                        <th>Region</th>

                        <th>Date Login</th>

                        <th>Thegioididong ID</th>

                    </tr>
                    {foreach $listuser as $k=>$v}
                    <tr>

                        <td>
                            {$v->id}
                        </td>
                        <td>
                            <img src="{$v->imgavarta}" width="50px">
                        </td>
                        <td>
                            {$v->fullname}
                        </td>
                        <td>
                            {$v->depart}
                        </td>
                        <td>
                             {if $v->phone!=''}{$v->phone}{else}-{/if}
                        </td>
                        <td>
                            {if $v->email!=''}{$v->email}{else}-{/if}
                        </td>
                        <td>
                            {$v->regionname}
                        </td>
                        <td>
                            {$v->lastdatef}
                        </td>
                        <td>
                            {$v->oauthUid}
                        </td>

                    </tr>
                    {/foreach}
                    <tr>
                        <td colspan="9">
                            <div class="pagination">
                                {assign var="pageurl" value="page/::PAGE::"}
                                     {paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
                            </div>
                        </td>

                    </tr>
                </table>
            {else}
                <table class="table table-condensed">
                    <tr>

                        <tr>
                            <td colspan="9">
                                Không tìm thấy nhân viên bạn muốn tìm
                            </td>
                        </tr>

                    </tr>

                </table>
            {/if}
            </span>
       </div>
    </div>


<script>
    
    var rootindexpeople = '{$conf.rooturl}profile/people/indexajax';
    var faccdmid     = ''; 
    var ffullname    = '';
    var fdepartment  = '';
    var fphone       = ''; 
    var femail       = ''; 
    var faccddid     = ''; 
    var page         = 0; 
    {literal}
    $(document).ready(function(){
        $("#fdepartment").select2();
    });
    function gosearch()
    {
        var codehtml = '<div style="text-align: center">Đang tìm kiếm<br><img src="'+rooturl+'/templates/default/images/ajax-loader.gif"></div>';
        var oldhtml = $('#divloadtab').html();
        $('#divloadtab').html(codehtml);
        faccdmid     = $('#faccdmid').val();
        ffullname    = $('#ffullname').val();
        fdepartment  = $('#fdepartment').val();
        fphone       = $('#fphone').val();
        femail       = $('#femail').val();
        faccddid     = $('#faccddid').val();
        
       var datasend = {
            action      : "searchpeople",
            faccdmid    : faccdmid ,  
            ffullname   : ffullname , 
            fdepartment : fdepartment,
            fphone      : fphone,
            femail      : femail,
            faccddid    : faccddid,
            page        : page,
        };
        
     
        $.ajax({
                type: "POST",
                data: datasend,
                url:  rootindexpeople,
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                dataType: "html",
                success: function (data) {
                        if(data!='')
                        {
                           $('#divloadtab').html(data); 
                        }
                        else
                        {
                            $('#divloadtab').html(oldhtml); 
                        }
                }
        })
    }
    function sendpage(pagesend)
    {
         var datasend = {
            action      : "searchpeople",
            faccdmid    : faccdmid ,  
            ffullname   : ffullname , 
            fdepartment : fdepartment,
            fphone      : fphone,
            femail      : femail,
            faccddid    : faccddid,
            page        : pagesend,
        };
            $.ajax({
                    type: "POST",
                    data: datasend,
                    url:  rootindexpeople,
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    dataType: "html",
                    success: function (data) {
                               if(data!='')
                        {
                           $('#divloadtab').html(data); 
                        }
                    }
            })
    }
    
    {/literal}
</script>




