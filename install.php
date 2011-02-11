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

require_once(WB_PATH.'/modules/'.basename(dirname(__FILE__)).'/class.link.php');
require_once(WB_PATH.'/modules/'.basename(dirname(__FILE__)).'/class.droplets.php');

$error = '';

$dbKITdirList = new dbKITdirList();
if (!$dbKITdirList->sqlTableExists()) {
	if (!$dbKITdirList->sqlCreateTable()) {
		$error .= sprintf('<p>[INSTALL %s] %s</p>', $dbKITdirList->getTableName(), $dbKITdirList->getError());
	}
}

// Install Droplets
$droplets = new checkDroplets();
if ($droplets->insertDropletsIntoTable()) {
  $message = 'The Droplets for kitDirList where successfully installed! Please look at the Help for further informations.';
}
else {
  $message = 'The installation of the Droplets for kitDirList failed. Error: '. $droplets->getError();
}
if ($message != "") {
  echo '<script language="javascript">alert ("'.$message.'");</script>';
}

// Prompt Errors
if (!empty($error)) {
	$admin->print_error($error);
}

?>