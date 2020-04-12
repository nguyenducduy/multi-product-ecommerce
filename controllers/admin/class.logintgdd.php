<?php



Class Controller_Admin_LoginTgdd Extends Controller_Admin_Base
{



	function indexAction()
	{


		if($this->registry->me->id > 0)
		{
			//already login, redirect to homepage
			header('location: ' . $this->registry->me->getUserPath() . '/home');
			exit();
		}
		else
		{
			//ini_set('display_errors', 1);
			//echo SITE_PATH . 'libs/phpseclib/';
			//die()

			//set new include path because the url in phpseclib include is in the phpseclib directory
			$oldIncludePath = set_include_path(SITE_PATH . 'libs/phpseclib/');
			require('Crypt/RSA.php');


			//following to f*cking tgdd itteam

			//building the login to redirect to oauth from baocaonoibo insite
			$returnUrl = $this->registry->conf['rooturl_admin'] . 'logintgdd';	//this controller
			$loginUrl = ShitUtil::$SSOLoginUrl . '?continue='.ShitUtil::ToUrlSafe($returnUrl).ShitUtil::GenerateRequestLogin($returnUrl);



			if(empty($_GET['token']) || empty($_GET['sign']))
			{
				//not the request return, just make the request to login from shit sso
				header('location: ' . $loginUrl);
			}
			else
			{
				//this is return from login success page, just check the token and sign
				$token = $_GET['token'];
				$sign = $_GET['sign'];

				//Boi vi token va sign goi tu SSO server da duoc URLSafe
				//Nhung, ham verify thi can thong tin khong safe, nen phai convert sang unsafe
				$token = ShitUtil::FromUrlSafe($token);
				$sign = ShitUtil::FromUrlSafe($sign);


				if(ShitUtil::VerifySSOToken($token, $sign))
				{
					//Login success, redirect to home page
					$strTokenData = explode('#', ShitUtil::DecryptSSOToken($token));
		            if (count($strTokenData) >= 3 && $strTokenData[0] == Helper::getSessionId())
		            {
		                //Wow, everything ok, just do everything you want
						//
						$tokendata['sessionid'] = $strTokenData[0];
						$tokendata['ipaddress'] = $strTokenData[1];
						$tokendata['tgddid'] = $strTokenData[2];
						$tokendata['avatar'] = $strTokenData[3];
						$tokendata['fullname'] = $strTokenData[4];

						//search account for this user is register with Dienmay system
						//get user information
					    $myUser = Core_User::getByOauthId(Core_User::OAUTH_PARTNER_NOIBOTHEGIOIDIDONG, $tokendata['tgddid']);
						if($myUser->id > 0)
					    {
					        $_SESSION['userLogin'] = $myUser->id;

					        $myUser->updateLastLogin();

							//redirect to homepage
							header('location: ' . $myUser->getUserPath() . '/home');
						}
						else
						{
							//dang nhap thanh cong tu he thong baocaonoibo
							//nhung khong tim thay tai khoa tren website
							//tien hanh dang ky tai khoan moi
							$myUser = new Core_User();
							$myUser->groupid = GROUPID_EMPLOYEE;
							$myUser->fullname = $tokendata['fullname'];
							$myUser->setPrivacy(Core_User::PRIVACY_INTERNET);

							$myUser->oauthPartner = Core_User::OAUTH_PARTNER_NOIBOTHEGIOIDIDONG;
							$myUser->oauthUid = $tokendata['tgddid'];
							if($myUser->addData())
							{
								$_SESSION['userLogin'] = $myUser->id;
						        $myUser->updateLastLogin();
								header('location: ' . $myUser->getUserPath() . '/home');

							}
							else
							{
								//Unknown error while login, try again
								header('location: ' . $this->registry->conf['rooturl_admin'] . 'admin');
							}
						}
		            }
					else
					{
						die('Token is invalid');
						//authentication fail, redirect to login from thegioididong insite
						header('location: ' . $loginUrl);
					}
				}
				else
				{
					die('Verify Token Error.');
					//authentication fail, redirect to login from thegioididong insite
					header('location: ' . $loginUrl);
				}
			}

			//rollback to original includepath
			set_include_path($oldIncludePath);
		}
	}

	public function testAction()
	{
		$oldIncludePath = set_include_path(SITE_PATH . 'libs/phpseclib/');
		require('Crypt/RSA.php');

		$encryptedData = 'i7YODSECTSAju7ZCrP8lw0Gindi2cjRriyLj60_dHhHcKr5cAjny4Mv7Iek9uz-5eGmtTMvIKKOAnDGFzYRyDFD2WhvKQyQ43ZslJqG_xFyXPYMcjljnLSvei3KW9-0RhyT9gytOEjVi_cpvpOkv39jCshKtUJw1eoviJuwov44=eQDgxDXMcx9LAoydMHpRn4zg_svJZiBCUl7Z6d1uLcaxmqUdlW4vOW_ytJv7bzkRffHHPp7t5xMajdQilPU3pUerLGbZwCH6fjatZDXgwrwwRtK21oolStqmWDODV43Ft7LRvjNVIeVL1GAHJ1otU2w_XiPKJWGW9xdm3W_97pM=';

		echo ShitUtil::DecryptSSOToken($encryptedData);

	}

	//Ma hoa bang .NET, giai ma bang PHP
	public function test2Action()
	{
		$oldIncludePath = set_include_path(SITE_PATH . 'libs/phpseclib/');
		require('Crypt/RSA.php');

		//test new ciphertext (encrypted from .NET)
		//"hello"
		$ciphertextBase64 = 'WrWlOiHr9Gdw9zZ2GjkEXX6y0RdKCZql4QJA5JnKgFIw8i25fMmYvG7CsJ3xcA2JNZ0NH+L7vJWg+bLxkuj2nqdlUqCUjPSky6YfeDDGuCRCjVwKEflFu2ulqEkSi/r+Dw/5vRuV0mC/CMzTiXBSUWHrb/9feQ9MFo3bgAKbaR0=';
		$ciphertextBase64 = 'Z14iuISxwYl4mNRaXzDNAlsfAGvQsqk4VCHr5+2/r9b99+37/nkklQFYyECGyE4R5GIR5FiEXw/KQvN6W4OZ7UI1D+iYeQ0cwu1WhIj3LB+JI0acjTaeZYn25N+6Oph8ajZU540wdrRFsuTBI/JGl4vmJZfrDYi47TXOFevkB2I=';

		//'1'
		$ciphertextBase64 = 'wIkm8qviHzwqHRZALFFsQqRc+Sq3TAZ0sAdXRTv1OzL2Q4CNKKYscCHFU8FCEkkNH9b3wxQu6FENBIQLM7yoUNkkBgYwf+9sgb6C6jSe+qJxPo1qy1Q9HJ5nfiLfqEnirgQQvtbS4+Gw6NK4zlX9oXa+wtAnp6By7qo2cmRUHGU=';

		$ciphertext = base64_decode($ciphertextBase64);
		echo Helper::hexDump($ciphertext);
		//da test va thay base64 encode/decode (giua PHP va C#) khong co van de trong quy trinh


		//start Description
		$rsa2 = new Crypt_RSA();
		//$rsa2->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);
		$rsa2->loadKey(ShitUtil::$EncryptionPrivateKey, CRYPT_RSA_PRIVATE_FORMAT_XML);
		$plaintext2 = $rsa2->decrypt($ciphertext);
		echo $plaintext2;

	}

	//Ma hoa bang PHP, giai ma bang .NET
	public function test3Action()
	{
		$oldIncludePath = set_include_path(SITE_PATH . 'libs/phpseclib/');
		require('Crypt/RSA.php');

		//start Encryption
		$plaintext = '1';
		$rsa = new Crypt_RSA();
		$rsa->loadKey(ShitUtil::$EncryptionPublicKey);
		$ciphertext = $rsa->encrypt($plaintext);

		echo base64_encode($ciphertext);	//base on http://www.frostjedi.com/phpbb3/viewtopic.php?f=46&t=141187&sid=d43f7b184462fe63e4360adc0c6413b3
		echo "\n\n";
		//exit();
		Helper::hexDump($ciphertext);
	}

	//try to decrypt string from C#
	// OK, everything OK at 10Am, 8/1/2013
	public function test4Action()
	{
		$encryptEncode = 'i7YODSECTSAju7ZCrP8lw0Gindi2cjRriyLj60_dHhHcKr5cAjny4Mv7Iek9uz-5eGmtTMvIKKOAnDGFzYRyDFD2WhvKQyQ43ZslJqG_xFyXPYMcjljnLSvei3KW9-0RhyT9gytOEjVi_cpvpOkv39jCshKtUJw1eoviJuwov44=eQDgxDXMcx9LAoydMHpRn4zg_svJZiBCUl7Z6d1uLcaxmqUdlW4vOW_ytJv7bzkRffHHPp7t5xMajdQilPU3pUerLGbZwCH6fjatZDXgwrwwRtK21oolStqmWDODV43Ft7LRvjNVIeVL1GAHJ1otU2w_XiPKJWGW9xdm3W_97pM=';

		//init RSA object
		$oldIncludePath = set_include_path(SITE_PATH . 'libs/phpseclib/');
		require('Crypt/RSA.php');
		$rsa = new Crypt_RSA();
		$rsa->loadKey(ShitUtil::$EncryptionPrivateKey);	//use our private to decrypt
		$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);

		//we need to explode before decrypt
		$blocks = explode('=', $encryptEncode);
		foreach($blocks as $block)
		{
			if(strlen($block) > 0)
			{
				$block .= '=';

				//un-safe string
				$block = ShitUtil::FromUrlSafe($block);

				//echo $block . "\n\n";

				//base64decode before decrypt
				$blocknoencode = base64_decode($block);

				//reverse the order
				$blocknoencode = strrev($blocknoencode);

				//deccrypt
				$plainblock = $rsa->decrypt($blocknoencode);
			}
		}
	}

	//Try to run encryptString() in PHP, used in generate requestLoginURL, and use C# to decrypt
	//DONE:
	public function test5Action()
	{
		//init RSA object
		$oldIncludePath = set_include_path(SITE_PATH . 'libs/phpseclib/');
		require('Crypt/RSA.php');


		//sample plaintext to encrypt
		$strRequest = 'hello';
		$isRsaReverseString = true;

		//partner Public Key
		$partnerPublicKey = ShitUtil::$SSOPublicKey;

		//TEST: check with my publickey
		$partnerPublicKey = ShitUtil::$EncryptionPublicKey;

		$strEncryptedDataNotUrlSafe = ShitUtil::EncryptString($strRequest, 1024, $partnerPublicKey, $isRsaReverseString);

		echo 'IS REVERSE IN EncryptString() & DecryptString(): ' . ($isRsaReverseString ? 'True' : 'False') . "\n\n";
		echo 'EncryptString(\''.$strRequest.'\') Return:' . "\n" . $strEncryptedDataNotUrlSafe;

		/////////////////////////////////
		/////////////////////////////////
		// decryption simulator in C#
		echo "\n\n=====================================\n" . 'Try to decrypt in PHP with $rsa Object' . "\n\n";
		$partnerPrivateKey = ShitUtil::$EncryptionPrivateKey;

		$plaintext = ShitUtil::DecryptString($strEncryptedDataNotUrlSafe, 1024, $partnerPrivateKey, $isRsaReverseString);
		echo "\nDecryptString('$strEncryptedDataNotUrlSafe') Return:\n" . $plaintext;
	}

	// tu tao sign va tu check verify, everything ok
	public function test6Action()
	{

		//init RSA object
		$oldIncludePath = set_include_path(SITE_PATH . 'libs/phpseclib/');
		require('Crypt/RSA.php');

		$data = '"hello"';

		$rsa = new Crypt_RSA();
		$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);
		$rsa->loadKey(ShitUtil::$EncryptionPrivateKey, CRYPT_RSA_PRIVATE_FORMAT_XML);
        //$rsa->signatureMode = CRYPT_RSA_SIGNATURE_PKCS1;
		//$rsa->setHash('sha1');


		echo "Data to Sign: " . $data . "\n--------------------\n";


		$sign1 = ShitUtil::ToUrlSafeBase64($rsa->sign(sha1($data)));
		echo "\n\nUtil::ToUrlSafeBase64(\$rsa->sign(sha1('$data'))): \$sign1 \n" . $sign1;

		$sign2 = ShitUtil::ToUrlSafeBase64($rsa->sign(sha1($data, true)));
		echo "\n\nUtil::ToUrlSafeBase64(\$rsa->sign(sha1('$data', true))): \$sign2\n" . $sign2;

		$sign3 = ShitUtil::ToUrlSafeBase64($rsa->sign($data));
		echo "\n\nUtil::ToUrlSafeBase64(\$rsa->sign('$data')): \$sign3\n" . $sign3;

		/////////////////////////
		//try to verify in PHP
		echo "\n\n===============================\n\nTRY TO VERIFY MY OWN TOKEN";
		$rsa = new Crypt_RSA();
		$rsa->loadKey(ShitUtil::$EncryptionPublicKey);

		//verify sign1
		echo "\n\nVerify Sign1 : ";
		$sign1 = ShitUtil::FromUrlSafeBase64($sign1);
		$sign1Result = $rsa->verify(sha1($data), $sign1);
		echo ($sign1Result ? 'True' : 'False');

		//verify sign2
		echo "\n\nVerify Sign2 : ";
		$sign2 = ShitUtil::FromUrlSafeBase64($sign2);
		$sign2Result = $rsa->verify(sha1($data, true), $sign2);
		echo ($sign2Result ? 'True' : 'False');


		//verify sign3
		echo "\n\nVerify Sign 3 : ";
		$sign3 = ShitUtil::FromUrlSafeBase64($sign3);
		$sign3Result = $rsa->verify($data, $sign3);
		echo ($sign3Result ? 'True' : 'False');




	}



	public function test7Action()
	{

		//init RSA object
		$oldIncludePath = set_include_path(SITE_PATH . 'libs/phpseclib/');
		require('Crypt/RSA.php');



		$x = 'ipaddress=localhost';

		//Data from SSO site
		$token = 'XdZ7lYYDyC0fBi3a1nGTudxA0aHIDXAklnGbiua2QrGxkU+LF4L6ZPEQZutsQqSV4Hs0E0VDFiEAt31eiezYU6iuFSco83PPlrImns7hIf7ERFeU0ULMUH5u7rY4l/7tdItwcVd5hosUSFgrqT3tgaaN0kQNDBiE7gzrJE3qQgI=';
		$sign = 'O6Plmdoa0kfp2c0MYf5ciT0TaKd9Q3kFkIjEuL9YxZbG2xAeobbU8W5fDB4NAEEoQbegutwAjFea62IEeWflvxW0xnXAhFBkduvH0F1i7LpuzJmCIboSnN9yxZ4XHTIrFnGxTJayOcMuM2X/hRfdQr1vJwMKG449PzOD5jKSfRw=';


		$rsa = new Crypt_RSA();
		$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);
		$rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
		$rsa->loadKey(ShitUtil::$SSOPublicKey);
		if(ShitUtil::VerifySSOToken($token, $sign))
		{
			echo 'Verify OK' . "\n\n";
			$tokenstring = ShitUtil::DecryptSSOToken($token);
			echo $tokenstring . "\n\n";
		}
		else
		{
			echo 'Verify Error';
		}
	}

	public function test8Action()
	{
		//init RSA object
		$oldIncludePath = set_include_path(SITE_PATH . 'libs/phpseclib/');
		require('Crypt/RSA.php');


		$data = 'hello';
		$rsa = new Crypt_RSA();
		$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);
		$rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
		$rsa->loadKey(ShitUtil::$EncryptionPrivateKey);
		$sign = $rsa->sign($data);
		$sign = base64_encode($sign);

		////////////////
		//Try using signature from .NET
		$sign = ShitUtil::FromUrlSafe('JtskD9fIE-nICVOtkK0XSc8nAXFeyYV0prxCscE_lD6t2clP6f5aifT9p7tnyvHoSQ7X_9lLAKAtyRcec6vYqhqTMk-acuR1oqE7__u6T63JFNCtAXojdgnLruwGagvLRvIS-w6JmBYf3lLC934yIHCxU0Jg0O_FUhhFeV-K-6Q=');
		//end .net try
		//////////////////////////////

		echo 'Data to sign: ' . $data . "\n\n";
		echo 'Signature (base64encode): ' . $sign . "\n\n";

		/////////////
		//Try to verify


		$signverify = $sign;
		echo "--------------------\n\nTry to Verify in PHP (In normal way):\n\n";
		$rsa = new Crypt_RSA();
		$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);
		$rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
		$rsa->loadKey(ShitUtil::$EncryptionPublicKey);
		$signverify = base64_decode($signverify);
		if($rsa->verify($data, $signverify))
			echo 'Verified';
		else
			echo 'Invalid';

	}

}

