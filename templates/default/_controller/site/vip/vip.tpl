<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VIP</title>
<link href="{$currentTemplate}css/site/css-vip.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="wrap-vip">
	<div class="vip-header">
    	<a href="{$conf.rooturl}" class="logo"> <img src="{$currentTemplate}images/vip/logo-dienmay-vip.png?v=2" alt="" title="" width="280" height="55" border="0" /></a>
        <div class="vip-menu">
        	<ul>
        		<li><a href="#menu-princ">  Qui định</a></li>
            	<li><a href="#check">  Kiểm tra điểm tích lũy</a></li>
           		<li><a href="#question">  Câu hỏi thường gặp</a></li>
            </ul>
        </div>
        <div class="vip-rigister"><span ><a href="{$conf.rooturl}register"> Đăng ký </a></span><span style="color:#fff;">|</span><span><a href="{$conf.rooturl}login"> Đăng nhập</a></span></div>
       
    </div>
    <div class="vip-banner"><img src="{$currentTemplate}images/vip/banner_vip.jpg" /></div>
    
    <div class="vip-benefit">
    	<div id="menu-princ" class="benefit-titl">Tận hưởng đặc quyền ưu đãi khi trở thành thành viên VIP</div>
        <div class="benefit-cont">
        	<ul>
            	<li>
                  <div class="layericon"><i class="icon-save"></i></div>
                  <p class="be-name"> Tích Lũy </p>
                    <p class="be-nd">Tích lũy thường xuyên khi mua sắm tại <span style="color:#00adf2; font-weight:bold;"><a href="{$conf.rooturl}">dienmay.com</a></span> <br />
