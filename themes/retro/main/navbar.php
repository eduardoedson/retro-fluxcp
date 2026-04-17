<?php if (!defined('FLUX_ROOT')) exit; ?>

<?php
function isWoeActive(array $schedule): bool
{
    $nowDay = (int)date('w');   // 0..6
    $nowTime = date('H:i');

    foreach ($schedule as $type) {
        foreach ($type as $slot) {
            if ($slot['day'] === $nowDay) {
                if ($nowTime >= $slot['start'] && $nowTime <= $slot['end']) {
                    return true;
                }
            }
        }
    }
    return false;
}

$adminMenuItems = $this->getAdminMenuItems();

$isLoggedIn = isset($session) && method_exists($session, 'isLoggedIn') && $session->isLoggedIn();

$logoIcon = $this->themePath('assets/img/logo.png');
$discordIcon = $this->themePath('assets/img/discord.svg');
$discordUrl = 'https://discord.gg/2Vwnc6Vjtz';

$whoOnlineUrl = $this->url('character', 'online');

$wikiUrl = '/wiki';
$downloadUrl = $this->url('service', 'download');
$rankingUrl = $this->url('ranking', 'character');
$donateUrl = $this->url('donate', 'index');
$vendingUrl = $this->url('vending');

// Database
$databaseItemUrl = $this->url('item');
$databaseMonsterUrl = $this->url('monster');

// !$isLoggedIn
$registerUrl = $this->url('account', 'create');
$loginUrl = $this->url('account', 'login');

// $isLoggedIn
$accountUrl = $this->url('account', 'view');
$historyUrl = $this->url('history', 'gamelogin');
$logoutUrl = $this->url('account', 'logout');

// Information
$infoUrl = $this->url('server', 'info');
$woeUrl = $this->url('woe');
$castleUrl = $this->url('castle');

$serverStatus = array();
$serverName = null;
$groupName = null;
$status = false;
$playersOnline = 0;

foreach (Flux::$loginAthenaGroupRegistry as $groupName => $loginAthenaGroup) {
    if (!array_key_exists($groupName, $serverStatus)) {
        $serverStatus[$groupName] = array();
    }

    $loginServerUp = $loginAthenaGroup->loginServer->isUp();
    foreach ($loginAthenaGroup->athenaServers as $athenaServer) {
        $serverName = $athenaServer->serverName;

        $sql = "SELECT COUNT(char_id) AS players_online FROM {$athenaServer->charMapDatabase}.char WHERE `online` > '0'";
        $sth = $loginAthenaGroup->connection->getStatement($sql);
        $sth->execute();
        $res = $sth->fetch();

        $serverStatus[$groupName][$serverName] = array(
            'loginServer' => $loginServerUp,
            'charServer' => $athenaServer->charServer->isUp(),
            'mapServer' => $athenaServer->mapServer->isUp(),
            'playersOnline' => intval($res ? $res->players_online : 0),
        );
    }
}

$status = $serverStatus[$groupName][$serverName]['loginServer'] && $serverStatus[$groupName][$serverName]['charServer'] && $serverStatus[$groupName][$serverName]['mapServer'];
$statusIcon = $status ? $this->themePath('assets/img/arrow-up.svg') : $this->themePath('assets/img/arrow-down.svg');

$woeSchedule = [
    'woe1' => [
        ['day' => 0, 'start' => '19:00', 'end' => '20:00'], // Domingo
    ],
    'woe2' => [],
];
$isWoeActive = isWoeActive($woeSchedule);
$woeIcon = $isWoeActive ? $this->themePath('assets/img/arrow-up.svg') : $this->themePath('assets/img/arrow-down.svg');

$playersOnline = intval($serverStatus[$groupName][$serverName]['playersOnline']);
?>

