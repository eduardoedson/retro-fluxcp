<?php if (!defined('FLUX_ROOT')) exit; ?>
<?php
$info = array(
    'accounts' => 0,
    'characters' => 0,
    'guilds' => 0,
    'parties' => 0,
    'zeny' => 0,
);

// Accounts.
$sql = "SELECT COUNT(account_id) AS total FROM {$server->loginDatabase}.login WHERE sex != 'S' ";
if (Flux::config('HideTempBannedStats')) {
    $sql .= "AND unban_time <= UNIX_TIMESTAMP() ";
}
if (Flux::config('HidePermBannedStats')) {
    if (Flux::config('HideTempBannedStats')) {
        $sql .= "AND state != 5 ";
    } else {
        $sql .= "AND state != 5 ";
    }
}
$sth = $server->connection->getStatement($sql);
$sth->execute();
$info['accounts'] += $sth->fetch()->total;

// Characters.
$sql = "SELECT COUNT(`char`.char_id) AS total FROM {$server->charMapDatabase}.`char` ";
if (Flux::config('HideTempBannedStats')) {
    $sql .= "LEFT JOIN {$server->loginDatabase}.login ON login.account_id = `char`.account_id ";
    $sql .= "WHERE login.unban_time <= UNIX_TIMESTAMP()";
}
if (Flux::config('HidePermBannedStats')) {
    if (Flux::config('HideTempBannedStats')) {
        $sql .= " AND login.state != 5";
    } else {
        $sql .= "LEFT JOIN {$server->loginDatabase}.login ON login.account_id = `char`.account_id ";
        $sql .= "WHERE login.state != 5";
    }
}
$sth = $server->connection->getStatement($sql);
$sth->execute();
$info['characters'] += $sth->fetch()->total;

// Guilds.
$sql = "SELECT COUNT(guild_id) AS total FROM {$server->charMapDatabase}.guild";
$sth = $server->connection->getStatement($sql);
$sth->execute();
$info['guilds'] += $sth->fetch()->total;

// Parties.
$sql = "SELECT COUNT(party_id) AS total FROM {$server->charMapDatabase}.party";
$sth = $server->connection->getStatement($sql);
$sth->execute();
$info['parties'] += $sth->fetch()->total;

// Zeny.
$bind = array();
$sql = "SELECT SUM(`char`.zeny) AS total FROM {$server->charMapDatabase}.`char` ";
if ($hideGroupLevel = Flux::config('InfoHideZenyGroupLevel')) {
    $sql .= "LEFT JOIN {$server->loginDatabase}.login ON login.account_id = `char`.account_id ";

    $groups = AccountLevel::getGroupID($hideGroupLevel, '<');
    if (!empty($groups)) {
        $ids = implode(', ', array_fill(0, count($groups), '?'));
        $sql .= "WHERE login.group_id IN ($ids) ";
        $bind = array_merge($bind, $groups);
    }
}
if (Flux::config('HideTempBannedStats')) {
    if ($hideGroupLevel) {
        $sql .= " AND unban_time <= UNIX_TIMESTAMP()";
    } else {
        $sql .= "LEFT JOIN {$server->loginDatabase}.login ON login.account_id = `char`.account_id ";
        $sql .= "WHERE unban_time <= UNIX_TIMESTAMP()";
    }
}
if (Flux::config('HidePermBannedStats')) {
    if ($hideGroupLevel || Flux::config('HideTempBannedStats')) {
        $sql .= " AND state != 5";
    } else {
        $sql .= "LEFT JOIN {$server->loginDatabase}.login ON login.account_id = `char`.account_id ";
        $sql .= "WHERE state != 5";
    }
}

$sth = $server->connection->getStatement($sql);
$sth->execute($hideGroupLevel ? $bind : array());
$info['zeny'] += $sth->fetch()->total;
?>

