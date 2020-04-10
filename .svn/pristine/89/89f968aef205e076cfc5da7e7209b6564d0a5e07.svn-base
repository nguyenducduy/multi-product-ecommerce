function profileadvanced_addwork()
{
	var company = $('#addworkform .company').val();
	var jobtitle = $('#addworkform .jobtitle').val();
	var region = $('#addworkform .region').val();
	var frommonth = parseInt($('#addworkform .frommonth').val());
	var fromyear = parseInt($('#addworkform .fromyear').val());
	var tomonth = parseInt($('#addworkform .tomonth').val());
	var toyear = parseInt($('#addworkform .toyear').val());
	var tonow = $('#addworkform .tonow:checked').val() == '1'?1:0;
	
	if(company.length == 0)
	{
		alert('Bạn chưa nhập tên công ty.');
		$('#addworkform .company').focus();
	}
	else
	{
		$('#addworkform .submit').after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').attr('disabled', 'disabled');
		
		$.ajax({
		   type: "POST",
		   dataType: 'xml',
		   data: 'type=work&text1=' + encodeURIComponent(company) + '&text2=' + encodeURIComponent(jobtitle) + '&text3=' + region + '&fromyear=' + fromyear + '&frommonth=' + frommonth + '&toyear=' + toyear + '&tomonth=' + tomonth + '&tonow=' + tonow,
		   url: rooturl + 'profile/additem',
		   error: function(){
				$("#addworkform .submit").removeAttr('disabled');
				$("#addworkform img.tmp_indicator").remove();
	
				//showGritterError('');
			   },
		   success: function(xml){
				$("#addworkform .submit").removeAttr('disabled');
				$("#addworkform img.tmp_indicator").remove();
				
				var success = $(xml).find('success').text();
				
				if(success == "1")
				{
					var message = $(xml).find('message').text();
					$.gritter.add({
						title: 'Th&#224;nh c&#244;ng',
						image: imageDir + 'gritter/success.png',
						time: gritterDelay,
						text: message
					});
					
					
					
					var pid = $(xml).find('id').text();
					var timetext = '';
					var regiontext = '';
					
					if(region > 0 && region < 70)
						regiontext = $('#addworkform .region option:selected').text(); 
						
					if(frommonth > 0 && fromyear > 0)
						timetext = frommonth + '/';
						
					if(fromyear > 0)
						timetext += fromyear ;
						
					if(tonow == 1)
						timetext += ' - Hiện tại';
					else
					{
						if(toyear > 0)
						{
							timetext += ' - ';
							if(tomonth > 0)
								timetext += tomonth + '/';
							timetext += toyear;
						}
					}

					//add to work list
					var html = '<div id="profile-'+pid+'" class="profileitem hide">';
					html += '<div class="profileitembutton"><a class="profiledelete" href="javascript:void(0)" onclick="profileadvanced_delete('+pid+')">Xóa</a></div>';
					html += '<div class="profileitemtitle"><span class="companytext">'+company+'</span> - <span class="regiontext">'+regiontext+'</span></div>';
					html += '<div class="profileitemtitlesub"><span class="jobtitletext">'+nl2br(jobtitle)+'</span></div>';
					html += '<div class="profileitemtime">'+timetext+'</div></div>';
					$('#worklist').append(html);
					$('#profile-' + pid).fadeIn();
					
					
					//clear form
					$('#addworkform .company').val('');
					$('#addworkform .jobtitle').val('');
					$('#addworkform .region').val('0');
					$('#addworkform .frommonth').val('0');
					$('#addworkform .fromyear').val('0');
					$('#addworkform .tomonth').val('0');
					$('#addworkform .toyear').val('0');
				}
				else
				{
					var message = $(xml).find('message').text();
					showGritterError(message);
					
				}
		   }
		 });
	}
	
}


