<?php

/**
 * kitDirList
 *
 * @author Ralf Hertsch (ralf.hertsch@phpmanufaktur.de)
 * @link http://phpmanufaktur.de
 * @copyright 2011
 * @license GNU GPL (http://www.gnu.org/licenses/gpl.html)
 * @version $Id$
 */

// include class.secure.php to protect this file and the whole CMS!
if (defined('WB_PATH')) {
  if (defined('LEPTON_VERSION'))
    include(WB_PATH.'/framework/class.secure.php');
}
else {
  $oneback = "../";
  $root = $oneback;
  $level = 1;
  while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
    $root .= $oneback;
    $level += 1;
  }
  if (file_exists($root.'/framework/class.secure.php')) {
    include($root.'/framework/class.secure.php');
  }
  else {
    trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
  }
}
// end include class.secure.php

// Checking Requirements
$PRECHECK['WB_VERSION'] = array('VERSION' => '2.8', 'OPERATOR' => '>=');
$PRECHECK['PHP_VERSION'] = array('VERSION' => '5.2.0', 'OPERATOR' => '>=');
$PRECHECK['WB_ADDONS'] = array(
    'dbconnect_le' => array('VERSION' => '0.64', 'OPERATOR' => '>='),
    'dwoo' => array('VERSION' => '0.11', 'OPERATOR' => '>='),
    'droplets' => array('VERSION' => '1.0', 'OPERATOR' => '>='),
    'droplets_extension' => array('VERSION' => '0.16', 'OPERATOR' => '>=')
		);
// SPECIAL: check dependency at runtime in kitDirList::checkDependency()
$PRECHECK['KIT'] = array(
    'kit' => array('VERSION' => '0.53', 'OPERATOR' => '>='),
    'kit_form' => array('VERSION' => '0.32', 'OPERATOR' => '>=')
		);

global $database;
$sql = "SELECT `value` FROM `".TABLE_PREFIX."settings` WHERE `name`='default_charset'";
$result = $database->query($sql);
if ($result) {
  $data = $result->fetchRow(MYSQL_ASSOC);
  $PRECHECK['CUSTOM_CHECKS'] = array(
      'Default Charset' => array(
          'REQUIRED' => 'utf-8',
          'ACTUAL' => $data['value'],
          'STATUS' => ($data['value'] === 'utf-8')
      		)
  		);
}

?>