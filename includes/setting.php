<?php

	/**
	 *
	* Cac setting cho website
	*/

    //format
	//$setting['group']['entry'] = value;
	$setting['site']['varnishserver'] = array();
	$setting['site']['isajaxprice'] = 1;
	$setting['site']['contactEmail'] = '';
	$setting['site']['heading'] = 'Siêu thị điện máy dienmay.com -  Mua bán điện thoại, laptop, tivi, điện lạnh, điện tử, đồ gia dụng, điện máy chính hãng giá rẻ
';
	$setting['site']['defaultPageTitle'] = 'Siêu thị điện máy dienmay.com -  Mua bán điện thoại, laptop, tivi, điện lạnh, điện tử, đồ gia dụng, điện máy chính hãng giá rẻ
';
	$setting['site']['defaultPageKeyword'] = 'mua dien thoai, mua laptop, tivi gia re, may lanh gia re, dien thoai gia re, laptop gia re';
	$setting['site']['defaultPageDescription'] = 'Siêu thị điện máy dienmay.com - Hệ thống siêu thị điện máy chuyên cung cấp các sản phẩm điện thoại, laptop, điện tử, gia dụng, điện máy chính hãng giá rẻ';
	$setting['site']['sessionExcludeController'] = array();	//array chua cac controller se khong cap nhat vao session table (thuong la cac request ajax hang loat)
	$setting['site']['taskurl'] = 'https://ecommerce.kubil.app/_sectask/';	//url toi automatic task
	$setting['site']['websocketurl'] = 'https://ecommerce.kubil.app/';	//end with slash /
	$setting['site']['websocketenable'] = 0;

	$setting['site']['apcUserCacheTimetolive'] = 3600;	//seconds, time to renew user cache data in data store in apc
	$setting['site']['abuseSpamExpired'] = 10;
	$setting['site']['smartyCompileCheck'] = true;	//true if development phase, false when go to live production
	$setting['site']['jsversion'] = '1';	//true if using cache, false if not
	$setting['site']['cssversion'] = '1';	//true if using cache, false if not

	$setting['cache']['enable'] = false;	//true if using cache, false if not
	$setting['cache']['site'] = 'uploads/cache/';	//root directory of cache
	$setting['cache']['bookDetailDir'] = 'uploads/cache/books/';	//root directory of cache
	$setting['cache']['bookDetailExpire'] = 0;	//minutes, the time cache will expired and create new cache file for each book detail
	$setting['cache']['homepageExpire'] = 3;	//minutes, the time cache will expired and create new cache file for homepage
	$setting['cache']['homepageLastActionExpire'] = 1;	//minutes, the time cache for homepage member last action

	$setting['resourcehost']['general'] = 'https://ecommerce.kubil.app/uploads/';
	$setting['resourcehost']['general_https'] = 'https://ecommerce.kubil.app/uploads/';

	$setting['resourcehost']['static'] = 'https://ecommerce.kubil.app/templates/default/';
	$setting['resourcehost']['static_https'] = 'https://ecommerce.kubil.app/templates/default/';

	$setting['resourcehost']['static_1'] = 'https://ecommerce.kubil.app/templates/default/';
	$setting['resourcehost']['static_1_https'] = 'https://ecommerce.kubil.app/templates/default/';

	$setting['resourcehost']['static_1'] = 'https://ecommerce.kubil.app/templates/default/';
	$setting['resourcehost']['static_1_https'] = 'https://ecommerce.kubil.app/templates/default/';

	$setting['apc']['shortDelay'] = 300;	//seconds, thoi gian de expire thong tin friendlist cache, va feed va notification, day la khoang thoi gian ngan, de cac thong tin cache rieng cua tung user co the cap nhat nhanh
	$setting['apc']['onlinestatusTimeout'] = 600;	//thoi gian de danh luu lai user online





	$setting['mail']['usingAmazonses'] = true;	//neu true thi su dung co che send mail cua amazon, ket hop voi amazon api key o setting o duoi de send, neu false thi su dung co che mac dinh de goi mail
	$setting['mail']['dateFormat'] = 'F j, Y, g:i a';
	$setting['mail']['fromName'] = 'Ecommerce';
	$setting['mail']['fromEmail'] = 'noreply@ecommerce.kubil.app';
	$setting['mail']['toName'] = 'ecommerce Webmaster';
	$setting['mail']['toEmail'] = 'admin@ecommerce.kubil.app';
	$setting['amazon']['publickey'] = '';
	$setting['amazon']['privatekey'] = '';

	$setting['avatar']['imageDirectory'] = 'uploads/avatar/';
	$setting['avatar']['imageDirectoryFromResourceHost'] = ''; //tuy thuoc vao cau hinh cua resourcehost ma co chi dinh thu muc hay khong
	$setting['avatar']['imageMaxWidth'] = '640';
	$setting['avatar']['imageMaxHeight'] = '640';
	$setting['avatar']['imageMediumWidth'] = '200';
	$setting['avatar']['imageMediumHeight'] = '200';
	$setting['avatar']['imageThumbWidth'] = '50';
	$setting['avatar']['imageThumbHeight'] = '50';
	$setting['avatar']['imageQuality'] = '95';
	$setting['avatar']['imageMaxSize'] = '5242880';	//unit in Byte

	$setting['payment']['vnd_to_usd_exchange'] = '20000';


	$setting['review']['recordPerPage'] = 20;	//so review load trong 1 page
	$setting['review']['messageMinLength'] = 50;	//so ky tu toi thieu de goi binh luan
	$setting['review']['messageMaxLength'] = 2000;	//so ky tu toi thieu de goi binh luan
	$setting['review']['spamExpired'] = 10;	//so second cach nhau de goi 1 review cua user
	$setting['review']['limitPage'] = 20;	//so page toi da co the select, chong leech review data

	$setting['feed']['eachRequestCount'] = 30;
	$setting['feed']['commentShowPerFeed'] = 3;	//so comment show trong 1 feed, trong truong hop nhieu hon thi se show link ajax de load all comment
	$setting['feed']['commentShowInFeedDetail'] = 7;	//so comment show trong khi xem detail 1 feed


	$setting['status']['messageMinLength'] = 5;	//so ky tu toi thieu de goi status
	$setting['status']['messageMaxLength'] = 10000;	//so ky tu toi da de goi status
	$setting['status']['linkTitleMinLength'] = 5;	//so ky tu toi thieu de goi status link
	$setting['status']['linkTitleMaxLength'] = 250;	//so ky tu toi da de goi status link
	$setting['status']['linkDescriptionMaxLength'] = 500;	//so ky tu toi da de goi status description
	$setting['status']['spamExpired'] = 2;	//so second cach nhau de goi 1 status cua user

	$setting['feedcomment']['messageMinLength'] = 5;	//so ky tu toi thieu de goi feed comment
	$setting['feedcomment']['messageMaxLength'] = 500;	//so ky tu toi da de goi feed comment
	$setting['feedcomment']['spamExpired'] = 10;	//so second cach nhau de goi 1 feed comment cua user
	$setting['feedcomment']['showUserBadge'] = true;	//neu true thi ben canh fullname cua user se xuat hien badge cua user
	$setting['feedcomment']['recordPerPage'] = 20;	//so comment se load neu nhan view more feed comment
	$setting['feedcomment']['ownerEditExpire'] = 5 * 60;	//thoi gian delay de owner cua feed comment co the edit/delete feedcomment cua minh (seconds)

	$setting['feedlike']['spamExpired'] = 10;	//so second cach nhau de goi 1 feed like cua user
	$setting['feedlike']['recordPerPage'] = 10;	//so user se hien thi trong trang xem tat ca feedlike

	$setting['notification']['minShow'] = 5;	//neu set > 0 thi du cho new notification co = 0 thi cung load theo so luong nay
	$setting['notification']['recordPerPage'] = 40;
	$setting['notification']['bottomItemLimit'] = 40;



	$setting['blog']['recordPerPage'] = 10;
	$setting['blog']['sidebarQuantity'] = 2;	//so blog se load tren sidebar trong cac trang
	$setting['blog']['imageDirectory'] = 'uploads/blog/';
	$setting['blog']['imageDirectoryFromResourceHost'] = 'blog/';
	$setting['blog']['imageMaxWidth'] = '600';
	$setting['blog']['imageMaxHeight'] = '600';
	$setting['blog']['imageThumbWidth'] = '260';
	$setting['blog']['imageThumbHeight'] = '260';
	$setting['blog']['imageQuality'] = '95';
	$setting['blog']['imageValidType'] = array('JPG', 'GIF', 'PNG');	//array of extension (in UPPER CASE)
	$setting['blog']['imageMaxFileSize'] = 1024 * 1024;	//filesize in Byte
	$setting['blog']['addspamExpired'] = 15;	//thoi gian delay de them sach vao tu sach cua 1 user
	$setting['blog']['messageMinLength'] = 20; //20 byte
	$setting['blog']['messageMaxLength'] = 409600;	//400kb
	$setting['blog']['spamExpired'] = 30;
	$setting['blogcomment']['recordPerPage'] = 20;	//so review load trong 1 page
	$setting['blogcomment']['messageMinLength'] = 5;	//so ky tu toi thieu de goi binh luan
	$setting['blogcomment']['messageMaxLength'] = 1000;	//so ky tu toi thieu de goi binh luan
	$setting['blogcomment']['spamExpired'] = 10;	//so second cach nhau de goi 1 review cua user

	$setting['news']['imageDirectory'] = 'uploads/news/';
	$setting['news']['imageDirectoryFromResourceHost'] = 'news/';
	$setting['news']['imageMaxWidth'] = '600';
	$setting['news']['imageMaxHeight'] = '600';
	$setting['news']['imageThumbWidth'] = '260';
	$setting['news']['imageThumbHeight'] = '260';
	$setting['news']['imageQuality'] = '95';
	$setting['news']['imageValidType'] = array('JPG', 'GIF', 'PNG');	//array of extension (in UPPER CASE)
	$setting['news']['imageMaxFileSize'] = 1024 * 1024;	//filesize in Byte

	$setting['job']['imageDirectory'] = 'uploads/job/';
	$setting['job']['imageDirectoryFromResourceHost'] = 'job/';
	$setting['job']['imageMaxWidth'] = '600';
	$setting['job']['imageMaxHeight'] = '600';
	$setting['job']['imageThumbWidth'] = '260';
	$setting['job']['imageThumbHeight'] = '260';
	$setting['job']['imageQuality'] = '95';
	$setting['job']['imageValidType'] = array('JPG', 'GIF', 'PNG'); //array of extension (in UPPER CASE)
	$setting['job']['imageMaxFileSize'] = 1024 * 1024; //filesize in Byte

	$setting['jobcv']['imageDirectory'] = 'uploads/jobcv/';
	$setting['jobcv']['imageDirectoryFromResourceHost'] = 'jobcv/';
	$setting['jobcv']['imageValidType'] = array('DOC', 'DOCX', 'PDF', 'ZIP'); //array of extension (in UPPER CASE)
	$setting['jobcv']['imageMaxFileSize'] = 1024 * 1024; //filesize in Byte

    $setting['newscategory']['imageDirectory'] = 'uploads/newscategory/';
	$setting['newscategory']['imageDirectoryFromResourceHost'] = 'newscategory/';
	$setting['newscategory']['imageMaxWidth'] = '600';
	$setting['newscategory']['imageMaxHeight'] = '600';
	$setting['newscategory']['imageThumbWidth'] = '260';
	$setting['newscategory']['imageThumbHeight'] = '260';
	$setting['newscategory']['imageQuality'] = '95';
	$setting['newscategory']['imageValidType'] = array('JPG', 'GIF', 'PNG');	//array of extension (in UPPER CASE)
	$setting['newscategory']['imageMaxFileSize'] = 1024 * 1024;	//filesize in Byte

    $setting['store']['imageDirectory'] = 'uploads/store/';
    $setting['store']['imageDirectoryFromResourceHost'] = 'store/';
    $setting['store']['imageMaxWidth'] = '600';
    $setting['store']['imageMaxHeight'] = '600';
    $setting['store']['imageThumbWidth'] = '260';
    $setting['store']['imageThumbHeight'] = '260';
    $setting['store']['imageQuality'] = '95';
    $setting['store']['imageValidType'] = array('JPG', 'GIF', 'PNG');    //array of extension (in UPPER CASE)
    $setting['store']['imageMaxFileSize'] = 1024 * 1024;    //filesize in Byte

	$setting['vendor']['imageDirectory'] = 'uploads/vendor/';
	$setting['vendor']['imageDirectoryFromResourceHost'] = 'vendor/';
	$setting['vendor']['imageMaxWidth'] = '600';
	$setting['vendor']['imageMaxHeight'] = '600';
	$setting['vendor']['imageThumbWidth'] = '260';
	$setting['vendor']['imageThumbHeight'] = '260';
	$setting['vendor']['imageQuality'] = '95';
	$setting['vendor']['imageValidType'] = array('JPG', 'GIF', 'PNG');	//array of extension (in UPPER CASE)
	$setting['vendor']['imageMaxFileSize'] = 1024 * 1024;	//filesize in Byte

	$setting['productcategory']['imageDirectory'] = 'uploads/productcategory/';
	$setting['productcategory']['imageDirectoryFromResourceHost'] = 'productcategory/';
	$setting['productcategory']['imageMaxWidth'] = '600';
	$setting['productcategory']['imageMaxHeight'] = '600';
	$setting['productcategory']['imageThumbWidth'] = '260';
	$setting['productcategory']['imageThumbHeight'] = '260';
	$setting['productcategory']['imageQuality'] = '95';
	$setting['productcategory']['imageValidType'] = array('JPG', 'GIF', 'PNG');	//array of extension (in UPPER CASE)
	$setting['productcategory']['imageMaxFileSize'] = 1024 * 1024;	//filesize in Byte

	$setting['product']['imageDirectory'] = 'uploads/product/';
	$setting['product']['imageDirectoryFromResourceHost'] = 'product/';
	$setting['product']['imageMaxWidth'] = '600';
	$setting['product']['imageMaxHeight'] = '600';
	$setting['product']['imageThumbWidth'] = '260';
	$setting['product']['imageThumbHeight'] = '260';	
	$setting['product']['imageQuality'] = '95';
	$setting['product']['imageValidType'] = array('JPG', 'GIF', 'PNG', 'JPEG');	//array of extension (in UPPER CASE)
	$setting['product']['imageMaxFileSize'] = 10* 1024 * 1024;	//filesize in Byte
	$setting['product']['fileimportValidType'] = array('CSV');
	$setting['product']['fileimportFileSize'] = 10* 1024 * 1024;
	$setting['product']['allowEdit'] = array(GROUPID_ADMIN,GROUPID_DEVELOPER, GROUPID_EMPLOYEE, GROUPID_PARTNER);
	
	$setting['productmedia']['imageDirectory'] = 'uploads/product/';
	$setting['productmeia']['imageDirectoryFromResourceHost'] = 'product/';
	$setting['productmeia']['imageMaxWidth'] = '800';
	$setting['productmeia']['imageMaxHeight'] = '800';
    $setting['productmeia']['imageMediumWidth'] = '400';
    $setting['productmeia']['imageMediumHeight'] = '400';
	$setting['productmeia']['imageThumbWidth'] = '60';
	$setting['productmeia']['imageThumbHeight'] = '60';
	$setting['productmeia']['imageQuality'] = '95';
	$setting['productmeia']['imageValidType'] = array('JPG', 'GIF', 'PNG', 'JPEG');	//array of extension (in UPPER CASE)
	$setting['productmeia']['imageMaxFileSize'] = 10 * 1024 * 1024;	//filesize in Byte

	 //Crazy deal 
	$setting['crazydeal']['imageDirectory'] = 'uploads/crazydeal/';
	$setting['crazydeal']['imageDirectoryFromResourceHost'] = 'crazydeal/';
	$setting['crazydeal']['imageMaxWidth'] = '1600';
	$setting['crazydeal']['imageMaxHeight'] = '1600';
	$setting['crazydeal']['imageThumbWidth'] = '200';
	$setting['crazydeal']['imageThumbHeight'] = '200';
	$setting['crazydeal']['imageQuality'] = '95';
	$setting['crazydeal']['imageValidType'] = array('JPG', 'GIF', 'PNG'); //array of extension (in UPPER CASE)
	$setting['crazydeal']['imageMaxFileSize'] = 10 * 1024 * 1024; //filesize in Byte

	$setting['stuffcategorys']['imageDirectory'] = 'uploads/stuffcategory/';
	$setting['stuffcategorys']['imageDirectoryFromResourceHost'] = 'stuffcategory/';
	$setting['stuffcategorys']['imageMaxWidth'] = '600';
	$setting['stuffcategorys']['imageMaxHeight'] = '600';
	$setting['stuffcategorys']['imageThumbWidth'] = '260';
	$setting['stuffcategorys']['imageThumbHeight'] = '260';
	$setting['stuffcategorys']['imageQuality'] = '95';
	$setting['stuffcategorys']['imageValidType'] = array('JPG', 'GIF', 'PNG');	//array of extension (in UPPER CASE)
	$setting['stuffcategorys']['imageMaxFileSize'] = 1024 * 1024;	//filesize in Byte	$setting['stuffcategorys']['imageDirectory'] = 'uploads/stuffcategorys/';

	$setting['stuff']['imageDirectory'] = 'uploads/stuff/';
	$setting['stuff']['imageDirectoryFromResourceHost'] = 'stuff/';
	$setting['stuff']['imageMaxWidth'] = '600';
	$setting['stuff']['imageMaxHeight'] = '600';
	$setting['stuff']['imageThumbWidth'] = '260';
	$setting['stuff']['imageThumbHeight'] = '260';
	$setting['stuff']['imageQuality'] = '95';
	$setting['stuff']['imageValidType'] = array('JPG', 'GIF', 'PNG');	//array of extension (in UPPER CASE)
	$setting['stuff']['imageMaxFileSize'] = 1024 * 1024;	//filesize in Byte



	$setting['user']['maxSesionGroupEntry'] = 100;	// so phan tu toi da cho cac lan luu session  thanh vien da xem, chong viec spam page view
	$setting['user']['idleTimeout'] = 300;	// seconds, dung cho tracking user status online. Neu thay user online (co record trong cache), thi neu thoi gian truoc khoang thoi gian idle thi danh dau la idle, con ko thi la apc status con moi, danh dau la ONLINE

	$setting['message']['recordPerPage'] = 10;
	$setting['message']['replyrecordPerPage'] = 30;
	$setting['message']['minlength'] = 5;
	$setting['message']['maxlength'] = 4000;
	$setting['message']['spamExpired'] = 10;
	$setting['message']['emailSendTimecheck'] = 12 * 3600;	//khoang thoi gian (giay) neu user khong active ma nhan duoc message thi se send email toi user nay

	$setting['reviewlike']['spamExpired'] = 10;	//so second cach nhau de goi 1 feed like cua user
	$setting['reviewlike']['recordPerPage'] = 10;	//so user se hien thi trong trang xem tat ca feedlike

	$setting['ads']['imageDirectory'] = 'uploads/asimg/';
	$setting['ads']['imageDirectoryFromResourceHost'] = 'asimg/';
	$setting['ads']['imageMaxWidth'] = '1600';
	$setting['ads']['imageMaxHeight'] = '1600';
	$setting['ads']['imageThumbWidth'] = '200';
	$setting['ads']['imageThumbHeight'] = '200';
	$setting['ads']['imageQuality'] = '95';
	$setting['ads']['imageValidType'] = array('JPG', 'GIF', 'PNG');	//array of extension (in UPPER CASE)
	$setting['ads']['imageMaxFileSize'] = 2 * 1024 * 1024;	//filesize in Byte

	$setting['filecloud']['fileDirectory'] = 'uploads/filecloud/';
	$setting['filecloud']['fileDirectoryFromResourceHost'] = 'filecloud/';
	$setting['filecloud']['fileValidType'] = array('DOC', 'DOCX', 'XLS', 'XLSX', 'PDF', 'ZIP', 'RAR', 'TXT', 'JPG', 'PNG', 'PPT', 'PPTX', 'RTF');	//array of extension (in UPPER CASE)
	$setting['filecloud']['fileMaxFileSize'] = 30 * 1024 * 1024;	//filesize in Byte

	$setting['googleanalytics']['username'] = '';
	$setting['googleanalytics']['password'] = '';
	$setting['googleanalytics']['profileid'] = '';


	$setting['notification']['productchangereceiver'] = array(1, 32, 41, 9759, 9417, 10016, 10180, 10179, 15469, 15468);


    $setting['scrumstorycomment']['imageDirectory'] = 'uploads/scrumstorycomment/';
    $setting['scrumstorycomment']['imageDirectoryFromResourceHost'] = 'scrumstorycomment/';

    $setting['statsd']['enable'] = 0;
    $setting['statsd']['host'] = '';
    $setting['statsd']['port'] = 0;

    
	$setting['region'] = array(
	'82' => 'An Giang',
	'102' => 'Bà Rịa - Vũng Tàu',
	'106' => 'Bắc Ninh',
	'103' => 'Bắc Giang',
	'104' => 'Bắc Kạn',
	'105' => 'Bạc Liêu',
	'107' => 'Bến Tre',
	'109' => 'Bình Dương',
	'108' => 'Bình Định',
	'110' => 'Bình Phước',
	'111' => 'Bình Thuận',
	'161' => 'Bình Trị Thiên',
	'81' => 'Cà Mau',
	'7' => 'Cần Thơ',
	'112' => 'Cao Bằng',
	'162' => 'Cửu Long',
	'9' => 'Đà Nẵng',
	'6' => 'Đắc Lắk',
	'113' => 'Đắc Nông',
	'114' => 'Điện Biên',
	'8' => 'Đồng Nai',
	'115' => 'Đồng Tháp',
	'116' => 'Gia Lai',
	'201' => 'Hà Bắc',
	'121' => 'Hải Dương',
	'117' => 'Hà Giang',
	'118' => 'Hà Nam',
	'159' => 'Hà Nam Ninh',
	'5' => 'Hà Nội',
	'119' => 'Hà Tây',
	'120' => 'Hà Tĩnh',
	'158' => 'Hải Hưng',
	'122' => 'Hậu Giang',
	'101' => 'Hải Phòng',
	'123' => 'Hoà Bình',
	'124' => 'Hưng Yên',
	'125' => 'Khánh Hoà',
	'126' => 'Kiên Giang',
	'157' => 'Khác',
	'127' => 'Kon Tum',
	'128' => 'Lai Châu',
	'130' => 'Lạng Sơn',
	'129' => 'Lâm Đồng',
	'131' => 'Lào Cai',
	'132' => 'Long An',
	'133' => 'Nam Định',
	'134' => 'Nghệ An',
	'160' => 'Nghĩa Bình',
	'135' => 'Ninh Bình',
	'136' => 'Ninh Thuận',
	'137' => 'Phú Thọ',
	'138' => 'Phú Yên',
	'139' => 'Quảng Bình',
	'140' => 'Quảng Nam',
	'141' => 'Quảng Ngãi',
	'142' => 'Quảng Ninh',
	'143' => 'Quảng Trị',
	'144' => 'Sóc Trăng',
	'145' => 'Sơn La',
	'146' => 'Tây Ninh',
	'147' => 'Thái Bình',
	'148' => 'Thái Nguyên',
	'149' => 'Thanh Hoá',
	'150' => 'Thừa Thiên Huế',
	'151' => 'Tiền Giang',
	'3' => 'TP.Hồ Chí Minh',
	'152' => 'Trà Vinh',
	'153' => 'Tuyên Quang',
	'154' => 'Vĩnh Long',
	'155' => 'Vĩnh Phúc',
	'156' => 'Yên Bái'

	);

	$setting['regionDefault'] = 3; //Ho Chi Minh

	$setting['phoneavalible'] = array('099','0199','091','094','0123','0125','0127','0129','0124', '095', '092','0188','0186','097','098','0168','0169','0166','0167','0165','0164','0163','0162','096','0197','0198','090','093','0122','0126','0121','0128','0120');