function profileadvanced_editwork(pid)
{
	var company = $('#profile-edit-'+pid+' .company').val();
	var jobtitle = $('#profile-edit-'+pid+' .jobtitle').val();
	var region = $('#profile-edit-'+pid+' .region').val();
	var frommonth = $('#profile-edit-'+pid+' .frommonth').val();
	var fromyear = $('#profile-edit-'+pid+' .fromyear').val();
	var tomonth = $('#profile-edit-'+pid+' .tomonth').val();
	var toyear = $('#profile-edit-'+pid+' .toyear').val();
	var tonow = $('#profile-edit-'+pid+' .tonow:checked').val() == '1'?1:0;
	
	if(company.length == 0)
	{
		alert('Bạn chưa nhập tên công ty.');
		$('#profile-edit-'+pid+' .company').focus();
	}
	else
	{
		$('#profile-edit-'+pid+' .submit').after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').attr('disabled', 'disabled');
		
		$.ajax({
		   type: "POST",
		   dataType: 'xml',
		   data: 'type=work&text1=' + encodeURIComponent(company) + '&text2=' + encodeURIComponent(jobtitle) + '&text3=' + region + '&fromyear=' + fromyear + '&frommonth=' + frommonth + '&toyear=' + toyear + '&tomonth=' + tomonth + '&tonow=' + tonow,
		   url: rooturl + 'profile/edititem/' + pid,
		   error: function(){
				$('#profile-edit-'+pid+' .submit').removeAttr('disabled');
				$('#profile-edit-'+pid+' img.tmp_indicator').remove();
	
				//showGritterError('');
			   },
		   success: function(xml){
				$('#profile-edit-'+pid+' .submit').removeAttr('disabled');
				$('#profile-edit-'+pid+' img.tmp_indicator').remove();
				
				var success = $(xml).find('success').text();
				
				if(success == "1")
				{
					var message = $(xml).find('message').text();
					$.gritter.add({
						title: 'Th&#224;nh c&#244;ng',
						image: imageDir + 'gritter/success.png',
						time: gritterDelay,
						text: message
					});
					
					//update text
					$('#profile-'+pid+' .companytext').html(company);
					$('#profile-'+pid+' .jobtitletext').html(nl2br(jobtitle));
					
					var regiontext = '';
					if(region > 0 && region < 70)
						regiontext = $('#profile-edit-' + pid + ' .region option:selected').text(); 
					$('#profile-'+pid+' .regiontext').html(regiontext);
					
					var timetext = '';
					if(frommonth > 0 && fromyear > 0)
						timetext = frommonth + '/';
						
					if(fromyear > 0)
						timetext += fromyear ;
						
					if(tonow == 1)
						timetext += ' - Hiện tại';
					else
					{
						if(toyear > 0)
						{
							timetext += ' - ';
							if(tomonth > 0)
								timetext += tomonth + '/';
							timetext += toyear;
						}
					}
					
					
					$('#profile-'+pid+' .profileitemtime').html(timetext);
					
					//hide box
					$('#profile-edit-' + pid).hide();
					
										
				}
				else
				{
					var message = $(xml).find('message').text();
					showGritterError(message);
					
				}
		   }
		 });
	}
	
}


function profileadvanced_tonowcheck(selector)
{
	if($(selector + ' .tonow:checked').val() == '1')
	{
		$(selector + ' .tonowrelative').attr('disabled', 'disabled');
		
	}
	else
	{
		$(selector + ' .tonowrelative').removeAttr('disabled');
	}
}

function profileadvanced_delete(pid)
{
	var answer = confirm("Bạn có đồng ý xóa?")
	if (answer)
	{
		$('#profile-' + pid + ' .profiledelete').after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').hide();
		
		$.ajax({
		   type: "GET",
		   dataType: 'xml',
		   url: rooturl + 'profile/deleteitem/' + pid,
		   error: function(){
				$('#profile-' + pid + ' .profiledelete').show();
				$('#profile-' + pid + " img.tmp_indicator").remove();
	
				//showGritterError('');
			   },
		   success: function(xml){
				$('#profile-' + pid + ' .profiledelete').show();
				$('#profile-' + pid + " img.tmp_indicator").remove();
				
				var success = $(xml).find('success').text();
				
				if(success == "1")
				{
					var message = $(xml).find('message').text();
					$.gritter.add({
						title: 'Th&#224;nh c&#244;ng',
						image: imageDir + 'gritter/success.png',
						time: gritterDelay,
						text: message
					});
					
										
					//hide profileitem
					$('#profile-' + pid).fadeOut();
					
					
				}
				else
				{
					var message = $(xml).find('message').text();
					showGritterError(message);
					
				}
		   }
		 });
	}
}