- <span class="percent">2%</span> đối với hạng Vip Vàng<br />
- <span class="percent">3%</span>  đối với hạng Vip Kim Cương
</p>
                
                </li>
                <li>
                	<div class="layericon"><i class="icon-gift"></i></div>
                	<p class="be-name">Mua hàng đổi quà </p>
                    <p class="be-nd">Dùng tiền tích lũy để mua / đổi  lấy bất cứ sản phẩm nào tại <span style="color:#00adf2; font-weight:bold;"><a href="{$conf.rooturl}">dienmay.com</a></span>.<br />
                    </p>
                
                </li>
                
                <li>
                	<div class="layericon"><i class="icon-special"></i></div>
                	<p class="be-name">Ưu đãi nhiều hơn </p>
                    <p class="be-nd">Tham gia các chương trình khuyến mại đặc biệt của <span style="color:#00adf2; font-weight:bold;"><a href="{$conf.rooturl}">dienmay.com</a></span> <br />
                  </p>
                
                </li>
            </ul>
        </div>
    </div>
  
  <div class="vip-check">
  	<div id="check" class="check-title">Kiểm tra điểm tích lũy</div>
    <div class="div"><img src="{$currentTemplate}images/vip/divider.jpg" width="968" height="5" /> </div>
    <div class="check-cont">
    	<div class="left-check"> <img src="{$currentTemplate}images/vip/VIPzone-1_07.png" width="240" height="240" /></div>
        <div class="right-check">
        	<div class="form-title">Vui lòng nhập thông tin đã đăng ký</div>
        	<form class="check-form" id="checkpointform">
	            <div class="f-single">
            		<label class="label1">Họ và tên</label>
           			 <input type="text" id="fullname" name="fullname" />
	             </div>  
	             <div class="f-single">
             		<label class="label1">Số điện thoại</label>
           			 <input type="text" name="phonenum" id="phonenum" /> 
	             </div>	             
	             <div class="btn-check"><a href="javascript:void(0)" onclick="checkpoint()"> Kiểm tra</a></div>
            </form>            
        </div>        
    </div>
       
  </div>
    
  <div class="vip-ques">
  	<div id="question" class="ques-title"> Câu hỏi thường gặp</div>
    <div class="div"><img src="{$currentTemplate}images/vip/divider.jpg" width="968" height="5" /></div>
    <div class="list-ques">
    	<div class="question-sent">
    		<h3 class="titleques">QUYỀN LỢI DÀNH RIÊNG CHO THÀNH VIÊN dienmay.com</h3>
    		<a class="question" href="#"><em>1. Tôi đăng ký thành viên <span style="color:#00adf2; font-weight:bold;">dienmay.com</span>, tôi được ưu đãi gì khi mua sắm?</em></a>
    	</div>
        <div class="sub-answer answer"><p>Từ ngày 22/10/2013, đăng ký thành viên <span style="color:#00adf2; font-weight:bold;">dienmay.com</span>, bạn nhận những ưu đãi:</p>
			<p>- Được tích lũy 2% hoặc 3% trên giá mua sản phẩm để đổi quà, giảm tiền, mua hàng vào hóa đơn sau, áp dụng cho tất cả các sản phẩm đang kinh doanh tại <span style="color:#00adf2; font-weight:bold;">dienmay.com</span>, áp dụng kể cả sản phẩm có khuyến mãi và mua trả góp. Không áp dụng với các sản phẩm sim số, thẻ cào, dịch vụ thu cước và đơn hàng doanh nghiệp, đơn hàng bán sỉ.</p>
			<p>- Được mua sản phẩm giảm giá sốc tại khu ưu đãi dành riêng cho thành viên của <span style="color:#00adf2; font-weight:bold;">dienmay.com</span>.</p>
			<p>- Được chăm sóc đặc biệt nhân ngày sinh nhật hoặc được ưu tiên mời tham gia các sự kiện đặc biệt do <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> tổ chức.</p>
			<p>- Được ưu tiên nhận thông tin khuyến mãi.</p>
		</div>    
    </div>	
    
    <div class="list-ques">
    	<div class="question-sent">
    		<h3 class="titleques">ĐĂNG KÝ THÀNH VIÊN, THAY ĐỔI THÔNG TIN, HỖ TRỢ KHI MẤT THẺ</h3>
    		<a class="question" href="#"><em>2. Đăng ký thẻ thành viên <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> như thế nào?</em></a>
    	</div>
        <div class="sub-answer answer"><p>Việc đăng ký thẻ thành viên là miễn phí và vô cùng đơn giản, bạn có thể thực hiện tại siêu thị hoặc ngay trên website <span style="color:#00adf2; font-weight:bold;"><a href="{$conf.rooturl}" title="siêu thị điện máy dienmay.com">dienmay.com</a></span></p>
			<p>Để <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> có thể dành những ưu đãi tốt nhất và mang lại niềm vui cho bạn và gia đình. Khi làm thẻ, bạn vui lòng cung cấp chính xác những thông tin sau:</p>
			<p>+ Họ và tên<br />
			+ Ngày sinh<br />
			+ Số CMND<br />
			+ Địa chỉ: đầy đủ số nhà, đường, phường, xã, thành phố, tỉnh…<br />
			+ Số điện thoại<br />
			+ Địa chỉ Email (nếu có)<br />
			</p>
			<p><span style="color:#00adf2; font-weight:bold;">dienmay.com</span> cam kết bảo mật tất cả những thông tin khách hàng cung cấpKhi có bất kỳ sự thay đổi nào đối với một trong những thông tin trên, khách hàng vui lòng liên hệ tổng đài 19001883 hoặc nhân viên siêu thị <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> để cập nhật thông tin mới. dienmay.com sẽ không chịu trách nhiệm với những tổn thất xảy ra trong trường hợp thông tin khách hàng không chính xác.</p>
		</div>    
    </div>
    
    <div class="list-ques">
    	<div class="question-sent">
    		<a class="question" href="#"><em>3. Tôi không sử dụng điện thoại di động, vậy liệu tôi có thể đăng ký thẻ thành viên của <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> hay không?</em></a>
    	</div>
        <div class="sub-answer answer"><p>Số điện thoại là một trong những thông tin quan trọng để <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> giữ liên lạc và đảm bảo quyền lợi tối đa về thông tin khuyến mãi, giảm giá … cho thành viên <span style="color:#00adf2; font-weight:bold;">dienmay.com</span>. Trong trường hợp bạn không có số điện thoại, việc liên hệ và thông tin tới khách hàng sẽ khó khăn hơn. </p>
			<p>Bạn sẽ vẫn được làm thẻ thành viên dựa trên số CMND và số điện thoại nhà. Tuy nhiên, để theo dõi các thông tin khuyến mãi hoặc ưu đãi dienmay.com dành riêng cho thành viên, bạn phải trực tiếp lên website <a href="{$conf.rooturl}" title="dienmay.com">dienmay.com</a> hoặc ghé các <a href="{$conf.rooturl}sieuthi" title="siêu thị điện máy dienmay.com">siêu thị điện máy dienmay.com</a></p>
		</div>    
    </div>
    
    <div class="list-ques">
    	<div class="question-sent">
    		<a class="question" href="#"><em>4. Tôi muốn đổi số điện thoại đã đăng ký trước đó thì cần làm gì?</em></a>
    	</div>
        <div class="sub-answer answer"><p>Mỗi CMND tương ứng với 1 số điện thoại chỉ được đăng ký cho một mã thẻ, nếu thành viên <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> muốn thay đổi số điện thoại, bạn có thể mang CMND / thẻ thành viên đến siêu thị để nhân viên hỗ trợ thay đổi thông tin.</p>
		</div>    
    </div>		
    
    <div class="list-ques">
    	<div class="question-sent">
    		<a class="question" href="#"><em>5. Tôi bị mất thẻ, nếu người khác nhặt được thì vẫn dùng được điểm số tích lũy của tôi phải không?</em></a>
    	</div>
        <div class="sub-answer answer"><p>Nếu bị mất thẻ, để bảo vệ quyền lợi ưu đãi thông qua số điểm tích lũy của mình, bạn nên nhanh chóng liên hệ Tổng đài <span style="color:#00adf2; font-weight:bold;">19001883</span> để khóa tài khoản và liên hệ với nhân viên <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> để được hỗ trợ cấp lại thẻ.Nguyên tắc cấp lại thẻ, khách hàng sẽ nhận được một mã số đại diện mới để thực hiện giao dịch, mã cũ sẽ bị khóa để đảm bảo không có ai khác sử dụng thẻ và điểm tích lũy của bạn.</p>
		</div>    
    </div>	
    
    <div class="list-ques">
    	<div class="question-sent">
    		<a class="question" href="#"><em>6. Tôi cần làm lại thẻ thành viên, <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> có tính phí tôi không? Tôi phải làm gì để được cấp lại thẻ thành viên </em></a>
    	</div>
        <div class="sub-answer answer"><p>Trường hợp mất thẻ thành viên <span style="color:#00adf2; font-weight:bold;">dienmay.com</span>, thành viên cần mang CMND đến siêu thị để nhân viên <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> hỗ trợ cấp lại thẻ khác sau khi đối chiếu một số thông tin cơ bản. Bạn bị trừ 20,000đ cho việc cấp lại thẻ.</p>
        <p>Trường hợp thông tin đối chiếu không khớp, nhân viên sẽ hỗ trợ bạn làm lại thẻ thành viên, tuy nhiên doanh số tích lũy và điểm tích lũy sẽ bằng 0</p>
		</div>    
    </div>

    <div class="list-ques">
    	<div class="question-sent">
    		<a class="question" href="#"><em>7. Thẻ thành viên <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> của tôi hư hỏng và không sử dụng được nữa, tôi phải làm gì để được cấp lại thẻ thành viên </em></a>
    	</div>
        <div class="sub-answer answer"><p>Trường hợp thẻ thành viên <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> hư hỏng và không sử dụng được, thành viên cần mang thẻ lỗi đến siêu thị để nhân viên <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> hỗ trợ cấp lại thẻ. Việc cấp lại thẻ là hoàn toàn miễn phí.</p>
		</div>    
    </div>

    <div class="list-ques">
    	<div class="question-sent">
    		<a class="question" href="#"><em>8. Tôi được thăng hạng từ Thành viên Vàng lên Thành viên Kim Cương. Tôi có phải làm lại thẻ thành viên không?</em></a>
    	</div>
        <div class="sub-answer answer"><p>Có. Nhằm đảm bảo quyền lợi của thành viên, bạn hãy ngay lập mang thẻ thành viên VIP Vàng đến siêu thị để nhân viên <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> hỗ trợ cấp thẻ thành viên VIP Kim Cương. Việc cấp lại thẻ là hoàn toàn miễn phí..</p>
		</div>    
    </div>
    
    <div class="list-ques">
    	<div class="question-sent">
    		<a class="question" href="#"><em>9. Nhân viên <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> có được làm thẻ ưu đãi và hưởng ưu đãi bình thường như khách hàng khác không?</em></a>
    	</div>
        <div class="sub-answer answer">
        	<p>Toàn bộ nhân viên dienmay.com được xem là khách hàng nội bộ của <span style="color:#00adf2; font-weight:bold;">dienmay.com</span>, cũng có quyền đăng ký làm thẻ và hưởng ưu đãi bình thường như các khách hàng khác.</p>
        	<p></p>
		</div>    
    </div>
    
    <div class="list-ques">
    	<div class="question-sent">
    		<h3 class="titleques">SỬ DỤNG THẺ THÀNH VIÊN ĐỂ TÍCH LŨY DOANH THU, TÍCH LŨY ĐIỂM VÀ SỬ DỤNG ĐIỂM TÍCH LŨY</h3>
    		<a class="question" href="#"><em>10. Trường hợp nào tôi được tích lũy 2% (Thành viên Vàng) và trường hợp nào tích lũy 3% (Thành viên Kim Cương)</em></a>
    	</div>
        <div class="sub-answer answer">
        	<p>Trường hợp bạn đăng ký làm thành viên <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> và có doanh số tích lũy ≤ 50 triệu (nhỏ hơn hoặc bằng) thì khách hàng là Thành viên Vàng với quyền lợi tích lũy ngay 2% trên giá sản phẩm để mua hàng, giảm tiền, đổi quà cho lần mua sắm sau.</p>
        	<p>Trường hợp bạn đăng ký làm thành viên <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> và có doanh số tích lũy >50 triệu (lớn hơn) thì khách hàng là Thành viên Kim Cương, quyền lợi tích lũy ngay 3% trên giá sản phẩm để mua hàng, giảm tiền đổi quà cho lần mua sắm sau</p>
        	<p><em>Doanh số tích lũy = doanh số hiện tại + tổng giá trị hóa đơn phát sinh</em></p>
        	<p>Ví dụ: </p>
        	<p>Tôi làm thẻ thành viên và mua <a href="{$conf.rooturl}/laptop/asus-k55a-53212g50">Laptop Asus K55A 53212G50</a> giá mua 13,190,000đ tại <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> và tại thời điểm đó</p>        	
        	<p>- doanh số tích lũy của tôi là 13,190,000đ</p>
        	<p>- điểm số tích lũy của tôi tương ứng là 2%*13,190,000=263,800</p>
		</div>    
    </div>

    <div class="list-ques">
    	<div class="question-sent">
    		<a class="question" href="#"><em>11. Khi nào thì tôi được sử dụng điểm tích lũy để đổi quà, giảm tiền, mua hàng</em></a>
    	</div>
        <div class="sub-answer answer">
        	<p>&#8226; - Trường hợp bạn là Thành viên Vàng, bạn được sử dụng điểm tích lũy vào đơn hàng của tháng kế tiếp.</p>
            <p><strong>Ví dụ</strong></p>
        	<p>Tôi là Thành viên Vàng, ngày 5/10 tôi mua <a href="{$conf.rooturl}laptop/asus-k55a-53212g50">Laptop Asus K55A 53212G50</a> giá mua 13,190,000đ tại <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> và điểm tích lũy tương ứng là 263,800đ, gọi là điểm tích lũy dự kiến.</p>
            <p>Ngày 1/11 tôi sẽ được sử dụng 263,800đ này để đổi quà, giảm tiền, mua hàng.</p>                        
        	<p>&#8226;- Trường hợp bạn là Thành viên Kim Cương, bạn được sử dụng ngay điểm tích lũy cho đơn hàng kế tiếp.</p>        	
        	<p><strong>Ví dụ</strong></p>
        	<p>Tôi là Thành viên Kim Cương, ngày 5/10 tôi mua <a href="{$conf.rooturl}laptop/asus-k55a-53212g50">Laptop Asus K55A 53212G50</a> giá mua 13,190,000đ tại <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> và điểm tích lũy tương ứng là 263,800đ.</p>
        	<p>Ngay từ đơn hàng kế tiếp, tôi sẽ được sử dụng 263,800đ này để đổi quà, giảm tiền, mua hàng.</p>
		</div>    
    </div>

    <div class="list-ques">
        <div class="question-sent">
            <a class="question" href="#"><em>12. Tôi tích lũy điểm và sử dụng điểm tích lũy như thế nào ?</em></a>
        </div>
        <div class="sub-answer answer">
            <p>- Trường hợp bạn là Thành viên Vàng, bạn được sử dụng điểm tích lũy vào đơn hàng của tháng kế tiếp. </p>
            <p><strong>Ví dụ:</strong></p>
            <p>
            	Tôi là Thành viên Vàng, ngày 5/10 tôi mua <a title="Laptop Asus K55A 53212G50" href="{$conf.rooturl}laptop/asus-k55a-53212g50">Laptop Asus K55A 53212G50</a> giá mua 13,190,000đ tại <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> và điểm tích lũy tương ứng là 263,800đ, gọi là điểm tích lũy dự kiến.
