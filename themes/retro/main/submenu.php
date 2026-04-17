<?php if (!defined('FLUX_ROOT')) exit; ?>

<?php $subMenuItems = $this->getSubMenuItems(); ?>

<?php if (!empty($subMenuItems)): ?>
    <nav class="fc-submenu" aria-label="User menu">
        <span class="fc-submenu-label">Menu</span>

        <div class="fc-submenu-links">
            <?php foreach ($subMenuItems as $menuItem): ?>
                <?php
                $isCurrent =
                    $params->get('module') === $menuItem['module']
                    && $params->get('action') === $menuItem['action'];
                ?>
                <span class="fc-submenu-part">
          <a
              href="<?php echo $this->url($menuItem['module'], $menuItem['action']) ?>"
              class="fc-submenu-link<?php echo $isCurrent ? ' is-current' : '' ?>"
            <?php echo $isCurrent ? 'aria-current="page"' : '' ?>
          >
            <span class="fc-submenu-text">
              <?php echo htmlspecialchars($menuItem['name']) ?>
            </span>
          </a>
        </span>
            <?php endforeach ?>
        </div>
    </nav>
<?php endif ?>
