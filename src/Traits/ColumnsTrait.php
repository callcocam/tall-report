<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Report\Traits;

use Tall\Report\Common\Entity\Style\Color;
/**
 * @property ?Batch $exportBatch
 */
trait ColumnsTrait
{   
      
    
    private function fontSize(){
        $fonts = [];
        for($i=4;$i<=150; $i+=2){
            $fonts[$i] = $i;
        }
        return $fonts;
    }

    protected function colors()
    {
        $colors[sprintf("#%s",Color::BLACK)] = 'BLACK';
        $colors[sprintf("#%s",Color::WHITE)] = 'WHITE';
        $colors[sprintf("#%s",Color::RED)] = 'RED';
        $colors[sprintf("#%s",Color::DARK_RED)] = 'DARK_RED';
        $colors[sprintf("#%s",Color::ORANGE)] = 'ORANGE';
        $colors[sprintf("#%s",Color::YELLOW)] = 'YELLOW';
        $colors[sprintf("#%s",Color::LIGHT_GREEN)] = 'LIGHT_GREEN';
        $colors[sprintf("#%s",Color::GREEN)] = 'GREEN';
        $colors[sprintf("#%s",Color::BLUE)] = 'BLUE';
        $colors[sprintf("#%s",Color::DARK_BLUE)] = 'DARK_BLUE';
        $colors[sprintf("#%s",Color::PURPLE)] = 'PURPLE';
        return array_keys($colors);
    }


}
