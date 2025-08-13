<?php

namespace App\Lib;

class PostInfo extends EntityInfo
{
    protected string $id;
    protected string $announce;
    protected string $date;
    protected string $detail_text;
    protected string $is_server_post;
    protected string $code;
    protected static object $instance;
}
