<?php


namespace app\index\controller;


class Index
{

    public function index()
    {
        echo '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><title>Oreo微框架</title><div style="padding: 24px 48px;"> <h1>^_^ </h1><p> Oreo微框架 V' . \oreo\lib\Route::version() . '<br/><span style="font-size:30px;">PHP小白也能操作的框架 - 初心未泯 从心出发</span></div>';
    }

}