/////////////////////////////////////////////
function profileadvanced_adduniversity()
{
	var university = $('#adduniversityform .university').val();
	var department = $('#adduniversityform .department').val();
	var region = $('#adduniversityform .region').val();
	var frommonth = parseInt($('#adduniversityform .frommonth').val());
	var fromyear = parseInt($('#adduniversityform .fromyear').val());
	var tomonth = parseInt($('#adduniversityform .tomonth').val());
	var toyear = parseInt($('#adduniversityform .toyear').val());
	var tonow = $('#adduniversityform .tonow:checked').val() == '1'?1:0;
	
	if(university.length == 0)
	{
		alert('Bạn chưa nhập tên trường.');
		$('#adduniversityform .university').focus();
	}
	else
	{
		$('#adduniversityform .submit').after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').attr('disabled', 'disabled');
		
		$.ajax({
		   type: "POST",
		   dataType: 'xml',
		   data: 'type=university&text1=' + encodeURIComponent(university) + '&text2=' + encodeURIComponent(department) + '&text3=' + region + '&fromyear=' + fromyear + '&frommonth=' + frommonth + '&toyear=' + toyear + '&tomonth=' + tomonth + '&tonow=' + tonow,
		   url: rooturl + 'profile/additem',
		   error: function(){
				$("#adduniversityform .submit").removeAttr('disabled');
				$("#adduniversityform img.tmp_indicator").remove();
	
				//showGritterError('');
			   },
		   success: function(xml){
				$("#adduniversityform .submit").removeAttr('disabled');
				$("#adduniversityform img.tmp_indicator").remove();
				
				var success = $(xml).find('success').text();
				
				if(success == "1")
				{
					var message = $(xml).find('message').text();
					$.gritter.add({
						title: 'Th&#224;nh c&#244;ng',
						image: imageDir + 'gritter/success.png',
						time: gritterDelay,
						text: message
					});
					
					
					
					var pid = $(xml).find('id').text();
					var timetext = '';
					var regiontext = '';
					
					if(region > 0 && region < 70)
						regiontext = $('#adduniversityform .region option:selected').text(); 
						
					if(frommonth > 0 && fromyear > 0)
						timetext = frommonth + '/';
						
					if(fromyear > 0)
						timetext += fromyear ;
						
					if(tonow == 1)
						timetext += ' - Hiện tại';
					else
					{
						if(toyear > 0)
						{
							timetext += ' - ';
							if(tomonth > 0)
								timetext += tomonth + '/';
							timetext += toyear;
						}
					}

					//add to university list
					var html = '<div id="profile-'+pid+'" class="profileitem hide">';
					html += '<div class="profileitembutton"><a class="profiledelete" href="javascript:void(0)" onclick="profileadvanced_delete('+pid+')">Xóa</a></div>';
					html += '<div class="profileitemtitle">'+university+' - '+regiontext+'</div>';
					html += '<div class="profileitemtitlesub">'+department+'</div>';
					html += '<div class="profileitemtime">'+timetext+'</div></div>';
					$('#universitylist').append(html);
					$('#profile-' + pid).fadeIn();
					
					
					//clear form
					$('#adduniversityform .university').val('');
					$('#adduniversityform .department').val('');
					$('#adduniversityform .region').val('0');
					$('#adduniversityform .frommonth').val('0');
					$('#adduniversityform .fromyear').val('0');
					$('#adduniversityform .tomonth').val('0');
					$('#adduniversityform .toyear').val('0');
				}
				else
				{
					var message = $(xml).find('message').text();
					showGritterError(message);
					
				}
		   }
		 });
	}
	
}


