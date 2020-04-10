<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
    <li><a href="{$conf.rooturl_admin}{$controller}">Customer</a> <span class="divider">/</span></li>
    <li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_user_list"><h1>{$lang.controller.head_add}</h1></div>


<form action="" method="post" name="myform" class="form-horizontal">
    <input type="hidden" name="ftoken" value="{$smarty.session.userAddToken}"/>


{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}



    <div class="control-group">
        <label class="control-label" for="ffname">{$lang.controller.lbFirstname} <span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="ffname" id="ffname" value="{$formData.fname|@htmlspecialchars}" class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="flname">{$lang.controller.lbLastname}  <span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="flname" id="flname"/>
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
        <label class="control-label" for="fisemail">{$lang.controller.lbGender} <span class="star_require">*</span></label>

        <div class="controls">
            <select id="fisemail" name="fisemail">
                <option value="1">Có</option>
                <option value="0">Không</option>
            </select>
        </div>
    </div>




    <div class="control-group">
        <label class="control-label" for="birthDay">{$lang.controller.lbBirthday}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" class="inputdatepicker" name="fbirthday" id="birthDay"/>
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
            <input type="text" name="faddress" id="faddress"/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fpersonal">{$lang.controller.lbpersonalID}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fpersonal" id="fpersonal" value="" class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fmainmobile">{$lang.controller.lbmainMobile}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fmainmobile" id="fmainmobile" value="" class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fsubmobile">{$lang.controller.lbsubMobile}</label>

        <div class="controls">
            <input type="text" name="fsubmobile" id="fsubmobile" value="" class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fmainemail">{$lang.controller.lbmainEmail}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fmainemail" id="fmainemail" value="" class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fsubemail">{$lang.controller.lbsubEmail}</label>

        <div class="controls">
            <input type="text" name="fsubemail" id="fsubemail" value="" class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="ftaxno">{$lang.controller.lbtaxNo}</label>

        <div class="controls">
            <input type="text" name="ftaxno" id="ftaxno" value="" class="">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="fpassword">{$lang.controller.lbpassword}</label>

        <div class="controls">
            <input type="password" name="fpassword" id="fpassword" value="" class="">
        </div>
    </div>

    <div class="form-actions">
        <input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary"/>
        <span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
    </div>    
    



</form>

