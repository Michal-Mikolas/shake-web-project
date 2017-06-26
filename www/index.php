<?php
declare(strict_types=1);

// Let bootstrap create Dependency Injection container.
$container = require __DIR__ . '/../app/bootstrap.php';

// Run application.
$container->getByType(Nette\Application\Application::class)
	->run();
