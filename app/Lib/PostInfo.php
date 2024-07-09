<?php

namespace App\Lib;

class PostInfo extends EntityInfo
{
    protected string $id;
    protected string $announce;
    protected string $date;
    protected string $detail_text;
    protected static object $instance;
}
