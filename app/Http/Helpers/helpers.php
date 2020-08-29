<?php

use App\Category;
use App\Post;

function getPages()
{
    $pages = Post::where('post_type', 'page')->where('is_published', '1')->get();
    return $pages;
}

function getColumns()
{
    $columns = Category::where('is_column', '1')->where('is_published', '1')->get();
    return $columns;
}
