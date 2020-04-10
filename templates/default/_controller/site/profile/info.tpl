<div id="panelleft">
	{literal}
	<style type="text/css">
		.profileaddform{background:#fff; padding:10px; border:1px solid #0C8EC0;}
		.profileaddformhead{font-weight:bold; background:#0C8EC0; color:#fff; padding:10px; margin-bottom:10px;}
		.profileeditform{background:#FFFDE8; margin-top:10px; padding:10px; border:1px solid #eee;}
		.profileaddlink{padding:10px; clear:both; display:block;}
		.profileaddlink:hover{background:#D2F8FF}
		.profileitem{border-bottom:1px solid #ccc; padding:10px;}
		.profileitemnoborder{border-bottom-width:0;}
		.profileitem:hover{background:#D2F8FF}
		.profileitemtitle{font-size:12px;  padding-bottom:3px;}
		.profileitembutton{float:right;}
		.profileitemtitlesub{font-size:12px; color:#555; padding-bottom:3px;}
		.profileitemtime{font-size:11px; color:#555; padding-left:0px;}
		.profileiteminputdisabled{background:#eee;}
	</style>
	{/literal}
	
	{include file="`$smartyControllerGroupContainer`topnav.tpl"}
	
		
	</div><!-- end #panelleft -->
	
	<div id="panelright">
		
		<ul id="msgtab">
			<li><a href="{$conf.rooturl}profile">{$lang.controller.tabAccount}</a></li>
			<li><a class="selected" href="{$conf.rooturl}profile/info">{$lang.controller.tabProfile}</a></li>
			<li><a href="{$conf.rooturl}profile/privacy" title="">{$lang.controller.tabPrivacy}</a></li>
			<li><a href="{$conf.rooturl}profile/changepassword">{$lang.controller.tabChangepassword}</a></li>
		</ul>
		
		{include file="notify.tpl" notifyError=$error notifySuccess=$success}
		
	  
		<div id="profileform" class="myform myformwide stylizedform">
			
				
				<h2>{$lang.controller.groupWork}</h2>
				
				<div id="worklist">
					{foreach item=profile from=$myProfileList.1}
						<div id="profile-{$profile->id}" class="profileitem">
							<div class="profileitembutton">
								<a href="javascript:void(0)" onclick="$('#profile-edit-{$profile->id}').toggle()">{$lang.controller.editLabel}</a> | 
								<a class="profiledelete" href="javascript:void(0)" onclick="profileadvanced_delete({$profile->id})">{$lang.controller.deleteLabel}</a>
							</div>
							
							<div class="profileitemtitle"><span class="companytext">{$profile->text1}</span> - <span class="regiontext">{$profile->getText3Region()}</span></div>
							
							<div class="profileitemtitlesub"><span class="jobtitletext">{$profile->text2|nl2br}</span></div>
							<div class="profileitemtime">
								{if $profile->date1_month > 0 && $profile->date1_year > 0}{$profile->date1_month}/{/if}{if $profile->date1_year > 0}{$profile->date1_year}{/if}
								
								{if $profile->date2_year > 0}
								 	- {if $profile->date2_month > 0}{$profile->date2_month}/{/if}{$profile->date2_year}
								{else}
									- {$lang.controller.now}
								{/if}
							</div>
							
							<div id="profile-edit-{$profile->id}" class="profileeditform hide">
								<div style="float:right"><a href="javascript:void(0)" onclick="$(this).parent().parent().hide()">X</a></div>
								<label>{$lang.controller.company}</label><input type="text" class="company" value="{$profile->text1}" />
								<select class="region">
									<option value="0">- - {$lang.controller.worklocation} - -</option>
									{foreach item=region key=regionid from=$setting.region}
									<option {if $regionid == $profile->text3}selected="selected"{/if} value="{$regionid}">{$region}</option>
									{/foreach}
									
								</select>
								<div class="clear"></div>
								<label>{$lang.controller.jobtitle}</label>
								<textarea class="jobtitle inputwide">{$profile->text2}</textarea>
								
								<div class="clear"></div>
								<label>{$lang.controller.datestart}</label>
								<select class="frommonth" style="width:70px">
									<option value="0">{$lang.controller.month}</option>
									{foreach item=month from=$monthList}
										<option {if $month == $profile->date1_month}selected="selected"{/if} value="{$month}">{$month}</option>
									{/foreach}
									<option value="0">{$lang.controller.monthUnknown}</option>
								</select>
								<select class="fromyear" style="width:70px">
									<option value="0">{$lang.controller.year}</option>
									{foreach item=year from=$yearList}
										<option {if $year == $profile->date1_year}selected="selected"{/if} value="{$year}">{$year}</option>
									{/foreach}
								</select><div class="clear"></div>
								{if $profile->date2_year ==0 && $profile->date2_month == 0}
									{assign var=istonow value=1}
								{else}
									{assign var=istonow value=0}
								{/if}
								<label>{$lang.controller.dateend}</label>
								<select class="tomonth tonowrelative" style="width:70px" {if $istonow == 1}disabled="disabled"{/if}>
									<option value="0">{$lang.controller.month}</option>
									{foreach item=month from=$monthList}
										<option {if $month == $profile->date2_month}selected="selected"{/if} value="{$month}">{$month}</option>
									{/foreach}
									<option value="0">{$lang.controller.monthUnknown}</option>
								</select>
								<select class="toyear tonowrelative" style="width:70px" {if $istonow == 1}disabled="disabled"{/if}>
									<option value="0">{$lang.controller.year}</option>
									{foreach item=year from=$yearList}
										<option {if $year == $profile->date2_year}selected="selected"{/if} value="{$year}">{$year}</option>
									{/foreach}
								</select>
								<label class="normal"><input type="checkbox" value="1" {if $istonow == 1}checked="checked"{/if}  class="checkbox tonow" onclick="profileadvanced_tonowcheck('#profile-edit-{$profile->id}')" />&nbsp;{$lang.controller.now}</label>
											
			
								<input type="button" onclick="profileadvanced_editwork({$profile->id})" class="submit" name="fsubmit" value="{$lang.controller.updateSubmit}" />
								
								<div class="clear"></div>
							</div>
						</div>
						
					{/foreach}
				</div>
				<div class="clear"></div>
				<div id="addworkform" class="profileaddform hide">
					<div class="profileaddformhead">{$lang.controller.addNewWork}
					
						<div style="float:right"><a href="javascript:void(0)" onclick="$('#addworkform').hide(); $('.profileaddwork').show()" style="color:#fff; font-weight:bold;">X</a></div>
					</div>
										
					<label>{$lang.controller.company}</label><input type="text" class="company" />
					<select class="region">
						<option value="0">- - {$lang.controller.worklocation} - -</option>
						{foreach item=region key=regionid from=$setting.region}
						<option value="{$regionid}">{$region}</option>
						{/foreach}
						
					</select>
					<div class="clear"></div>
					<label>{$lang.controller.jobtitle}</label>
					<textarea class="jobtitle inputwide"></textarea>
					
					<div class="clear"></div>
					<label>{$lang.controller.datestart}</label>
					<select class="frommonth" style="width:70px">
						<option value="0">{$lang.controller.month}</option>
						{foreach item=month from=$monthList}
							<option value="{$month}">{$month}</option>
						{/foreach}
						<option value="0">{$lang.controller.monthUnknown}</option>
					</select>
					<select class="fromyear" style="width:70px">
						<option value="0">{$lang.controller.year}</option>
						{foreach item=year from=$yearList}
							<option value="{$year}">{$year}</option>
						{/foreach}
					</select><div class="clear"></div>
					
					<label>{$lang.controller.dateend}</label>
					<select class="tomonth tonowrelative" style="width:70px">
						<option value="0">{$lang.controller.month}</option>
						{foreach item=month from=$monthList}
							<option value="{$month}">{$month}</option>
						{/foreach}
						<option value="0">{$lang.controller.monthUnknown}</option>
					</select>
					<select class="toyear tonowrelative" style="width:70px">
						<option value="0">{$lang.controller.year}</option>
						{foreach item=year from=$yearList}
							<option value="{$year}">{$year}</option>
						{/foreach}
					</select>
					<label class="normal"><input type="checkbox" value="1" class="checkbox tonow" onclick="profileadvanced_tonowcheck('#addworkform')" />&nbsp;{$lang.controller.now}</label>


					<input type="button" onclick="profileadvanced_addwork()" class="submit" name="fsubmit" value="{$lang.controller.addSubmit}" />
					
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<div class="profileaddwork"><a href="javascript:void(0)" onclick="$('#addworkform').show();$('.profileaddwork').hide()" class="profileaddlink">{$lang.controller.addNewWork}</a></div>
			</div>
			
			<div id="profileform" class="myform myformwide stylizedform">
				<h2>{$lang.controller.groupUniversity}</h2>
				
				<div id="universitylist">
					{foreach item=profile from=$myProfileList.2}
						<div id="profile-{$profile->id}" class="profileitem">
							<div class="profileitembutton">
								<a href="javascript:void(0)" onclick="$('#profile-edit-{$profile->id}').toggle()">{$lang.controller.editLabel}</a> | 
								<a class="profiledelete" href="javascript:void(0)" onclick="profileadvanced_delete({$profile->id})">{$lang.controller.deleteLabel}</a>
							</div>
							
							<div class="profileitemtitle"><span class="universitytext">{$profile->text1}</span> - <span class="regiontext">{$profile->getText3Region()}</span></div>
							
							<div class="profileitemtitlesub"><span class="departmenttext">{$profile->text2}</span></div>
							<div class="profileitemtime">
								{if $profile->date1_month > 0 && $profile->date1_year > 0}{$profile->date1_month}/{/if}{if $profile->date1_year > 0}{$profile->date1_year}{/if}
								
								{if $profile->date2_year > 0}
								 	- {if $profile->date2_month > 0}{$profile->date2_month}/{/if}{$profile->date2_year}
								{else}
									- {$lang.controller.now}
								{/if}
							</div>
							
							<div id="profile-edit-{$profile->id}" class="profileeditform hide">
								<div style="float:right"><a href="javascript:void(0)" onclick="$(this).parent().parent().hide()">X</a></div>
								<label>{$lang.controller.university}</label><input type="text" class="university" value="{$profile->text1}" />
								<select class="region">
									<option value="0">- - {$lang.controller.universitylocation} - -</option>
									{foreach item=region key=regionid from=$setting.region}
									<option {if $regionid == $profile->text3}selected="selected"{/if} value="{$regionid}">{$region}</option>
									{/foreach}
									
								</select>
								<div class="clear"></div>
								<label>{$lang.controller.department}</label>
								<input type="text" class="department" value="{$profile->text2}" />
								
								<div class="clear"></div>
								<label>{$lang.controller.datestart}</label>
								<select class="frommonth" style="width:70px">
									<option value="0">{$lang.controller.month}</option>
									{foreach item=month from=$monthList}
										<option {if $month == $profile->date1_month}selected="selected"{/if} value="{$month}">{$month}</option>
									{/foreach}
									<option value="0">{$lang.controller.monthUnknown}</option>
								</select>
								<select class="fromyear" style="width:70px">
									<option value="0">{$lang.controller.year}</option>
									{foreach item=year from=$yearList}
										<option {if $year == $profile->date1_year}selected="selected"{/if} value="{$year}">{$year}</option>
									{/foreach}
								</select><div class="clear"></div>
								{if $profile->date2_year ==0 && $profile->date2_month == 0}
									{assign var=istonow value=1}
								{else}
									{assign var=istonow value=0}
								{/if}
								<label>{$lang.controller.dateend}</label>
								<select class="tomonth tonowrelative" style="width:70px" {if $istonow == 1}disabled="disabled"{/if}>
									<option value="0">{$lang.controller.month}</option>
									{foreach item=month from=$monthList}
										<option {if $month == $profile->date2_month}selected="selected"{/if} value="{$month}">{$month}</option>
									{/foreach}
									<option value="0">{$lang.controller.monthUnknown}</option>
								</select>
								<select class="toyear tonowrelative" style="width:70px" {if $istonow == 1}disabled="disabled"{/if}>
									<option value="0">{$lang.controller.year}</option>
									{foreach item=year from=$yearList}
										<option {if $year == $profile->date2_year}selected="selected"{/if} value="{$year}">{$year}</option>
									{/foreach}
								</select>
								<label class="normal"><input type="checkbox" value="1" {if $istonow == 1}checked="checked"{/if}  class="checkbox tonow" onclick="profileadvanced_tonowcheck('#profile-edit-{$profile->id}')" />&nbsp;{$lang.controller.now}</label>
											
			
								<input type="button" onclick="profileadvanced_edituniversity({$profile->id})" class="submit" name="fsubmit" value="{$lang.controller.updateSubmit}" />
								
								<div class="clear"></div>
							</div>
						</div>
						
					{/foreach}
				</div>
				<div class="clear"></div>
				<div id="adduniversityform" class="profileaddform hide">
					<div class="profileaddformhead">{$lang.controller.addNewUniversity}
					
						<div style="float:right"><a href="javascript:void(0)" onclick="$('#adduniversityform').hide(); $('.profileadduniversity').show()" style="color:#fff; font-weight:bold;">X</a></div>
					</div>
										
					<label>{$lang.controller.university}</label><input type="text" class="university" />
					<select class="region">
						<option value="0">- - {$lang.controller.universitylocation} - -</option>
						{foreach item=region key=regionid from=$setting.region}
						<option value="{$regionid}">{$region}</option>
						{/foreach}
						
					</select>
					<div class="clear"></div>
					<label>{$lang.controller.department}</label>
					<input type="text" class="department" />
					
					<div class="clear"></div>
					<label>{$lang.controller.datestart}</label>
					<select class="frommonth" style="width:70px">
						<option value="0">{$lang.controller.month}</option>
						{foreach item=month from=$monthList}
							<option value="{$month}">{$month}</option>
						{/foreach}
						<option value="0">{$lang.controller.monthUnknown}</option>
					</select>
					<select class="fromyear" style="width:70px">
						<option value="0">{$lang.controller.year}</option>
						{foreach item=year from=$yearList}
							<option value="{$year}">{$year}</option>
						{/foreach}
					</select><div class="clear"></div>
					
					<label>{$lang.controller.dateend}</label>
					<select class="tomonth tonowrelative" style="width:70px">
						<option value="0">{$lang.controller.month}</option>
						{foreach item=month from=$monthList}
							<option value="{$month}">{$month}</option>
						{/foreach}
						<option value="0">{$lang.controller.monthUnknown}</option>
					</select>
					<select class="toyear tonowrelative" style="width:70px">
						<option value="0">{$lang.controller.year}</option>
						{foreach item=year from=$yearList}
							<option value="{$year}">{$year}</option>
						{/foreach}
					</select>
					<label class="normal"><input type="checkbox" value="1" class="checkbox tonow" onclick="profileadvanced_tonowcheck('#adduniversityform')" />&nbsp;{$lang.controller.now}</label>


					<input type="button" onclick="profileadvanced_adduniversity()" class="submit" name="fsubmit" value="{$lang.controller.addSubmit}" />
					
					<div class="clear"></div>
				</div>
				<div class="profileadduniversity"><a href="javascript:void(0)" onclick="$('#adduniversityform').show(); $('.profileadduniversity').hide()" class="profileaddlink" >{$lang.controller.addNewUniversity}</a></div>
			</div>
			
			<div id="profileform" class="myform myformwide stylizedform">
				<h2>{$lang.controller.groupSchool}</h2>
				
				<div id="schoollist">
					{foreach item=profile from=$myProfileList.3}
						<div id="profile-{$profile->id}" class="profileitem">
							<div class="profileitembutton">
								<a href="javascript:void(0)" onclick="$('#profile-edit-{$profile->id}').toggle()">{$lang.controller.editLabel}</a> | 
								<a class="profiledelete" href="javascript:void(0)" onclick="profileadvanced_delete({$profile->id})">{$lang.controller.deleteLabel}</a>
							</div>
							
							<div class="profileitemtitle"><span class="schooltext">{$profile->getText2Schooltype()} {$profile->text1}</span> - <span class="regiontext">{$profile->getText3Region()}</span></div>
							
							<div class="profileitemtime">
								{if $profile->date1_month > 0 && $profile->date1_year > 0}{$profile->date1_month}/{/if}{if $profile->date1_year > 0}{$profile->date1_year}{/if}
								
								{if $profile->date2_year > 0}
								 	- {if $profile->date2_month > 0}{$profile->date2_month}/{/if}{$profile->date2_year}
								{else}
									- {$lang.controller.now}
								{/if}
							</div>
							
							<div id="profile-edit-{$profile->id}" class="profileeditform hide">
								<div style="float:right"><a href="javascript:void(0)" onclick="$(this).parent().parent().hide()">X</a></div>
								<label>{$lang.controller.school}</label>
								<select class="schooltype" style="width:100px">
									<option value="1" {if $profile->text2 == 1}selected="selected"{/if}>{$lang.controller.schooltypecap3}</option>
									<option value="2" {if $profile->text2 == 2}selected="selected"{/if}>{$lang.controller.schooltypecap2}</option>
									<option value="3" {if $profile->text2 == 3}selected="selected"{/if}>{$lang.controller.schooltypecap1}</option>
									<option value="4" {if $profile->text2 == 4}selected="selected"{/if}>{$lang.controller.schooltypemamnon}</option>
									<option value="5" {if $profile->text2 == 5}selected="selected"{/if}>{$lang.controller.schooltypeother}</option>
								</select>
								<input type="text" class="school" value="{$profile->text1}" />
								<select class="region" style="width:120px;">
									<option value="0">- - {$lang.controller.schoollocation} - -</option>
									{foreach item=region key=regionid from=$setting.region}
									<option {if $regionid == $profile->text3}selected="selected"{/if} value="{$regionid}">{$region}</option>
									{/foreach}
									
								</select>
								
								<div class="clear"></div>
								<label>{$lang.controller.datestart}</label>
								<select class="frommonth" style="width:70px">
									<option value="0">{$lang.controller.month}</option>
									{foreach item=month from=$monthList}
										<option {if $month == $profile->date1_month}selected="selected"{/if} value="{$month}">{$month}</option>
									{/foreach}
									<option value="0">{$lang.controller.monthUnknown}</option>
								</select>
								<select class="fromyear" style="width:70px">
									<option value="0">{$lang.controller.year}</option>
									{foreach item=year from=$yearList}
										<option {if $year == $profile->date1_year}selected="selected"{/if} value="{$year}">{$year}</option>
									{/foreach}
								</select><div class="clear"></div>
								{if $profile->date2_year ==0 && $profile->date2_month == 0}
									{assign var=istonow value=1}
								{else}
									{assign var=istonow value=0}
								{/if}
								<label>{$lang.controller.dateend}</label>
								<select class="tomonth tonowrelative" style="width:70px" {if $istonow == 1}disabled="disabled"{/if}>
									<option value="0">{$lang.controller.month}</option>
									{foreach item=month from=$monthList}
										<option {if $month == $profile->date2_month}selected="selected"{/if} value="{$month}">{$month}</option>
									{/foreach}
									<option value="0">{$lang.controller.monthUnknown}</option>
								</select>
								<select class="toyear tonowrelative" style="width:70px" {if $istonow == 1}disabled="disabled"{/if}>
									<option value="0">{$lang.controller.year}</option>
									{foreach item=year from=$yearList}
										<option {if $year == $profile->date2_year}selected="selected"{/if} value="{$year}">{$year}</option>
									{/foreach}
								</select>
								<label class="normal"><input type="checkbox" value="1" {if $istonow == 1}checked="checked"{/if}  class="checkbox tonow" onclick="profileadvanced_tonowcheck('#profile-edit-{$profile->id}')" />&nbsp;{$lang.controller.now}</label>
											
			
								<input type="button" onclick="profileadvanced_editschool({$profile->id})" class="submit" name="fsubmit" value="{$lang.controller.updateSubmit}" />
								
								<div class="clear"></div>
							</div>
						</div>
						
					{/foreach}
				</div>
				<div class="clear"></div>
				<div id="addschoolform" class="profileaddform hide">
					<div class="profileaddformhead">{$lang.controller.addNewSchool}
					
						<div style="float:right"><a href="javascript:void(0)" onclick="$('#addschoolform').hide(); $('.profileaddschool').show()" style="color:#fff; font-weight:bold;">X</a></div>
					</div>
										
					<label>{$lang.controller.school}</label>
					<select class="schooltype" style="width:100px">
						<option value="1">{$lang.controller.schooltypecap3}</option>
						<option value="2">{$lang.controller.schooltypecap2}</option>
						<option value="3">{$lang.controller.schooltypecap1}</option>
						<option value="4">{$lang.controller.schooltypemamnon}</option>
						<option value="5">{$lang.controller.schooltypeother}</option>
					</select>
					<input type="text" class="school" />
					<select class="region" style="width:120px">
						<option value="0">- - {$lang.controller.schoollocation} - -</option>
						{foreach item=region key=regionid from=$setting.region}
						<option value="{$regionid}">{$region}</option>
						{/foreach}
						
					</select>
										
					<div class="clear"></div>
					<label>{$lang.controller.datestart}</label>
					<select class="frommonth" style="width:70px">
						<option value="0">{$lang.controller.month}</option>
						{foreach item=month from=$monthList}
							<option value="{$month}">{$month}</option>
						{/foreach}
						<option value="0">{$lang.controller.monthUnknown}</option>
					</select>
					<select class="fromyear" style="width:70px">
						<option value="0">{$lang.controller.year}</option>
						{foreach item=year from=$yearList}
							<option value="{$year}">{$year}</option>
						{/foreach}
					</select><div class="clear"></div>
					
					<label>{$lang.controller.dateend}</label>
					<select class="tomonth tonowrelative" style="width:70px">
						<option value="0">{$lang.controller.month}</option>
						{foreach item=month from=$monthList}
							<option value="{$month}">{$month}</option>
						{/foreach}
						<option value="0">{$lang.controller.monthUnknown}</option>
					</select>
					<select class="toyear tonowrelative" style="width:70px">
						<option value="0">{$lang.controller.year}</option>
						{foreach item=year from=$yearList}
							<option value="{$year}">{$year}</option>
						{/foreach}
					</select>
					<label class="normal"><input type="checkbox" value="1" class="checkbox tonow" onclick="profileadvanced_tonowcheck('#addschoolform')" />&nbsp;{$lang.controller.now}</label>


					<input type="button" onclick="profileadvanced_addschool()" class="submit" name="fsubmit" value="{$lang.controller.addSubmit}" />
					
					<div class="clear"></div>
				</div>
				<div class="profileaddschool"><a href="javascript:void(0)" onclick="$('#addschoolform').show(); $('.profileaddschool').hide()" class="profileaddlink" >{$lang.controller.addNewSchool}</a></div>
				
			</div>
			
			<div id="profileform" class="myform myformwide stylizedform">
				
				<form id="form1" name="form1" method="post" action="{$conf.rooturl}profile/info">
                <h2>{$lang.controller.groupOther}</h2>
				<p></p>
				<label>{$lang.controller.phone1}
					
				</label>
				<input type="text" name="fphone" id="fphone" value="{$formData.fphone}" />
				<div class="clear"></div>
				
				<label>{$lang.controller.address}
					<span class="small"></span>
				</label>
				<input type="text" name="faddress" id="faddress" value="{$formData.faddress}" />
				<select  name="fregion" id="fregion">
					{foreach item=region key=regionid from=$setting.region}
					<option {if $regionid == $formData.fregion}selected="selected" {/if} value="{$regionid}">{$region}</option>
					{/foreach}
					
				</select>
				<div class="clear"></div>
				
				
				
				
				<label>{$lang.controller.website}
					
				</label>
				<input type="text" name="fwebsite" id="fwebsite" value="{$formData.fwebsite}" />
				<div class="clear"></div>
				
				
                
                <label>{$lang.controller.gender}
				</label>
				<select id="fgender" name="fgender">
					<option value="">- - - -</option>
					<option value="1" {if $formData.fgender == '1'}selected="selected"{/if}>{$lang.default.genderMale}</option>
                    <option value="2" {if $formData.fgender == '2'}selected="selected"{/if}>{$lang.default.genderFemale}</option>
				</select>
				<div class="clear"></div>
                
                <label>{$lang.controller.birthday}
					
				</label>
				<input type="text" name="fbirthday" id="fbirthday" title="DD/MM/YYYY" class="tipsy-trigger" value="{$formData.fbirthday}" />
				<div class="clear"></div>
                
				                
				
				
				
								
				<label>{$lang.controller.bio}
					<span class="small"></span>
				</label>
				<textarea name="fbio" id="fbio" class="inputwide" rows="5">{$formData.fbio}</textarea>
				<div class="clear"></div>
                <div id="otherfieldlist">
					{foreach item=profile from=$myProfileList.4}
						<div id="profile-{$profile->id}" class="profileitem profileitemnoborder">
							<div class="profileitembutton">
								<a href="javascript:void(0)" onclick="$('#profile-edit-{$profile->id}').toggle()">{$lang.controller.editLabel}</a> | 
								<a class="profiledelete" href="javascript:void(0)" onclick="profileadvanced_delete({$profile->id})">{$lang.controller.deleteLabel}</a>
							</div>
							
							<div class="profileitemtitle">
								<label class="fieldnametext" style="width:90px;">{$profile->text1}</label> 
								<input type="text" readonly="readonly" class="fieldvaluetext inputwide profileiteminputdisabled" value="{$profile->text2}" /></span>
							</div>
							<div class="clear"></div>
							
							
							
							<div id="profile-edit-{$profile->id}" class="profileeditform hide">
								<div style="float:right"><a href="javascript:void(0)" onclick="$(this).parent().parent().hide()">X</a></div>
								<label>{$lang.controller.fieldname}</label><input type="text" class="fieldname " value="{$profile->text1}" />
								<div class="clear"></div>
								<label>{$lang.controller.fieldvalue}</label><input type="text" class="fieldvalue inputwide" value="{$profile->text2}" />
								<div class="clear"></div>
								<input type="button" onclick="profileadvanced_editotherfield({$profile->id})" class="submit" name="fsubmit" value="{$lang.controller.updateSubmit}" />
								
								<div class="clear"></div>
							</div>
						</div>
						<div class="clear"></div>
						
					{/foreach}
				</div>
				<div class="clear"></div>
				<div id="addotherfieldform" class="profileaddform hide">
					<div class="profileaddformhead">{$lang.controller.addNewOtherfield}
					
						<div style="float:right"><a href="javascript:void(0)" onclick="$('#addotherfieldform').hide(); $('.profileaddotherfield').show()" style="color:#fff; font-weight:bold;">X</a></div>
					</div>
										
					<label>{$lang.controller.fieldname}</label><input type="text" class="fieldname" />
					<div class="clear"></div>
					<label>{$lang.controller.fieldvalue}</label><input type="text" class="fieldvalue inputwide" />			
					<div class="clear"></div>
					
					<input type="button" onclick="profileadvanced_addotherfield()" class="submit" name="fsubmit" value="{$lang.controller.addSubmit}" />
					
					<div class="clear"></div>
				</div>
				<div class="profileaddotherfield"><a href="javascript:void(0)" onclick="$('#addotherfieldform').show(); $('.profileaddotherfield').hide()" class="profileaddlink" >{$lang.controller.addNewOtherfield}</a></div>
				<br /><br />
				
				<input type="submit" class="submit" name="fsubmit" value="{$lang.controller.submitLabel}" />
				<div class="spacer"></div>
		
		  </form>
		  <p></p>
		  <div><a href="{$me->getUserPath()}/info">&raquo; T&#7899;i trang th&#244;ng tin c&#225; nh&#226;n - Profile</a><br /></div>
	  </div><!-- end #profileform -->
	  
     
	  
	  
	</div><!-- end #panelright -->
    
	
	<script type="text/javascript" src="{$currentTemplate}js/site/profile.js"></script>
    