<?php
Class Controller_Site_Moigiomotbatngo Extends Controller_Site_Base
{
	public function indexAction()
	{
		header('Location: '. $this->registry['conf']['rooturl'] . 'moi-gio-mot-bat-ngo');
		$countdownDelay = mktime(8, 0, 0, 9,2,2013) - time();
		if($countdownDelay > 0)
		{
			$remainDay = floor($countdownDelay / (3600 * 24));
			$remainHour = floor(($countdownDelay - $remainDay * 24 * 3600) / 3600);
			$remainMinute = floor(($countdownDelay - $remainDay * 24 * 3600 - $remainHour*3600)/60);
			$remainSecond = $countdownDelay - $remainDay * 24 * 3600 - $remainHour * 3600 - $remainMinute * 60;
		}	
		else
		{
			header('location: '.$this->registry->conf['rooturl'].'eventproducthours');
			exit();
		}
		$countdowntime = sprintf('%02d',$remainDay).':'.sprintf('%02d',$remainHour).':'.sprintf('%02d',$remainMinute).':'.sprintf('%02d',$remainSecond);
		$this->registry->smarty->assign(array(
			'discount' =>1,
			'countdowntime' => $countdowntime
		));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'index.tpl');

		$this->registry->smarty->assign(array('contents' => $contents,										
													'pageTitle'                 => '"Mỗi giờ một bất ngờ - Chương trình bán hàng đồng giá 29.000 đ duy nhất vào 2/9 tại dienmay.com',
                                                    'pageKeyword'               => 'khuyến mãi, tin khuyến mãi, dienmay.com',
                                                    'pageDescription'           => 'dienmay.com đang đồng hành cùng cuộc sống học sinh, sinh viên và đem lại những ưu đãi ở các nhu cầu như học hành, kết nối, ăn ở tại ký túc xá, giải trí... với ưu đãi lên đến 2 triệu đồng dành cho bạn - Cho Sinh Viên',
                                                    'pageMetarobots'           => 'index, follow',
		));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');		
	}
}