<link href="{$currentTemplate}css/site/auction.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="{$currentTemplate}js/jquery.min.js"></script>
<!-- popup danh sách -->
{literal}
<style type="text/css">
    .clear{
        clear: both;
    }
    .listallplayer_auc ul{
        margin: 0;
        padding: 0px;
    }
    body{
        background: #fff;
    }
    .cont_auc{
        margin:10px !important;
    }
    .forminfo_auc{
        margin-top:0 !important;
    }
    .listallplayer_auc{
        margin-top: 5px;
    }
</style>
{/literal}
<div class="popup_auc_1">
	<div class="titpop">Danh sách người tham gia đấu giá</div>
    <div class="cont_auc">
        <div class="forminfo_auc">
              <input type="text" class="inpt3" id="ffullname" placeholder="Họ tên">
              <input class="tim" name="" type="button" onclick="gosearch()"  value="TÌM"/>
                <div class="clear"></div>
         <div class="listallplayer_auc">
         	<ul>
                {if $userList|count > 0}
                    {foreach from=$userList item=user}
            	   <li>
                    	<strong>{$user->fullname}</strong>
                    	<span>{$user->price|number_format} đ</span>
                    </li>
                    {/foreach}
                    {assign var="pageurl" value="page/::PAGE::"}
                    {paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateUrl``$pageurl`"}
                {else}
                    Không tìm thấy kết quả phù hợp
                {/if}
            </ul>
         </div>
        </div>
    </div>
</div>
{literal}
<script type="text/javascript">
    var rooturl = "{/literal}{$registry->conf.rooturl}{literal}";
    function gosearch()
    {
        var path = rooturl + "site/reverseauctions/listuser/pid/{/literal}{$productid}{literal}";
        var fullname = $('#ffullname').val();
        if(fullname.length > 0)
        {
            path += '/fullname/' + fullname;
        }

        document.location.href= path;
    }

</script>
{/literal}