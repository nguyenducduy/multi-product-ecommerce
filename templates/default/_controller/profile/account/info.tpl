<div class="page-header" rel="menu_sessionmanager"><h1>{$me->fullname}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li><a href="{$conf.rooturl_profile}account">{$lang.controller.titleAccount} {if $me->email != ''}&lt;{$me->email}&gt;{/if}</a></li>
		<li class="active"><a href="#" data-toggle="tab">{$lang.controller.tabProfile}</a></li>
		<li><a href="{$conf.rooturl_profile}account?tab=3">{$lang.controller.tabChangepassword}</a></li>
	</ul>
	<div class="tab-content">
		
		{include file="notify.tpl" notifyError=$error notifySuccess=$success}
		<div class="tab-pane active" id="tab2">
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

								<div id="profile-edit-{$profile->id}" class="profileeditform hide form-horizontal">
									<div style="float:right"><a href="javascript:void(0)" onclick="$(this).parent().parent().hide()">X</a></div>
									
									<div class="control-group">
										<label class="control-label">{$lang.controller.company}</label>
										<div class="controls">
											<input type="text" class="company" value="{$profile->text1}" />
											<select class="region">
												<option value="0">- - {$lang.controller.worklocation} - -</option>
												{foreach item=region key=regionid from=$setting.region}
												<option {if $regionid == $profile->text3}selected="selected"{/if} value="{$regionid}">{$region}</option>
												{/foreach}

											</select>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">{$lang.controller.jobtitle}</label>
										<div class="controls">
											<textarea class="jobtitle">{$profile->text2}</textarea>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">{$lang.controller.datestart}</label>
										<div class="controls">
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
											</select>
										</div>
									</div>
									
									<div class="control-group">
										{if $profile->date2_year ==0 && $profile->date2_month == 0}
											{assign var=istonow value=1}
										{else}
											{assign var=istonow value=0}
										{/if}
										<label class="control-label">{$lang.controller.dateend}</label>
										<div class="controls">
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
										</div>
									</div>

									<div class="control-group">
										<label class="control-label"></label>
										<div class="controls"><input type="button" onclick="profileadvanced_editwork({$profile->id})" class="submit btn btn-primary" name="fsubmit" value="{$lang.controller.updateSubmit}" /></div>
									</div>
									
								</div>
							</div>

						{/foreach}
					</div>
					<div class="clear"></div>
					<div id="addworkform" class="profileaddform hide form-horizontal">
						<div class="profileaddformhead" onclick="$('#addworkform').hide(); $('.profileaddwork').show()" >{$lang.controller.addNewWork}

							<div style="float:right"><a href="javascript:void(0)" onclick="$('#addworkform').hide(); $('.profileaddwork').show()" style="color:#fff; font-weight:bold;">X</a></div>
						</div>

						<div class="control-group">
							<label class="control-label" for="company">{$lang.controller.company}</label>
							<div class="controls">
								<input type="text" class="company input-xlarge" />
								<select class="region">
									<option value="0">- - {$lang.controller.worklocation} - -</option>
									{foreach item=region key=regionid from=$setting.region}
									<option value="{$regionid}">{$region}</option>
									{/foreach}

								</select>
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="jobtitle">{$lang.controller.jobtitle}</label>
							<div class="controls"><input type="text" name="jobtitle" class="jobtitle input-xlarge"></div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="datestart">{$lang.controller.datestart}</label>
							<div class="controls"> 
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
								</select>
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="dateend">{$lang.controller.dateend}</label>
							<div class="controls">
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
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="">&nbsp;</label>
							<div class="controls">
								<input type="button" onclick="profileadvanced_addwork()" class="submit btn btn-primary" name="fsubmit" value="{$lang.controller.addSubmit}" />
							</div>
						</div>
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

								<div id="profile-edit-{$profile->id}" class="profileeditform hide form-horizontal">
									<div style="float:right"><a href="javascript:void(0)" onclick="$(this).parent().parent().hide()">X</a></div>
									
									<div class="control-group">
										<label class="control-label">{$lang.controller.university}</label>
										<div class="controls">
											<input type="text" class="university" value="{$profile->text1}" />
											<select class="region">
												<option value="0">- - {$lang.controller.universitylocation} - -</option>
												{foreach item=region key=regionid from=$setting.region}
												<option {if $regionid == $profile->text3}selected="selected"{/if} value="{$regionid}">{$region}</option>
												{/foreach}

											</select>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">{$lang.controller.department}</label>
										<div class="controls">
											<input type="text" class="department" value="{$profile->text2}" />
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">{$lang.controller.datestart}</label>
										<div class="controls">
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
											</select>
										</div>
									</div>
									
									
									{if $profile->date2_year ==0 && $profile->date2_month == 0}
										{assign var=istonow value=1}
									{else}
										{assign var=istonow value=0}
									{/if}
									<div class="control-group">
										<label class="control-label">{$lang.controller.dateend}</label>
										<div class="controls">
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
										</div>
									</div>

									<div class="control-group">
										<label class="control-label"></labe>
										<div class="controls">
											<input type="button" onclick="profileadvanced_edituniversity({$profile->id})" class="submit btn btn-primary" name="fsubmit" value="{$lang.controller.updateSubmit}" />
										</div>
									</div>
								</div>
							</div>

						{/foreach}
					</div>
					<div class="clear"></div>
					<div id="adduniversityform" class="profileaddform hide form-horizontal">
						<div class="profileaddformhead" onclick="$('#adduniversityform').hide(); $('.profileadduniversity').show()">{$lang.controller.addNewUniversity}

							<div style="float:right"><a href="javascript:void(0)" onclick="$('#adduniversityform').hide(); $('.profileadduniversity').show()" style="color:#fff; font-weight:bold;">X</a></div>
						</div>

						<div class="control-group">
							<label class="control-label" for="">{$lang.controller.university}</label>
							<div class="controls">
								<input type="text" class="university" />
								<select class="region">
									<option value="0">- - {$lang.controller.universitylocation} - -</option>
									{foreach item=region key=regionid from=$setting.region}
									<option value="{$regionid}">{$region}</option>
									{/foreach}
								</select>
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="department">{$lang.controller.department}</label>
							<div class="controls">
								<input type="text" class="department" />
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="datestart">{$lang.controller.datestart}</label>
							<div class="controls">
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
								</select>
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="dateend">{$lang.controller.dateend}</label>
							<div class="controls">
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
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="">&nbsp;</label>
							<div class="controls">
								<input type="button" onclick="profileadvanced_adduniversity()" class="submit btn btn-primary" name="fsubmit" value="{$lang.controller.addSubmit}" />
							</div>
						</div>
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

								<div id="profile-edit-{$profile->id}" class="profileeditform hide form-horizontal">
									<div style="float:right"><a href="javascript:void(0)" onclick="$(this).parent().parent().hide()">X</a></div>
									
									<div class="control-group">
										<label class="control-label">{$lang.controller.school}</label>
										<div class="controls">
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
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">{$lang.controller.datestart}</label>
										<div class="controls">
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
											</select>
										</div>
									</div>
									
									{if $profile->date2_year ==0 && $profile->date2_month == 0}
										{assign var=istonow value=1}
									{else}
										{assign var=istonow value=0}
									{/if}
									<div class="control-group">
										<label class="control-label">{$lang.controller.dateend}</label>
										<div class="controls">
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
										</div>
									</div>
									
									<div class="control-group">
										<div class="control-label"></div>
										<div class="controls">
											<input type="button" onclick="profileadvanced_editschool({$profile->id})" class="submit btn btn-primary" name="fsubmit" value="{$lang.controller.updateSubmit}" />
										</div>
									</div>
								</div>
							</div>

						{/foreach}
					</div>
					<div class="clear"></div>
					<div id="addschoolform" class="profileaddform hide form-horizontal">
						<div class="profileaddformhead" onclick="$('#addschoolform').hide(); $('.profileaddschool').show()">{$lang.controller.addNewSchool}

							<div style="float:right"><a href="javascript:void(0)" onclick="$('#addschoolform').hide(); $('.profileaddschool').show()" style="color:#fff; font-weight:bold;">X</a></div>
						</div>

						<div class="control-group">
							<label class="control-label" for="schooltype">{$lang.controller.school}</label>
							<div class="controls">
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
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="datestart">{$lang.controller.datestart}</label>
							<div class="controls">
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
								</select>
							</div>
						</div>
						
						
						<div class="control-group">
							<label class="control-label" for="dateend">{$lang.controller.dateend}</label>
							<div class="controls">
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
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="">&nbsp;</label>
							<div class="controls">
								<input type="button" onclick="profileadvanced_addschool()" class="submit btn btn-primary" name="fsubmit" value="{$lang.controller.addSubmit}" />
							</div>
						</div>
					</div>
					<div class="profileaddschool"><a href="javascript:void(0)" onclick="$('#addschoolform').show(); $('.profileaddschool').hide()" class="profileaddlink" >{$lang.controller.addNewSchool}</a></div>

				</div>

				<div id="profileform" class="myform myformwide stylizedform">

					<form id="form1" name="form1" method="post" action="{$conf.rooturl_profile}account/info" class="form-horizontal">
	                <h2>{$lang.controller.groupOther}</h2>
					<p></p>
					
					<div class="control-group">
						<label class="control-label" for="fphone">{$lang.controller.phone1}</label>
						<div class="controls"><input type="text" name="fphone" id="fphone" value="{$formData.fphone|@htmlspecialchars}" class="input-xlarge"></div>
					</div>
					
					<div class="control-group">
						<label class="control-label" for="faddress">{$lang.controller.address}</label>
						<div class="controls">
							<input type="text" name="faddress" id="faddress" value="{$formData.faddress|@htmlspecialchars}" class="input-xlarge">
							<select  name="fregion" id="fregion">
								{foreach item=region key=regionid from=$setting.region}
								<option {if $regionid == $formData.fregion}selected="selected" {/if} value="{$regionid}">{$region}</option>
								{/foreach}

							</select>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="fwebsite">{$lang.controller.website}</label>
						<div class="controls"><input type="text" name="fwebsite" id="fwebsite" value="{$formData.fwebsite|@htmlspecialchars}" class="input-xlarge"></div>
					</div>
					
					<div class="control-group">
						<label class="control-label" for="fgender">{$lang.controller.gender}</label>
						<div class="controls">
							<select id="fgender" name="fgender">
								<option value="">- - - -</option>
								<option value="1" {if $formData.fgender == '1'}selected="selected"{/if}>{$lang.default.genderMale}</option>
			                    <option value="2" {if $formData.fgender == '2'}selected="selected"{/if}>{$lang.default.genderFemale}</option>
							</select>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label" for="fbirthday">{$lang.controller.birthday}</label>
						<div class="controls"><input type="text" name="fbirthday" id="fbirthday" class="tipsy-trigger" title="DD/MM/YYY" placeholder="DD/MM/YYYY" value="{$formData.fbirthday|@htmlspecialchars}" class="input-xlarge"></div>
					</div>
					
					
					
					<div class="control-group">
						<label class="control-label" for="fbio">{$lang.controller.bio}</label>
						<div class="controls">
							<textarea name="fbio" id="fbio" class="input-xxlarge" rows="5">{$formData.fbio}</textarea>
						</div>
					</div>
					
	                <div id="otherfieldlist">
						{foreach item=profile from=$myProfileList.4}
							<div id="profile-{$profile->id}" class="profileitem profileitemnoborder">
								<div class="control-group">
									<div class="profileitembutton">
										<a href="javascript:void(0)" onclick="$('#profile-edit-{$profile->id}').toggle()">{$lang.controller.editLabel}</a> | 
										<a class="profiledelete" href="javascript:void(0)" onclick="profileadvanced_delete({$profile->id})">{$lang.controller.deleteLabel}</a>
									</div>

									<div class="profileitemtitle">
										<label class="control-label fieldnametext">{$profile->text1}</label> 
										<div class="controls"><input type="text" readonly="readonly" class="fieldvaluetext profileiteminputdisabled" value="{$profile->text2}" /></div>
									</div>
								</div>



								<div id="profile-edit-{$profile->id}" class="profileeditform hide">
									<div style="float:right"><a href="javascript:void(0)" onclick="$(this).parent().parent().hide()">X</a></div>
									<div class="control-group">
										<label class="control-label">{$lang.controller.fieldname}</label>
										<div class="controls"><input type="text" class="fieldname " value="{$profile->text1}" /></div>
									</div>
									
									<div class="control-group">
										<label class="control-label">{$lang.controller.fieldvalue}</label>
										<div class="controls"><input type="text" class="fieldvalue inputwide" value="{$profile->text2}" /></div>
									</div>
									
									<div class="control-group">
										<label class="control-label"></label>
										<div class="controls"><input type="button" onclick="profileadvanced_editotherfield({$profile->id})" class="submit btn btn-primary" name="fsubmit" value="{$lang.controller.updateSubmit}" /></div>
									</div>
								</div>
							</div>
							<div class="clear"></div>

						{/foreach}
					</div>
					<div class="clear"></div>
					<div id="addotherfieldform" class="profileaddform hide form-horizontal">
						<div class="profileaddformhead" onclick="$('#addotherfieldform').hide(); $('.profileaddotherfield').show()">{$lang.controller.addNewOtherfield}

							<div style="float:right"><a href="javascript:void(0)" onclick="$('#addotherfieldform').hide(); $('.profileaddotherfield').show()" style="color:#fff; font-weight:bold;">X</a></div>
						</div>

						<div class="control-group">
							<label class="control-label" for="fieldname">{$lang.controller.fieldname}</label>
							<div class="controls"><input type="text" name="fieldname" class="fieldname" class="input-xlarge"></div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="fieldvalue">{$lang.controller.fieldvalue}</label>
							<div class="controls"><input type="text" name="fieldvalue" class="fieldvalue" class="input-xlarge"></div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for=""></label>
							<div class="controls">
								<input type="button" onclick="profileadvanced_addotherfield()" class="submit btn btn-primary" name="fsubmit" value="{$lang.controller.addSubmit}" />
							</div>
						</div>
					</div>
					<div class="profileaddotherfield"><a href="javascript:void(0)" onclick="$('#addotherfieldform').show(); $('.profileaddotherfield').hide()" class="profileaddlink" >{$lang.controller.addNewOtherfield}</a></div>
					<br /><br />

					<div class="form-actions">
						<input type="submit" name="fsubmit" value="{$lang.controller.submitLabel}" class="submit btn btn-large btn-primary" />
						<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
					</div>
					

			  </form>
		  </div><!-- end #profileform -->
		</div><!-- end #tab2 -->
	</div>
</div>



		
	  
	<script type="text/javascript" src="{$currentTemplate}js/profile/account.js?v={$smarty.now}"></script>
    