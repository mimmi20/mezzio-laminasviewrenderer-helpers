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

use Laminas\View\Exception\InvalidArgumentException;
use Laminas\View\Exception\RuntimeException;
use Laminas\View\Model\ModelInterface;

interface PartialRendererInterface extends HelperInterface
{
    /**
     * Returns an HTML string
     *
     * @param array<int, string>|ModelInterface|string|null $partial
     * @param array<mixed>                                  $params
     *
     * @return string HTML string
     *
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public function render($partial, array $params): string;
}
