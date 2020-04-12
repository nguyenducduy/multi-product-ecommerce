<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="https://ecommerce.kubil.app/templates/default/min/?g=css&ver=196-02112012" media="screen" />
<link type="text/css" rel="stylesheet" href="{$currentTemplate}css/site/style29.css" media="screen" />
<script src="{$currentTemplate}/js/jquery.js"></script>
<title>Untitled Document</title>
<style type="text/css">
    td{
        padding:5px;
        line-height: 18px;
        color: #333;
        font:13px arial;
    }
    table{
      width: 100%;
    }
    table body > tr:nth-child(odd) > td, table tbody > tr:nth-child(odd) > td {
     background-color: #f9f9f9;
    }
    table th, table td {
      padding: 8px;
      line-height: 20px;
      text-align: left;
      vertical-align: top;
      border-top: 1px solid #dddddd;
  }
</style>
</head>

<body>
   <div class="rowpopup292">Danh sách khách hàng đăng ký &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div>
<table cellspacing="0" cellpadding="0">
  <col width="32" />
  <col width="200" span="2" />
  <col width="100" span="2" />
  <col width="100" span="2" />
  <col width="300" span="2" />
  <col width="300" span="2" />
   <col width="300" span="2" />
  <tr>
    <td dir="ltr" width="64">STT</td>
    <td dir="ltr" width="135">Tên KH</td>
    <td dir="ltr" width="247">Email</td>
    <td dir="ltr" width="247">Số điện thoại</td>
    <td dir="ltr" width="247">Ngày đăng ký</td>
  </tr>
  {if !empty($listfulluser)}
  {foreach item=fulluser from=$listfulluser}
  <tr {if $fulluser->position == 1} style="color: red" {/if}>
    <td width="64">{$fulluser->position}</td>
    <td dir="ltr" width="135">{$fulluser->fullname}</td>
    <td>{$fulluser->email}</td>
    <td dir="ltr" width="247">{$fulluser->phone}</td>
    <td dir="ltr" width="247">{$fulluser->datemodified|date_format:$lang.default.dateFormatTimeSmarty}</td>
  </tr>
  {/foreach}
  {else}
   <tr >
    <td colspan="4">Chưa có khách hàng đăng ký</td>
  </tr>
  {/if}
</table>
</body>
</html>