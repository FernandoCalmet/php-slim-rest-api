<?php

declare(strict_types=1);

use App\Service\Note;
use App\Service\Task;
use App\Service\User;
use Psr\Container\ContainerInterface;

$container['find_user_service'] = static fn (ContainerInterface $container): User\Find => new User\Find(
    $container->get('user_repository'),
    $container->get('redis_service'),
    $container->get('logger_service')
);

$container['create_user_service'] = static fn (ContainerInterface $container): User\Create => new User\Create(
    $container->get('user_repository'),
    $container->get('redis_service'),
    $container->get('logger_service')
);

$container['update_user_service'] = static fn (ContainerInterface $container): User\Update => new User\Update(
    $container->get('user_repository'),
    $container->get('redis_service'),
    $container->get('logger_service')
);

$container['delete_user_service'] = static fn (ContainerInterface $container): User\Delete => new User\Delete(
    $container->get('user_repository'),
    $container->get('redis_service'),
    $container->get('logger_service')
);

$container['login_user_service'] = static fn (ContainerInterface $container): User\Login => new User\Login(
    $container->get('user_repository'),
    $container->get('redis_service'),
    $container->get('logger_service')
);

$container['find_task_service'] = static fn (ContainerInterface $container): Task\Find => new Task\Find(
    $container->get('task_repository'),
    $container->get('redis_service'),
    $container->get('logger_service')
);

$container['create_task_service'] = static fn (ContainerInterface $container): Task\Create => new Task\Create(
    $container->get('task_repository'),
    $container->get('redis_service'),
    $container->get('logger_service')
);

$container['update_task_service'] = static fn (ContainerInterface $container): Task\Update => new Task\Update(
    $container->get('task_repository'),
    $container->get('redis_service'),
    $container->get('logger_service')
);

$container['delete_task_service'] = static fn (ContainerInterface $container): Task\Delete => new Task\Delete(
    $container->get('task_repository'),
    $container->get('redis_service'),
    $container->get('logger_service')
);

$container['find_note_service'] = static fn (ContainerInterface $container): Note\Find => new Note\Find(
    $container->get('note_repository'),
    $container->get('redis_service'),
    $container->get('logger_service')
);

$container['create_note_service'] = static fn (ContainerInterface $container): Note\Create => new Note\Create(
    $container->get('note_repository'),
    $container->get('redis_service'),
    $container->get('logger_service')
);

$container['update_note_service'] = static fn (ContainerInterface $container): Note\Update => new Note\Update(
    $container->get('note_repository'),
    $container->get('redis_service'),
    $container->get('logger_service')
);

$container['delete_note_service'] = static fn (ContainerInterface $container): Note\Delete => new Note\Delete(
    $container->get('note_repository'),
    $container->get('redis_service'),
    $container->get('logger_service')
);
