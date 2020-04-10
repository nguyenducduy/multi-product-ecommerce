
<style type="text/css">
.formComment {
			margin: 0px; 
			padding: 15px 10px; 
			border-width: 0px 0px 1px;
			border-bottom-style: solid; 
			border-bottom-color: rgb(211, 211, 211); 
			list-style: none; outline: 0px; 
			background-color: #f1f1f1;
			font-size: 16px;
			float: left; 
			width: 480px; 
			border-radius: 3px; 
			z-index: 100; 
			line-height: 20px;
}
.divimg
{
		margin: 0px; 
		padding: 3px; 
		border: 1px solid rgb(223, 223, 223); 
		list-style: none; 
		outline: 0px; 
		background-attachment: scroll; 
		width: 50px; 
		height: 50px; 
		float: left; 
		border-radius: 3px;
		-webkit-box-shadow: rgb(235, 235, 235) 0px 0px 5px; 
		box-shadow: rgb(235, 235, 235) 0px 0px 5px;
		background-position: 2px 2px; 
		background-repeat: no-repeat no-repeat;
}
.divarea
{
	margin: 0px; 
	padding: 0px; 
	border: 0px; 
	list-style: none; 
	outline: 0px; 
	background-color: transparent; 
	float: right; 
	width: 410px; 
	position: relative;
}
.clsarea
{
	margin: 0px; 
	padding: 10px; 
	border-color: rgb(223, 223, 223); 
	list-style: none; 
	outline: 0px; 
	font-size: 12px; 
	width: 385px; 
	height: 35px; 
	color: rgb(51, 51, 51);
}
#parentComment ul
{
			margin: 0px; 
			padding: 10px; 
			border: 0px; 
			list-style: none;
			outline: 0px; 
			font-size: 16px;
			width: 480px;
			z-index: -500; 
			line-height: 20px;
}
#parentComment li
{
		margin: 0px 0px 10px; 
		padding: 0px; 
		border: 0px; 
		list-style: none; 
		outline: 0px;
		font-size: 10pt;
		background-color: transparent;
		width: 480px; 
		float: left;
		background-position: initial initial; 
		background-repeat: initial initial;
}
#parentComment .user
{
		margin: 0px; 
		padding: 3px; 
		border: 1px solid rgb(223, 223, 223); 
		list-style: none; 
		outline: 0px; 
		width: 50px; 
		height: 50px; 
		float: left; 
		border-radius: 3px; 
		box-shadow: rgb(235, 235, 235) 0px 0px 5px; 
		background-position: 3px 3px; 
		background-repeat: no-repeat no-repeat;
}
.noidung
{
			margin: 0px;
			padding: 10px; 
			border: 1px solid rgb(223, 223, 223); 
			list-style: none; 
			outline: 0px; 
			float: right; 
			width: 385px; 
			position: relative; 
			border-radius: 3px;

}
.ptime
{
		margin: 0px; 
		padding: 0px; 
		border: 0px; 
		font-size: 9pt; 
		position: absolute; 
		top: 10px; 
		right: 10px; 

}
.message_txt
{
		border-width: 1px 0px 0px;
		border-top-style: solid;
		 border-top-color: rgb(223, 223, 223);
		   background-color: transparent;
		    width: 385px;

}
.currentedit
{
	border:5px solid green;
}
.sb-nav-close {
float: right;
width: 29px;
height: 29px;
position: absolute;
right: -20px;
top: -15px;
margin: -8px -9px 0 0;
z-index: 1000;
cursor: pointer;
background-image: url(/templates/default/images/shadowbox/close.png);
background-repeat: no-repeat;
}
.avata
{
	height:50px !important;
}
</style>
<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
    <li class=""><a href="{$conf.rooturl_admin}/scrumstory">List Story</a> <span class="divider">/</span></li>
    <li class="active">Story Detail</li>
</ul>

