<?php if (!defined('FLUX_ROOT')) exit; ?>

<?php
$itemsSafe = array(
    array(
        'title' => 'Full Client',
        'desc' => 'Complete client for first-time installation.',
        'links' => array(
            array(
                'label' => 'Google Drive',
                'href' => 'https://drive.google.com/file/d/1dzQK6gaNVp4Ejjs9EBl4tV1mzr-iwzJc/view?usp=sharing',
            ),
            array(
                'label' => 'MediaFire',
                'href' => 'https://www.mediafire.com/file/ri4nj1d3xtwes8a/RetRO_Setup.exe/file',
            ),
        ),
        'tag' => 'Recommended'
    ),
    array(
        'title' => 'Minimum Patcher Client',
        'desc' => 'Minimum installation package if you already have the required game files.',
        'links' => array(
            array(
                'label' => 'Google Drive',
                'href' => 'https://drive.google.com/file/d/1IaJZTk-Vldwe99jmW6Qo4VDdtUZbHvmo/view?usp=sharing',
            )
        ),
        'tag' => 'Patcher'
    ),
    array(
        'title' => 'BGM Folder',
        'desc' => 'Optional BGM folder for fixing in-game audio issues.',
        'links' => array(
            array(
                'label' => 'Google Drive',
                'href' => 'https://drive.google.com/file/d/1lgJBEOICrXCtyY_GkAdnygXL3rH2gOnf/view?usp=sharing',
            )
        ),
        'tag' => 'Optional'
    ),
    array(
        'title' => 'Base GRF Files',
        'desc' => 'GRF files for fixing missing sprites, textures, or visual glitches.',
        'links' => array(
            array(
                'label' => 'Google Drive',
                'href' => 'https://drive.google.com/file/d/1DS0kPp4IhWBtLPdQ_CUp0vixj6Qea9QA/view?usp=sharing',
            )
        ),
        'tag' => 'Fix'
    )
);

$discordSafe = 'https://discord.gg/2Vwnc6Vjtz';

function dl_tag_to_class($tag)
{
    $t = strtolower((string)$tag);
    if ($t === 'recommended') return 'dl2-pill dl2-pill--gold';
    if ($t === 'patcher') return 'dl2-pill dl2-pill--blue';
    if ($t === 'optional') return 'dl2-pill dl2-pill--slate';
    if ($t === 'fix' || $t === 'files') return 'dl2-pill dl2-pill--green';
    return 'dl2-pill';
}

function dl_title_to_icon($title)
{
    $t = strtolower((string)$title);
    if (strpos($t, 'full') !== false || strpos($t, 'client') !== false) return '⬇️';
    if (strpos($t, 'patcher') !== false || strpos($t, 'thor') !== false) return '🛡️';
    if (strpos($t, 'bgm') !== false || strpos($t, 'music') !== false) return '🎵';
    if (strpos($t, 'grf') !== false) return '🧩';
    return '📦';
}

function dl_links_normalize($it)
{
    $links = array();

    if (isset($it['links']) && is_array($it['links'])) {
        foreach ($it['links'] as $lnk) {
            if (!is_array($lnk)) continue;
            $label = isset($lnk['label']) ? trim((string)$lnk['label']) : '';
            $href = isset($lnk['href']) ? trim((string)$lnk['href']) : '';
            if ($href === '') continue;
            if ($label === '') $label = 'Download';
            $links[] = array('label' => $label, 'href' => $href);
        }
    }

    // Backwards compatibility: single href on root
    if (empty($links) && isset($it['href'])) {
        $href = trim((string)$it['href']);
        if ($href !== '') {
            $links[] = array('label' => 'Download', 'href' => $href);
        }
    }

    return $links;
}

?>

<link rel="stylesheet" href="<?php echo $this->themePath('css/download.css') ?>"/>

<div class="dl2">
    <aside class="dl2-side">
        <div class="dl2-side__title">
            <div class="dl2-logo" aria-hidden="true">R</div>
            <div>
                <h2 class="dl2-h2">Download Center</h2>
                <p class="dl2-sub">Everything you need to play RetRO.</p>
            </div>
        </div>

        <div class="dl2-box">
            <div class="dl2-box__head">Quick install</div>
            <ol class="dl2-steps">
                <li><strong>Full Client</strong> → extract (ex: <code>C:\RetRO</code>)</li>
                <li>Run <strong>Patcher RetRO.exe</strong> (updates)</li>
                <li>Open the game and log in</li>
            </ol>
        </div>

        <?php if (!empty($discordSafe)): ?>
            <a class="dl2-discord"
               href="<?php echo htmlspecialchars($discordSafe) ?>"
               target="_blank" rel="noopener">
                <span class="dl2-discord__icon" aria-hidden="true">💬</span>
                <span class="dl2-discord__text">
                    <strong>Need help?</strong><br>
                    Join our Discord
                </span>
            </a>
        <?php endif; ?>

        <div class="dl2-alert">
            <div class="dl2-alert__icon" aria-hidden="true">⚠️</div>
            <div class="dl2-alert__text">
                Some files like <code>Patcher RetRO.exe</code> may trigger antivirus warnings.
                Add your game folder to exceptions.
            </div>
        </div>
    </aside>

    <main class="dl2-main">
        <div class="dl2-main__head">
            <h3 class="dl2-h3">Downloads</h3>
            <div class="dl2-main__hint">Pick a mirror (opens in a new tab).</div>
        </div>

        <?php if (empty($itemsSafe)): ?>
            <div class="dl2-empty">
                <div class="dl2-empty__title">No downloads available</div>
                <div class="dl2-empty__desc">
                    Configure the <code>$itemsSafe</code> array inside <code>modules/download/index.php</code>.
                </div>
            </div>
        <?php else: ?>
            <div class="dl2-list" role="list">
                <?php foreach ($itemsSafe as $it): ?>
                    <?php
                    $title = isset($it['title']) ? (string)$it['title'] : 'Download';
                    $desc = isset($it['desc']) ? (string)$it['desc'] : '';
                    $tag = isset($it['tag']) ? (string)$it['tag'] : '';

                    $pill = dl_tag_to_class($tag);
                    $icon = dl_title_to_icon($title);
                    $isRecommended = (strtolower($tag) === 'recommended');

                    $links = dl_links_normalize($it);
                    $hasLinks = !empty($links);
                    ?>

                    <article class="dl2-item<?php echo $isRecommended ? ' is-recommended' : '' ?>" role="listitem">
                        <div class="dl2-item__icon" aria-hidden="true"><?php echo $icon ?></div>

                        <div class="dl2-item__body">
                            <div class="dl2-item__top">
                                <div class="dl2-item__title"><?php echo htmlspecialchars($title) ?></div>
                                <?php if ($tag !== ''): ?>
                                    <span class="<?php echo $pill; ?>"><?php echo htmlspecialchars($tag) ?></span>
                                <?php endif; ?>
                            </div>

                            <?php if ($desc !== ''): ?>
                                <div class="dl2-item__desc"><?php echo htmlspecialchars($desc) ?></div>
                            <?php endif; ?>

                            <div class="dl2-links">
                                <?php if ($hasLinks): ?>
                                    <?php foreach ($links as $lnk): ?>
                                        <a class="dl2-link"
                                           href="<?php echo htmlspecialchars($lnk['href']) ?>"
                                           target="_blank" rel="noopener">
                                            <span
                                                class="dl2-link__label"><?php echo htmlspecialchars($lnk['label']) ?></span>
                                            <span class="dl2-link__arrow" aria-hidden="true">↗</span>
                                        </a>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="dl2-links__empty">
                                        Links unavailable.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</div>
