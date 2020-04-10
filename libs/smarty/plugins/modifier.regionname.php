<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty format price modifier plugin
 *
 * Type:     modifier<br>
 * Name:     formatprice<br>
 * Purpose:  convert string vietnamese price format
 * @author   lonelyworlf(tuanmaster2002@yahoo.com)
 * @param string
 * @return string
 */
function smarty_modifier_regionname($regionid)
{
    return Helper::getRegionName($regionid);
}

?>
