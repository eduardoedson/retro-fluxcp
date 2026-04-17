<?php if (!defined('FLUX_ROOT')) exit; ?>
<?php

$isLoggedIn = isset($session) && method_exists($session, 'isLoggedIn') && $session->isLoggedIn();

$logoUrl = $this->themePath('assets/img/logo-icon.png');
$discordIcon = $this->themePath('assets/img/discord.svg');

$wikiUrl = '/wiki';
$discordUrl = 'https://discord.gg/2Vwnc6Vjtz';

$downloadUrl = $this->url('service', 'download');
$rankingUrl = $this->url('ranking', 'character');
$donateUrl = $this->url('donate', 'index');
$vendingUrl = $this->url('vending');
$infoUrl = $this->url('server', 'info');
$databaseMonsterUrl = $this->url('monster');
$loginUrl = $this->url('account', 'login');
$accountUrl = $this->url('account', 'view');
?>
</div> <!-- Pages Wrapper -->
</div> <!-- Wrapper -->

<footer class="footer-container">
    <div class="section-1">
        <div class="left">
            <img class="logo" src="<?php echo $logoUrl; ?>" alt="Logo"/>
            <div class="navigation">
                <h3 class="title" style="color: white">Navigation</h3>
                <div class="divider" style="border-bottom: 0.125rem solid white; margin-bottom: 1rem;"></div>
                <ul class="link-list" style="list-style: none">
                    <li><a href="/" style="text-decoration: none; color: white;">Home</a></li>
                    <li><a href="<?php echo $wikiUrl; ?>" style="text-decoration: none; color: white;">Wiki</a></li>
                    <li><a href="<?php echo $downloadUrl; ?>" style="text-decoration: none; color: white;">Download</a>
                    </li>
                    <li><a href="<?php echo $rankingUrl; ?>" style="text-decoration: none; color: white;">Ranking</a>
                    </li>
                    <li><a href="<?php echo $donateUrl; ?>" style="text-decoration: none; color: white;">Donate</a></li>
                    <li><a href="<?php echo $vendingUrl; ?>" style="text-decoration: none; color: white;">Vending</a>
                    </li>
                    <li><a href="<?php echo $infoUrl; ?>" style="text-decoration: none; color: white;">Information</a>
                    </li>
                    <li><a href="<?php echo $databaseMonsterUrl; ?>" style="text-decoration: none; color: white;">Database</a>
                    </li>
                    <li>
                        <a href="<?php echo $isLoggedIn ? $accountUrl : $loginUrl; ?>"
                           style="text-decoration: none; color: white;">Control Panel</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="right">
            <div class="discord-btn-container">
                <a class="discord-oauth-btn" href="<?php echo $discordUrl ?>" target="_blank" rel="noopener"
                   style="text-decoration: none">
                    <svg class="discord-icon" xmlns="http://www.w3.org/2000/svg"
                         width="800px" height="800px" viewBox="0 -28.5 256 256" version="1.1"
                         preserveAspectRatio="xMidYMid">
                        <g>
                            <path
                                d="M216.856339,16.5966031 C200.285002,8.84328665 182.566144,3.2084988 164.041564,0 C161.766523,4.11318106 159.108624,9.64549908 157.276099,14.0464379 C137.583995,11.0849896 118.072967,11.0849896 98.7430163,14.0464379 C96.9108417,9.64549908 94.1925838,4.11318106 91.8971895,0 C73.3526068,3.2084988 55.6133949,8.86399117 39.0420583,16.6376612 C5.61752293,67.146514 -3.4433191,116.400813 1.08711069,164.955721 C23.2560196,181.510915 44.7403634,191.567697 65.8621325,198.148576 C71.0772151,190.971126 75.7283628,183.341335 79.7352139,175.300261 C72.104019,172.400575 64.7949724,168.822202 57.8887866,164.667963 C59.7209612,163.310589 61.5131304,161.891452 63.2445898,160.431257 C105.36741,180.133187 151.134928,180.133187 192.754523,160.431257 C194.506336,161.891452 196.298154,163.310589 198.110326,164.667963 C191.183787,168.842556 183.854737,172.420929 176.223542,175.320965 C180.230393,183.341335 184.861538,190.991831 190.096624,198.16893 C211.238746,191.588051 232.743023,181.531619 254.911949,164.955721 C260.227747,108.668201 245.831087,59.8662432 216.856339,16.5966031 Z M85.4738752,135.09489 C72.8290281,135.09489 62.4592217,123.290155 62.4592217,108.914901 C62.4592217,94.5396472 72.607595,82.7145587 85.4738752,82.7145587 C98.3405064,82.7145587 108.709962,94.5189427 108.488529,108.914901 C108.508531,123.290155 98.3405064,135.09489 85.4738752,135.09489 Z M170.525237,135.09489 C157.88039,135.09489 147.510584,123.290155 147.510584,108.914901 C147.510584,94.5396472 157.658606,82.7145587 170.525237,82.7145587 C183.391518,82.7145587 193.761324,94.5189427 193.539891,108.914901 C193.539891,123.290155 183.391518,135.09489 170.525237,135.09489 Z"
                                fill="#5865F2" fill-rule="nonzero">
                            </path>
                        </g>
                    </svg>
                    <span>Join our Discord</span>
                </a>
            </div>
        </div>
    </div>
    <div class="section-2">
        <span>All other copyrights and trademarks are property of their respective owners</span>
        <span><?php echo date('Y') ?> • Ret-RO. All Rights Reserved</span>
    </div>
</footer>

</body>
</html>
