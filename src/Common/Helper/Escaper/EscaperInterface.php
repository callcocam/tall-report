<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Common\Helper\Escaper;

/**
 * @internal
 */
interface EscaperInterface
{
    /**
     * Escapes the given string to make it compatible with PHP.
     *
     * @param string $string The string to escape
     *
     * @return string The escaped string
     */
    public function escape(string $string): string;

    /**
     * Unescapes the given string to make it compatible with PHP.
     *
     * @param string $string The string to unescape
     *
     * @return string The unescaped string
     */
    public function unescape(string $string): string;
}
