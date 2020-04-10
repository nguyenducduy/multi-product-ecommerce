COM

<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
    <li><a href="{$conf.rooturl_admin}{$controller}">User</a> <span class="divider">/</span></li>
    <li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_user_list"><h1>{$lang.controller.head_add}</h1></div>

<form action="" method="post" name="myform" class="form-horizontal">
    <input type="hidden" name="ftoken" value="{$smarty.session.userAddToken}"/>


{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}



    <div class="control-group">
        <label class="control-label" for="fCompanyName">{$lang.controller.lbCompanyName} <span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fCompanyName" id="fCompanyName" value="{$formData.fname|@htmlspecialchars}" class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fCompanyAddress">{$lang.controller.lbCompanyAddress}  <span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fCompanyAddress" id="fCompanyAddress"/>
        </div>
    </div>




    <div class="control-group">
        <label class="control-label" for="fCompanyTaxNo">{$lang.controller.lbCompanyTaxNo}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text"  name="fCompanyTaxNo" id="fCompanyTaxNo"/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fCompanyMobile">{$lang.controller.lbCompanyMobile}<span
                class="star_require">*</span></label>


        <div class="controls">
            <input type="text" name="fCompanyMobile" id="fCompanyMobile"/>
        </div>

    </div>

    <div class="control-group">
        <label class="control-label" for="fCustomerFullName">{$lang.controller.lbCustomerFullName}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fCustomerFullName" id="fCustomerFullName"/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fCustomerEmail">{$lang.controller.lbCustomerEmail}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fCustomerEmail" id="fCustomerEmail"/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fCustomerMobile">{$lang.controller.lbCustomerMobile}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fCustomerMobile" id="fCustomerMobile" value="" class="">
        </div>
    </div>


	<div class="control-group">
        <label class="control-label" for="fpassword">{$lang.controller.lbfcpassword}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="password" name="fpassword" id="fpassword" value="" class="">
        </div>
    </div>

    <div class="form-actions">
        <input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary"/>
        <span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
    </div>


</form>

