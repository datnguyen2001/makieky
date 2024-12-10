<?php

return [
    'admin' => [
        [
            'name' => 'dashboard',
            'title' => 'Dashboard',
            'icon' => 'bi bi-grid',
            'route' => 'admin.index',
            'submenu' => [],
            'number' => 1
        ],
        [
            'name' => 'order',
            'title' => 'Quản lý đơn hàng',
            'icon' => 'bi bi-grid',
            'route' => 'admin.order.index',
            'parameters' => ['status' => 'all'],
            'submenu' => [],
            'number' => 2
        ],
        [
            'name' => 'banner',
            'title' => 'Cài đặt Banner',
            'icon' => 'bi bi-grid',
            'route' => 'admin.banner.index',
            'submenu' => [],
            'number' => 1
        ],
        [
            'name' => 'introduce',
            'title' => 'Bài viết giới thiệu ở trang chủ',
            'icon' => 'bi bi-grid',
            'route' => 'admin.introduce.index',
            'submenu' => [],
            'number' => 1
        ],
        [
            'name' => 'promote',
            'title' => 'Quảng bá',
            'icon' => 'bi bi-grid',
            'route' => 'admin.promote.index',
            'submenu' => [],
            'number' => 1
        ],
        [
            'name' => 'category',
            'title' => 'Danh mục sản phẩm',
            'icon' => 'bi bi-grid',
            'route' => 'admin.category.index',
            'submenu' => [],
            'number' => 1
        ],
        [
            'name' => 'trademark',
            'title' => 'Thương hiệu sản phẩm',
            'icon' => 'bi bi-grid',
            'route' => 'admin.trademark.index',
            'submenu' => [],
            'number' => 1
        ],
        [
            'name' => 'product',
            'title' => 'Quản lý sản phẩm',
            'icon' => 'bi bi-grid',
            'route' => 'admin.product.index',
            'submenu' => [],
            'number' => 1
        ],
        [
            'name' => 'footer',
            'title' => 'Bài viết footer',
            'icon' => 'bi bi-grid',
            'route' => 'admin.footer.index',
            'submenu' => [],
            'number' => 1
        ],
        [
            'name' => 'setting',
            'title' => 'Cài đặt chung',
            'icon' => 'bi bi-grid',
            'route' => 'admin.setting.index',
            'submenu' => [],
            'number' => 1
        ],
    ]
];
