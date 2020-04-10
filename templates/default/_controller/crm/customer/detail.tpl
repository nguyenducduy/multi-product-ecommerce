<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
    <li><a href="{$conf.rooturl_admin}{$controller}">CRM</a> <span class="divider">/</span></li>
    <li class="active">{$lang.controller.head_detail}</li>
</ul>

<div class="page-header" rel="menu_user_list"><span class="label label-success"><h1 style='margin-bottom: 0px'>{$lang.controller.head_detail}</h1></span></div>

<form action="" method="post" name="myform" class="form-horizontal">
    <input type="hidden" name="ftoken" value="{$smarty.session.userAddToken}"/>


{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}

{if $formData.group==0}
	{foreach $customer as $K=>$V}

		    <div class="control-group">
		        <label class="control-label" >{$lang.controller.lbrid} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text" disabled="disabled"  value="{if {$V.CUSTOMERID}==""}{$lang.controller.lbdempty}{else}{$V.CUSTOMERID}{/if}" class="">
		        </div>
		    </div>

			<div class="control-group">
		        <label class="control-label" >{$lang.controller.lbdfullname} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text" disabled="disabled"  value="{if {$V.FULLNAME}==""}{$lang.controller.lbdempty}{else}{$V.FULLNAME}{/if}" class="">
		        </div>
		    </div>


		    <div class="control-group">
		        <label class="control-label" >{$lang.controller.lbBirthday} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text"  disabled="disabled"  value="{if {$V.BIRTHDAY}==""}{$lang.controller.lbdempty}{else}{$V.BIRTHDAY}{/if}" class="">
		        </div>
		    </div>



		    <div class="control-group">
		        <label class="control-label" >{$lang.controller.lbaddress} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text"disabled="disabled"value="{if {$V.ADDRESS}==""}{$lang.controller.lbdempty}{else}{$V.ADDRESS}{/if}" class="">
		        </div>
		    </div>




		    <div class="control-group">
		        <label class="control-label" >{$lang.controller.lbGender} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text"disabled="disabled"value="{if {$V.GENDER} == '2'}{$lang.controller.lbdempty}{elseif {$V.GENDER}==1} {$lang.controller.lbmale} {else} {$lang.controller.lbfemale} {/if}" class="">
		        </div>
		    </div>


		    <div class="control-group">
		        <label class="control-label" >{$lang.controller.lbpersonalID} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text"disabled="disabled"value="{if {$V.PERSONALID}==""}{$lang.controller.lbdempty}{else}{$V.PERSONALID}{/if}" class="">
		        </div>
		    </div>


		    <div class="control-group">
		        <label class="control-label" >{$lang.controller.lbmainMobile} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text"disabled="disabled"value="{if {$V.MAINMOBILE}==""}{$lang.controller.lbdempty}{else}{$V.MAINMOBILE}{/if}" class="">
		        </div>
		    </div>



		    <div class="control-group">
		        <label class="control-label" >{$lang.controller.lbmainEmail} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text"disabled="disabled"value="{if {$V.MAINEMAIL}==""}{$lang.controller.lbdempty}{else}{$V.MAINEMAIL}{/if}" class="">
		        </div>
		    </div>
	{/foreach}

{/if}


<!-- ####### END DETAIL CUSTOMER #######  -->
<div class="tab-content">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.head_detail_saleorder}</a></li>
			<li><a href="#tab2" data-toggle="tab">{$lang.controller.head_detail_suppport}</a></li>
			<li><a href="#tab3"  data-toggle="tab">{$lang.controller.head_detail_sms}</a></li>
			<li><a href="#tab4"  data-toggle="tab">{$lang.controller.head_detail_email}</a></li>
			
		</ul>


		<div class="tab-pane active" id="tab1">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
			
			<form class="form-inline" action="" method="post" onsubmit="return confirm('Are You Sure ?');">
		{if $formData.countSal>0}
				<table class="table table-striped" cellpadding="5" width="100%">
					<thead>
						<tr>
							<th align="left" >{$lang.controller.lbsaleorderid}</th>
							<th align="left" >{$lang.controller.lbsaleorderproductname}</th>
							<th width="100px">{$lang.controller.lbsaleorderprice}</th>
							<th width="100px">{$lang.controller.lbordertype}</th>
							<th width="100px"align="left">{$lang.controller.lbsaleorderdatecreat}</th>
							<th ></th>
						</tr>
					</thead>
					<tbody>
					{foreach $saleorder as $k=>$v}
						<tr>
							<td style="font-weight:bold;"><span class="label label-info">{$v->SALEORDERID}</span></td>
							<td style="font-weight:bold;">{$v->PRODUCTNAME}</td>
							<td align="center">{$v->TOTALAMOUNT} VND</td>
							<td>{$v->ORDERTYPENAME}</td>
                            <td>{$v->INPUTTIME}</td>
							<td >
									<a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl_crm}customer/detailsale/id/{$formData.idcustomer}/saleid/{$v->SALEORDERID}" class="btn btn-mini"><i class="icon-folder-open">Chi tiết</i></a>
							</td>
							
						</tr>
					{/foreach}		
				</tbody>
			{else}		
				  
				
					<tr>
						<td colspan="6"> {$lang.default.notfound}</td>
					</tr>
			{/if}	
				</table>
			</form>
		</div>


