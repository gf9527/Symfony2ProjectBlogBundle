<?php

// this check prevents access to debug front controllers that are deployed by accident to production servers.
// feel free to remove this, extend it, or make something more sophisticated.
/*
if (!in_array(@$_SERVER['REMOTE_ADDR'], array(
    '127.0.0.1',
    '::1',
    '10.50.1.126',
    '10.50.1.128',
))) {    header('HTTP/1.0 403 Forbidden');
    die('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}
*/
require_once __DIR__.'/../app/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Debug\DebugExceptionHandler;

set_exception_handler(new DebugExceptionHandler());

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$kernel->handle(Request::createFromGlobals())->send();
