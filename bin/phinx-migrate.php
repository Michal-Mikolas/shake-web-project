<?php
/**/ini_set('display_errors', 1); error_reporting(E_ALL);
require dirname(__DIR__) . '/vendor/autoload.php';


// ###      #   #
//  #  ##      ###
//  #  # #  #   #
//  #  # #  ##  ##
// ###
$environment = @$_GET['environment'];
if (!$environment) {
    header('HTTP/1.1 500 Internal Server Error');
    print('Missing `environment` value.');
    exit(1);
}

$key = @$_GET['key'];
if ($key != '123456') {
    header('HTTP/1.1 401 Unauthorized');
    print('Invalid security key.');
    exit(1);
}


// # #  #               #
// ###     ### ###  ## ### ###
// ###  #  # # #   # #  #  ##
// # #  ##  ## #   ###  ## ###
// # #     ###
$phinxApp = new Phinx\Console\PhinxApplication();
$phinxTextWrapper = new Phinx\Wrapper\TextWrapper($phinxApp);

$phinxTextWrapper->setOption('configuration', dirname(__DIR__) . '/phinx.yml');
$phinxTextWrapper->setOption('parser', 'YAML');
$phinxTextWrapper->setOption('environment', $environment);

$log = $phinxTextWrapper->getMigrate();


// ###  #       #      #
// #       ##       ## ###
// ##   #  # #  #   #  # #
// #    ## # #  ## ##  # #
// #
header('HTTP/1.1 200 OK');
print('Migration finished.');
exit(0);
