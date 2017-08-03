<?php
/**
 * Created by PhpStorm.
 * User: eddy
 * Date: 05/02/2016
 * Time: 9:35
 */

namespace Rebelpenguin\Events\Classes;
use redirect;
use Db;
use App;
use Request;
use Cms\Classes\ComponentBase;
use ApplicationException;
use Rebelpenguin\Events\Classes\General;
use Rebelpenguin\Events\Classes\template;

class RedirectFTurl
{
       static function fakeurl($falseurl){
           return 'http://google.com';
       }
}