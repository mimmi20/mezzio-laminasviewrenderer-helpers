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

use Interop\Container\ContainerInterface;
use Mezzio\LaminasView\LaminasViewRenderer;
use Psr\Container\ContainerExceptionInterface;

final class PartialRendererFactory
{
    /**
     * @throws ContainerExceptionInterface
     */
    public function __invoke(ContainerInterface $container): PartialRenderer
    {
        return new PartialRenderer(
            $container->get(LaminasViewRenderer::class)
        );
    }
}
