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

namespace Mezzio\LaminasViewHelper\Helper;

interface HtmlElementInterface extends HelperInterface
{
    /**
     * Returns an HTML string
     *
     * @param array<string, array<string>|bool|float|int|iterable|string|null> $attribs
     *
     * @return string HTML string
     */
    public function toHtml(string $element, array $attribs, string $content): string;
}
