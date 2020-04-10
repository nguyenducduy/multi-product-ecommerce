<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>PlugoBrowser</title>
	<!-- TinyMCE PopUp -->
	<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<!-- jQuery LIBS -->
	<script type="text/javascript" src="js/jquery.1.7.2.min.js"></script>
	<!-- Plugo Browser CSS -->
	<link media="screen,tv,projection" type="text/css" rel="stylesheet" href="css/plugobrowser.css" />
</head>
<body>
<div id="all">
  <form method="post" action="initSet.php">
    <p>{#plugobrowser_dlg.insert_upload_dir}</p>
    <table>
      <tr>
        <td class="t-right">{#plugobrowser_dlg.upload_dir}:</td>
        <td>
				  <select name="init[upload_dir]">
<?php
$paths = $plugoBrowser->getAccessiblePaths();
foreach($paths as $path => $realPath)
{
?>
            <option value="<?php echo $path; ?>"<?php if ($path == $plugoBrowser->getSettings('upload_dir')) { ?> selected="selected"<?php } ?>><?php echo htmlspecialchars($realPath); ?></option>
<?php
}
?>
				  </select>
				</td>
      </tr>
      <tr>
        <td class="t-right">{#plugobrowser_dlg.timezone}:</td>
        <td>
				  <select name="init[timezone]">
<?php
$selTimezone = explode('|', $plugoBrowser->getSettings('timezone'));
if (!isset($selTimezone[1])) $selTimezone = array('', '');

$timezoneList = CommonLib::getTimezoneList();
$timezoneOptions = array();
foreach($timezoneList as $offset => $citys)
{
  $abs = abs($offset);
  $hours = intval($abs);
  $minutes = $abs - $hours;
  $prefix = '(UTC' . ($offset ? ' ' . ($offset > 0 ? '+' : '-') . $hours . ':' . ($minutes ? 60 * $minutes : '00') : NULL) . ') ';
      
  if (is_array($citys))
  {
    for($i = 0; isset($citys[$i]); $i++)
    {
?>
				    <option rel="<?php echo $offset; ?>" value="<?php echo $citys[$i]; ?>"<?php if ($selTimezone[0] == $citys[$i]) { ?> selected="selected"<?php } ?>><?php echo $prefix . $citys[$i]; ?></option>
<?php
		}
	}
	else
	{
?>
				    <option rel="<?php echo $offset; ?>" value="<?php echo $citys; ?>"<?php if ($selTimezone[0] == $citys) { ?> selected="selected"<?php } ?>><?php echo $prefix . $citys; ?></option>
<?php
	}
}
?>
				  </select>
				</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" value="{#plugobrowser_dlg.save}" class="btn" /></td>
      </tr>
    </table>
  </form>
</div>
<script type="text/javascript">
function getTimezoneOffset()
{
	var dateObj = new Date();
	var jan1 = new Date(dateObj.getFullYear(), 0, 1, 0, 0, 0, 0);
	var june1 = new Date(dateObj.getFullYear(), 6, 1, 0, 0, 0, 0);
	  
	var tmpDate = jan1.toGMTString();
	var jan2 = new Date(tmpDate.substring(0, tmpDate.lastIndexOf(' ') - 1));
	  
	tmpDate = june1.toGMTString();
	var june2 = new Date(tmpDate.substring(0, tmpDate.lastIndexOf(' ') - 1));
	  
  var stdOffset = (jan1 - jan2) / (1000 * 60 * 60);
	var dstOffset = (june1 - june2) / (1000 * 60 * 60);
	  
  if ((stdOffset != dstOffset) && (stdOffset - dstOffset >= 0)) stdOffset = dstOffset;
		
	return stdOffset;
}

$(document).ready(function()
{
  var timezoneSelect = $('select[name="init[timezone]"]');
  if (!timezoneSelect.find('option[selected]').length)
  {
	  var offset = getTimezoneOffset();
	  timezoneSelect.find('option[rel="' + offset + '"]:first').attr('selected', 'selected');	  
	}
});
</script>
</body>
</html>