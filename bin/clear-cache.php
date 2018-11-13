<?php
//**/ini_set('display_errors', 1); error_reporting(E_ALL);
use Nette,
	Nette\Utils\Finder,
	Nette\Utils\FileSystem;


###
 #  #    # # #####
 #  ##   # #   #
 #  # #  # #   #
 #  #  # # #   #
 #  #   ## #   #
### #    # #   #
$context = require(dirname(__DIR__) . '/app/bootstrap.php');

$key = @$_GET['key'];
if ($key != '123456') {
    header('HTTP/1.1 401 Unauthorized');
    print('Invalid security key.');
    exit(1);
}


 #####
#     # #      ######   ##   #####      ####    ##    ####  #    # ######
#       #      #       #  #  #    #    #    #  #  #  #    # #    # #
#       #      #####  #    # #    #    #      #    # #      ###### #####
#       #      #      ###### #####     #      ###### #      #    # #
#     # #      #      #    # #   #     #    # #    # #    # #    # #
 #####  ###### ###### #    # #    #     ####  #    #  ####  #    # ######
require_once(__DIR__ . '/../vendor/autoload.php');

$tempDir = $context->parameters['tempDir'];
foreach (Finder::findDirectories('*')->in($tempDir) as $dirPath => $dir) {
    FileSystem::delete($dirPath);
}
FileSystem::createDir($tempDir . '/cache');


#######
#       # #    # #  ####  #    #
#       # ##   # # #      #    #
#####   # # #  # #  ####  ######
#       # #  # # #      # #    #
#       # #   ## # #    # #    #
#       # #    # #  ####  #    #
header('HTTP/1.1 200 OK');
print('Cache cleared.');
exit(0);