<div class="section-1">
    <?php include $this->themePath('main/menu_bar.php', true) ?>

    <div class="content">
        <div class="left">
            <div class="server-description">
                <h3 class="title" style="margin-top: 0">RetRO – Where Ragnarok Begins Again</h3>
                <div class="divider"></div>
                <span class="desc">
                    a classic Ragnarok Online server designed for players who value nostalgia, balance, and long-term progression. Our goal is to recreate the authentic Ragnarok experience while introducing carefully selected quality-of-life improvements that respect the original gameplay.
                </span>
            </div>
            <div class="server-info-container">
                <h3 class="title">Information</h3>
                <div class="divider"></div>

                <div class="information-wrapper">
                    <div class="left">
                        <div class="item">
                            <span class="title">Max Level</span>
                            <span class="desc">99/70</span>
                        </div>

                        <div class="item">
                            <span class="title">Max Stats Normal/Baby</span>
                            <span class="desc">99</span>
                        </div>

                        <div class="item">
                            <span class="title">Exp Rates</span>
                            <span class="desc">5x</span>
                        </div>

                        <div class="item">
                            <span class="title">Normal Monster Drops</span>
                            <span class="desc">5x</span>
                        </div>

                        <div class="item">
                            <span class="title">MvP Drops</span>
                            <span class="desc">3x</span>
                        </div>

                        <div class="item">
                            <span class="title">MvP and Mini-Boss Card Drops</span>
                            <span class="desc">1x</span>
                        </div>
                    </div>
                    <div class="right">
                        <div class="item">
                            <span class="title">Instant Cast</span>
                            <span class="desc">150 dex</span>
                        </div>

                        <div class="item">
                            <span class="title">Max Attack Speed</span>
                            <span class="desc">193</span>
                        </div>

                        <div class="item">
                            <span class="title">Multi Client</span>
                            <span class="desc">Unlimited</span>
                        </div>

                        <div class="item">
                            <span class="title">Server Language</span>
                            <span class="desc">English</span>
                        </div>

                        <div class="item">
                            <span class="title">Emulator</span>
                            <span class="desc">rAthena</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="right">
            <div class="timezone-container">
                <h3 class="title" style="margin-top: 0">Server Time</h3>
                <div class="divider"></div>
                <div class="timezone" id="utc-0" style="background-color: #0B7AD1">
                    <div class="dates-container">
                        <span class="date-label"></span>
                        <spbcan class="timezone-label"></spbcan>
                    </div>
                    <span class="time-label"></span>
                </div>

                <h3 class="title" style="margin-top: 0">Timezones</h3>
                <div class="divider"></div>
                <div class="timezone" id="utc-8" style="background-color: #1F6F8B">
                    <div class="dates-container">
                        <span class="date-label"></span>
                        <span class="timezone-label"></span>
                    </div>
                    <span class="time-label"></span>
                </div>

                <div class="timezone" id="utc-5" style="background-color: #9E2A2B">
                    <div class="dates-container">
                        <span class="date-label"></span>
                        <span class="timezone-label"></span>
                    </div>
                    <span class="time-label"></span>
                </div>

                <div class="timezone" id="utc-3" style="background-color: #D97706">
                    <div class="dates-container">
                        <span class="date-label"></span>
                        <span class="timezone-label"></span>
                    </div>
                    <span class="time-label"></span>
                </div>

                <div class="timezone" id="utc-7" style="background-color: #F97316">
                    <div class="dates-container">
                        <span class="date-label"></span>
                        <span class="timezone-label"></span>
                    </div>
                    <span class="time-label"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-2">
    <div class="infos-wrapper">
        <div class="info info-accounts" style="background-color: #E04B4B">
            <span class="title">Accounts</span>
            <span class="value"><?php echo $info['accounts']; ?></span>
        </div>
        <div class="info info-characters" style="background-color: #19B86B">
            <span class="title">Characters</span>
            <span class="value"><?php echo $info['characters']; ?></span>
        </div>
        <div class="info info-guilds" style="background-color: #FDDB43">
            <span class="title">Guilds</span>
            <span class="value"><?php echo $info['guilds']; ?></span>
        </div>
        <div class="info info-parties" style="background-color: #3A8FE6">
            <span class="title">Parties</span>
            <span class="value"><?php echo $info['parties']; ?></span>
        </div>
        <div class="info info-zeny" style="background-color: #D4A017">
            <span class="title">Zeny</span>
            <span class="value"><?php echo $info['zeny']; ?></span>
        </div>
    </div>
</div>

<script>
    startTimezoneClock(document.getElementById('utc-0'), 0);

    startTimezoneClock(document.getElementById('utc-8'), -8);
    startTimezoneClock(document.getElementById('utc-5'), -5);
    startTimezoneClock(document.getElementById('utc-3'), -3);
    startTimezoneClock(document.getElementById('utc-7'), 7);

    function startTimezoneClock(el, utcOffset) {
        if (!el) return;

        const dateLabel = el.querySelector('.date-label');
        const timeLabel = el.querySelector('.time-label');
        const timezoneLabel = el.querySelector('.timezone-label');

        function update() {
            const now = new Date();

            const utcMs = now.getTime() + (now.getTimezoneOffset() * 60000);

            const localDate = new Date(utcMs + utcOffset * 3600000);

            const dateText = new Intl.DateTimeFormat('en-US', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            }).format(localDate);

            const timeText = new Intl.DateTimeFormat('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }).format(localDate);

            dateLabel.textContent = dateText;
            timeLabel.textContent = timeText;
            timezoneLabel.textContent = `UTC ${utcOffset >= 0 ? (utcOffset === 0 ? '' : '+') : ''}${(utcOffset === 0 ? '' : utcOffset)}`;
        }

        update();
        setInterval(update, 60000);
    }

</script>