<div class="page-header" rel="menu_user_list"><span class="label label-success"><h1 style='margin-bottom: 0px'>{$lang.controller.head_detail}</h1></span></div>

<form action="" method="post" name="myform" class="form-horizontal">
    <input type="hidden" name="ftoken" value="{$smarty.session.userAddToken}"/>


{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}



		    <div class="control-group">
		        <label class="control-label" >{$lang.controller.labelSpid} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text" disabled="disabled"  value="{if {$myScrumStory->projectname}==""}{$lang.controller.lbdempty}{else}{$myScrumStory->projectname}{/if}" class="">
		        	<input type="hidden" id="fssid" value="{$myScrumStory->id}">
		        </div>
		    </div>

			<div class="control-group">
		        <label class="control-label" >{$lang.controller.labelAsa} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text" disabled="disabled"  value="{if {$myScrumStory->asa}==""}{$lang.controller.lbdempty}{else}{$myScrumStory->asa}{/if}" class="">
		        </div>
		    </div>


		    <div class="control-group">
		        <label class="control-label" >{$lang.controller.labelIwant} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text"  disabled="disabled"  value="{if {$myScrumStory->iwant}==""}{$lang.controller.lbdempty}{else}{$myScrumStory->iwant}{/if}" class="">
		        </div>
		    </div>

		    <div class="control-group">
		        <label class="control-label" >{$lang.controller.labelSothat} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text" disabled="disabled"  value="{if {$myScrumStory->sothat}==""}{$lang.controller.lbdempty}{else}{$myScrumStory->sothat}{/if}" class="">
		        </div>
		    </div>

		    <div class="control-group">
		        <label class="control-label" >{$lang.controller.labelTag} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text"disabled="disabled"value="{if {$myScrumStory->tag}==""}{$lang.controller.lbdempty}{else}{$myScrumStory->tag}{/if}" class="">
		        </div>
		    </div>




		    <div class="control-group">
		        <label class="control-label" >{$lang.controller.labelPoint} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text"disabled="disabled"value="{if {$myScrumStory->point}==""}{$lang.controller.lbdempty}{else}{$myScrumStory->point}{/if}" class="">
		        </div>
		    </div>


		    <div class="control-group">
		        <label class="control-label" >{$lang.controller.labelCategoryid} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text"disabled="disabled"value="{if {$myScrumStory->categoryid}==""}{$lang.controller.lbdempty}{else}{$myScrumStory->categoryid}{/if}" class="">
		        </div>
		    </div>


		    <div class="control-group">
		        <label class="control-label" >{$lang.controller.labelPriority} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text"disabled="disabled"value="{if {$myScrumStory->priority}==""}{$lang.controller.lbdempty}{else}{$myScrumStory->priority}{/if}" class="">
		        </div>
		    </div>

            <div class="control-group">
		        <label class="control-label" >Level<span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text"disabled="disabled"value="{if {$myScrumStory->mylevel}==""}{$lang.controller.lbdempty}{else}{$myScrumStory->mylevel}{/if}" class="">
		        </div>
		    </div>



		    <div class="control-group">
		        <label class="control-label" >{$lang.controller.labelStatus} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text"disabled="disabled"value="{if {$myScrumStory->status}==""}{$lang.controller.lbdempty}{else}{$myScrumStory->status}{/if}" class="">
		        </div>
		    </div>

		    <div class="control-group">
		        <label class="control-label" >{$lang.controller.labelDatecompleted} <span
		                class="star_require">*</span></label>

		        <div class="controls">
		            <input type="text"disabled="disabled"value="{if {$myScrumStory->datecompleted}==""}{$lang.controller.lbdempty}{else}{$myScrumStory->datecompleted}{/if}" class="">
		        </div>
		    </div>





