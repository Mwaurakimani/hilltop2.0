<?php
session_start();

use Lyricorn\System\DbConnect;
use Lyricorn\System\Sys_Init;
use Lyricorn\System\DbCrud;

use Lyricorn\User\User;

use Lyricorn\Operations\catalogue\catalogue;
use Lyricorn\Operations\catalogue\product;


require_once __DIR__ . '/config/config_s.php';
require_once __DIR__ . '/../vendor/autoload.php';

$admin = new User();
