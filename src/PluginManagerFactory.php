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

namespace Mezzio\LaminasView\Helper;

use Interop\Container\ContainerInterface;

/**
 * Plugin manager implementation for navigation helpers
 *
 * Enforces that helpers retrieved are instances of
 * LaminasView\HelperInterface. Additionally, it registers a number of default
 * helpers.
 */
final class PluginManagerFactory
{
    /**
     * Create and return a navigation view helper instance.
     */
    public function __invoke(ContainerInterface $container): PluginManager
    {
        return new PluginManager(
            $container
        );
    }
}
