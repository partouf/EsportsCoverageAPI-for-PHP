# EsportsCoverageAPI-for-PHP

PHP API to control your stream at esportscoverage.net

Available functions:

* GetStreamDetails()
* SetCurrentPlayers(string $player1name, string $player2name, int $player1score = 0, int $player2score = 0)
* SetCurrentScore(int $player1score, int $player2score)
* SetEvent(int $event_id)
* ListEventNames()

For usage, check out [test.php](https://github.com/partouf/EsportsCoverageAPI-for-PHP/blob/master/test.php)
