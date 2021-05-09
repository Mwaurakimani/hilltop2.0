<?php
namespace Lyricorn\System;

class Sys_Init
{
    function __construct()
    {
    }
    public function log_out(){
        session_destroy();
    }
}