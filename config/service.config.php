<?php

return [
    'factories' => [
        // Forms
        'Eye4web\Zf2BoardAdmin\Form\Board\EditForm' => 'Eye4web\Zf2BoardAdmin\Factory\Form\Board\EditFormFactory',
        'Eye4web\Zf2BoardAdmin\Form\Board\CreateForm' => 'Eye4web\Zf2BoardAdmin\Factory\Form\Board\CreateFormFactory',
        'Eye4web\Zf2BoardAdmin\Form\Topic\EditForm' => 'Eye4web\Zf2BoardAdmin\Factory\Form\Topic\EditFormFactory',

        // Mappers
        'Eye4web\Zf2BoardAdmin\Mapper\DoctrineORM\BoardAdminMapper' => 'Eye4web\Zf2BoardAdmin\Factory\Mapper\DoctrineORM\BoardAdminMapperFactory',
        'Eye4web\Zf2BoardAdmin\Mapper\DoctrineORM\TopicAdminMapper' => 'Eye4web\Zf2BoardAdmin\Factory\Mapper\DoctrineORM\TopicAdminMapperFactory',
        'Eye4web\Zf2BoardAdmin\Mapper\DoctrineORM\PostAdminMapper' => 'Eye4web\Zf2BoardAdmin\Factory\Mapper\DoctrineORM\PostAdminMapperFactory',

        // Services
        'Eye4web\Zf2BoardAdmin\Service\BoardAdminService' => 'Eye4web\Zf2BoardAdmin\Factory\Service\BoardAdminServiceFactory',
        'Eye4web\Zf2BoardAdmin\Service\TopicAdminService' => 'Eye4web\Zf2BoardAdmin\Factory\Service\TopicAdminServiceFactory',
        'Eye4web\Zf2BoardAdmin\Service\PostAdminService' => 'Eye4web\Zf2BoardAdmin\Factory\Service\PostAdminServiceFactory',

        // Options
        'Eye4web\Zf2BoardAdmin\Options\ModuleOptions' => 'Eye4web\Zf2BoardAdmin\Factory\Options\ModuleOptionsFactory',

    ]
];
