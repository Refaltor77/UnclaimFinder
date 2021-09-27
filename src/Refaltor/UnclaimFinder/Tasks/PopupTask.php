<?php

namespace Refaltor\UnclaimFinder\Tasks;

use pocketmine\scheduler\Task;
use pocketmine\Server;
use Refaltor\UnclaimFinder\Events\Listeners\PlayerListener;
use Refaltor\UnclaimFinder\Main;

class PopupTask extends Task
{
    /** @var Main */
    public $main;

    public function __construct(Main $main) {
        $this->main = $main;
    }

    public function onRun(int $currentTick)
    {
        $array = PlayerListener::$cache;
        foreach ($array as $name => $bool) {
            if ($bool) {
                $player = $this->getMain()->getServer()->getPlayerExact($name);
                if (!is_null($player)) {
                    $i = 0;
                    foreach ($player->getLevel()->getChunk($player->getX() >> 4, $player->getZ() >> 4)->getTiles() as $tile) $i++;
                    $array = $this->getMain()->getConfig()->getAll();
                    $message = str_replace('{tiles}', $i, $array['unclaimFinder']['popup']);
                    $player->sendPopup($message);
                }
            }
        }
    }

    /**
     * @return Main
     */
    public function getMain(): Main
    {
        return $this->main;
    }
}