Ngày 1/11 tôi sẽ được sử dụng 263,800đ này để đổi quà, giảm tiền, mua hàng.
            </p>
            <p>
            	- Trường hợp bạn là Thành viên Kim Cương, bạn được sử dụng ngay điểm tích lũy cho đơn hàng kế tiếp.
            </p>
            <p>
            	<strong>Ví dụ:</strong>
            </p>
            <p>
            	Tôi là Thành viên Kim Cương, ngày 5/10 tôi mua <a title="Laptop Asus K55A 53212G50" href="{$conf.rooturl}laptop/asus-k55a-53212g50">Laptop Asus K55A 53212G50</a> giá mua 13,190,000đ tại <span style="color:#00adf2; font-weight:bold;">Laptop Asus K55A 53212G50</a> giá mua 13,190,000đ tại dienmay.com và điểm tích lũy tương ứng là 263,800đ. 
Ngay từ đơn hàng kế tiếp, tôi sẽ được sử dụng 263,800đ này để đổi quà, giảm tiền, mua hàng.
            </p>
        </div>    
    </div>
    
    <div class="list-ques">
    	<div class="question-sent">
    		<a class="question" href="#"><em>13. Tôi có thể đưa thẻ cho người thân hoặc bạn bè mình dùng thẻ được không?</em></a>
    	</div>
        <div class="sub-answer answer">
        	<p><span style="color:#00adf2; font-weight:bold;">dienmay.com</span> vẫn khuyến khích khách hàng dùng chung thẻ với người thân, bạn bè để tích lũy. Tuy nhiên, việc làm thẻ tại dienmay.com nhanh và thuận tiện, mỗi khách hàng được khuyến khích làm thẻ riêng cho mình để nhận được nhiều ưu đãi và chăm sóc đặc biệt của dienmay.com.</p>
		</div>    
    </div>
    
    <div class="list-ques">
    	<div class="question-sent">
    		<a class="question" href="#"><em>14. Nếu tôi có 2 thẻ thành viên thì có được cộng dồn điểm để mua 1 sản phẩm hay không</em></a>
    	</div>
        <div class="sub-answer answer">
        	<p>Bạn chỉ có thể sử dụng ưu đãi từ 1 thẻ để mua 1 đơn hàng. Để đảm bảo quyền lợi cho khách hàng, <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> sẽ áp dụng mức ưu đãi lớn hơn.</p>
		</div>    
    </div>
    
    <div class="list-ques">
    	<div class="question-sent">
    		<a class="question" href="#"><em>15. Tôi đăng ký thẻ thành viên trước ngày 22/10 (trước khi đổi sang chính sách mới), thì tôi dùng chính sách nào.</em></a>
    	</div>
        <div class="sub-answer answer">
        	<p>Các thành viên cũ (đăng ký trước ngày 22/10) thì vẫn được giữ nguyên hạng thành viên và doanh số tích lũy trước đó. </p>
        	<p>- Trường hợp bạn là Thành viên Vàng, bạn vẫn được giữ nguyên hạng thành viên, tỉ lệ tích lũy 2% và được áp dụng ngay chính sách mới từ ngày 23/10.</p>
            <p>- Trường hợp bạn là Thành viên Kim Cương, bạn được giữ nguyên hạng thành viên, tỉ lệ tích lũy 5% cho đến ngày 31/12/2013 và được áp dụng chính sách mới từ ngày 1/1/2014.</p>
            <p><strong>Ví dụ:</strong></p>
            <p>Tôi là Thành viên Kim Cương của <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> từ ngày 1/10.</p>
        <p>+ Ngày 5/11, tôi mua <a href="{$conf.rooturl}tivi/led-sony-kdl-32ex650">TV Led Sony</a> 32 giá 8,399,000 đồng. </p>
        <p>Doanh số tích lũy của tôi là 35,000,000 + 8,399,000 = 43,399,000đ </p>
        <p>Điểm tích lũy của tôi cho đơn hàng này là 8,399,000  x 5% = 419,950đ</p>
        <p>+ Ngày 1/1/2014, doanh thu tích lũy của tôi là 43,399,000đ (dưới 50 triệu đồng), tôi trở thành Thành viên Vàng.</p>
        <p>+ Ngày 1/1/2014, tôi mua <a href="{$conf.rooturl}dien-thoai-di-dong/nokia-lumia-520">Nokia Lumia 520</a> giá 3,490,000đ.</p>
        <p>Doanh số tích lũy của tôi là 43,399,000 + 3,490,000 = 46,889,000đ </p>
        <p>Điểm tích lũy của tôi cho đơn hàng này là 3,490,000  x 2% = 69,800đ</p>
		</div>    
    </div>
    <div class="list-ques">
    	<div class="question-sent">
    		<a class="question" href="#"><em>16. Doanh số tích lũy của tôi sẽ được cập nhật khi nào?</em></a>
    	</div>
        <div class="sub-answer answer">
        	<p>Sau khi hoàn tất đơn hàng (<span style="color:#00adf2; font-weight:bold;">dienmay.com</span> đã giao hàng & nhận thanh toán từ khách hàng), doanh số và điểm tích lũy (đối với Thành viên Kim Cương) hoặc điểm tích lũy dự kiến (đối với Thành viên Vàng) sẽ được cập nhật ngay vào tài khoản khách hàng đã đăng ký.</p>
		</div>    
    </div>
    <div class="list-ques">
    	<div class="question-sent">
    		<a class="question" href="#"><em>17. Làm thế nào để kiểm tra tôi tích lũy được bao nhiêu điểm / tiền trong tài khoản</em></a>
    	</div>
        <div class="sub-answer answer">
        	<p>Hiện để kiểm tra điểm tích lũy trong tài khoản, bạn có thể liên hệ tổng đài <span style="color:#00adf2; font-weight:bold;">1900 1883</span> hoặc đến siêu thị để được nhân viên hỗ trợ trực tiếp</p>
		</div>    
    </div>    
    <div class="list-ques">
    	<div class="question-sent">
    		<a class="question" href="#"><em>18. Tôi quên thẻ thành viên khi tới mua sắm tại <span style="color:#00adf2; font-weight:bold;">dienmay.com</span>, làm thế nào để tích lũy điểm </em></a>
    	</div>
        <div class="sub-answer answer">
        	<p>Khi bạn đến siêu thị mua hàng mà quên mang theo Thẻ thành viên, để được tích lũy điểm khi mua hàng, bạn chỉ cần đọc số điện thoại đã đăng ký làm thẻ cho nhân viên thu ngân để được tích lũy doanh số/điểm vào thẻ của mình.</p>
            <p>Lưu ý: bạn phải đọc đúng số điện thoại tương ứng với mã thẻ thành viên của bạn.</p>
		</div>    
    </div>
    <div class="list-ques">
        <div class="question-sent">
            <a class="question" href="#"><em>19. Tôi quên thẻ thành viên khi tới mua sắm tại <span style="color:#00adf2; font-weight:bold;">dienmay.com</span>, tôi có thể sử dụng điểm tích lũy để đổi quà, giảm tiền, mua hàng không?</em></a>
        </div>
        <div class="sub-answer answer">
            <p>Thành viên dienmay.com vui lòng mang theo thẻ khi sử dụng điểm tích lũy để đổi quà, giảm tiền, mua hàng. Nhằm đảm bảo quyền lợi cho khách hàng, trong trường hợp không mang theo thẻ thì không được sử dụng điểm tích lũy.</p>
        </div>    
    </div>
    <div class="list-ques">
        <div class="question-sent">
            <a class="question" href="#"><em>20. Khi thanh toán tôi quên đưa thẻ thì như thế nào?</em></a>
        </div>
        <div class="sub-answer answer">
            <p>Thành viên <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> vui lòng đưa thẻ cho nhân viên thu ngân trước khi thanh toán. Trong trường hợp sau khi đã thanh toán xong mới xuất trình thẻ thì không được hưởng ưu đãi của thẻ.</p>
        </div>    
    </div>
    <div class="list-ques">
        <div class="question-sent">
            <a class="question" href="#"><em>21. Đơn hàng trả góp có được hưởng ưu đãi khi dùng thẻ không?</em></a>
        </div>
        <div class="sub-answer answer">
            <p>Đơn hàng trả góp vẫn được hưởng ưu đãi thẻ thành viên như đơn hàng thông thường. Doanh số và điểm tích lũy (đối với Thành viên Kim Cương) hoặc điểm tích lũy dự kiến (đối với Thành viên Vàng) sẽ được cập nhật vào tài khoản khách hàng đã đăng ký ngay khi đơn hàng trả góp được duyệt.</p>
        </div>    
    </div>
    <div class="list-ques">
        <div class="question-sent">
            <a class="question" href="#"><em>22. Các khuyến mãi hiện đang áp dụng có được hưởng ưu đãi khi dùng thẻ không?</em></a>
        </div>
        <div class="sub-answer answer">
            <p>Ưu đãi thẻ thành viên áp dụng song song với TẤT CẢ các khuyến mãi hiện có tại <span style="color:#00adf2; font-weight:bold;">dienmay.com</span>.</p>
            <p>VD: Tôi đang có điểm số tích lũy là 200,000</p>
            <p>Tôi muốn mua <a href="{$conf.rooturl}tu-lanh/panasonic-nr-bj175snvn">Tủ lạnh Panasonic NR-BJ175SNVN</a> giá niêm yết 5,390,000đ, giá khuyến mãi 4,190,000đ (giảm 1,200,000đ) bằng tất cả điểm số tích lũy</p>            
            <p>Tôi chỉ phải trả 3,990,000đ để mua <a href="{$conf.rooturl}tu-lanh/panasonic-nr-bj175snvn">Tủ lạnh Panasonic NR-BJ175SNVN</a></p>
        </div>    
    </div>
    <div class="list-ques">
        <div class="question-sent">
            <a class="question" href="#"><em>23. Trường hợp đổi trả hàng mua tại <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> (không tính phí), điểm trên thẻ sẽ thay đổi như thế nào & nếu điểm đó tôi đã sử dụng để mua hàng thì như thế nào?</em></a>
        </div>
        <div class="sub-answer answer">
            <p>Nguyên tắc chung cho các trường hợp đổi trả hàng: Đã cộng thêm hoặc trừ bao nhiêu điểm từ giao dịch đó thì khi trả hàng lại sẽ trừ đi/ cộng ngược lại điểm số mà hệ thống ghi nhận</p>
            <p>VD: Tôi đang có 12 triệu doanh số tích lũy, 200,000 điểm tích lũy từ việc mua <a href="{$conf.rooturl}laptop/asus-k55a-53212g50">Laptop Asus K55A</a>, tôi dùng tất cả điểm số này mua điện thoại trị giá 200,000đ.</p>
            <p>Nếu tôi muốn trả lại Laptop đã mua đúng theo chính sách đổi trả của <span style="color:#00adf2; font-weight:bold;">dienmay.com</span>.</p>
            <p>Cách 1: tôi được hoàn lại tiền 12 triệu, doanh số tích lũy giảm tương ứng với giá laptop, tôi trả lại điện thoại đã mua từ điểm số này (điện thoại chưa sử dụng)</p>
            <p>Cách 2: tôi được hoàn lại tiền 12,000,000 - 200,000 = 11,800,000 và doanh số tích lũy giảm tương ứng với giá laptop.</p>
        </div>    
    </div>
    <div class="list-ques">
        <div class="question-sent">
            <a class="question" href="#"><em>24. Trường hợp đổi trả hàng mua tại <span style="color:#00adf2; font-weight:bold;">dienmay.com</span>, có tính phí, điểm trên thẻ sẽ thay đổi như thế nào?</em></a>
        </div>
        <div class="sub-answer answer">
            <p>Tôi đang có 12 triệu doanh số tích lũy và 200,000 điểm tích lũy từ việc mua <a href="{$conf.rooturl}laptop/asus-k55a-53212g50">Laptop Asus K55A</a>. Nếu tôi muốn trả lại Laptop đã mua đúng theo chính sách đổi trả của <span style="color:#00adf2; font-weight:bold;">dienmay.com</span>, bị trừ phí 12% giá trị sản phẩm.</p>            
			<p>Tôi được hoàn lại tiền 12,000,000 - (12,000,000 x 12%) = 10,560,000 và doanh số tích lũy giảm tương ứng 12,000,000đ.</p>
			<p>Điểm tích lũy của tôi bị trừ tương ứng là 200,000đ</p>
			
        </div>    
    </div>
    <div class="list-ques">
        <div class="question-sent">
            <a class="question" href="#"><em>25. Trường hợp đổi trả hàng mua bằng điểm tại <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> (không tính phí), điểm trên thẻ sẽ thay đổi như thế nào?</em></a>
        </div>
        <div class="sub-answer answer">
            <p>Tôi đang có 12 triệu doanh số tích lũy và 200,000 điểm tích lũy từ việc mua <a href="{$conf.rooturl}laptop/asus-k55a-53212g50">Laptop Asus K55A</a>, tôi dùng tất cả điểm số này mua điện thoại trị giá 200,000đ.</p>
            <p>Nếu tôi muốn trả lại điện thoại trị giá 200,000đ đã mua đúng theo chính sách đổi trả của <span style="color:#00adf2; font-weight:bold;">dienmay.com</span>.</p>
            <p>Doanh số tích lũy của tôi không đổi, điểm tích lũy của tôi được cộng lại 200,000đ.</p>            
        </div>    
    </div>
    <div class="list-ques">
        <div class="question-sent">
            <a class="question" href="#"><em>26. Trường hợp đổi trả hàng mua bằng điểm tại <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> (có tính phí), điểm trên thẻ sẽ thay đổi như thế nào? </em></a>
        </div>
        <div class="sub-answer answer">
            <p>Tôi đang có 12 triệu doanh số tích lũy và 200,000 điểm tích lũy từ việc mua <a href="{$conf.rooturl}laptop/asus-k55a-53212g50">Laptop Asus K55A</a>, tôi dùng tất cả điểm số này mua điện thoại trị giá 200,000đ.</p>
            <p>Nếu tôi muốn trả lại điện thoại trị giá 200,000đ đã mua đúng theo chính sách đổi trả của <span style="color:#00adf2; font-weight:bold;">dienmay.com</span>, bị trừ phí đổi trả 12%</p>
            <p>Doanh số tích lũy của tôi không đổi</p>            
			<p>Điểm tích lũy của tôi được cộng lại là 200,000 – (200,000 x 12%) = 176,000đ.</p>
        </div>    
    </div>
    <div class="list-ques">
        <div class="question-sent">
            <a class="question" href="#"><em>27. Sau một thời gian không mua hàng, điểm số của tôi có được duy trì không? </em></a>
        </div>
        <div class="sub-answer answer">
            <p>Nếu sau 12 tháng kể từ ngày giao dịch cuối cùng mà không có giao dịch mới tại <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> thì điểm số tích lũy, doanh số tích lũy bằng 0 và quyền lợi của chủ thẻ sẽ hết hiệu lực.</p>
            <p>Lưu ý: giao dịch thu cước, thẻ cào, sim số vẫn được áp dụng để duy trì quyền lợi của chủ thẻ.</p>            
            <p><strong>Ví dụ:</strong></p>
            <p>Ngày 15/5/2013: khách hàng đăng ký thành viên</p>                   
			<p>Ngày 15/9/2013: khách hàng mua hàng và tích lũy điểm</p>
			<p>Nếu từ 15/9/2013 đến 15/9/2014, khách hàng không có bất cứ giao dịch nào với dienmay.com thì điểm số tích lũy và doanh số tích lũy bằng 0đ.</p>
        </div>    
    </div> 
    <div class="list-ques">
        <div class="question-sent">
            <a class="question" href="#"><em>28. Nếu tôi đăng ký thẻ tại 1 siêu thị điện máy <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> và dùng thẻ để mua sắm tại những siêu thị điện máy <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> khác thì có được không và có được tích lũy điểm không?</em></a>
        </div>
        <div class="sub-answer answer">
            <p>Hoàn toàn được, thẻ ưu đãi có giá trị sử dụng trong toàn hệ thống <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> nên quý khách hàng yên tâm khi mua sắm tại bất kỳ siêu thị <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> nào mà được hưởng ưu đãi và tích lũy điểm.</p>            
        </div>    
    </div>     
    <div class="list-ques">
        <div class="question-sent">
            <h3 class="titleques">CÁC HỖ TRỢ KHÁC</h3>
            <a class="question" href="#"><em>29. Tôi cần hỗ trợ về thẻ thành viên ngoài những thắc mắc bên trên</em></a>
        </div>
        <div class="sub-answer answer">
            <p>Để được hỗ trợ cụ thể các vấn đề liên quan đến thẻ thành viên, hoặc quyền lợi thể thành viên, bạn có thể trực tiếp liên hệ tổng đài 1900-1883 để tổng đài viên trả lời trực tiếp thắc mắc của bạn; hoặc bạn liên hệ với <span style="color:#00adf2; font-weight:bold;">dienmay.com</span> qua các kênh thông tin</p>
            <p>&#8226; fanpage: <a href="https://www.facebook.com/dienmaycom">www.facebook.com/dienmaycom</a><br />
