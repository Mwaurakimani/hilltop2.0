<?php
namespace Lyricorn\Operations\catalogue;

use Lyricorn\User\User;

class catalogue extends User
{
    function __construct()
    {
        User::__construct();
    }
}