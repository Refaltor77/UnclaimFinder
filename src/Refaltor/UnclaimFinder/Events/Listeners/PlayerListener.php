<?php

namespace Refaltor\UnclaimFinder\Events\Listeners;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use Refaltor\UnclaimFinder\Main;

class PlayerListener implements Listener
{
    /** @var array  */
    public static $cache = [];

    /** @var Main */
    public $main;

    public function __construct(Main $main) {
        $this->main = $main;
    }

    public function onJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        self::$cache[$player->getName()] = false;
    }

    public function onQuit(PlayerQuitEvent $event): void {
        $player = $event->getPlayer();
        unset(self::$cache[$player->getName()]);
    }

    public function onHelmItem(PlayerItemHeldEvent $event): void {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $array = $this->getMain()->getConfig()->getAll();
        if ($array['unclaimFinder']['idMeta'] === $item->getId() . ':' . $item->getDamage()) {
            self::$cache[$player->getName()] = true;
        } else self::$cache[$player->getName()] = false;
    }

    /**
     * @return Main
     */
    public function getMain(): Main
    {
        return $this->main;
    }
}