function profileadvanced_edituniversity(pid)
{
	var university = $('#profile-edit-'+pid+' .university').val();
	var department = $('#profile-edit-'+pid+' .department').val();
	var region = $('#profile-edit-'+pid+' .region').val();
	var frommonth = $('#profile-edit-'+pid+' .frommonth').val();
	var fromyear = $('#profile-edit-'+pid+' .fromyear').val();
	var tomonth = $('#profile-edit-'+pid+' .tomonth').val();
	var toyear = $('#profile-edit-'+pid+' .toyear').val();
	var tonow = $('#profile-edit-'+pid+' .tonow:checked').val() == '1'?1:0;
	
	if(university.length == 0)
	{
		alert('Bạn chưa nhập tên trường.');
		$('#profile-edit-'+pid+' .university').focus();
	}
	else
	{
		$('#profile-edit-'+pid+' .submit').after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').attr('disabled', 'disabled');
		
		$.ajax({
		   type: "POST",
		   dataType: 'xml',
		   data: 'type=university&text1=' + encodeURIComponent(university) + '&text2=' + encodeURIComponent(department) + '&text3=' + region + '&fromyear=' + fromyear + '&frommonth=' + frommonth + '&toyear=' + toyear + '&tomonth=' + tomonth + '&tonow=' + tonow,
		   url: rooturl + 'profile/edititem/' + pid,
		   error: function(){
				$('#profile-edit-'+pid+' .submit').removeAttr('disabled');
				$('#profile-edit-'+pid+' img.tmp_indicator').remove();
	
				//showGritterError('');
			   },
		   success: function(xml){
				$('#profile-edit-'+pid+' .submit').removeAttr('disabled');
				$('#profile-edit-'+pid+' img.tmp_indicator').remove();
				
				var success = $(xml).find('success').text();
				
				if(success == "1")
				{
					var message = $(xml).find('message').text();
					$.gritter.add({
						title: 'Th&#224;nh c&#244;ng',
						image: imageDir + 'gritter/success.png',
						time: gritterDelay,
						text: message
					});
					
					//update text
					$('#profile-'+pid+' .universitytext').html(university);
					$('#profile-'+pid+' .departmenttext').html(department);
					
					var regiontext = '';
					if(region > 0 && region < 70)
						regiontext = $('#profile-edit-' + pid + ' .region option:selected').text(); 
					$('#profile-'+pid+' .regiontext').html(regiontext);
					
					var timetext = '';
					if(frommonth > 0 && fromyear > 0)
						timetext = frommonth + '/';
						
					if(fromyear > 0)
						timetext += fromyear ;
						
					if(tonow == 1)
						timetext += ' - Hiện tại';
					else
					{
						if(toyear > 0)
						{
							timetext += ' - ';
							if(tomonth > 0)
								timetext += tomonth + '/';
							timetext += toyear;
						}
					}
					
					
					$('#profile-'+pid+' .profileitemtime').html(timetext);
					
					//hide box
					$('#profile-edit-' + pid).hide();
					
										
				}
				else
				{
					var message = $(xml).find('message').text();
					showGritterError(message);
					
				}
		   }
		 });
	}
	
}










/////////////////////////////////////////////
function profileadvanced_addschool()
{
	var school = $('#addschoolform .school').val();
	var schooltype = parseInt($('#addschoolform .schooltype').val());
	var region =  parseInt($('#addschoolform .region').val());
	var frommonth = parseInt($('#addschoolform .frommonth').val());
	var fromyear = parseInt($('#addschoolform .fromyear').val());
	var tomonth = parseInt($('#addschoolform .tomonth').val());
	var toyear = parseInt($('#addschoolform .toyear').val());
	var tonow = $('#addschoolform .tonow:checked').val() == '1'?1:0;
	
	if(school.length == 0)
	{
		alert('Bạn chưa nhập tên trường.');
		$('#addschoolform .school').focus();
	}
	else
	{
		$('#addschoolform .submit').after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').attr('disabled', 'disabled');
		
		$.ajax({
		   type: "POST",
		   dataType: 'xml',
		   data: 'type=school&text1=' + encodeURIComponent(school) + '&text2=' + schooltype + '&text3=' + region + '&fromyear=' + fromyear + '&frommonth=' + frommonth + '&toyear=' + toyear + '&tomonth=' + tomonth + '&tonow=' + tonow,
		   url: rooturl + 'profile/additem',
		   error: function(){
				$("#addschoolform .submit").removeAttr('disabled');
				$("#addschoolform img.tmp_indicator").remove();
	
				//showGritterError('');
			   },
		   success: function(xml){
				$("#addschoolform .submit").removeAttr('disabled');
				$("#addschoolform img.tmp_indicator").remove();
				
				var success = $(xml).find('success').text();
				
				if(success == "1")
				{
					var message = $(xml).find('message').text();
					$.gritter.add({
						title: 'Th&#224;nh c&#244;ng',
						image: imageDir + 'gritter/success.png',
						time: gritterDelay,
						text: message
					});
					
					
					
					var pid = $(xml).find('id').text();
					var schooltypetext = '';
					var timetext = '';
					var regiontext = '';
					
					if(schooltype < 5)
						schooltypetext = $('#addschoolform .schooltype option:selected').text(); 
						
					if(region > 0 && region < 70)
						regiontext = $('#addschoolform .region option:selected').text(); 
						
					
						
					if(frommonth > 0 && fromyear > 0)
						timetext = frommonth + '/';
						
					if(fromyear > 0)
						timetext += fromyear ;
						
					if(tonow == 1)
						timetext += ' - Hiện tại';
					else
					{
						if(toyear > 0)
						{
							timetext += ' - ';
							if(tomonth > 0)
								timetext += tomonth + '/';
							timetext += toyear;
						}
					}

					//add to school list
					var html = '<div id="profile-'+pid+'" class="profileitem hide">';
					html += '<div class="profileitembutton"><a class="profiledelete" href="javascript:void(0)" onclick="profileadvanced_delete('+pid+')">Xóa</a></div>';
					html += '<div class="profileitemtitle">'+schooltypetext + ' ' + school+' - '+regiontext+'</div>';
					html += '<div class="profileitemtime">'+timetext+'</div></div>';
					$('#schoollist').append(html);
					$('#profile-' + pid).fadeIn();
					
					
					//clear form
					$('#addschoolform .school').val('');
					$('#addschoolform .region').val('0');
					$('#addschoolform .frommonth').val('0');
					$('#addschoolform .fromyear').val('0');
					$('#addschoolform .tomonth').val('0');
					$('#addschoolform .toyear').val('0');
				}
				else
				{
					var message = $(xml).find('message').text();
					showGritterError(message);
					
				}
		   }
		 });
	}
	
}


