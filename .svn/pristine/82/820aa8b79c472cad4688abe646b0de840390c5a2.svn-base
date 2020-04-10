<?php
class StrLib
{
	//According to the $filesize, converts numeric statement of filesize in Bytes to kB or MB
	public static function convert_filesize($filesize) {
		if (!is_int($filesize)) return FALSE;
		if ($filesize > 1048576) return round($filesize / 1048576, 2) . " MB";
		if ($filesize > 1024) return round($filesize / 1024, 2) . " kB";
		return $filesize . " B";
	}

	//Converts string url from charset UTF-8 to format suitable cool URLs
	public static function seo_url($url) {
		$url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
		$url = trim($url, "-");
		$tbl = array("\xc3\xa1"=>"a","\xc3\xa4"=>"a","\xc4\x8d"=>"c","\xc4\x8f"=>"d","\xc3\xa9"=>"e","\xc4\x9b"=>"e","\xc3\xad"=>"i","\xc4\xbe"=>"l","\xc4\xba"=>"l","\xc5\x88"=>"n","\xc3\xb3"=>"o","\xc3\xb6"=>"o","\xc5\x91"=>"o","\xc3\xb4"=>"o","\xc5\x99"=>"r","\xc5\x95"=>"r","\xc5\xa1"=>"s","\xc5\xa5"=>"t","\xc3\xba"=>"u","\xc5\xaf"=>"u","\xc3\xbc"=>"u","\xc5\xb1"=>"u","\xc3\xbd"=>"y","\xc5\xbe"=>"z","\xc3\x81"=>"A","\xc3\x84"=>"A","\xc4\x8c"=>"C","\xc4\x8e"=>"D","\xc3\x89"=>"E","\xc4\x9a"=>"E","\xc3\x8d"=>"I","\xc4\xbd"=>"L","\xc4\xb9"=>"L","\xc5\x87"=>"N","\xc3\x93"=>"O","\xc3\x96"=>"O","\xc5\x90"=>"O","\xc3\x94"=>"O","\xc5\x98"=>"R","\xc5\x94"=>"R","\xc5\xa0"=>"S","\xc5\xa4"=>"T","\xc3\x9a"=>"U","\xc5\xae"=>"U","\xc3\x9c"=>"U","\xc5\xb0"=>"U","\xc3\x9d"=>"Y","\xc5\xbd"=>"Z");
		$url = strtr($url, $tbl);
		$url = strtolower($url);
		return preg_replace('~[^-a-z0-9_]+~', '', $url);
	}
	
	//Converts chars to entities
	public static function to_entities($s, $all = FALSE) {
		$s = htmlentities($s);
		if ($all) return $s;
		return self::unhtmlentities($s);
	}

	//Converts entities to chars
	public static function unhtmlentities($s, $all = FALSE) {
		if ($all) {
			$trans_tbl = get_html_translation_table(HTML_ENTITIES);
			$trans_tbl = array_flip($trans_tbl);
		}
		else $trans_tbl = array("&Aacute;" => "Á","&Egrave;" => "Č","&Eacute;" => "É","&Igrave;" => "Ě","&Iuml;" => "Ď","&Ograve;" => "Ň","&Oacute;" => "Ó","&Oslash;" => "Ř","&Ugrave;" => "Ů","&Uacute;" => "Ú","&Yacute;" => "Ý","&aacute;" => "á","&egrave;" => "č","&eacute;" => "é","&igrave;" => "ě","&iacute;" => "í","&iuml;" => "ď","&ograve;" => "ň","&oacute;" => "ó","&oslash;" => "ř","&ugrave;" => "ů","&uacute;" => "ú","&yacute;" => "ý","&scaron;" => "š");
		return strtr($s, $trans_tbl);
	}

	//Converts date a time or date only from format YYYY-MM-DD HH:MM:SS to format DD.MM.YYYY, HH:MM:SS, or from YYYY-MM-DD to DD.MM.YYYY
	//If inserted string doesn't match neither of two possible formats, returns FALSE
	public static function convert_datetime($s) {
		if (preg_match("/^((?:19|20)[0-9]{2})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/", $s)) return preg_replace("/^((?:19|20)[0-9]{2})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/", "\\3.\\2.\\1", $s);
		if (preg_match("/^((?:19|20)[0-9]{2})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01]) ((?:[01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9])$/", $s)) return preg_replace("/^((?:19|20)[0-9]{2})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01]) ((?:[01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9])$/", "\\3.\\2.\\1, \\4", $s);
	}

