<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$idRole = $_SESSION['id_role'] ?? null;
$currentPage = basename($_SERVER['PHP_SELF']);

$menus = [
    [
        'title' => 'Dashboard (General Report)',
        'icon' => 'fa-dashboard',
        'link' => 'dashboard.php',
        'roles' => [1, 2, 3, 4, 5],
        'children' => [
            ['title' => 'DN Status', 'icon' => 'fa-dashboard', 'link' => 'dashbstatusdn.php', 'roles' => [1, 2, 3, 4, 5]]
        ]
    ],
    [
        'title' => 'Master Part Data',
        'icon' => 'fa-database',
        'link' => 'javascript:void(0)',
        'roles' => [1, 2],
        'children' => [
            ['title' => 'ADM Parts', 'icon' => 'fa-wrench', 'link' => 'masterpart_adm.php', 'roles' => [1, 2]],
            ['title' => 'HINO Parts', 'icon' => 'fa-wrench', 'link' => 'masterpart_hino.php', 'roles' => [1, 2]],
            ['title' => 'HPM Parts', 'icon' => 'fa-wrench', 'link' => 'masterpart_hpm.php', 'roles' => [1, 2]],
            ['title' => 'MMKI Parts', 'icon' => 'fa-wrench', 'link' => 'masterpart_mmki.php', 'roles' => [1, 2]],
            ['title' => 'SUZUKI Parts', 'icon' => 'fa-wrench', 'link' => 'masterpart_suzuki.php', 'roles' => [1, 2]],
            ['title' => 'TMMIN Parts', 'icon' => 'fa-wrench', 'link' => 'masterpart_tmmin.php', 'roles' => [1, 2]],
        ]
    ],
    [
        'title' => 'Delivery Data',
        'icon' => 'fa-database',
        'link' => 'javascript:void(0)',
        'roles' => [1, 2, 3, 4, 5],
        'children' => [
            ['title' => 'Delivery ADM', 'icon' => 'fa-truck', 'link' => 'delivery_adm.php', 'roles' => [1, 2, 4, 5]],
            ['title' => 'Delivery HINO', 'icon' => 'fa-truck', 'link' => 'delivery_hino.php', 'roles' => [1, 2, 4, 5]],
            ['title' => 'Delivery HPM', 'icon' => 'fa-truck', 'link' => 'delivery_hpm.php', 'roles' => [1, 2, 4, 5]],
            ['title' => 'Delivery MMKI', 'icon' => 'fa-truck', 'link' => 'delivery_mmki.php', 'roles' => [1, 2, 4, 5]],
            ['title' => 'Delivery SUZUKI', 'icon' => 'fa-truck', 'link' => 'delivery_suzuki.php', 'roles' => [1, 2, 4, 5]],
            ['title' => 'Delivery TMMIN', 'icon' => 'fa-truck', 'link' => 'delivery_tmmin.php', 'roles' => [1, 2, 4, 5]]
        ]
    ],
    [
        'title' => 'History Scan',
        'icon' => 'fa-history',
        'link' => 'history_delivery.php',
        'roles' => [1, 2, 3, 4, 5]
    ],
    [
        'title' => 'Users',
        'icon' => 'fa-users',
        'link' => 'User.php',
        'roles' => [1]
    ]
];
?>

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <?php foreach ($menus as $menu): ?>
                <?php if (in_array($idRole, $menu['roles'])): ?>
                    <?php
                    $isActive = ($menu['link'] === $currentPage);
                    $hasActiveChild = false;

                    if (isset($menu['children'])) {
                        foreach ($menu['children'] as $child) {
                            if ($child['link'] === $currentPage) {
                                $hasActiveChild = true;
                                break;
                            }
                        }
                    }

                    $liClass = ($isActive || $hasActiveChild) ? 'active' : '';
                    $submenuClass = 'nav nav-second-level collapse';
                    if ($hasActiveChild) {
                        $submenuClass .= ' in';
                    }
                    ?>

                    <li class="<?= $liClass ?>">
                        <a href="<?= isset($menu['children']) ? 'javascript:void(0)' : $menu['link'] ?>">
                            <i class="fa <?= $menu['icon'] ?> fa-fw"></i> <?= $menu['title'] ?>
                            <?php if (isset($menu['children'])): ?><span class="fa arrow"></span><?php endif; ?>
                        </a>

                        <?php if (isset($menu['children'])): ?>
                            <ul class="<?= $submenuClass ?>">
                                <?php foreach ($menu['children'] as $child): ?>
                                    <?php if (in_array($idRole, $child['roles'])): ?>
                                        <li class="<?= ($child['link'] === $currentPage) ? 'active' : '' ?>">
                                            <a href="<?= $child['link'] ?>">
                                                <i class="fa <?= $child['icon'] ?> fa-fw"></i> <?= $child['title'] ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<?php if ($idRole == 5): ?>
    <style>#admin{display:none;}</style>
<?php endif; ?>
