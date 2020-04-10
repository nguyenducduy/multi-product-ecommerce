<?php
require '../config.php';

$errs = $plugoBrowser->doTest();
$r = isset($errs[0]) ? array('success' => FALSE, 'errors' => $errs) : array('success' => TRUE, 'settings' => $plugoBrowser->getSettings());
echo json_encode($r);