	//Detects encoding of given string
	public static function detect_charset($s) {
		//detect UTF-8
		if (preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $s)) return "UTF-8";
		//detect WINDOWS-1250
		if (preg_match('#[\x7F-\x9F]#', $s)) return "WINDOWS-1250";
		//detect Unicode
		if (preg_match('#^\xFF\xFE#', $s)) return "Unicode";
		//assume ISO-8859-2
		return "ISO-8859-2";
	}

	//Converts string to UTF-8
	public static function toUTF8($s) {
		//detect UTF-8
		if (preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $s)) return $s;
		//detect WINDOWS-1250
		if (preg_match('#[\x7F-\x9F]#', $s)) return strtr($s, array("\x80"=>"\xe2\x82\xac","\x81"=>"","\x82"=>"\xe2\x80\x9a","\x83"=>"","\x84"=>"\xe2\x80\x9e","\x85"=>"\xe2\x80\xa6","\x86"=>"\xe2\x80\xa0","\x87"=>"\xe2\x80\xa1","\x88"=>"","\x89"=>"\xe2\x80\xb0","\x8a"=>"\xc5\xa0","\x8b"=>"\xe2\x80\xb9","\x8c"=>"\xc5\x9a","\x8d"=>"\xc5\xa4","\x8e"=>"\xc5\xbd","\x8f"=>"\xc5\xb9","\x90"=>"","\x91"=>"\xe2\x80\x98","\x92"=>"\xe2\x80\x99","\x93"=>"\xe2\x80\x9c","\x94"=>"\xe2\x80\x9d","\x95"=>"\xe2\x80\xa2","\x96"=>"\xe2\x80\x93","\x97"=>"\xe2\x80\x94","\x98"=>"","\x99"=>"\xe2\x84\xa2","\x9a"=>"\xc5\xa1","\x9b"=>"\xe2\x80\xba","\x9c"=>"\xc5\x9b","\x9d"=>"\xc5\xa5","\x9e"=>"\xc5\xbe","\x9f"=>"\xc5\xba","\xa0"=>"\xc2\xa0","\xa1"=>"\xcb\x87","\xa2"=>"\xcb\x98","\xa3"=>"\xc5\x81","\xa4"=>"\xc2\xa4","\xa5"=>"\xc4\x84","\xa6"=>"\xc2\xa6","\xa7"=>"\xc2\xa7","\xa8"=>"\xc2\xa8","\xa9"=>"\xc2\xa9","\xaa"=>"\xc5\x9e","\xab"=>"\xc2\xab","\xac"=>"\xc2\xac","\xad"=>"\xc2\xad","\xae"=>"\xc2\xae","\xaf"=>"\xc5\xbb","\xb0"=>"\xc2\xb0","\xb1"=>"\xc2\xb1","\xb2"=>"\xcb\x9b","\xb3"=>"\xc5\x82","\xb4"=>"\xc2\xb4","\xb5"=>"\xc2\xb5","\xb6"=>"\xc2\xb6","\xb7"=>"\xc2\xb7","\xb8"=>"\xc2\xb8","\xb9"=>"\xc4\x85","\xba"=>"\xc5\x9f","\xbb"=>"\xc2\xbb","\xbc"=>"\xc4\xbd","\xbd"=>"\xcb\x9d","\xbe"=>"\xc4\xbe","\xbf"=>"\xc5\xbc","\xc0"=>"\xc5\x94","\xc1"=>"\xc3\x81","\xc2"=>"\xc3\x82","\xc3"=>"\xc4\x82","\xc4"=>"\xc3\x84","\xc5"=>"\xc4\xb9","\xc6"=>"\xc4\x86","\xc7"=>"\xc3\x87","\xc8"=>"\xc4\x8c","\xc9"=>"\xc3\x89","\xca"=>"\xc4\x98","\xcb"=>"\xc3\x8b","\xcc"=>"\xc4\x9a","\xcd"=>"\xc3\x8d","\xce"=>"\xc3\x8e","\xcf"=>"\xc4\x8e","\xd0"=>"\xc4\x90","\xd1"=>"\xc5\x83","\xd2"=>"\xc5\x87","\xd3"=>"\xc3\x93","\xd4"=>"\xc3\x94","\xd5"=>"\xc5\x90","\xd6"=>"\xc3\x96","\xd7"=>"\xc3\x97","\xd8"=>"\xc5\x98","\xd9"=>"\xc5\xae","\xda"=>"\xc3\x9a","\xdb"=>"\xc5\xb0","\xdc"=>"\xc3\x9c","\xdd"=>"\xc3\x9d","\xde"=>"\xc5\xa2","\xdf"=>"\xc3\x9f","\xe0"=>"\xc5\x95","\xe1"=>"\xc3\xa1","\xe2"=>"\xc3\xa2","\xe3"=>"\xc4\x83","\xe4"=>"\xc3\xa4","\xe5"=>"\xc4\xba","\xe6"=>"\xc4\x87","\xe7"=>"\xc3\xa7","\xe8"=>"\xc4\x8d","\xe9"=>"\xc3\xa9","\xea"=>"\xc4\x99","\xeb"=>"\xc3\xab","\xec"=>"\xc4\x9b","\xed"=>"\xc3\xad","\xee"=>"\xc3\xae","\xef"=>"\xc4\x8f","\xf0"=>"\xc4\x91","\xf1"=>"\xc5\x84","\xf2"=>"\xc5\x88","\xf3"=>"\xc3\xb3","\xf4"=>"\xc3\xb4","\xf5"=>"\xc5\x91","\xf6"=>"\xc3\xb6","\xf7"=>"\xc3\xb7","\xf8"=>"\xc5\x99","\xf9"=>"\xc5\xaf","\xfa"=>"\xc3\xba","\xfb"=>"\xc5\xb1","\xfc"=>"\xc3\xbc","\xfd"=>"\xc3\xbd","\xfe"=>"\xc5\xa3","\xff"=>"\xcb\x99"));
		//assume ISO-8859-2
		return strtr($s, array("\x80"=>"\xc2\x80","\x81"=>"\xc2\x81","\x82"=>"\xc2\x82","\x83"=>"\xc2\x83","\x84"=>"\xc2\x84","\x85"=>"\xc2\x85","\x86"=>"\xc2\x86","\x87"=>"\xc2\x87","\x88"=>"\xc2\x88","\x89"=>"\xc2\x89","\x8a"=>"\xc2\x8a","\x8b"=>"\xc2\x8b","\x8c"=>"\xc2\x8c","\x8d"=>"\xc2\x8d","\x8e"=>"\xc2\x8e","\x8f"=>"\xc2\x8f","\x90"=>"\xc2\x90","\x91"=>"\xc2\x91","\x92"=>"\xc2\x92","\x93"=>"\xc2\x93","\x94"=>"\xc2\x94","\x95"=>"\xc2\x95","\x96"=>"\xc2\x96","\x97"=>"\xc2\x97","\x98"=>"\xc2\x98","\x99"=>"\xc2\x99","\x9a"=>"\xc2\x9a","\x9b"=>"\xc2\x9b","\x9c"=>"\xc2\x9c","\x9d"=>"\xc2\x9d","\x9e"=>"\xc2\x9e","\x9f"=>"\xc2\x9f","\xa0"=>"\xc2\xa0","\xa1"=>"\xc4\x84","\xa2"=>"\xcb\x98","\xa3"=>"\xc5\x81","\xa4"=>"\xc2\xa4","\xa5"=>"\xc4\xbd","\xa6"=>"\xc5\x9a","\xa7"=>"\xc2\xa7","\xa8"=>"\xc2\xa8","\xa9"=>"\xc5\xa0","\xaa"=>"\xc5\x9e","\xab"=>"\xc5\xa4","\xac"=>"\xc5\xb9","\xad"=>"\xc2\xad","\xae"=>"\xc5\xbd","\xaf"=>"\xc5\xbb","\xb0"=>"\xc2\xb0","\xb1"=>"\xc4\x85","\xb2"=>"\xcb\x9b","\xb3"=>"\xc5\x82","\xb4"=>"\xc2\xb4","\xb5"=>"\xc4\xbe","\xb6"=>"\xc5\x9b","\xb7"=>"\xcb\x87","\xb8"=>"\xc2\xb8","\xb9"=>"\xc5\xa1","\xba"=>"\xc5\x9f","\xbb"=>"\xc5\xa5","\xbc"=>"\xc5\xba","\xbd"=>"\xcb\x9d","\xbe"=>"\xc5\xbe","\xbf"=>"\xc5\xbc","\xc0"=>"\xc5\x94","\xc1"=>"\xc3\x81","\xc2"=>"\xc3\x82","\xc3"=>"\xc4\x82","\xc4"=>"\xc3\x84","\xc5"=>"\xc4\xb9","\xc6"=>"\xc4\x86","\xc7"=>"\xc3\x87","\xc8"=>"\xc4\x8c","\xc9"=>"\xc3\x89","\xca"=>"\xc4\x98","\xcb"=>"\xc3\x8b","\xcc"=>"\xc4\x9a","\xcd"=>"\xc3\x8d","\xce"=>"\xc3\x8e","\xcf"=>"\xc4\x8e","\xd0"=>"\xc4\x90","\xd1"=>"\xc5\x83","\xd2"=>"\xc5\x87","\xd3"=>"\xc3\x93","\xd4"=>"\xc3\x94","\xd5"=>"\xc5\x90","\xd6"=>"\xc3\x96","\xd7"=>"\xc3\x97","\xd8"=>"\xc5\x98","\xd9"=>"\xc5\xae","\xda"=>"\xc3\x9a","\xdb"=>"\xc5\xb0","\xdc"=>"\xc3\x9c","\xdd"=>"\xc3\x9d","\xde"=>"\xc5\xa2","\xdf"=>"\xc3\x9f","\xe0"=>"\xc5\x95","\xe1"=>"\xc3\xa1","\xe2"=>"\xc3\xa2","\xe3"=>"\xc4\x83","\xe4"=>"\xc3\xa4","\xe5"=>"\xc4\xba","\xe6"=>"\xc4\x87","\xe7"=>"\xc3\xa7","\xe8"=>"\xc4\x8d","\xe9"=>"\xc3\xa9","\xea"=>"\xc4\x99","\xeb"=>"\xc3\xab","\xec"=>"\xc4\x9b","\xed"=>"\xc3\xad","\xee"=>"\xc3\xae","\xef"=>"\xc4\x8f","\xf0"=>"\xc4\x91","\xf1"=>"\xc5\x84","\xf2"=>"\xc5\x88","\xf3"=>"\xc3\xb3","\xf4"=>"\xc3\xb4","\xf5"=>"\xc5\x91","\xf6"=>"\xc3\xb6","\xf7"=>"\xc3\xb7","\xf8"=>"\xc5\x99","\xf9"=>"\xc5\xaf","\xfa"=>"\xc3\xba","\xfb"=>"\xc5\xb1","\xfc"=>"\xc3\xbc","\xfd"=>"\xc3\xbd","\xfe"=>"\xc5\xa3","\xff"=>"\xcb\x99"));
	}

	//Converts string from UTF-8 to Win-1250
	public static function UTF8_to_WIN1250($s) {
		$s = preg_replace('#[^\x00-\x7F\xa0\xa4\xa6-\xa9\xab-\xae\xb0\xb1\xb4-\xb8\xbb\xc1\xc2\xc4\xc7\xc9\xcb\xcd\xce\xd3\xd4\xd6\xd7\xda\xdc\xdd\xdf\xe1\xe2\xe4\xe7\xe9\xeb\xed\xee\xf3\xf4\xf6\xf7\xfa\xfc\xfd\x{102}-\x{107}\x{10c}-\x{111}\x{118}-\x{11b}\x{139}\x{13a}\x{13d}\x{13e}\x{141}-\x{144}\x{147}\x{148}\x{150}\x{151}\x{154}\x{155}\x{158}-\x{15b}\x{15e}-\x{165}\x{16e}-\x{171}\x{179}-\x{17e}\x{2c7}\x{2d8}\x{2d9}\x{2db}\x{2dd}\x{2013}\x{2014}\x{2018}-\x{201a}\x{201c}-\x{201e}\x{2020}-\x{2022}\x{2026}\x{2030}\x{2039}\x{203a}\x{20ac}\x{2122}]#u', '', $s);
		return strtr($s, array("\xe2\x82\xac"=>"\x80","\xe2\x80\x9a"=>"\x82","\xe2\x80\x9e"=>"\x84","\xe2\x80\xa6"=>"\x85","\xe2\x80\xa0"=>"\x86","\xe2\x80\xa1"=>"\x87","\xe2\x80\xb0"=>"\x89","\xc5\xa0"=>"\x8a","\xe2\x80\xb9"=>"\x8b","\xc5\x9a"=>"\x8c","\xc5\xa4"=>"\x8d","\xc5\xbd"=>"\x8e","\xc5\xb9"=>"\x8f","\xe2\x80\x98"=>"\x91","\xe2\x80\x99"=>"\x92","\xe2\x80\x9c"=>"\x93","\xe2\x80\x9d"=>"\x94","\xe2\x80\xa2"=>"\x95","\xe2\x80\x93"=>"\x96","\xe2\x80\x94"=>"\x97","\xe2\x84\xa2"=>"\x99","\xc5\xa1"=>"\x9a","\xe2\x80\xba"=>"\x9b","\xc5\x9b"=>"\x9c","\xc5\xa5"=>"\x9d","\xc5\xbe"=>"\x9e","\xc5\xba"=>"\x9f","\xc2\xa0"=>"\xa0","\xcb\x87"=>"\xa1","\xcb\x98"=>"\xa2","\xc5\x81"=>"\xa3","\xc2\xa4"=>"\xa4","\xc4\x84"=>"\xa5","\xc2\xa6"=>"\xa6","\xc2\xa7"=>"\xa7","\xc2\xa8"=>"\xa8","\xc2\xa9"=>"\xa9","\xc5\x9e"=>"\xaa","\xc2\xab"=>"\xab","\xc2\xac"=>"\xac","\xc2\xad"=>"\xad","\xc2\xae"=>"\xae","\xc5\xbb"=>"\xaf","\xc2\xb0"=>"\xb0","\xc2\xb1"=>"\xb1","\xcb\x9b"=>"\xb2","\xc5\x82"=>"\xb3","\xc2\xb4"=>"\xb4","\xc2\xb5"=>"\xb5","\xc2\xb6"=>"\xb6","\xc2\xb7"=>"\xb7","\xc2\xb8"=>"\xb8","\xc4\x85"=>"\xb9","\xc5\x9f"=>"\xba","\xc2\xbb"=>"\xbb","\xc4\xbd"=>"\xbc","\xcb\x9d"=>"\xbd","\xc4\xbe"=>"\xbe","\xc5\xbc"=>"\xbf","\xc5\x94"=>"\xc0","\xc3\x81"=>"\xc1","\xc3\x82"=>"\xc2","\xc4\x82"=>"\xc3","\xc3\x84"=>"\xc4","\xc4\xb9"=>"\xc5","\xc4\x86"=>"\xc6","\xc3\x87"=>"\xc7","\xc4\x8c"=>"\xc8","\xc3\x89"=>"\xc9","\xc4\x98"=>"\xca","\xc3\x8b"=>"\xcb","\xc4\x9a"=>"\xcc","\xc3\x8d"=>"\xcd","\xc3\x8e"=>"\xce","\xc4\x8e"=>"\xcf","\xc4\x90"=>"\xd0","\xc5\x83"=>"\xd1","\xc5\x87"=>"\xd2","\xc3\x93"=>"\xd3","\xc3\x94"=>"\xd4","\xc5\x90"=>"\xd5","\xc3\x96"=>"\xd6","\xc3\x97"=>"\xd7","\xc5\x98"=>"\xd8","\xc5\xae"=>"\xd9","\xc3\x9a"=>"\xda","\xc5\xb0"=>"\xdb","\xc3\x9c"=>"\xdc","\xc3\x9d"=>"\xdd","\xc5\xa2"=>"\xde","\xc3\x9f"=>"\xdf","\xc5\x95"=>"\xe0","\xc3\xa1"=>"\xe1","\xc3\xa2"=>"\xe2","\xc4\x83"=>"\xe3","\xc3\xa4"=>"\xe4","\xc4\xba"=>"\xe5","\xc4\x87"=>"\xe6","\xc3\xa7"=>"\xe7","\xc4\x8d"=>"\xe8","\xc3\xa9"=>"\xe9","\xc4\x99"=>"\xea","\xc3\xab"=>"\xeb","\xc4\x9b"=>"\xec","\xc3\xad"=>"\xed","\xc3\xae"=>"\xee","\xc4\x8f"=>"\xef","\xc4\x91"=>"\xf0","\xc5\x84"=>"\xf1","\xc5\x88"=>"\xf2","\xc3\xb3"=>"\xf3","\xc3\xb4"=>"\xf4","\xc5\x91"=>"\xf5","\xc3\xb6"=>"\xf6","\xc3\xb7"=>"\xf7","\xc5\x99"=>"\xf8","\xc5\xaf"=>"\xf9","\xc3\xba"=>"\xfa","\xc5\xb1"=>"\xfb","\xc3\xbc"=>"\xfc","\xc3\xbd"=>"\xfd","\xc5\xa3"=>"\xfe","\xcb\x99"=>"\xff"));
	}

	//Converts string from UTF-8 to ISO 8859-2
	public static function UTF8_to_ISO8859($s) {
		$s = preg_replace('#[^\x00-\x7F\xa0\xa4\xa7\xa8\xad\xb0\xb4\xb8\xc1\xc2\xc4\xc7\xc9\xcb\xcd\xce\xd3\xd4\xd6\xd7\xda\xdc\xdd\xdf\xe1\xe2\xe4\xe7\xe9\xeb\xed\xee\xf3\xf4\xf6\xf7\xfa\xfc\xfd\x{102}-\x{107}\x{10c}-\x{111}\x{118}-\x{11b}\x{139}\x{13a}\x{13d}\x{13e}\x{141}-\x{144}\x{147}\x{148}\x{150}\x{151}\x{154}\x{155}\x{158}-\x{15b}\x{15e}-\x{165}\x{16e}-\x{171}\x{179}-\x{17e}\x{2c7}\x{2d8}\x{2d9}\x{2db}\x{2dd}]#u', '', $s);
		return strtr($s, array("\xc2\xa0"=>"\xa0","\xc4\x84"=>"\xa1","\xcb\x98"=>"\xa2","\xc5\x81"=>"\xa3","\xc2\xa4"=>"\xa4","\xc4\xbd"=>"\xa5","\xc5\x9a"=>"\xa6","\xc2\xa7"=>"\xa7","\xc2\xa8"=>"\xa8","\xc5\xa0"=>"\xa9","\xc5\x9e"=>"\xaa","\xc5\xa4"=>"\xab","\xc5\xb9"=>"\xac","\xc2\xad"=>"\xad","\xc5\xbd"=>"\xae","\xc5\xbb"=>"\xaf","\xc2\xb0"=>"\xb0","\xc4\x85"=>"\xb1","\xcb\x9b"=>"\xb2","\xc5\x82"=>"\xb3","\xc2\xb4"=>"\xb4","\xc4\xbe"=>"\xb5","\xc5\x9b"=>"\xb6","\xcb\x87"=>"\xb7","\xc2\xb8"=>"\xb8","\xc5\xa1"=>"\xb9","\xc5\x9f"=>"\xba","\xc5\xa5"=>"\xbb","\xc5\xba"=>"\xbc","\xcb\x9d"=>"\xbd","\xc5\xbe"=>"\xbe","\xc5\xbc"=>"\xbf","\xc5\x94"=>"\xc0","\xc3\x81"=>"\xc1","\xc3\x82"=>"\xc2","\xc4\x82"=>"\xc3","\xc3\x84"=>"\xc4","\xc4\xb9"=>"\xc5","\xc4\x86"=>"\xc6","\xc3\x87"=>"\xc7","\xc4\x8c"=>"\xc8","\xc3\x89"=>"\xc9","\xc4\x98"=>"\xca","\xc3\x8b"=>"\xcb","\xc4\x9a"=>"\xcc","\xc3\x8d"=>"\xcd","\xc3\x8e"=>"\xce","\xc4\x8e"=>"\xcf","\xc4\x90"=>"\xd0","\xc5\x83"=>"\xd1","\xc5\x87"=>"\xd2","\xc3\x93"=>"\xd3","\xc3\x94"=>"\xd4","\xc5\x90"=>"\xd5","\xc3\x96"=>"\xd6","\xc3\x97"=>"\xd7","\xc5\x98"=>"\xd8","\xc5\xae"=>"\xd9","\xc3\x9a"=>"\xda","\xc5\xb0"=>"\xdb","\xc3\x9c"=>"\xdc","\xc3\x9d"=>"\xdd","\xc5\xa2"=>"\xde","\xc3\x9f"=>"\xdf","\xc5\x95"=>"\xe0","\xc3\xa1"=>"\xe1","\xc3\xa2"=>"\xe2","\xc4\x83"=>"\xe3","\xc3\xa4"=>"\xe4","\xc4\xba"=>"\xe5","\xc4\x87"=>"\xe6","\xc3\xa7"=>"\xe7","\xc4\x8d"=>"\xe8","\xc3\xa9"=>"\xe9","\xc4\x99"=>"\xea","\xc3\xab"=>"\xeb","\xc4\x9b"=>"\xec","\xc3\xad"=>"\xed","\xc3\xae"=>"\xee","\xc4\x8f"=>"\xef","\xc4\x91"=>"\xf0","\xc5\x84"=>"\xf1","\xc5\x88"=>"\xf2","\xc3\xb3"=>"\xf3","\xc3\xb4"=>"\xf4","\xc5\x91"=>"\xf5","\xc3\xb6"=>"\xf6","\xc3\xb7"=>"\xf7","\xc5\x99"=>"\xf8","\xc5\xaf"=>"\xf9","\xc3\xba"=>"\xfa","\xc5\xb1"=>"\xfb","\xc3\xbc"=>"\xfc","\xc3\xbd"=>"\xfd","\xc5\xa3"=>"\xfe","\xcb\x99"=>"\xff"));
	} 

	//Returns substring of given string in UTF8 encoding
	public static function UTF8_substr($s, $start, $len) {
		return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $start . '}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $len . '}).*#s', '$1', $s);
	}

	public static function UTF8_strlen($s) {
  	return strlen(utf8_decode($s));
	}

	//Returns substring of given string with keeping XHTML tags
	public static function XHTML_substr($s, $limit, $hellip = FALSE) {
		$len = 0;
		$tags = array();
		for($i=0; $i < strlen($s) && $len < $limit; $i++) {
			switch ($s{$i}) {
		
				case "<":
					$start = $i+1;
					while($i < strlen($s) && $s{$i} != '>' && !ctype_space($s{$i})) {
						$i++;
					}
					$tag = substr($s, $start, $i - $start);
					$in_quote = "";
					while($i < strlen($s) && ($in_quote || $s{$i} != ">")) {
						if (($s{$i} == "\"" || $s{$i} == "'") && !$in_quote) $in_quote = $s{$i};
						elseif ($in_quote == $s{$i}) $in_quote = "";
	          $i++;
					}
					if ($s{$start} == "/") array_shift($tags);
					elseif ($s{$i-1} != "/") array_unshift($tags, $tag);
					break;
				
				case "&":
					$len++;
					while($i < strlen($s) && $s{$i} != ";") {
						$i++;
					}
					break;
				
				default:
					$len++;
					while($i+1 < strlen($s) && ord($s{$i+1}) > 127 && ord($s{$i+1}) < 192) {
						$i++;
					}        
			}
		}
		$s = rtrim(substr($s, 0, $i)) . ($hellip ? "&hellip;" : NULL);
		if ($tags) $s .= "</" . implode("></", $tags) . ">";
		return $s;
	}

	//Returns length of given string without XHTML tags
	public static function XHTML_strlen($s) {
		$s = strip_tags($s);
		$s = self::unhtmlentities($s, TRUE);
  
  	return self::UTF8_strlen($s);
	}

	public static function format_link($link, $http = TRUE) {
		if (preg_match("`^((http|https|ftp)\://)?([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&%\$\-]+)*@)?((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.[a-zA-Z]{2,4})(\:[0-9]+)?(/[^/][a-zA-Z0-9\.\,\?\'\\/\+&%\$#\=~_\-@]*)*$`", $link))
			return preg_replace("`^(?:(?:http|https|ftp)\://)?((?:[a-zA-Z0-9\.\-]+(?:\:[a-zA-Z0-9\.&%\$\-]+)*@)?(?:(?:25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(?:25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(?:25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(?:25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|(?:[a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.[a-zA-Z]{2,4})(?:\:[0-9]+)?(?:/[^/][a-zA-Z0-9\.\,\?\'\\/\+&%\$#\=~_\-@]*)*)$`", ($http ? "http://" : NULL) . "$1", $link);
	}
	
	public static function HexToRgb($s) {
		if (strlen($s) != 6) return FALSE;
		return array(hexdec(substr($s, 0, 2)), hexdec(substr($s, 2, 2)), hexdec(substr($s, -2)));
	}
	
	public static function random_string($len = 5)
	{
    $chars = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charsLen = strlen($chars);
    $r = '';    

    for ($i = 0; $i < $len; $i++)
		{
      $r .= $chars[mt_rand(0, $charsLen - 1)];
    }

    return $r;
	}
}
?>