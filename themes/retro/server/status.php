<?php if (!defined('FLUX_ROOT')) exit; ?>

<?php
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

        $sql = "SELECT `users` FROM {$athenaServer->charMapDatabase}.cp_onlinepeak";
        $sth = $loginAthenaGroup->connection->getStatement($sql);
        $sth->execute();
        $peak = $sth->fetch();

        $serverStatus[$groupName][$serverName] = array(
            'loginServer' => $loginServerUp,
            'charServer' => $athenaServer->charServer->isUp(),
            'mapServer' => $athenaServer->mapServer->isUp(),
            'playersOnline' => intval($res ? $res->players_online : 0),
            'peakOnline' => intval($peak ? $peak->users : 0),
        );
    }
}
$status = $serverStatus[$groupName][$serverName]['loginServer'] && $serverStatus[$groupName][$serverName]['charServer'] && $serverStatus[$groupName][$serverName]['mapServer'];

$playersOnline = intval($serverStatus[$groupName][$serverName]['playersOnline']);
?>

<h2><?php echo htmlspecialchars(Flux::message('ServerStatusHeading')) ?></h2>
<p><?php echo htmlspecialchars(Flux::message('ServerStatusInfo')) ?></p>
<?php foreach ($serverStatus as $privServerName => $gameServers): ?>
    <h3>Server Status for <?php echo htmlspecialchars($privServerName) ?></h3>
    <table id="server_status">
        <tr>
            <td class="status"><?php echo htmlspecialchars(Flux::message('ServerStatusServerLabel')) ?></td>
            <td class="status"><?php echo htmlspecialchars(Flux::message('ServerStatusLoginLabel')) ?></td>
            <td class="status"><?php echo htmlspecialchars(Flux::message('ServerStatusCharLabel')) ?></td>
            <td class="status"><?php echo htmlspecialchars(Flux::message('ServerStatusMapLabel')) ?></td>
            <td class="status"><?php echo htmlspecialchars(Flux::message('ServerStatusOnlineLabel')) ?></td>
            <?php if (Flux::config('EnablePeakDisplay')): ?>
                <td class="status"><?php echo htmlspecialchars(Flux::message('ServerStatusPeakLabel')) ?></td>
            <?php endif ?>
        </tr>
        <?php foreach ($gameServers as $serverName => $gameServer): ?>
            <tr>
                <th class="server"><?php echo htmlspecialchars($serverName) ?></th>
                <td class="status">
                    <?php echo ($serverStatus[$groupName][$serverName]['loginServer'] == 1) ? 'Online' : 'Offline'; ?>
                </td>
                <td class="status">
                    <?php echo ($serverStatus[$groupName][$serverName]['charServer'] == 1) ? 'Online' : 'Offline'; ?>
                </td>
                <td class="status">
                    <?php echo ($serverStatus[$groupName][$serverName]['mapServer'] == 1) ? 'Online' : 'Offline'; ?>
                </td>
                <td class="status"><?php echo $gameServer['playersOnline'] ?></td>
                <?php if (Flux::config('EnablePeakDisplay')): ?>
                    <td class="status"><?php echo $serverStatus[$groupName][$serverName]['peakOnline'] ?></td>
                <?php endif ?>
            </tr>
        <?php endforeach ?>
    </table>


<?php endforeach ?>
