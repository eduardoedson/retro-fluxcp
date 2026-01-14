<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2><?php echo htmlspecialchars(Flux::message('Trade Log')) ?></h2>
<form action="" method="get">
    <input type="hidden" name="module" value="<?php echo htmlspecialchars($params->get('module')) ?>">
    <input type="hidden" name="action" value="<?php echo htmlspecialchars($params->get('action')) ?>">
    <input type="text" name="search_char" value="<?php echo htmlspecialchars($searchChar) ?>" placeholder="Search by Character">
	<input type="text" name="search_nameid" value="<?php echo htmlspecialchars($searchnameid) ?>" placeholder="Search by Item ID">
    <input type="text" name="search_unique_id" value="<?php echo htmlspecialchars($searchUniqueID) ?>" placeholder="Search by Unique ID">
    <input type="text" name="search_Date" value="<?php echo htmlspecialchars($search_Date) ?>" placeholder="Search by Date">
    <input type="submit" value="Search">
</form>


<?php if ($picks): ?>
    <?php echo $paginator->infoText() ?>
    <table class="horizontal-table">
        <tr>
            <th><?php echo $paginator->sortableColumn('time', Flux::message('PickLogDateLabel')) ?></th>
            <th><?php echo $paginator->sortableColumn('char_id', Flux::message('PickLogCharacterLabel')) ?></th>
            <th><?php echo $paginator->sortableColumn('type', Flux::message('PickLogTypeLabel')) ?></th>
			<th><?php echo $paginator->sortableColumn('nameid', Flux::message('PickLogItemLabel')) ?></th>
            <th><?php echo $paginator->sortableColumn('nameid', Flux::message('Item ID')) ?></th>
            <th><?php echo $paginator->sortableColumn('amount', Flux::message('PickLogAmountLabel')) ?></th>
            <th><?php echo $paginator->sortableColumn('refine', Flux::message('PickLogRefineLabel')) ?></th>
            <th><?php echo $paginator->sortableColumn('card0', Flux::message('PickLogCard0Label')) ?></th>
            <th><?php echo $paginator->sortableColumn('card1', Flux::message('PickLogCard1Label')) ?></th>
            <th><?php echo $paginator->sortableColumn('card2', Flux::message('PickLogCard2Label')) ?></th>
            <th><?php echo $paginator->sortableColumn('card3', Flux::message('PickLogCard3Label')) ?></th>
			<th><?php echo $paginator->sortableColumn('Options', Flux::message('Options')) ?></th>
            <th><?php echo $paginator->sortableColumn('map', Flux::message('PickLogMapLabel')) ?></th>
			<th><?php echo $paginator->sortableColumn('unique_id', Flux::message('unique_id')) ?></th>
        </tr>
        <?php foreach ($picks as $pick): ?>
		<td align="right"><?php echo $this->formatDateTime($pick->time) ?></td>
		<td>
			<?php if ($pick->char_name): ?>
				<?php if ($pick->type == 'M' || $pick->type == 'L'): ?>
					<?php if ($auth->actionAllowed('monster', 'view')): ?>
						<em><?php echo $this->linkToMonster($pick->char_id, $pick->char_name) ?></em>
					<?php else: ?>
						<em><?php echo htmlspecialchars($pick->char_name) ?></em>
					<?php endif ?>
				<?php else: ?>
					<?php if ($auth->actionAllowed('character', 'view') && $auth->allowedToViewCharacter): ?>
						<strong><?php echo $this->linkToCharacter($pick->char_id, $pick->char_name) ?></strong>
					<?php else: ?>
						<strong><?php echo htmlspecialchars($pick->char_name) ?></strong>	
					<?php endif ?>
				<?php endif ?>
			<?php elseif ($pick->char_id): ?>
				<?php if ($pick->type == 'M' || $pick->type == 'L'): ?>
					<?php if ($auth->actionAllowed('monster', 'view')): ?>
						<em><?php echo $this->linkToMonster($pick->char_id, $pick->char_id) ?></em>
					<?php else: ?>
						<em><?php echo htmlspecialchars($pick->char_id) ?></em>
					<?php endif ?>
				<?php else: ?>
					<?php if ($auth->actionAllowed('character', 'view') && $auth->allowedToViewCharacter): ?>
						<strong><?php echo $this->linkToCharacter($pick->char_id, $pick->char_id) ?></strong>
					<?php else: ?>
						<strong><?php echo htmlspecialchars($pick->char_id) ?></strong>	
					<?php endif ?>
				<?php endif ?>
			<?php else: ?>
				<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('UnknownLabel')) ?></span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($pick->pick_type): ?>
				<?php echo htmlspecialchars($pick->pick_type) ?>
			<?php elseif ($pick->type): ?>
				<?php echo $pick->type ?>
			<?php else: ?>
				<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('UnknownLabel')) ?></span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($pick->nameid): ?>
				<?php echo htmlspecialchars(basename($pick->nameid,)) ?>
			<?php else: ?>
				<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('UnknownLabel')) ?></span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($pick->item_name): ?>
				<?php if ($auth->actionAllowed('item', 'view')): ?>
					<?php echo $this->linkToItem($pick->nameid, $pick->item_name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($pick->item_name) ?>
				<?php endif ?>
			<?php elseif ($pick->nameid): ?>
				<?php if ($auth->actionAllowed('item', 'view')): ?>
					<?php echo $this->linkToItem($pick->nameid, $pick->nameid) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($pick->nameid) ?>
				<?php endif ?>
			<?php else: ?>
				<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('UnknownLabel')) ?></span>
			<?php endif ?>
		</td>
		<td><?php echo $pick->amount >= 0 ? '+'.number_format($pick->amount) : number_format($pick->amount) ?></td>
		<td><?php echo $pick->refine ?></td>
		<!-- Slot 1 -->
		<td>
			<?php if ($pick->card0_name): ?>
				<?php if ($auth->actionAllowed('item', 'view')): ?>
					<?php echo $this->linkToItem($pick->card0, $pick->card0_name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($pick->card0_name) ?>
				<?php endif ?>
			<?php elseif ($pick->card0): ?>
				<?php if ($auth->actionAllowed('item', 'view')): ?>
					<?php echo $this->linkToItem($pick->card0, $pick->card0) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($pick->card0) ?>
				<?php endif ?>
			<?php else: ?>
				<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('NoneLabel')) ?></span>
			<?php endif ?>
		</td>
		<!-- Slot 2 -->
		<td>
			<?php if ($pick->card1_name): ?>
				<?php if ($auth->actionAllowed('item', 'view')): ?>
					<?php echo $this->linkToItem($pick->card1, $pick->card1_name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($pick->card1_name) ?>
				<?php endif ?>
			<?php elseif ($pick->card1): ?>
				<?php if ($auth->actionAllowed('item', 'view')): ?>
					<?php echo $this->linkToItem($pick->card1, $pick->card1) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($pick->card1) ?>
				<?php endif ?>
			<?php else: ?>
				<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('NoneLabel')) ?></span>
			<?php endif ?>
		</td>
		<!-- Slot 3 -->
		<td>
			<?php if ($pick->card2_name): ?>
				<?php if ($auth->actionAllowed('item', 'view')): ?>
					<?php echo $this->linkToItem($pick->card2, $pick->card2_name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($pick->card2_name) ?>
				<?php endif ?>
			<?php elseif ($pick->card2): ?>
				<?php if ($auth->actionAllowed('item', 'view')): ?>
					<?php echo $this->linkToItem($pick->card2, $pick->card2) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($pick->card2) ?>
				<?php endif ?>
			<?php else: ?>
				<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('NoneLabel')) ?></span>
			<?php endif ?>
		</td>
		<!-- Slot 4 -->
		<td>
			<?php if ($pick->card3_name): ?>
				<?php if ($auth->actionAllowed('item', 'view')): ?>
					<?php echo $this->linkToItem($pick->card3, $pick->card3_name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($pick->card3_name) ?>
				<?php endif ?>
			<?php elseif ($pick->card3): ?>
				<?php if ($auth->actionAllowed('item', 'view')): ?>
					<?php echo $this->linkToItem($pick->card3, $pick->card3) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($pick->card3) ?>
				<?php endif ?>
			<?php else: ?>
				<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('NoneLabel')) ?></span>
			<?php endif ?>
		</td>