/**
 * Simulate the Util from damnit tgdd
 */
Class ShitUtil
{
	public static $SSOLoginUrl = 'https://insitelogin.dienmay.com/signin/';
	public static $SSOTransferPage = 'http://insitelogin.dienmay.com/';
	public static $EncryptionPublicKey = '<RSAKeyValue><Modulus>ymBDz2kVbXOfpYYhAwU/reBjZE1SJDjsBDArlPy7rfdmMT7LsSJKPZ6dlntLYiq/h+uNFw4sKVW+99E6zIOoDlxmMZI+mCAoKMtxTLIbqz050dqGjUO0CsouCc74fgQLo+ZS6Yrndh6v2y/SGYLeK8Iitbu6Uh8QwzBgtcDGUBc=</Modulus><Exponent>AQAB</Exponent></RSAKeyValue>';
	public static $EncryptionPrivateKey = '<RSAKeyValue><Modulus>ymBDz2kVbXOfpYYhAwU/reBjZE1SJDjsBDArlPy7rfdmMT7LsSJKPZ6dlntLYiq/h+uNFw4sKVW+99E6zIOoDlxmMZI+mCAoKMtxTLIbqz050dqGjUO0CsouCc74fgQLo+ZS6Yrndh6v2y/SGYLeK8Iitbu6Uh8QwzBgtcDGUBc=</Modulus><Exponent>AQAB</Exponent><P>6hFZmZgQyZhA13ij+SCNsXBmbuvwkYO/uN3ZKGSiW7PozcMK0vIMa28nTITeyd+cWeuqNwFaYPsFkT6dYCB6zQ==</P><Q>3Va3Vr6qs92/trBUOYzP8LoCK1/9Cc6KxYE0MSqA3K2MmgQIeLHd4R3b0clViPwtMM7f2m5bXc6ItASfaTe+cw==</Q><DP>LRDOGX5nrQi9Yz79Axg7b7BeaHjQxpOBNEyyZM6LW/CVoBgvW1HzBjROcrMaWe/NoJp5GUIPbqCl/8L4deuK+Q==</DP><DQ>H2Dqzv5q3uMCCdlHp30CAcOtCQ8rpVdFryhZCNtYt3BXLYKC3PGCXibIgh5D5Q6zLWc2rxXUGCFume7J1rXTZw==</DQ><InverseQ>G0frKuhkSdyjyGWUzm8oWugOvKhKiQcNdhbH+mjoDNa8NRMkGzEk7Macb0YB8g7v7tYt7b9sNQJzch5NKRJkXg==</InverseQ><D>JJubSJaasKzcsSV9LT2y0jIn6InwFOtTDkLkb1P0YzjAfKH+WLF6OoFJwmHVNhHDicO7RvNiW6vOGqf3ee1K5dPB0IdZGNk5XvwO7HIMsu8cr45VzHG6FP3hmFtozmrPAxATHZNeFZnSgcFRWZEArWGWb2ejjXwBBXqOX0Zq3Kk=</D></RSAKeyValue>';
	public static $SSOPublicKey = '<RSAKeyValue><Modulus>tki/0rd6zmzMBcnUY/Ey4mPPBlGHhBQeU5g4y4OW5rBX4pC8A/Sva9jTH7K0+zuwdJjdMV6qQkSB6/HKeyl4p6ldhDNRE+SGn+jRN43yEKPqsJXVwbG1MhO17kpqbvfjHWSW0+9rsCAIb592gVN9/2Mm33ucDL106Sfo1VQo2OU=</Modulus><Exponent>AQAB</Exponent></RSAKeyValue>';

	public static function ToUrlSafe($url)
	{
		return str_replace(array('+', '/'), array('-', '_'), $url);
	}

	public static function ToUrlSafeBase64($input)
    {
		return str_replace(array('+', '/'), array('-', '_'), base64_encode($input));
    }

	public static function FromUrlSafeBase64($input)
    {
        return base64_decode(str_replace(array('-', '_'), array('+', '/'), $input));
    }

	public static function FromUrlSafe($input)
    {
        return str_replace(array('-', '_'), array('+', '/'), $input);
    }

	public static function GenerateRequestLogin($strFromUrl)
	{
		global $registry;

		//create the request information
		//$strRequest = Helper::getSessionId().'#'.Helper::getIpAddress().'#' . self::ToUrlSafe($strFromUrl);
		//create the request information
		$strRequest = Helper::getSessionId().'#'.Helper::getIpAddress().'#'.$registry->conf['host'] . '#' . self::ToUrlSafe($strFromUrl);


		//get the encrypt data before send
		$strEncryptionPrivateKey = self::$EncryptionPrivateKey;
        $strSSOPublicKey = self::$SSOPublicKey;

		$strEncryptedDataNotUrlSafe = self::EncryptString($strRequest, 1024, $strSSOPublicKey);
		$strEncryptedData = self::ToUrlSafe($strEncryptedDataNotUrlSafe);
		$strUrlParams = '&req=' . $strEncryptedData;

		$rsa = new Crypt_RSA();
		$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);
		$rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
		$rsa->loadKey($strEncryptionPrivateKey);
		$sign = $rsa->sign($strEncryptedData);

		$strUrlParams .= '&sign=' . self::ToUrlSafeBase64($sign) . '&domain=' . $registry->conf['host'];

        return $strUrlParams;
	}


	public static function VerifySSOToken($strToken, $strSign)
    {
        $token = self::ToUrlSafe($strToken);
        $sign = self::FromUrlSafeBase64($strSign);
        $strSSOPublicKey = self::$SSOPublicKey;

        $rsa = new Crypt_RSA();
		$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);
		$rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
		$rsa->loadKey($strSSOPublicKey, CRYPT_RSA_PUBLIC_FORMAT_XML);

		return $rsa->verify($token, $sign);
    }

	public static function DecryptSSOToken($strToken)
    {
        $strEncryptionPrivateKey = self::$EncryptionPrivateKey;
        return self::DecryptString(self::FromUrlSafe($strToken), 1024, $strEncryptionPrivateKey);
    }


	/**
	 * @param $xmlString: SSO Public Key
	 */
	public static function EncryptString($inputString, $dwKeySize, $xmlString)
    {
		$rsa = new Crypt_RSA();
		$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);
		$rsa->loadKey($xmlString, CRYPT_RSA_PUBLIC_FORMAT_XML);


		$keySize = $dwKeySize / 8;
        $bytes = $inputString;
        // The hash function in use by the .NET RSACryptoServiceProvider here
        // is SHA1
        // int maxLength = ( keySize ) - 2 -
        //              ( 2 * SHA1.Create().ComputeHash( rawBytes ).Length );
        $maxLength = $keySize - 42;
        $dataLength = strlen($bytes);
        $iterations = (int)($dataLength / $maxLength);

		$out = '';
        for ($i = 0; $i <= $iterations; $i++)
        {
			$tempBytesLength = ($dataLength - $maxLength * $i > $maxLength) ? $maxLength : $dataLength - $maxLength * $i;
			$tempBytes = substr($bytes, $maxLength * $i, $tempBytesLength);

			$encryptedBytes = $rsa->encrypt($tempBytes);

			//Reverse the order is CORRECT (testing on C# project)
			$encryptedBytes = strrev($encryptedBytes);

			$out .= base64_encode($encryptedBytes);
        }

        return $out;
    }


	public static function DecryptString($inputString, $dwKeySize, $xmlString)
    {
		$rsa = new Crypt_RSA();
		$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);
		$rsa->loadKey($xmlString);

		//we need to explode before decrypt
		$blocks = explode('=', $inputString);
		$out = '';
		foreach($blocks as $block)
		{
			if(strlen($block) > 0)
			{
				$block .= '=';

				//un-safe string
				$block = ShitUtil::FromUrlSafe($block);

				//echo $block . "\n\n";

				//base64decode before decrypt
				$blocknoencode = base64_decode($block);

				//reverse the order
				$blocknoencode = strrev($blocknoencode);

				//deccrypt
				$plainblock = $rsa->decrypt($blocknoencode);

				$out .= $plainblock;
			}


		}

		return $out;
	}
}


