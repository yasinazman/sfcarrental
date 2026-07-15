<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->fetch('title') ?> - SF Car Rental</title>
    
    <script>
        const storedTheme = localStorage.getItem('sf_theme') || (window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light");
        if (storedTheme) { document.documentElement.setAttribute('data-theme', storedTheme); }
    </script>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght=300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <?= $this->Html->css('admin-layout') ?>
    
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>

    <aside class="sidebar">
        <div class="brand-logo">SF <span> Car Rental</span></div>
        
        <?php 
            $currentController = $this->request->getParam('controller'); 
        ?>
        
        <ul class="nav-links">
            <li><a href="<?= $this->Url->build('/admins-dashboard') ?>" class="<?= $currentController === 'AdminsDashboard' ? 'active' : '' ?>"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'AdminsCars', 'action' => 'index']) ?>" class="<?= $currentController === 'AdminsCars' ? 'active' : '' ?>"><i class="fas fa-car"></i> Manage Cars</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'AdminsBookings', 'action' => 'index']) ?>" class="<?= $currentController === 'AdminsBookings' ? 'active' : '' ?>"><i class="fas fa-calendar-check"></i> Manage Bookings</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'AdminsCustomers', 'action' => 'index']) ?>" class="<?= $currentController === 'AdminsCustomers' ? 'active' : '' ?>"><i class="fas fa-users"></i> Manage Customers</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'Admins', 'action' => 'index']) ?>" class="<?= $currentController === 'Admins' && $this->request->getParam('action') === 'index' ? 'active' : '' ?>"><i class="fas fa-user-shield"></i> Manage Admins</a></li>
        </ul>

        <div class="menu-label">Operations & Reports</div>
        <ul class="nav-links">
            <li><a href="<?= $this->Url->build(['controller' => 'AdminsSales', 'action' => 'index']) ?>" class="<?= $currentController === 'AdminsSales' ? 'active' : '' ?>"><i class="fas fa-chart-line"></i> View Sales</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'AdminsMaintenances', 'action' => 'index']) ?>" class="<?= $currentController === 'AdminsMaintenances' ? 'active' : '' ?>"><i class="fas fa-tools"></i> Maintenance</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'AdminsGps', 'action' => 'index']) ?>" class="<?= $currentController === 'AdminsGps' ? 'active' : '' ?>"><i class="fas fa-map-marker-alt"></i> GPS Tracker</a></li>
            <li style="margin-top: 30px;"><a href="<?= $this->Url->build(['controller' => 'Admins', 'action' => 'logout']) ?>" style="color: var(--text-light);"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
        </ul>
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <div>
                <h2 style="margin:0; font-size: 20px; font-weight: 600;"><?= $this->fetch('title') ?></h2>
                <span style="font-size: 12px; color: var(--text-light);"><?= date('l, d F Y') ?></span>
            </div>
            
            <div class="topbar-right">
                <i class="fas fa-moon topbar-icon" id="darkModeToggle" title="Toggle Dark/Light Mode" style="cursor: pointer; transition: 0.3s; font-size: 20px;"></i>
                <i class="fas fa-bell topbar-icon" title="Notifications"></i>

                <?php $identity = $this->request->getAttribute('identity'); ?>
                <div class="admin-profile-wrapper">
                    <div class="admin-profile" id="profileToggle">
                        <div class="admin-avatar"><i class="fas fa-user"></i></div>
                        <span><?= h($identity ? $identity->get('username') : 'Administrator') ?></span>
                        <i class="fas fa-chevron-down" style="font-size: 11px; color: var(--text-light); margin-left: 4px;"></i>
                    </div>

                    <div class="profile-dropdown" id="profileDropdown">
                        <div class="profile-dropdown-header">
                            <div class="admin-avatar-lg"><i class="fas fa-user"></i></div>
                            <div>
                                <div class="dropdown-name"><?= h($identity ? $identity->get('username') : 'Administrator') ?></div>
                                <div class="dropdown-role"><?= h($identity ? $identity->get('role') : '') ?></div>
                            </div>
                        </div>
                        <ul class="profile-dropdown-menu">
                            <li><a href="<?= $this->Url->build(['controller' => 'Admins', 'action' => 'profile']) ?>"><i class="fas fa-user-cog"></i> Account Settings</a></li>
                            <li><a href="<?= $this->Url->build(['controller' => 'Admins', 'action' => 'logout']) ?>"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
                        </ul>
                    </div>
                </div>
                
            </div>
        </header>

        <main class="content-area">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </main>
    </div>

    <?= $this->Html->script('admin-theme') ?>
</body>
</html>