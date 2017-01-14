<?php

return array(

    /*product management*/
    'admin/product/delete/([0-9]+)' => 'adminProduct/delete/$1',
    'admin/product/create' => 'adminProduct/create',
    'admin/product/update/([0-9]+)' => 'adminProduct/update/$1',
    'admin/product' => 'adminProduct/index',

    /*category management*/
    'admin/category/delete/([0-9]+)' => 'adminCategory/delete/$1',
    'admin/category/create' => 'adminCategory/create',
    'admin/category/update/([0-9]+)' => 'adminCategory/update/$1',
    'admin/category' => 'adminCategory/index',

    /*order management*/
    'admin/order/update/([0-9]+)' => 'adminOrder/update/$1',
    'admin/order/delete/([0-9]+)' => 'adminOrder/delete/$1',
    'admin/order/view/([0-9]+)' => 'adminOrder/view/$1',
    'admin/order' => 'adminOrder/index',

    /*admin panel*/
    'admin' => 'admin/index',

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
    'about' => 'site/about',
    'contacts' => 'site/contact',
    'category/([0-9]+)' => 'catalog/category/$1',

    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    '' => 'site/index',
);