</form>
<div class="page-header" rel="menu_user_list"><span class="label label-success"><h1 style='margin-bottom: 0px'>{$lang.controller.head_comment}</h1></span></div>
<div class="tab-pane active" id="tab1" style="width:800px;margin-left: 80px">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}

				<div id="parentComment" >
					<ul id="ulComment">
						{foreach $comment as $k=>$v}
						<li id="li_{$v->id}">
							<div class="user" >
								<span >
									<a href="#">
										<img class="avata" height="50" src="http://new.dienmay.com/uploads/avatar/{$v->avatar}"  width="50" />
									</a>
								</span>
							</div>
							<div class="noidung" id="noidung">
								<p><a href="#">{$v->username}</a></p>
								<p class="ptime" >
									{$v->datecreate} {if {$formData.permiss}} &nbsp<span class="btn btn-mini" onclick="editaction(this,'{$v->id}')"><i class="icon-pencil"></i></span>{/if}
									&nbsp<a style="{if {$v->filepath==""}}display:none{/if}" class="btn btn-mini" href="{$v->filepath}" id="download_{$v->id}"><i class="icon-paper-clip" ></i></a>
									<a class="sb-nav-close exit_{$v->id}" onclick="cancel();"  title="Close" style="display:none"></a>
								</p>
								<div class="message_txt" id="content_{$v->id}">
									{$v->content}
								</div>
							</div>
						</li>
						{/foreach}
					</ul>

					<div class="formComment">
						<div class="divimg">
							<span >
									<a href="#">
										<img class="avata" height="50" src="{$formData.avatar}"  width="50" />
									</a>
							</span>
						</div>
						<div class="divarea">
							<textarea cols="20" id="fcontent" maxlength="500" rows="5" class="clsarea" value="Bạn nghĩ gì về chủ đề bài viết? Nhập nội dung chia sẻ tại đây..."></textarea>
							<form id="frmupload">
							<p style="margin-top: 8px" id="pupload">
								<input type="file" name="datafile" id="datafile">
								<input type="hidden" name="idComment" id="idComment" value="">
								<input type="hidden" name="contentComment" id="contentComment" value="">
							</p>
							<p style="margin-top: 8px" id="pgui">
								<input type="button" id="gui" class="btn btn-primary" value="gửi" onclick="addaction(this.form);return false;">
								<input type="button" id="clear" class="btn btn-primary" value="clear" >
							</p>
							{if {$formData.permiss}} 
							<p style="margin-top: 8px;display: none" id="pegui">
								<input type="button" id="egui" class="btn btn-primary" value="gửi" onclick="edit('{$v->id}',this.form);return false;">
								<input type="button" id="cancel" class="btn btn-primary" value="cancel" >
							</p>
							{/if}
							</form >
						</div>
					</div>
				</div>
<div id='url' url='{$conf.root_admin}'></div>
<div id="upload"></div>
				
</div>
{literal}
<script type="text/javascript">
var ideditreal = "";
var oldclass   = "";
$("#clear").click(function(){
	$("#fcontent").val("");
});
$("#cancel").click(function(){
	$("#fcontent").val("");
	$("#pgui").show();
	$("#pegui").hide();
	$(".sb-nav-close").hide();
});
function cancel(){
	$("#fcontent").val("");
	$("#pgui").show();
	$("#pegui").hide();
	$(".sb-nav-close").hide();
}
function addaction(form){
		var Story_id = $("#fssid").val();
		var content = $("#fcontent").val();
		
		var url = '/admin/scrumstory/indexAjax';
        var urladmin = $('#url').attr('url');
		$.ajax({
				type : "POST",
				data : {contents :content,Story_id:Story_id,action:"add"},
				url : url,
				dataType: "html",
				success: function(data){
					if(data !="")
					{
						$("#ulComment").append(data);
						$("#fcontent").val("");
						
						$("#ulComment").html();
						/*upload anh */
						var id = $("#newid").val();
						$("#idComment").val(id);
						$("#contentComment").val(content);
						fileUpload(form,urladmin+'scrumstory/indexAjax','upload');
						setTimeout(function(){getimg(id)},2000);
						$("#datafile").val("");
					}
						
				}
		});

}
function editaction(e,id)
{
	ideditreal = id;
	$(".sb-nav-close").hide();
	$(".exit_"+id).show();
	$("#pgui").hide();
	$("#pegui").show();
	var text =$("#content_"+id).html();
	$("#fcontent").val($.trim(text));
}

