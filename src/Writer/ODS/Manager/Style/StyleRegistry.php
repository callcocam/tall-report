<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Writer\ODS\Manager\Style;

use Tall\Report\Common\Entity\Style\Style;
use Tall\Report\Writer\Common\Manager\Style\AbstractStyleRegistry as CommonStyleRegistry;

/**
 * @internal
 */
final class StyleRegistry extends CommonStyleRegistry
{
    /** @var array<string, bool> [FONT_NAME] => [] Map whose keys contain all the fonts used */
    private array $usedFontsSet = [];

    /**
     * Registers the given style as a used style.
     * Duplicate styles won't be registered more than once.
     *
     * @param Style $style The style to be registered
     *
     * @return Style the registered style, updated with an internal ID
     */
    public function registerStyle(Style $style): Style
    {
        if ($style->isRegistered()) {
            return $style;
        }

        $registeredStyle = parent::registerStyle($style);
        $this->usedFontsSet[$style->getFontName()] = true;

        return $registeredStyle;
    }

    /**
     * @return string[] List of used fonts name
     */
    public function getUsedFonts(): array
    {
        return array_keys($this->usedFontsSet);
    }
}
