<?php

return [
    '' => [
        'controller' => 'Main',
        'action' => 'index',
        'view' => 'main/index'
    ],
    'server' => [
        'controller' => 'Main',
        'action' => 'server',
        'view' => 'main/server'
    ],
    'guides' => [
        'controller' => 'Main',
        'action' => 'guides',
        'view' => 'main/guides'
    ],

    'login' => [
        'controller' => 'Auth',
        'action' => 'login',
        'view' => 'auth/login'
    ],
    'loginProcess' => [
        'controller' => 'Auth',
        'action' => 'loginProcess',
        'view' => 'auth/login'
    ],
    'registration' => [
        'controller' => 'Auth',
        'action' => 'registration',
        'view' => 'auth/registration'
    ],
    'registrationProcess' => [
        'controller' => 'Auth',
        'action' => 'registrationProcess',
        'view' => 'auth/registration'
    ],
    'logout' => [
        'controller' => 'Auth',
        'action' => 'logout',
        'view' => 'auth/login'
    ],
    'confirm' => [
        'controller' => 'Auth',
        'action' => 'confirmEmail',
        'view' => 'auth/confirm'
    ],


    'admin' => [
        'controller' => 'Admin',
        'action' => 'login',
        'view' => 'admin/login'
    ],
    'admin/loginProcess' => [
        'controller' => 'Admin',
        'action' => 'loginProcess',
        'view' => 'admin/login'
    ],
    'admin/dashboard' => [
        'controller' => 'Admin',
        'action' => 'dashboard',
        'view' => 'admin/dashboard'
    ],
    'admin/users' => [
        'controller' => 'Admin',
        'action' => 'users',
        'view' => 'admin/users'
    ],
    'admin/users/edit/{id:\d+}' => [
        'controller' => 'Admin',
        'action' => 'editUser',
        'view' => 'admin/user'
    ],
    'admin/users/add' => [
        'controller' => 'Admin',
        'action' => 'addUser',
        'view' => 'admin/user'
    ],
    'admin/users/delete/{id:\d+}' => [
        'controller' => 'Admin',
        'action' => 'deleteUser',
    ],

    'admin/posts' => [
        'controller' => 'Admin',
        'action' => 'posts',
        'view' => 'admin/posts'
    ],
    'admin/posts/edit/{id:\d+}' => [
        'controller' => 'Admin',
        'action' => 'editPost',
        'view' => 'admin/post'
    ],
    'admin/posts/add' => [
        'controller' => 'Admin',
        'action' => 'addPost',
        'view' => 'admin/post'
    ],
    'admin/posts/delete/{id:\d+}' => [
        'controller' => 'Admin',
        'action' => 'deletePost',
    ],

    'admin/pages' => [
        'controller' => 'Admin',
        'action' => 'pages',
        'view' => 'admin/pages'
    ],
    'admin/pages/edit/{id:\d+}' => [
        'controller' => 'Admin',
        'action' => 'editPage',
        'view' => 'admin/page'
    ],
    'admin/pages/add' => [
        'controller' => 'Admin',
        'action' => 'addPage',
        'view' => 'admin/page'
    ],
    'admin/pages/delete/{id:\d+}' => [
        'controller' => 'Admin',
        'action' => 'deletePage',
    ],



    'user' => [
        'controller' => 'User',
        'action' => 'show',
        'view' => 'user/show'
    ],
    'user/edit' => [
        'controller' => 'User',
        'action' => 'edit',
        'view' => 'user/edit'
    ],
    'user/update' => [
        'controller' => 'User',
        'action' => 'update'
    ],


    'detail/{id:\d+}' => [
        'controller' => 'Post',
        'action' => 'detail',
        'view' => 'post/detail'
    ],
    'news' => [
        'controller' => 'Post',
        'action' => 'list',
        'view' => 'post/list'
    ],
    'news/(?P<slug>[a-z0-9-]+)' => [
        'controller' => 'Post',
        'action' => 'detail',
        'view' => 'post/detail',
    ],
    'news/load' => [
        'controller' => 'Post',
        'action' => 'load'
    ],
    'news/{id:\d+}' => [
        'controller' => 'Post',
        'action' => 'list',
        'view' => 'post/list'
    ],
];