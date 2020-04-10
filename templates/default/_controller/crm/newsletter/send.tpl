<h2>{$lang.controller.head_send}</h2>

<form action="" method="post" name="myform" enctype="multipart/form-data">
<input type="hidden" name="ftoken" value="{$smarty.session.newsletterSendToken}" />
<div class="content-box"><!-- Start Content Box -->
	<div class="content-box-header">		
		<h3>{$lang.controller.title_send}</h3>
		<ul class="content-box-tabs">
			<li><a href="#tab1" class="default-tab">{$lang.default.formFormLabel}</a></li> <!-- href must be unique and match the id of target div -->
		</ul>
		<ul class="content-box-link">
			<li><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></li>
		</ul>
		<div class="clear"></div>  
	</div> <!-- End .content-box-header -->
	
	<div class="content-box-content">
		<div class="tab-content default-tab" id="tab1">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
			
				<fieldset>
				<p>
					<label>Subject : {$myNewsletter->subject}</label>
					
				</p>
				<p>
					<label>From : <em>{$myNewsletter->fromname}&lt;{$myNewsletter->fromemail}&gt;</em></label>
					
				</p>
				<p>
					<label>To (Maximum {$formData.maxToEmail} emails) : Fetch result email: {$toEmailListCount}</label>
					<textarea class="text-input"  rows="10" name="femaillist" id="femaillist">{$formData.femaillist}</textarea>
				</p>
				
				<p>
					<label><strong>SQL Query to get user email (For Advanced User) : </label>
					SELECT email FROM user u
					INNER JOIN profile p ON u.u_id = p.u_id
					WHERE</strong>
					<input type="text" name="fquery" id="fquery" size="40" value="{$formData.fquery|default:"u.u_id > 0 limit 3"}" class="text-input">
					<input type="submit" name="fquerysubmit" value="Fetch" />
					<br />
					(Available columns: u.u_id, u_avatar, u_groupid, u_count_book, b_count_review, u_count_quote, u_count_friend, u_count_sell, u_count_shelf,
					u_count_fav, u_datelastaction, u_gender, u_region, u_point, u_privacy_binary, u_datecreated, u_datemodified, u_datelastlogin, u_oauth_partner)
				</p>
				               
				</fieldset>
			
		</div>
		
	</div>
	
	<div class="content-box-content-alt">
		<fieldset>
		<p>
			<input type="submit" name="fsubmit" value="START SEND EMAIL" class="btn btn-primary btn-large">
			<br /><small><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</small>
		</p>
		</fieldset>
	</div>

    	
</div>
</form>





