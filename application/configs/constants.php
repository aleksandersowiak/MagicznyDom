<?php

/*
|--------------------------------------------------------------------------
| application version
*/
//$this->getModel()->getData_IP($data, $filters, $data_offset, $data_page_size);
define('APP_VER', '1.00');
define('DB_USER_PASSWORD_STATIC_SALT', 'cd22dcd24ddf4ea8b49fa7880a065bbf1317c98d');
/*
|--------------------------------------------------------------------------
| web interface constants
*/
define('WEB_ROOT_PATH', '/MagicznyDom/public');
define("SESSION_NAMESPACE", 'base');
define("SESSION_USER_ID", 'u_id');
define("SESSION_USER_NAME", 'u_name');
define("SESSION_USER_ROLE", 'u_role');
/*
|--------------------------------------------------------------------------
| DATE TIME constants
|--------------------------------------------------------------------------
| Configuration details
*/
define("DATE_DB_FORMAT", 'y-MM-dd'); // MySQL DATE format
define("DATE_YM_DB_FORMAT", 'y-MM'); // MySQL DATE format
define('DATE_TIME_DB_FORMAT', 'Y-m-d H:i:s');
define("DATE_EXPORT_FORMAT", 'y-MM-dd');
define("DATE_INDEX_FORMAT", 'j F, Y, g:i');

define("MAX_LIMIT_INDEX", 5);
define("MAX_LIMIT_HOT_INDEX", 5);
define("COM_PER_PAGE", 10);
define("LIMIT_REPLY_COMMENT", 3);
/*
|--------------------------------------------------------------------------
| Database error codes
|--------------------------------------------------------------------------
| Configuration details
*/

define("CMD_DB_ERROR_NO_ERROR", 'no-error');
define("CMD_DB_ERROR", 'db-error');
define("CMD_INTERNAL_ERROR", 'db-error');
define("CMD_DB_ERROR_DATA_CHANGED", 'data-changed');
define("CMD_DB_ERROR_NO_DATA", 'no-data');
define("CMD_SAVED", 'saved');
define("CMD_INVALID", 'invalid');
define("CMD_DELETED", 'deleted');
define("CMD_CANCEL", 'cancel');
define("CMD_DB_ERROR_NO_MODIFY", 'no-modify');
define("CMD_DB_ERROR_NO_MODIFY_USER", 'no-modify-user');
define("CMD_POPUP", 'popup');

define("DEF_CONTROLER__LOGIN", 'login');
define("DEF_ACTION__LOGIN", 'index');

define("DEF_CONTROLER__USER", 'index');
define("DEF_ACTION__USER", 'index');