&#8226; G+: <a href="https://plus.google.com/+dienmay/">www.google.com/+dienmay</a>
</p>
        </div>    
    </div>

</div>

 {if !empty($listbanner)}
 <div class="vip-ads">
 	<ul>
    	{foreach item=banner from=$listbanner}
    	<li><a href="{$banner->getAdsPath()}" title="{$banner->title}"> <img src="{$banner->getImage()}" align="{$banner->name}" width="320" /> </a>       </li>
    	{/foreach}
    </ul>
 </div>
 {/if}
<div class="vip-footer">
	 <div class="col-f-1"> 
        	<ul>
            	<p class="f-title"> Cam kết tận tâm </p>
                <li><i class="icon-tag"></i> Sản phẩm chính hãng chất lượng</li>
                <li><i class="icon-car"></i> 50 km giao hàng miễn phí</li>
                <li><i class="icon-cal"></i>10 ngày Đổi trả miễn phí</li>
            </ul>
    </div>
    
    <div class="col-f-2"> 
        	<ul>
            	<p class="f-title"> Hỗ trợ khách hàng </p>
                <li><i class="arrow2"></i><a href="https://ecommerce.kubil.app/huong-dan-mua-online" title="Hướng dẫn mua online">Hướng dẫn mua online</a></li>
	            <li><i class="arrow2"></i><a href="https://ecommerce.kubil.app/huong-dan-mua-tra-gop-tai-dienmaycom" title="Hướng dẫn mua trả góp">Hướng dẫn mua trả góp</a></li>
	            <li><i class="arrow2"></i><a href="https://ecommerce.kubil.app/bao-hanh-doi-tra" title="Bảo hành, đổi trả">Bảo hành, đổi trả</a></li>
	            <li><i class="arrow2"></i><a href="https://ecommerce.kubil.app/danh-cho-doanh-nghiep" title="Dành cho doanh nghiệp">Dành cho doanh nghiệp</a></li>
	            <li><i class="arrow2"></i><a href="https://ecommerce.kubil.app/thanh-vien-vip" title="Thành viên VIP">Thành viên VIP</a></li>
	            <li><i class="arrow2"></i><a href="https://ecommerce.kubil.app/chinh-sach-giao-hang-lap-dat-50-km" title="Chính sách giao hàng">Chính sách giao hàng</a></li>
        
            </ul>
    </div>
    
    <div class="col-f-3"> 
        	<ul>
            	<p class="f-title"> Thông tin công ty </p>                
	            <li><i class="arrow2"></i><a href="https://ecommerce.kubil.app/gioi-thieu-ve-dienmaycom" title="Giới thiệu về dienmay.com">Giới thiệu về dienmay.com</a></li>
	            <li><i class="arrow2"></i><a href="https://ecommerce.kubil.app/tuyendung" title="Tuyển dụng">Tuyển dụng</a></li>
                <li> <a href="https://www.facebook.com/dienmaycom" target="_blank"><i class="icon-face"></i></a> <a href="https://www.google.com/+dienmay" target="_blank"><i class="icon-gl-plus"></i></a></li>
                
            </ul>
    </div>
    <div class="col-f-4"> 
        	<ul>
            	<p class="f-title"> Tổng đài trợ giúp </p>
                <li><i class="icon-phone"></i> <span class="hotline">1900 1883 <br />
(08) 39 48 6789 </span></li>
                <li><i class="icon-email"></i> <span class="email">cskh@dienmay.com</span></li>
                               
            </ul>
    </div>
</div>

</div>
<script type="text/javascript">
    var rooturl = "{$conf.rooturl}";
    var imageDir = "{$imageDir}";
    var rootindexgiare = rooturl+'giare/indexajax';
    var rootresult = rooturl+'giare/showresult';
</script>
<script src="{$currentTemplate}/js/jquery.js"></script>
<script  type="text/javascript" src="{$currentTemplate}/min/?g=js&ver={$setting.site.jsversion}"></script>
<script type="text/javascript" src="{$currentTemplate}js/site/vip.js"></script>
</body>
</html>
