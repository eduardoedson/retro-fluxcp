<?php if (!defined('FLUX_ROOT')) exit; ?>

<?php if (!empty($pageMenuItems)): ?>
    <nav class="fc-pagemenu" aria-label="Page actions">
    <span class="fc-pagemenu-label">
      <?php echo empty($title) ? 'Actions for this page' : htmlspecialchars($title) ?>
    </span>

        <div class="fc-pagemenu-links">
            <?php foreach ($pageMenuItems as $menuItemName => $menuItemLink): ?>
                <span class="fc-pagemenu-part">
          <a href="<?php echo $menuItemLink ?>" class="fc-pagemenu-link">
            <span class="fc-pagemenu-text"><?php echo htmlspecialchars($menuItemName) ?></span>
          </a>
        </span>
            <?php endforeach ?>
        </div>
    </nav>
<?php endif ?>
