<?php

return array(


    'product/([0-9]+)' => 'product/view/$1',
    'product/addAjax' =>'product/addAjax',

    'catalog' => 'catalog/index',

    'user/register' => 'user/register',

    'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2',

    'cabinet/edit' => 'cabinet/edit',
    'cart/add/([0-9]+)' => 'cart/add/$1',
    'cart/addAjax/([0-9]+)' => 'cart/addAjax/$1',
    'cart/checkout' => 'cart/checkout',
    'cart/delete/([0-9]+)' => 'cart/delete/$1',
    'cart' => 'cart/index',
    'cabinet' => 'cabinet/index',
    'contacts' => 'site/contact',
    'category/([0-9]+)' => 'catalog/category/$1',

    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    '' => 'site/index',
);
