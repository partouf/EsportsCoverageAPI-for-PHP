<?php

include_once("esportscoverageapi.class.php");

$api = new CEsportsCoverageAPI("your esportscoverage stream key");

if (!empty($_POST['player1name']) && !empty($_POST['player2name'])) {
    if (!$api->SetCurrentPlayers($_POST['player1name'], $_POST['player2name'])) {
        die("something went wrong");
    }
}

$details = $api->GetStreamDetails();

?>
Stream: <b><?= $details->streamname; ?></b><br />
<form method="post">
    Player1: <input name="player1name" id="player1name" value="<?= $details->player1->actualname;?>"><br />
    Player2: <input name="player2name" id="player2name" value="<?= $details->player2->actualname;?>"><br />
    <input type="submit" />
</form>
