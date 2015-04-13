<?php

include_once("esportscoverageapi.class.php");

$api = new CEsportsCoverageAPI("your esportscoverage stream key");


if (!empty($_POST['eventid'])) {
    if (!$api->SetEvent($_POST['eventid'])) {
        die("something went wrong");
    }
}

if (!empty($_POST['player1name']) && !empty($_POST['player2name'])) {
    if (!$api->SetCurrentPlayers($_POST['player1name'], $_POST['player2name'])) {
        die("something went wrong");
    }
}

$details = $api->GetStreamDetails();
$currentevent = $details->event_id;

$events = $api->ListEventNames(C_GAME_SC2);

?>
<div>
    <div>Stream: <b><?= $details->streamname; ?></b></div>

    <form method="post">
        Event: <select id="eventid" name="eventid">
<?php
    foreach($events as $eventid => $eventname) {
            if ($currentevent == $eventid) {
                echo "<option value='$eventid' selected>" . htmlentities($eventname) . "</option>";
            } else {
                echo "<option value='$eventid'>" . htmlentities($eventname) . "</option>";
            }
    }
?>
            </select>
            <input type="submit" />
    </form>

    <form method="post">
        Player1: <input name="player1name" id="player1name" value="<?= $details->player1->actualname;?>"><br />
        Player2: <input name="player2name" id="player2name" value="<?= $details->player2->actualname;?>"><br />
        <input type="submit" />
    </form>
</div>
