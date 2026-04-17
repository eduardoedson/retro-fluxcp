<?php if (!defined('FLUX_ROOT')) exit; ?>
<?php if (!empty($errorMessage)): ?>
    <p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php endif ?>

<form action="<?php echo $this->urlWithQs ?>" method="post" class="content__form">
    <?php if (count($serverNames) > 1): ?>

        <select name="login" id="login"<?php if (count($serverNames) === 1) echo ' disabled="disabled"' ?>>
            <?php foreach ($serverNames as $serverName): ?>
                <option
                    value="<?php echo htmlspecialchars($serverName) ?>"<?php if ($params->get('server') == $serverName) echo ' selected="selected"' ?>><?php echo htmlspecialchars($serverName) ?></option>
            <?php endforeach ?>
        </select>
    <?php endif ?>
    <input type="text" name="userid" id="userid" class="custom-input"
           placeholder="<?php echo htmlspecialchars(Flux::message('ResetPassAccountLabel')) ?>"/>
    <input type="text" name="email" id="email" class="custom-input"
           placeholder="<?php echo htmlspecialchars(Flux::message('ResetPassEmailLabel')) ?>"/>
    <input type="submit" class="btn-primary"
           value="<?php echo htmlspecialchars(Flux::message('ResetPassButton')) ?>"/>
</form>
