<?php if (!defined('FLUX_ROOT')) exit; ?>

<?php
$downloadIcon = $this->themePath('assets/img/download-icon.svg');
$downloadUrl = $this->url('service', 'download');

$isLoggedIn = isset($session) && method_exists($session, 'isLoggedIn') && $session->isLoggedIn();
$panelIcon = $this->themePath('assets/img/panel-icon.svg');
$panelUrl = $isLoggedIn ? $this->url('account', 'view') : $this->url('account', 'login');

$wikiIcon = $this->themePath('assets/img/wiki-icon.svg');
$wikiUrl = '/wiki';

$voteIcon = $this->themePath('assets/img/vote-icon.svg');
$voteUrl = 'https://ratemyserver.net/index.php?page=detailedlistserver&preview=1&serid=23227&url_sname=RetRO';
?>


<div class="menu-bar">
    <a href="<?php echo $downloadUrl; ?>" class="menu-item">
        <img class="download-icon" src="<?php echo $downloadIcon; ?>" alt="download-icon"/>
        <div class="text-container">
            <span class="title">Download</span>
            <span class="desc">Official client, always up to date</span>
        </div>
    </a>

    <a href="<?php echo $panelUrl; ?>" class="menu-item">
        <img class="panel-icon" src="<?php echo $panelIcon; ?>" alt="panel-icon"/>
        <div class="text-container">
            <span class="title">Control Panel</span>
            <span class="desc">Manage your account and characters</span>
        </div>
    </a>

    <a href="<?php echo $wikiUrl; ?>" target="_blank" class="menu-item">
        <img class="wiki-icon" src="<?php echo $wikiIcon; ?>" alt="wiki-icon"/>
        <div class="text-container">
            <span class="title">Wiki</span>
            <span class="desc">Complete guides and server information</span>
        </div>
    </a>

    <a href="<?php echo $voteUrl; ?>" target="_blank" class="menu-item">
        <img class="vote-icon" src="<?php echo $voteIcon; ?>" alt="vote-icon"/>
        <div class="text-container">
            <span class="title">Review on RMS</span>
            <span class="desc">Help us grow by rating on rms</span>
        </div>
    </a>
</div>