function getimg(id)
{
	var url      = '/admin/scrumstory/indexAjax'; 
	var content  = "getimg";
	$.ajax({
			type : "POST",
			data : {contents :content,Comment_id:id,action:"getimg"},
			url : url,
			dataType: "html",
			success: function(data){
				
					if(data!="")
					{
						$("#download_"+id).attr("href",data);
						$("#download_"+id).show(1000);
					}
					else
					{
						$("#download_"+id).attr("",data);
						$("#download_"+id).hide(1000);
					}
			}
	});
}

function edit(id,form)
{
	var id       =    ideditreal;
	var text     = $("#content_"+id).html();
	var Story_id = $("#fssid").val();
	var url      = '/admin/scrumstory/indexAjax'; 
	var content  = $("#fcontent").val();
    var urladmin = $('#url').attr('url');

    $.ajax({
					type : "POST",
					data : {contents :content,Comment_id:id,Story_id:Story_id,action:"edit"},
					url : url,
					dataType: "html",
					success: function(data){
						if(data =="ok")
						{
							$("#content_"+id).html(content);
							$("#pgui").show();
							$("#pegui").hide();
							$("#fcontent").val("");
							$("#idComment").val("");

							/*upload anh */
							$("#contentComment").val(content);
							$("#idComment").val(id);
							fileUpload(form,urladmin+'scrumstory/indexAjax','upload');
							setTimeout(function(){getimg(id)},2000);
							$("#datafile").val("");
							$(".exit_"+id).hide();
						}
							
					}
			});
}

function fileUpload(form, action_url, div_id) {
    // Create the iframe...
    var iframe = document.createElement("iframe");
    iframe.setAttribute("id", "upload_iframe");
    iframe.setAttribute("name", "upload_iframe");
    iframe.setAttribute("width", "0");
    iframe.setAttribute("height", "0");
    iframe.setAttribute("border", "0");
    iframe.setAttribute("style", "width: 0; height: 0; border: none;");
 
    // Add to document...
    $("#frmupload").append(iframe);
    window.frames['upload_iframe'].name = "upload_iframe";
 
    iframeId = document.getElementById("upload_iframe");
 
    // Add event...
    var eventHandler = function () {
 
            if (iframeId.detachEvent) iframeId.detachEvent("onload", eventHandler);
            else iframeId.removeEventListener("load", eventHandler, false);
 
            // Message from server...
            if (iframeId.contentDocument) {
                content = iframeId.contentDocument.body.innerHTML;
            } else if (iframeId.contentWindow) {
                content = iframeId.contentWindow.document.body.innerHTML;
            } else if (iframeId.document) {
                content = iframeId.document.body.innerHTML;
            }
 
             document.getElementById(div_id).innerHTML = content;
 
            // Del the iframe...
            setTimeout('iframeId.parentNode.removeChild(iframeId)', 250);
        }
 
    if (iframeId.addEventListener) iframeId.addEventListener("load", eventHandler, true);
    if (iframeId.attachEvent) iframeId.attachEvent("onload", eventHandler);
 
    // Set properties of form...
    $("#frmupload").attr("target", "upload_iframe");
    $("#frmupload").attr("action", action_url);
    $("#frmupload").attr("method", "post");
    $("#frmupload").attr("enctype", "multipart/form-data");
    $("#frmupload").attr("encoding", "multipart/form-data");
 
    // Submit the form...
    $("#frmupload").submit();
 
    // document.getElementById(div_id).innerHTML = "Uploading...";
}
</script>

	
	
{/literal}