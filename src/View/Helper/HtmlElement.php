<?php
/**
 * This file is part of the mimmi20/mezzio-laminasviewrenderer-helpers package.
 *
 * Copyright (c) 2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mezzio\LaminasViewHelper\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Mezzio\LaminasViewHelper\Helper\HtmlElementTrait;
use stdClass;

final class HtmlElement extends AbstractHelper
{
    use HtmlElementTrait;

    public function __invoke(): self
    {
        return $this;
    }

    /**
     * Generate an opening tag
     *
     * @param array<string, (array<int, string>|bool|float|int|iterable|stdClass|string|null)> $attribs
     */
    public function openTag(string $element, array $attribs): string
    {
        return $this->open($element, $attribs);
    }

    /**
     * Return a closing tag
     */
    public function closeTag(string $element): string
    {
        return $this->close($element);
    }
}
