<?php

namespace  gamegam\ChopTree;

use pocketmine\item\Axe;
use pocketmine\block\VanillaBlocks;
use pocketmine\math\Vector3;
use pocketmine\block\Wood;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class ChopTree extends PluginBase implements  Listener{

	public  function  onEnable() : void{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onBreak(BlockBreakEvent $ev){
		$block = $ev->getBlock();
		$p = $ev->getPlayer();
		$pos = $block->getPosition();
		$x = $pos->getX();
		$y = $pos->getY();
		$z = $pos->getZ();
		$hand = $p->getInventory()->getItemInHand();
		if (! $hand instanceof  Axe){
			return false;
		}
		if($block instanceof Wood){
			for($i = $y; $i <= 319; $i++){
				$xz = $p->getWorld()->getBlock(new Vector3($x, $i, $z));
				if (! $xz instanceof  Wood){
					break;
				}
				if ($p->isSurvival()){
					$p->getWorld()->useBreakOn(new Vector3($x, $i, $z));
				}
				$p->getWorld()->setBlock(new Vector3($x, $i, $z), VanillaBlocks::AIR());
				$ev->cancel();
			}
		}
	}
}
