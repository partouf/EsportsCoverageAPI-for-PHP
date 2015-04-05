<?php

/**
 * Class CEsportsCoverageAPI
 */
class CEsportsCoverageAPI {
    protected $mainurl = "http://esportscoverage.net/ajax.php";
    protected $streamkey = "";

    public function __construct($streamkey) {
        $this->streamkey = $streamkey;
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
}