<nav class="navbar">
    <div class="line-1">
        <div class="left">
            <a href="/" class="logo">
                <img class="logo-icon" src="<?php echo $logoIcon; ?>" alt="retro-logo"/>
            </a>
        </div>

        <button class="navbar-toggle" type="button" aria-label="Open menu" aria-expanded="false"
                aria-controls="primary-navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="right">
            <div class="server-status-container">
                <span class="text">Server Status: </span>
                <img class="server-status-icon" src="<?php echo $statusIcon; ?>" alt="server-status-icon"/>
            </div>

            <div class="woe-status-container">
                <span class="text">WoE Status: </span>
                <img class="woe-status-icon" src="<?php echo $woeIcon; ?>" alt="woe-status-icon"/>
            </div>

            <a class="players-container" href="<?php echo $whoOnlineUrl; ?>"
               style="text-decoration: none; cursor: pointer;">
                <span class="text">Players Online: </span>
                <span class="players-online-text"><?php echo $playersOnline; ?></span>
            </a>

            <a href="<?php echo $discordUrl; ?>" target="_blank" class="discord-header-container">
                <img class="discord-icon" src="<?php echo $discordIcon; ?>" alt="discord-icon"/>
            </a>
        </div>
    </div>


    <div class="line-2" id="primary-navigation">
        <a class="link-item" href="/">
            Home
        </a>

        <a class="link-item" href="<?php echo $wikiUrl; ?>" target="_blank" rel="noopener">
            Wiki
        </a>

        <a class="link-item" href="<?php echo $downloadUrl; ?>">
            Download
        </a>

        <a class="link-item" href="<?php echo $rankingUrl; ?>">
            Ranking
        </a>

        <a class="link-item" href="<?php echo $donateUrl; ?>">
            Donate
        </a>

        <a class="link-item" href="<?php echo $vendingUrl; ?>">
            Vending
        </a>

        <!-- Information submenu -->
        <div class="nav-item nav-item--has-sub">
            <a class="link-item" href="<?php echo $infoUrl; ?>">
                Information
            </a>

            <div class="submenu" role="menu" aria-label="Database submenu">
                <a href="<?php echo $infoUrl; ?>" role="menuitem">
                    Server
                </a>
                <a href="<?php echo $woeUrl; ?>" role="menuitem">
                    WoE
                </a>

                <a href="<?php echo $castleUrl; ?>" role="menuitem">
                    Castles
                </a>
            </div>
        </div>

        <!-- Database submenu -->
        <div class="nav-item nav-item--has-sub">
            <a class="link-item" href="<?php echo $databaseMonsterUrl; ?>">
                Database
            </a>

            <div class="submenu" role="menu" aria-label="Database submenu">
                <a href="<?php echo $databaseMonsterUrl; ?>" role="menuitem">
                    Monsters
                </a>
                <a href="<?php echo $databaseItemUrl; ?>" role="menuitem">
                    Items
                </a>
            </div>
        </div>

        <!-- Control Panel submenu -->
        <div class="nav-item nav-item--has-sub">
            <a class="link-item" href="<?php echo $isLoggedIn ? $accountUrl : $loginUrl; ?>">
                Control Panel
            </a>

            <div class="submenu" role="menu" aria-label="Control Panel submenu">
                <?php if ($isLoggedIn): ?>
                    <a href="<?php echo $accountUrl; ?>" role="menuitem">
                        View Account
                    </a>
                    <a href="<?php echo $historyUrl; ?>" role="menuitem">
                        History
                    </a>
                    <a href="<?php echo $logoutUrl; ?>" role="menuitem">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="<?php echo $registerUrl; ?>" role="menuitem">
                        Register
                    </a>
                    <a href="<?php echo $loginUrl; ?>" role="menuitem">
                        Login
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Admin Menu -->
        <?php if (!empty($adminMenuItems) && Flux::config('AdminMenuNewStyle')): ?>
            <div class="nav-item nav-item--has-sub">
                <a class="link-item" href="<?php echo $isLoggedIn ? $accountUrl : $loginUrl; ?>">
                    Admin
                </a>

                <div class="submenu" role="menu" aria-label="Admin submenu">
                    <?php foreach ($adminMenuItems as $menuItem): ?>
                        <a href="<?php echo $menuItem['url']; ?>" role="menuitem">
                            <?php echo htmlspecialchars(Flux::message($menuItem['name'])) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

        <?php endif ?>

    </div>

</nav>

<script>
    (function () {
        const navbar = document.querySelector('.navbar');
        const toggle = document.querySelector('.navbar-toggle');

        if (!navbar || !toggle) return;

        toggle.addEventListener('click', function () {
            const isOpen = navbar.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            toggle.setAttribute('aria-label', isOpen ? 'Close menu' : 'Open menu');

            if (!isOpen) {
                navbar.querySelectorAll('.nav-item--has-sub.is-open').forEach(function (item) {
                    item.classList.remove('is-open');
                });
            }
        });

        navbar.querySelectorAll('.nav-item--has-sub > .link-item').forEach(function (link) {
            link.addEventListener('click', function (event) {
                if (!window.matchMedia('(max-width: 900px)').matches) return;

                event.preventDefault();

                const item = link.parentElement;
                const shouldOpen = !item.classList.contains('is-open');

                navbar.querySelectorAll('.nav-item--has-sub.is-open').forEach(function (openItem) {
                    openItem.classList.remove('is-open');
                });

                if (shouldOpen) {
                    item.classList.add('is-open');
                }
            });
        });
    }());
</script>