<!-- ####### END HISTORY SALEORDER #######  -->	





		<div class="tab-pane " id="tab2">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
			
			<form class="form-inline" action="" method="post" onsubmit="return confirm('Are You Sure ?');">
		{if $formData.countSup>0}
				<table class="table table-striped" cellpadding="5" width="100%">
					<thead>
						<tr>
							<th align="left" >{$lang.controller.lbticketid}</th>
							<th align="left" >{$lang.controller.lbtopicname}</th>
							<th>{$lang.controller.lbcutomernote}</th>
							<th align="left">{$lang.controller.lbupdateusernote}</th>
						</tr>
					</thead>
					<tbody>
					{foreach $ticket as $k=>$v}
						<tr>
							<td style="font-weight:bold;"><span class="label label-info">{$v->longTicketID}</span></td>
							<td style="font-weight:bold;">{$v->strTopicName}</td>
							<td align="center">{$v->strCustomerNote}</td>
							<td>{$v->strUpdatedUserNote}</td>
						</tr>
					{/foreach}		
				</tbody>
			{else}		
				  
				
					<tr>
						<td colspan="6"> {$lang.default.notfound}</td>
					</tr>
			{/if}	
				</table>
			</form>
		</div>


<!-- ####### END HISTORY SUPPORT #######  -->	

		<div class="tab-pane " id="tab3">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
			
			<form class="form-inline" action="" method="post" onsubmit="return confirm('Are You Sure ?');">
		{if $formData.countSms>0}
				<table class="table table-striped" cellpadding="5" width="100%">
					<thead>
						<tr>
							<th align="left" >{$lang.controller.lbSMSLOGID}</th>
							<th align="left" >{$lang.controller.lbPHONENUMBER}</th>
							<th>{$lang.controller.lbSMSCONTENT}</th>
							<th align="left">{$lang.controller.lbnote}</th>
						</tr>
					</thead>
					<tbody>
					{foreach $sms as $k=>$v}
						<tr>
							<td style="font-weight:bold;"><span class="label label-info">{$v->SMSLOGID}<span></td>
							<td style="font-weight:bold;">{$v->PHONENUMBER}</td>
							<td align="center">{$v->SMSCONTENT}</td>
							<td>{$v->NOTE}</td>
						</tr>
					{/foreach}		
				</tbody>
			{else}		
				  
					<tr>
						<td colspan="6"> {$lang.default.notfound}</td>
					</tr>
			{/if}	
				</table>
			</form>
		</div>


<!-- ####### END SMS Support#######  -->	


		<div class="tab-pane " id="tab4">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
			
			<form class="form-inline" action="" method="post" onsubmit="return confirm('Are You Sure ?');">
		{if $formData.countEmail>0}
				<table class="table table-striped" cellpadding="5" width="100%">
					<thead>
						<tr>
							<th align="left" >{$lang.controller.lbEMAILID}</th>
							<th align="left" >{$lang.controller.lbEMAILSUBJECT}</th>
							<th align="left">{$lang.controller.lbCUSTOMERNAME}</th>
							<th align="left">{$lang.controller.lbCUSTOMEREMAIL}</th>
							<th width="150px"align="left">{$lang.controller.lbCUSTOMERMOBILE}</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					{foreach $email as $k=>$v}
						<tr>
							<td style="font-weight:bold;"><span class="label label-info">{$v->EMAILID}</span></td>
							<td style="font-weight:bold;">{$v->EMAILSUBJECT}</td>
							<td>{$v->CUSTOMERNAME}</td>
							<td>{$v->CUSTOMEREMAIL}</td>
							<td>{$v->CUSTOMERMOBILE}</td>
							<td >
									<a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl_crm}customer/detailemail/id/{$formData.idcustomer}/emailid/{$v->EMAILID}" class="btn btn-mini" rel="shadowbox;height=250;width=550"><i class="icon-inbox">&nbsp Nội dung</i></a>
							</td>
						</tr>
					{/foreach}		
				</tbody>
			{else}		
				  
				
					<tr>
						<td colspan="6"> {$lang.default.notfound}</td>
					</tr>
			{/if}	
				</table>
			</form>
		</div>

</div>
<!-- ####### END Email Support#######  -->	

</form>


