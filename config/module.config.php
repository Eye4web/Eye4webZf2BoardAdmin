<?php

/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

return [
    'router' => [
        'routes' => [
            'zfcadmin' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/admin',
                    'defaults' => [
                        'controller' => 'ZfcAdmin\Controller\AdminController',
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'zf2-board-admin' => [
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => [
                            'route' => '/board'
                        ],
                        'may_terminate' => false,
                        'child_routes' => [
                            'board' => [
                                'type' => 'Zend\Mvc\Router\Http\Literal',
                                'options' => [
                                    'route' => '/board'
                                ],
                                'may_terminate' => false,
                                'child_routes' => [
                                    'list' => [
                                        'type' => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => [
                                            'route' => '/list',
                                            'defaults' => [
                                                'controller' => 'Eye4web\Zf2BoardAdmin\Controller\BoardAdminController',
                                                'action'     => 'boardList',
                                            ],
                                        ],
                                    ],
                                    'edit' => [
                                        'type' => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => [
                                            'route' => '/edit/:id',
                                            'defaults' => [
                                                'controller' => 'Eye4web\Zf2BoardAdmin\Controller\BoardAdminController',
                                                'action'     => 'boardEdit',
                                            ],
                                        ],
                                    ],
                                    'create' => [
                                        'type' => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => [
                                            'route' => '/create',
                                            'defaults' => [
                                                'controller' => 'Eye4web\Zf2BoardAdmin\Controller\BoardAdminController',
                                                'action'     => 'boardCreate',
                                            ],
                                        ],
                                    ],
                                    'delete' => [
                                        'type' => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => [
                                            'route' => '/delete/:id',
                                            'defaults' => [
                                                'controller' => 'Eye4web\Zf2BoardAdmin\Controller\BoardAdminController',
                                                'action'     => 'boardDelete',
                                            ],
                                        ],
                                    ]
                                ],
                            ],
                            'topic' => [
                                'type' => 'Zend\Mvc\Router\Http\Literal',
                                'options' => [
                                    'route' => '/topic'
                                ],
                                'may_terminate' => false,
                                'child_routes' => [
                                    'list' => [
                                        'type' => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => [
                                            'route' => '/list/:board',
                                            'defaults' => [
                                                'controller' => 'Eye4web\Zf2BoardAdmin\Controller\TopicAdminController',
                                                'action'     => 'topicList',
                                            ],
                                        ],
                                    ],
                                    'edit' => [
                                        'type' => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => [
                                            'route' => '/edit/:id',
                                            'defaults' => [
                                                'controller' => 'Eye4web\Zf2BoardAdmin\Controller\TopicAdminController',
                                                'action'     => 'topicEdit',
                                            ],
                                        ],
                                    ],
                                    'delete' => [
                                        'type' => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => [
                                            'route' => '/delete/:id',
                                            'defaults' => [
                                                'controller' => 'Eye4web\Zf2BoardAdmin\Controller\TopicAdminController',
                                                'action'     => 'topicDelete',
                                            ],
                                        ],
                                    ]
                                ],
                            ],
                            'post' => [
                                'type' => 'Zend\Mvc\Router\Http\Literal',
                                'options' => [
                                    'route' => '/post'
                                ],
                                'may_terminate' => false,
                                'child_routes' => [
                                    'list' => [
                                        'type' => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => [
                                            'route' => '/list/:topic',
                                            'defaults' => [
                                                'controller' => 'Eye4web\Zf2BoardAdmin\Controller\PostAdminController',
                                                'action'     => 'postList',
                                            ],
                                        ],
                                    ],
                                    'edit' => [
                                        'type' => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => [
                                            'route' => '/edit/:id',
                                            'defaults' => [
                                                'controller' => 'Eye4web\Zf2BoardAdmin\Controller\PostAdminController',
                                                'action'     => 'postEdit',
                                            ],
                                        ],
                                    ],
                                    'delete' => [
                                        'type' => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => [
                                            'route' => '/delete/:id',
                                            'defaults' => [
                                                'controller' => 'Eye4web\Zf2BoardAdmin\Controller\PostAdminController',
                                                'action'     => 'postDelete',
                                            ],
                                        ],
                                    ]
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],

    'navigation' => [
        'admin' => [
            'Eye4web\Zf2BoardAdmin' => [
                'label' => 'Board',
                'route' => 'zfcadmin/zf2-board-admin/board/list',
                'pages' => [
                ],
            ],
        ],
    ],
];
