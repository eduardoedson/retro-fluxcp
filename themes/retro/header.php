<?php if (!defined('FLUX_ROOT')) exit; ?>

<?php
$background = $this->themePath('assets/img/background.png');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo $this->themePath('assets/img/favicon.ico') ?>" type="image/x-icon">

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo $this->themePath('assets/css/button.css') ?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo $this->themePath('assets/css/checkbox.css') ?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo $this->themePath('assets/css/footer.css') ?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo $this->themePath('assets/css/input.css') ?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo $this->themePath('assets/css/main.css') ?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo $this->themePath('assets/css/radio.css') ?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo $this->themePath('assets/css/recaptcha.css') ?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo $this->themePath('assets/css/select.css') ?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo $this->themePath('assets/css/table.css') ?>" type="text/css"/>

    <link rel="stylesheet" href="<?php echo $this->themePath('assets/css/main/index.css') ?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo $this->themePath('assets/css/main/menu_bar.css') ?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo $this->themePath('assets/css/main/navbar.css') ?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo $this->themePath('assets/css/main/pagemenu.css') ?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo $this->themePath('assets/css/main/submenu.css') ?>" type="text/css"/>

    <link rel="stylesheet" href="<?php echo $this->themePath('assets/css/service/download.css') ?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo $this->themePath('assets/css/service/tos.css') ?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo $this->themePath('assets/css/responsive.css') ?>" type="text/css"/>


    <!-- Scripts -->
    <?php if (Flux::config('EnableReCaptcha')): ?>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php endif ?>

    <script type="text/javascript" src="<?php echo $this->themePath('js/jquery-1.8.3.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo $this->themePath('js/flux.datefields.js') ?>"></script>
    <script type="text/javascript" src="<?php echo $this->themePath('js/flux.unitip.js') ?>"></script>

    <?php if (isset($metaRefresh)): ?>
        <meta http-equiv="refresh"
              content="<?php echo $metaRefresh['seconds'] ?>; URL=<?php echo $metaRefresh['location'] ?>"/>
    <?php endif ?>

    <title>
        <?php echo Flux::config('SiteTitle');
        if (isset($title)) echo ": $title" ?>
    </title>
</head>

<body>
<?php include $this->themePath('main/navbar.php', true) ?>
<?php
$bannerUrl = $this->themePath('assets/img/background.png');
?>

<div id="wrapper">
    <div class="banner-container">
        <img class="banner-img" src="<?php echo $bannerUrl; ?>" alt="discord-icon"/>
    </div>

    <div class="pages-wrapper">
        <?php include $this->themePath('main/submenu.php', true) ?>
        <?php include $this->themePath('main/pagemenu.php', true) ?>


        <!-- Messages -->
        <?php if ($message = $session->getMessage()): ?>
            <p class="message"><?php echo htmlspecialchars($message) ?></p>
        <?php endif ?>


        <script>
            $(document).ready(function () {
                $('.money-input').keyup(function () {
                    var creditValue = parseInt($(this).val() / <?php echo Flux::config('CreditExchangeRate') ?>, 10);
                    if (isNaN(creditValue))
                        $('.credit-input').val('?');
                    else
                        $('.credit-input').val(creditValue);
                }).keyup();
                $('.credit-input').keyup(function () {
                    var moneyValue = parseFloat($(this).val() * <?php echo Flux::config('CreditExchangeRate') ?>);
                    if (isNaN(moneyValue))
                        $('.money-input').val('?');
                    else
                        $('.money-input').val(moneyValue.toFixed(2));
                }).keyup();

                // In: js/flux.datefields.js
                processDateFields();
            });

            function reload() {
                window.location.href = '<?php echo $this->url ?>';
            }

            function refreshSecurityCode(imgSelector) {
                const spinner = new Image();
                spinner.src = '<?php echo $this->themePath('img/spinner.gif') ?>';

                $(imgSelector).attr('src', spinner.src);

                const clean = <?php echo Flux::config('UseCleanUrls') ? 'true' : 'false' ?>;
                const image = new Image();
                image.src = "<?php echo $this->url('captcha') ?>" + (clean ? '?nocache=' : '&nocache=') + Math.random();

                $(imgSelector).attr('src', image.src);
            }


            function toggleSearchForm() {
                $('.search-form').slideToggle('fast');
            }

            function setCookie(key, value) {
                const expires = new Date();
                expires.setTime(expires.getTime() + expires.getTime()); // never expires
                document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
            }
        </script>
