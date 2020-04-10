<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
    <li><a href="{$conf.rooturl_admin}{$controller}">User</a> <span class="divider">/</span></li>
    <li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_user_list"><h1>{$lang.controller.head_add}</h1></div>

<form action="" method="post" name="myform" class="form-horizontal">
    <input type="hidden" name="ftoken" value="{$smarty.session.userEditToken}"/>


{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}



    <div class="control-group">
        <label class="control-label" for="ffname">{$lang.controller.lbFirstname} <span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="ffname" id="ffname" value="{$formData.ffname}" class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="flname">{$lang.controller.lbLastname}  <span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="flname" id="flname" value="{$formData.flname}" />
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
        <label class="control-label" for="birthDay">{$lang.controller.lbBirthday}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" class="inputdatepicker" name="fbirthday" id="birthDay" value="{$formData.fbirthday}"/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fcity">{$lang.controller.lbCity}<span
                class="star_require">*</span></label>


        <div class="controls">
            <select id="fcity" name="fcity">
                <option value="">- - - -</option>
			    {foreach item=city key=key from=$City}
	                <option value="{$key}" {if {$key}=={$formData.fcity}}selected="selected" {/if}>{$city}</option>
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
	                <option value="{$key}"{if {$key}=={$formData.fdistrict}}selected="selected" {/if}>{$district}</option>
			    {/foreach}
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="faddress">{$lang.controller.lbaddress}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="faddress" id="faddress" value="{$formData.faddress}"/>
        </div>
    </div>

	<div class="control-group">
        <label class="control-label" for="foaddress">{$lang.controller.lboaddress}</label>

        <div class="controls">
            <input type="text" name="foaddress" id="foaddress" value="{$formData.foaddress}"/>
        </div>
    </div>



    <div class="control-group">
        <label class="control-label" for="fmainmobile">{$lang.controller.lbmainMobile}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fmainmobile" id="fmainmobile" value="{$formData.fmainmobile}" class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fsubmobile">{$lang.controller.lbsubMobile}</label>

        <div class="controls">
            <input type="text" name="fsubmobile" id="fsubmobile" value="{$formData.fsubmobile}" class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fmainemail">{$lang.controller.lbmainEmail}<span
                class="star_require">*</span></label>

        <div class="controls">
            <input type="text" name="fmainemail" id="fmainemail" value="{$formData.fmainemail}" class="">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fsubemail">{$lang.controller.lbsubEmail}</label>

        <div class="controls">
            <input type="text" name="fsubemail" id="fsubemail" value="{$formData.fsubemail}" class="">
        </div>
    </div>



    <div class="form-actions">
        <input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary"/>
        <span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
    </div>


</form>