function profileadvanced_editschool(pid)
{
	var school = $('#profile-edit-'+pid+' .school').val();
	var schooltype = parseInt($('#profile-edit-'+pid+' .schooltype').val());
	var region = parseInt($('#profile-edit-'+pid+' .region').val());
	var frommonth = parseInt($('#profile-edit-'+pid+' .frommonth').val());
	var fromyear =  parseInt($('#profile-edit-'+pid+' .fromyear').val());
	var tomonth =  parseInt($('#profile-edit-'+pid+' .tomonth').val());
	var toyear =  parseInt($('#profile-edit-'+pid+' .toyear').val());
	var tonow = $('#profile-edit-'+pid+' .tonow:checked').val() == '1'?1:0;
	
	if(school.length == 0)
	{
		alert('Bạn chưa nhập tên trường.');
		$('#profile-edit-'+pid+' .school').focus();
	}
	else
	{
		$('#profile-edit-'+pid+' .submit').after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').attr('disabled', 'disabled');
		
		$.ajax({
		   type: "POST",
		   dataType: 'xml',
		   data: 'type=school&text1=' + encodeURIComponent(school) + '&text2=' + schooltype + '&text3=' + region + '&fromyear=' + fromyear + '&frommonth=' + frommonth + '&toyear=' + toyear + '&tomonth=' + tomonth + '&tonow=' + tonow,
		   url: rooturl + 'profile/edititem/' + pid,
		   error: function(){
				$('#profile-edit-'+pid+' .submit').removeAttr('disabled');
				$('#profile-edit-'+pid+' img.tmp_indicator').remove();
	
				//showGritterError('');
			   },
		   success: function(xml){
				$('#profile-edit-'+pid+' .submit').removeAttr('disabled');
				$('#profile-edit-'+pid+' img.tmp_indicator').remove();
				
				var success = $(xml).find('success').text();
				
				if(success == "1")
				{
					var message = $(xml).find('message').text();
					$.gritter.add({
						title: 'Th&#224;nh c&#244;ng',
						image: imageDir + 'gritter/success.png',
						time: gritterDelay,
						text: message
					});
					
					
					var schooltypetext = '';
					if(schooltype < 5)
						schooltypetext = $('#profile-edit-' + pid + ' .schooltype option:selected').text() + ' '; 
						
					//update text
					$('#profile-'+pid+' .schooltext').html(schooltypetext + school);
					
						
					var regiontext = '';
					if(region > 0 && region < 70)
						regiontext = $('#profile-edit-' + pid + ' .region option:selected').text(); 
					$('#profile-'+pid+' .regiontext').html(regiontext);
					
					var timetext = '';
					if(frommonth > 0 && fromyear > 0)
						timetext = frommonth + '/';
						
					if(fromyear > 0)
						timetext += fromyear ;
						
					if(tonow == 1)
						timetext += ' - Hiện tại';
					else
					{
						if(toyear > 0)
						{
							timetext += ' - ';
							if(tomonth > 0)
								timetext += tomonth + '/';
							timetext += toyear;
						}
					}
					
					
					$('#profile-'+pid+' .profileitemtime').html(timetext);
					
					//hide box
					$('#profile-edit-' + pid).hide();
					
										
				}
				else
				{
					var message = $(xml).find('message').text();
					showGritterError(message);
					
				}
		   }
		 });
	}
	
}



