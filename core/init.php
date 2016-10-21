<?php
session_start();



// Project Map:
const PROJ_DIR  = 'namespaces' ;
define( 'PROJ_PATH' , $_SERVER['DOCUMENT_ROOT'] . '/' . PROJ_DIR);
const LANG_DIR  = PROJ_PATH . 'app/lang';

// Database Information:
const DB_HOST = 'localhost';

// Database username:
const DB_USER = 'root';

// Database password:
const DB_PASS = 'root';

// Database name:
const DB_NAME = 'namespace';


const TABLE_PREFIX = 'greedy_';


const PER_TBL = TABLE_PREFIX . 'permissions';


const USR_TBL = TABLE_PREFIX . 'users';


const USR_GRP_TBL = TABLE_PREFIX . 'user_groups';


const PER_GRP_TBL = TABLE_PREFIX . 'permissions_groups';


const PER_USR_TBL = TABLE_PREFIX . 'permissions_users';




require_once PROJ_PATH.'/vendor/autoload.php';


