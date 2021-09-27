<?php

namespace Refaltor\UnclaimFinder;

use pocketmine\plugin\PluginBase;
use Refaltor\UnclaimFinder\Events\Listeners\PlayerListener;
use Refaltor\UnclaimFinder\Tasks\PopupTask;

class Main extends PluginBase
{
    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents(new PlayerListener($this), $this);
        $this-saveDefaultConfig();
        $array = $this->getConfig()->getAll();
        $this->getScheduler()->scheduleRepeatingTask(new PopupTask($this), $array['task_tick']);
    }
}
