<?php
/*
:: Filesystem ::

Class for Merlin Web Administration System
version 1.0

Copyright (C) 2007 Xtend Webdesign
All rights reserved
http://www-xtend-studio.com
*/

class FileSystem {
	//Reads selected directory and returns array, where first value is array with directories and second is array with files
	public static function dir_content($dir, $list_d = TRUE, $list_f = TRUE) {
		if (substr($dir, -1) == '/') $dir = substr($dir, 0, -1);
		if (!is_dir($dir)) return FALSE;
		
		$dirs = array();
		$files = array();
	
		$handle = opendir($dir);
		while (false !== ($fn = readdir($handle))) {
			if ($fn == "." || $fn == "..") continue;
		
			if ($list_d && is_dir($dir . '/' . $fn)) $dirs[] = $fn;
			elseif ($list_f && is_file($dir . '/' . $fn)) $files[] = $fn;
  	}
  	closedir($handle);
  
  	return array($dirs, $files);	
	}

	//Returns array with filename, filesize, date of last access, date of last change and date of last change of file properties
	//If file doesn't exist, returns FALSE
	public static function file_info($file) {
		if (!is_file($file)) return FALSE;
	
		$fsize = filesize($file);
		$fsize = StrLib::convert_filesize($fsize);
		return array("filename" => basename($file), "size" => $fsize, "last_access" => date("d.m.Y, H:i:s", fileatime($file)),
		"last_modify" => date("d.m.Y, H:i:s", filemtime($file)), "last_attrib_modify" => date("d.m.Y, H:i:s", filectime($file)));
	}

	//Reads selected folder and returns array with count of files, subfolders and total size of folder
	public static function dir_info($dir) {
		if (substr($dir, -1) == '/') $dir = substr($dir, 0, -1);
		if (!is_dir($dir)) return FALSE;
		
		$dirs = $files = $size = 0;
	
		$handle = opendir($dir);
		while (false !== ($fn = readdir($handle))) {
			if ($fn == "." || $fn == "..") continue;
		
			if (is_file($dir . '/' . $fn)) {
				$files++;
				$size += filesize($dir . '/' . $fn);
			}
		
			elseif (is_dir($dir . '/' . $fn)) {
				$dirs++;
				$subdirs = self::dir_info($dir . '/' . $fn);
				$files += $subdirs[0];
				$dirs += $subdirs[1];
				$size += $subdirs[2];
			}
  	}
  	closedir($handle);
		return array($files, $dirs, $size);
	}

	//Removes dir with whole content
	public static function rmdir($dir) {
		if (!is_dir($dir)) return FALSE;
		if (substr($dir, -1) != '/') $dir .= '/';
		if (!is_dir($dir)) return;
  	$handle = opendir($dir);
  	$r = TRUE;
		while (FALSE !== ($file = readdir($handle))) {
			if ($file == "." || $file == "..") continue; 
			$path = $dir . $file;
			$r = is_dir($path) ? self::rmdir($path) : self::unlink($path);
			if (!$r) break;
		}
	  closedir($handle);
  	return $r && @rmdir($dir);
	}
	
	public static function unlink($path) {
		if (file_exists($path)) {
			for($i = 0; $i < 20; $i++) {
				if (@unlink($path)) return TRUE;
				usleep(100000);
			}
		}
		return FALSE;
	}
	
	public static function dircopy($src, $dst, $chmod = NULL) {
  	if (!is_dir($dst)) mkdir($dst);
  	if ($chmod) {
  		umask(0000);
			chmod($dst, $chmod);
		}
  	if ($curdir = @opendir($src)) {
			while($file = readdir($curdir)) {
      	if ($file == '.' || $file == '..') continue;
				if (is_file("$src\\$file")) {
          if (is_file("$dst\\$file")) self::unlink("$dst\\$file");
					copy("$src\\$file", "$dst\\$file");
					if ($chmod) {
						umask(0000);
						chmod("$dst\\$file", $chmod);
					}
        }
      	elseif (is_dir("$src\\$file")) self::dircopy("$src\\$file", "$dst\\$file", $chmod);
      }
     	closedir($curdir);
     	return TRUE;
    }
    else return FALSE;
	}
}
?>