/////////////////////////////////////////////
function profileadvanced_addotherfield()
{
	var fieldname = $('#addotherfieldform .fieldname').val();
	var fieldvalue = $('#addotherfieldform .fieldvalue').val();
	
	if(fieldname.length == 0)
	{
		alert('Bạn chưa nhập tên thông tin');
		$('#addotherfieldform .fieldname').focus();
	}
	else
	{
		$('#addotherfieldform .submit').after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').attr('disabled', 'disabled');
		
		$.ajax({
		   type: "POST",
		   dataType: 'xml',
		   data: 'type=other&text1=' + encodeURIComponent(fieldname) + '&text2=' + encodeURIComponent(fieldvalue),
		   url: rooturl + 'profile/additem',
		   error: function(){
				$("#addotherfieldform .submit").removeAttr('disabled');
				$("#addotherfieldform img.tmp_indicator").remove();
	
				//showGritterError('');
			   },
		   success: function(xml){
				$("#addotherfieldform .submit").removeAttr('disabled');
				$("#addotherfieldform img.tmp_indicator").remove();
				
				var success = $(xml).find('success').text();
				
				if(success == "1")
				{
					var message = $(xml).find('message').text();
					$.gritter.add({
						title: 'Th&#224;nh c&#244;ng',
						image: imageDir + 'gritter/success.png',
						time: gritterDelay,
						text: message
					});
					
					
					
					var pid = $(xml).find('id').text();
					

					//add to otherfield list
					var html = '<div id="profile-'+pid+'" class="profileitem profileitemnoborder hide">';
					html += '<div class="profileitembutton"><a class="profiledelete" href="javascript:void(0)" onclick="profileadvanced_delete('+pid+')">Xóa</a></div>';
					html += '<div class="profileitemtitle">';
					html += '<label class="fieldnametext" style="width:130px;">'+fieldname+'</label>';
					html += '<input type="text" readonly="readonly" class="fieldvaluetext inputwide profileiteminputdisabled" value="'+fieldvalue+'" /></span></div>';
					html += '<div class="clear"></div>';
					html += '</div>';
					$('#otherfieldlist').append(html);
					$('#profile-' + pid).fadeIn();
					
					
					//clear form
					$('#addotherfieldform .fieldname').val('');
					$('#addotherfieldform .fieldvalue').val('');
				}
				else
				{
					var message = $(xml).find('message').text();
					showGritterError(message);
					
				}
		   }
		 });
	}
	
}


function profileadvanced_editotherfield(pid)
{
	var fieldname = $('#profile-edit-'+pid+' .fieldname').val();
	var fieldvalue = $('#profile-edit-'+pid+' .fieldvalue').val();
	
	if(fieldname.length == 0)
	{
		alert('Bạn chưa nhập tên thông tin.');
		$('#profile-edit-'+pid+' .fieldname').focus();
	}
	else
	{
		$('#profile-edit-'+pid+' .submit').after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').attr('disabled', 'disabled');
		
		$.ajax({
		   type: "POST",
		   dataType: 'xml',
		   data: 'type=other&text1=' + encodeURIComponent(fieldname) + '&text2=' + encodeURIComponent(fieldvalue) ,
		   url: rooturl + 'profile/edititem/' + pid,
		   error: function(){
				$('#profile-edit-'+pid+' .submit').removeAttr('disabled');
				$('#profile-edit-'+pid+' img.tmp_indicator').remove();
	
				//showGritterError('');
			   },
		   success: function(xml){
				$('#profile-edit-'+pid+' .submit').removeAttr('disabled');
				$('#profile-edit-'+pid+' img.tmp_indicator').remove();
				
				var success = $(xml).find('success').text();
				
				if(success == "1")
				{
					var message = $(xml).find('message').text();
					$.gritter.add({
						title: 'Th&#224;nh c&#244;ng',
						image: imageDir + 'gritter/success.png',
						time: gritterDelay,
						text: message
					});
					
					
					
					//update text
					$('#profile-'+pid+' .fieldnametext').html(fieldname);
					$('#profile-'+pid+' .fieldvaluetext').val(fieldvalue);
					
						
										
					//hide box
					$('#profile-edit-' + pid).hide();
					
										
				}
				else
				{
					var message = $(xml).find('message').text();
					showGritterError(message);
					
				}
		   }
		 });
	}
	
}