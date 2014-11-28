<?php

return [
    'factories' => [
        // Forms
        'Eye4web\Zf2BoardAdmin\Form\Board\EditForm' => 'Eye4web\Zf2BoardAdmin\Factory\Form\Board\EditFormFactory',
        'Eye4web\Zf2BoardAdmin\Form\Board\CreateForm' => 'Eye4web\Zf2BoardAdmin\Factory\Form\Board\CreateFormFactory',
        'Eye4web\Zf2BoardAdmin\Form\Topic\EditForm' => 'Eye4web\Zf2BoardAdmin\Factory\Form\Topic\EditFormFactory',

        // Mappers
        'Eye4web\Zf2BoardAdmin\Mapper\DoctrineORM\BoardAdminMapper' => 'Eye4web\Zf2BoardAdmin\Factory\Mapper\DoctrineORM\BoardAdminMapperFactory',

        // Services
        'Eye4web\Zf2BoardAdmin\Service\BoardAdminService' => 'Eye4web\Zf2BoardAdmin\Factory\Service\BoardAdminServiceFactory',

        // Options
        'Eye4web\Zf2BoardAdmin\Options\ModuleOptions' => 'Eye4web\Zf2BoardAdmin\Factory\Options\ModuleOptionsFactory',

    ]
];
