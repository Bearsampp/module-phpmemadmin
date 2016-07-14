<?php

$html = '<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>
        phpMemAdmin - Bringing Memcached to the web
    </title>
    <meta name="description" content="phpMemAdmin - brings Memcached to the web. Manage the data stored in your Memcached cluster or view detailed information and statistics about it.">
    <meta name="viewport"    content="width=device-width, initial-scale=1">
    <meta name="robots"      content="noindex,nofollow,noarchive" />
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64,AAABAAEAEBAAAAAAAABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAD///8AAAAACgAAABgAAAAaAAAAGgAAABoAAAAaAAAAGgAAABoAAAAaAAAAGgAAABoAAAAaAAAAGAAAAAv///8A////AAAAABMBAQFnAgICpAICAqQCAgKkAgICpAICAqQCAgKkAgICpAICAqQCAgKkAgICpAEBAWgAAAAV////AP///wAAAAAAAgICJQQEBI6Ghob/goKC/4KCgv+CgoL/goKC/4KCgv+CgoL/hoaG/wQEBI4CAgIlAAAAAP///wD///8AAQEBAAQEBAAEBASTbW1t/2lpaf9paWn/aWlp/2lpaf9paWn/M8wz/21tbf8EBASTBAQEAAEBAQD///8A////AAICAgACAgIAAgICqFVVVf9VVVX/VVVV/1VVVf9VVVX/VVVV/1VVVf9VVVX/AgICqAICAgACAgIA////AP///wAfHx8AHx8fAB8fH37Hx8f/vb29/729vf+9vb3/vb29/729vf+9vb3/x8fH/x8fH34fHx8AHx8fAP///wD///8ALy8vAC8vLwAvLy94ysrK/8DAwP/AwMD/wMDA/8DAwP/AwMD/0tLS/8rKyv8vLy94Ly8vAC8vLwD///8A////ADQ0NAA0NDQANDQ0dc3Nzf/Dw8P/w8PD/8PDw//Dw8P/w8PD/5mZmf/Nzc3/NDQ0dTQ0NAA0NDQA////AP///wA5OTkAOTk5ADk5OXPW1tb/0dHR/9HR0f/R0dH/0dHR/9HR0f/R0dH/1tbW/zk5OXM5OTkAOTk5AP///wD///8APj4+AD4+PgA+Pj5xt7e3/7u7u/+7u7v/u7u7/7u7u/+7u7v/u7u7/7e3t/8+Pj5xPj4+AD4+PgD///8A////AENDQwBDQ0MAQ0NDb9nZ2f/Pz8//z8/P/8/Pz//Pz8//z8/P/8/Pz//Z2dn/Q0NDb0NDQwBDQ0MA////AP///wBHR0cAR0dHAEdHR23h4eH/3Nzc/9zc3P/c3Nz/3Nzc/9zc3P/c3Nz/4eHh/0dHR21HR0cAR0dHAP///wD///8AS0tLAEtLSwBLS0trwcHB/8bGxv/Gxsb/xsbG/8bGxv/Gxsb/xsbG/8HBwf9LS0trS0tLAEtLSwD///8A////AE9PTwBPT08AT09PaePj4//a2tr/2tra/9ra2v/a2tr/2tra/9ra2v/j4+P/T09PaU9PTwBPT08A////AP///wBSUlIAUlJSAFJSUmjq6ur/5eXl/+Xl5f/l5eX/5eXl/+Xl5f/l5eX/6urq/1JSUmhSUlIAUlJSAP///wD///8AVFRUAFRUVABVVVVNVVVVZ1VVVWdVVVVnVVVVZ1VVVWdVVVVnVVVVZ1VVVWdVVVVNVFRUAFRUVAD///8A//8AAOAHAADgBwAA4AcAAOAHAADwDwAA8A8AAPAPAADwDwAA8A8AAPAPAADwDwAA8A8AAPAPAADwDwAA//8AAA==">
</head>
<body>%s</body>
</html>';

if (version_compare(phpversion(), '5.3.0', '<')) {
    echo sprintf($html, '<strong>PHP >= 5.3</strong> is required');
    exit(1);
}

if (!function_exists('memcache_connect')) {
    echo sprintf($html, 'Memcache PHP extension is not installed');
    exit(1);
}

$path = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
$config = json_decode(file_get_contents($path . 'app/.config'), true);

$memcacheObj = @memcache_connect($config['cluster']['hosts'][0]['host'], $config['cluster']['hosts'][0]['port']);
if (!$memcacheObj) {
    echo sprintf($html, 'Memcached server offline on <strong>' . $config['cluster']['hosts'][0]['host'] . ':' . $config['cluster']['hosts'][0]['port'] . '</strong>');
    exit(1);
}

memcache_close($memcacheObj);
include_once 'index2.php';
