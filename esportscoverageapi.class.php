<?php


define("C_GAME_UNKNOWN", 0);
define("C_GAME_SC2", 1);
define("C_GAME_BW", 2);
define("C_GAME_DOTA2", 3);
define("C_GAME_LOL", 4);
define("C_GAME_CSGO", 5);
define("C_GAME_HEARTHSTONE", 6);
define("C_GAME_HEROES", 7);


/**
 * Class CEsportsCoverageAPI
 */
class CEsportsCoverageAPI {
    protected $mainurl = "http://esportscoverage.net/ajax.php";
    protected $streamkey = "";

    protected $lastresult = false;

    public function __construct($streamkey) {
        $this->streamkey = $streamkey;
    }

    public function GetLastResult() {
        return $this->lastresult;
    }

    /**
     * @param string $page
     * @param string $function
     * @param bool|array $extraparams
     * @return mixed
     */
    protected function execCommand($page, $function, $extraparams = false) {
        $url = $this->mainurl . "?nohtml=1&action=" . urlencode($page) . "&func=" . urlencode($function) . "&key=" . urlencode($this->streamkey);
        if ($extraparams) {
            foreach ($extraparams as $k => $v) {
                $url .= "&" . urlencode($k) . "=" . urlencode($v);
            }
        }

        $data = file_get_contents($url);
        $result = @json_decode($data);

        $this->lastresult = $result;

        return $result;
    }

    /**
     * @return mixed
     */
    public function GetStreamDetails() {
        $arrResult = $this->execCommand("streamdetails", "GetCurrentMatchInfoArr");

        return $arrResult->result;
    }

    /** Sets the playernames for the stream, requires key
     * @param string $player1name
     * @param string $player2name
     * @param int $player1score
     * @param int $player2score
     * @return mixed
     */
    public function SetCurrentPlayers($player1name, $player2name, $player1score = 0, $player2score = 0) {
        $extradata = array("player1" => $player1name, "player2" => $player2name, "score1" => $player1score, "score2" => $player2score);
        $arrResult = $this->execCommand("streamdetails", "setPlayers", $extradata);

        return ($arrResult && ($arrResult->result == "OK"));
    }

    /** Sets the score for this stream, requires key
     * @param int $player1score
     * @param int $player2score
     */
    public function SetCurrentScore($player1score, $player2score) {
        $extradata = array("score1" => $player1score, "score2" => $player2score);
        $arrResult = $this->execCommand("streamdetails", "setPlayerScore", $extradata);

        return ($arrResult && ($arrResult->result == "OK"));
    }

    /** Sets the event for the stream, requires key
     * @param int $event_id
     * @return bool
     */
    public function SetEvent($event_id) {
        $extradata = array("event_id" => $event_id);
        $arrResult = $this->execCommand("streamdetails", "setStreamEvent", $extradata);

        return ($arrResult && ($arrResult->result == "OK"));
    }

    /** Lists the names of the available Events
     * @param int $game_id
     * @return array
     */
    public function ListEventNames($game_id = C_GAME_SC2) {
        $extradata = array("game" => $game_id);
        $arrResult = $this->execCommand("events", "ListEvents", $extradata);

        $arrEvents = array();

        $arr = $arrResult->result;
        foreach ($arr as $k => $event) {
            $dt = $event->startdt;
            $arrEvents[$event->id] = $event->name . " (" . date("Y-m-d H:i", $dt) . ")";
        }

        return $arrEvents;
    }
}
