<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_crm}">Dashboard</a> <span class="divider">/</span></li>
    <li><a href="{$conf.rooturl_crm}{$controller}">User</a> <span class="divider">/</span></li>
    <li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_user_list"><h1>{$lang.controller.head_add}</h1></div>

<form action="" method="post" name="myform" class="form-horizontal">
    <input type="hidden" name="ftoken" value="{$smarty.session.userAddToken}"/>


{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}



    <div class="control-group">
        <label class="control-label" for="fstrFullname">{$lang.controller.lbstrFullname} <span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fstrFullname" id="fstrFullname" value="Nguyễn Hoàng Quân" class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fstrPersonalID">{$lang.controller.lbstrPersonalID} <span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fstrPersonalID" id="fstrPersonalID" value="024649477" class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fgender">{$lang.controller.lbGender} <span class="star_require">*</span></label>

        <div class="controls">
            <select id="fgender" name="fgender">
                <option value="1">Nam</option>
                <option value="0">Nữ</option>
            </select>
        </div>
    </div>




    <div class="control-group">
        <label class="control-label" for="birthDay">{$lang.controller.lbBirthday}</label>

        <div class="controls">
            <input type="text" class="inputdatepicker" name="fbirthday" id="birthDay" value='15/11/1989'/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fcity">{$lang.controller.lbCity}<span
                class="star_require">*</span></label>


        <div class="controls">
            <select id="fcity" name="fcity">
                <option value="">- - - -</option>
			    {foreach item=city key=key from=$City}
	                <option value="{$key}">{$city}</option>
			    {/foreach}
            </select>
        </div>

    </div>

    <div class="control-group">
        <label class="control-label" for="fdistrict">{$lang.controller.lbdistrict}<span
                class="star_require">*</span></label>

        <div class="controls">
            <select id="fdistrict" name="fdistrict">
                <option value="">- - - -</option>
			    {foreach item=district key=key from=$District}
	                <option value="{$key}">{$district}</option>
			    {/foreach}
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="faddress">{$lang.controller.lbaddress}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="faddress" id="faddress" value='206/22, lê văn quới'/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fBillAddress">{$lang.controller.lbBillAddress}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fBillAddress" id="fBillAddress" value='206/22, lê văn quới' class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fmainmobile">{$lang.controller.lbmainMobile}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fmainmobile" id="fmainmobile" value="01267171723" class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fShippAddress">{$lang.controller.lbShippAddress}</label>

        <div class="controls">
            <input type="text" name="fShippAddress" id="fShippAddress" value='206/22, lê văn quới' class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fmainemail">{$lang.controller.lbmainEmail}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fmainemail" id="fmainemail" value="ngoctai999@yahoo.com" class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fStoreID">{$lang.controller.lbStoreID}</label>

        <div class="controls">
            <input type="text" name="fStoreID" id="fStoreID" value="1" class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="ftaxno">{$lang.controller.lbtaxNo}</label>

        <div class="controls">
            <input type="text" name="ftaxno" id="ftaxno" value="123456" class="">
        </div>
    </div>

	<div class="control-group">
        <label class="control-label" for="fNote">{$lang.controller.lbNote}</label>

        <div class="controls">
            <input type="text" name="fNote" id="fNote" value="aaaa" class="">
        </div>
    </div>

	<div class="control-group">
        <label class="control-label" for="fPayment">{$lang.controller.lbPayment}</label>

        <div class="controls">
            <input type="text" name="fPayment" id="fPayment" value="1" class="">
        </div>
    </div>

	<div class="control-group">
        <label class="control-label" for="fDelivery">{$lang.controller.lbDelivery}</label>

        <div class="controls">
            <select id="fDelivery" name="fDelivery">
                <option value="1">Có</option>
                <option value="0">Không</option>
            </select>
        </div>
    </div>

	<div class="control-group">
        <label class="control-label" for="fShippingCost">{$lang.controller.lbShippingCost}</label>

        <div class="controls">
            <input type="text" name="fShippingCost" id="fShippingCost" value="1" class="">
        </div>
    </div>

	<div class="control-group">
        <label class="control-label" for="fCurrencyUnit">{$lang.controller.lbCurrencyUnit}</label>

        <div class="controls">
            <input type="text" name="fCurrencyUnit" id="fCurrencyUnit" value="1" class="">
        </div>
    </div>

	<div class="control-group">
        <label class="control-label" for="fCurrencyExchange">{$lang.controller.lbCurrencyExchange}</label>

        <div class="controls">
            <input type="text" name="fCurrencyExchange" id="fCurrencyExchange" value="1" class="">
        </div>
    </div>

	<div class="control-group">
        <label class="control-label" for="fProductID">{$lang.controller.lbProductID}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fProductID" id="fProductID" value="1" class="">
        </div>
    </div>

	<div class="control-group">
        <label class="control-label" for="fQuantity">{$lang.controller.lbQuantity}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fQuantity" id="fQuantity" value="1" class="">
        </div>
    </div>

	<div class="control-group">
        <label class="control-label" for="fProductCode">{$lang.controller.lbProductCode}</label>

        <div class="controls">
            <input type="text" name="fProductCode" id="fProductCode" value="1" class="">
        </div>
    </div>

	<div class="control-group">
        <label class="control-label" for="fIMEI">{$lang.controller.lbIMEI}</label>

        <div class="controls">
            <input type="text" name="fIMEI" id="fIMEI" value="1" class="">
        </div>
    </div>

	<div class="control-group">
        <label class="control-label" for="fCategoryID">{$lang.controller.lbCategoryID}</label>

        <div class="controls">
            <input type="text" name="fCategoryID" id="fCategoryID" value="1" class="">
        </div>
    </div>

	<div class="control-group">
        <label class="control-label" for="fPrice">{$lang.controller.lbPrice}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fPrice" id="fPrice" value="1" class="">
        </div>
    </div>

	<div class="control-group">
        <label class="control-label" for="fProductList">{$lang.controller.lbProductList}</label>

        <div class="controls">
            <input type="text" name="fProductList" id="fProductList" value="" class="">
        </div>
    </div>



	<div class="control-group">
        <label class="control-label" for="fCouponCode">{$lang.controller.lbCouponCode}</label>

        <div class="controls">
            <input type="text" name="fCouponCode" id="fCouponCode" value="1" class="">
        </div>
    </div>

	<div class="control-group">
        <label class="control-label" for="fCouponDiscount">{$lang.controller.lbCouponDiscount}</label>

        <div class="controls">
            <input type="text" name="fCouponDiscount" id="fCouponDiscount" value="1" class="">
        </div>
    </div>

	<div class="control-group">
        <label class="control-label" for="fOWNERBANKNAME">{$lang.controller.lbOWNERBANKNAME}</label>

        <div class="controls">
            <input type="text" name="fOWNERBANKNAME" id="fOWNERBANKNAME" value="1" class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fEXPIRATIONDATEBANKACC">{$lang.controller.lbEXPIRATIONDATEBANKACC}</label>

        <div class="controls">
            <input type="text" name="fEXPIRATIONDATEBANKACC" id="fEXPIRATIONDATEBANKACC" value="1" class="inputdatepicker">
        </div>
    </div>

    <div class="form-actions">
        <input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary"/>
        <span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
    </div>


</form>