<td>
    <?php
    $options = [
        2 => 'SP',
        3 => 'STR',
        4 => 'AGI',
        5 => 'VIT',
        6 => 'INT',
        7 => 'DEX',
        8 => 'LUK'
    ];

    $optionNames = [];
    if ($pick->option_id0) {
        $optionNames[] = $options[$pick->option_id0];
    }

    if (empty($optionNames)) {
        echo Flux::message('NoneLabel');
    } else {
        echo implode(', ', $optionNames);
        if ($pick->option_val0) {
            echo ' + ' . htmlspecialchars($pick->option_val0);
        }
    }
    ?>
</td>

		<td>
			<?php if ($pick->map): ?>
				<?php echo htmlspecialchars(basename($pick->map, '.gat')) ?>
			<?php else: ?>
				<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('UnknownLabel')) ?></span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($pick->unique_id): ?>
				<?php echo htmlspecialchars(basename($pick->unique_id,)) ?>
			<?php else: ?>
				<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('UnknownLabel')) ?></span>
			<?php endif ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>
	<?php echo htmlspecialchars(Flux::message('PickLogNotFound')) ?>
	<a href="javascript:history.go(-1)"><?php echo htmlspecialchars(Flux::message('GoBackLabel')) ?></a>
</p>
<?php endif ?>
