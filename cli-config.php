<?php

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;

const ROOT_PATH = __DIR__;
require ROOT_PATH . '/vendor/autoload.php';

$container = require ROOT_PATH . '/app/dependencies.php';
$config = new PhpFile(ROOT_PATH . '/app/config/migrations.php');

$entityManager = $container->get(EntityManagerInterface::class);

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));
