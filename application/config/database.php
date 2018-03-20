<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = '192.168.51.52';
$db['default']['port']     =  5432;
$db['default']['username'] = 'postgres';
$db['default']['password'] = '';
$db['default']['database'] = 'import';
$db['default']['dbdriver'] = 'postgre';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

$db['db2']['hostname'] = '192.168.51.123';
$db['db2']['port']     =  5432;
$db['db2']['username'] = 'adempiere';
$db['db2']['password'] = 'Becarefulwithme';
$db['db2']['database'] = 'aimsdbc';
$db['db2']['dbdriver'] = 'postgre';
$db['db2']['dbprefix'] = '';
$db['db2']['pconnect'] = FALSE;
$db['db2']['db_debug'] = TRUE;
$db['db2']['cache_on'] = FALSE;
$db['db2']['cachedir'] = '';
$db['db2']['char_set'] = 'utf8';
$db['db2']['dbcollat'] = 'utf8_general_ci';
$db['db2']['swap_pre'] = '';
$db['db2']['autoinit'] = TRUE;
$db['db2']['stricton'] = FALSE;

$db['dc']['hostname'] = '192.168.51.202';
$db['dc']['port']     =  5432;
$db['dc']['username'] = 'wmsacc';
$db['dc']['password'] = 'Password12345';
$db['dc']['database'] = 'wms_acc';
$db['dc']['dbdriver'] = 'postgre';
$db['dc']['dbprefix'] = '';
$db['dc']['pconnect'] = FALSE;
$db['dc']['db_debug'] = TRUE;
$db['dc']['cache_on'] = FALSE;
$db['dc']['cachedir'] = '';
$db['dc']['char_set'] = 'utf8';
$db['dc']['dbcollat'] = 'utf8_general_ci';
$db['dc']['swap_pre'] = '';
$db['dc']['autoinit'] = TRUE;
$db['dc']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */
