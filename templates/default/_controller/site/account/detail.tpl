

<div class="navbarprod">
	<li><a href="#">Trang chủ</a> ››</li>
	<li>Profiles</li>
</div>

<!-- Profiles -->
<div class="bodymember">

	<div class="logsigndm marlogin">
		<div class="barMB">{$lang.controller.titleProfile}</div>
		{include file="notify.tpl" notifyError=$error notifySuccess=$success}

		<form id="formProfile" method='POST'>
			<div class="iconinput">
				<label class="labelMB">{$lang.controller.fullname} <span>*</span></label>
				<input class="inputmember" name="ffullname" type="text" placeholder="{$formData.fullname|@htmlspecialchars}"/>
			</div><div class="iconinput">
				<label class="labelMB">{$lang.controller.phone1} <span>*</span></label>
				<input class="inputmember" name="fphone" type="text" placeholder="{$formData.phone|@htmlspecialchars}"/>
			</div><div class="iconinput">
				<label class="labelMB">{$lang.controller.email} <span>*</span></label>
				<input class="inputmember" name="femail" type="text" placeholder="{$formData.email|@htmlspecialchars}"/>
			</div><div class="iconinput">
				<label class="labelMB">Địa chỉ <span>*</span></label>
				<input class="inputmember" name="faddress" type="text" placeholder="{$formData.address|@htmlspecialchars}"/>

			</div>

			<div class="iconinput"><label class="labelMB">{$lang.controller.gender}<span>*</span></label>
				<div class="wrapradiomb">
		    		<input class="radiomb" name="fgender" type="radio" value="1" {if {$formData.email|@htmlspecialchars}}checked{/if} /><div class="gendermb">Anh<span> </span></div>
		    		<input class="radiomb" name="fgender" type="radio" value="0" {if !{$formData.email|@htmlspecialchars}}checked{/if}/><div class="gendermb">Chị<span> </span></div>
			    </div>
			</div>
			<div class="iconinput">
				<label class="labelMB">{$lang.controller.birthday}</label>
				<input class="inputmember inputdatepicker"  name="fbirthday" type="text" placeholder="{$formData.birthday|@htmlspecialchars}"/>
			</div><div class="iconinput">

				<!-- <label class="label_prop">{$lang.controller.personalID}</label>
				<input class="input_prop" name="fpersonalID" type="text" placeholder="{$formData.PERSONALID|@htmlspecialchars}" /> -->

				{*<label class="label_prop">{$lang.controller.address}<span>*</span></label>
				<input class="input_prop" name="faddress" type="text" placeholder="{$formData.address|@htmlspecialchars}" />*}
				</div><div class="iconinput">
				<label class="labelMB">{$lang.controller.province}<span>*</span></label>
				<select class="inputmember" name="fcity" style="width: 342px;">
					<option value=''>----</option>
					{foreach $setting as $key=>$value}
						<option value='{$key}' {if {$key}=={$formData.city}}selected{/if}>{$value}</option>
					{/foreach}
				</select>
				</div>
				<input class="btnmember" name="fSubmitBasic" type="submit" value="Cập nhật"/>
		</form>
	</div>

	<!-- 	<div class="profiles_right">
			<div class="user_intro">
					<div class="intro-layer1"><a href="#"><i class="icon-pfs16"></i><span>30</span></a></div>
						<div class="intro-layer2"><a href="#"><i class="icon-pfs17"></i><span>80</span></a></div>
						<div class="intro-layer3"><a href="#"><i class="icon-pfs18"></i><span>200</span></a></div>
						
					<div class="introrow">
								<div class="introrow-r"><a href="#"><img src="images/avatar_user-larg.png" width="120" height="95" /></a></div>
							<div class="introrow-l">
									<div class="l-rowname">
											<div class="nameuser">Cao Cầu</div>
												<span>Hồ Chí Minh</span>
												<span>12/12/1981</span>
										</div>
									<div class="l-rowinfo">
											<strong>Đời là phù du, ngu là phù mỏ</strong>
										<span>"Tâm tịnh, lòng không tịnh"</span>
										</div>
								</div>
						</div>
						<div class="user_more"><a href="#">Xem thêm</a></div>
				</div>
				
				<div class="chart">
					<span><i class="icon-pfs19"></i>Số lượng đơn hàng</span>
						<div><img src="images/chart.jpg" width="300" height="200" /></div>
				</div>
				<div class="chart">
					<span><i class="icon-pfs19"></i>Lượt mua bán</span>
						<div><img src="images/chart.jpg" width="300" height="200" /></div>
				</div>
				<div class="chart">
					<span><i class="icon-pfs19"></i>Lượt xem sản phẩm</span>
						<div><img src="images/chart.jpg" width="300" height="200" /></div>
				</div>
		</div> -->

</div>

{literal}
	<script type="text/javascript">

		$(document).ready(function(){
			$('.inputdatepicker').datepicker({'format':'dd-mm-yyyy', 'weekStart' : 1})
					.on('changeDate', function(ev){
						$('.datepicker').hide();
						$(this).blur();
					});
		});


	</script>
{/literal}