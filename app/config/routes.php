<?php

return [
    '' => [
        'controller' => 'Main',
        'action' => 'index'
    ],
    'detail/{id:\d+}' => [
        'controller' => 'Post',
        'action' => 'detail'
    ],
    'feedback' => [
      'controller' => 'FeedBack',
      'action' => 'index'
    ],
    'feedback/send' => [
        'controller' => 'FeedBack',
        'action' => 'send'
    ],
    'news' => [
        'controller' => 'Post',
        'action' => 'list'
    ],
    'news/load' => [
        'controller' => 'Post',
        'action' => 'load'
    ],
    'news/{id: /d+}' => [
        'controller' => 'Post',
        'action' => 'list'
    ],
];
