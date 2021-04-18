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

namespace MezzioTest\LaminasViewHelper;

use Mezzio\LaminasViewHelper\ConfigProvider;
use Mezzio\LaminasViewHelper\Helper\PluginManager;
use Mezzio\LaminasViewHelper\View\Helper\HtmlElement;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

final class ConfigProviderTest extends TestCase
{
    private ConfigProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new ConfigProvider();
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testReturnedArrayContainsDependencies(): void
    {
        $config = ($this->provider)();
        self::assertIsArray($config);

        self::assertArrayHasKey('dependencies', $config);

        $dependencies = $config['dependencies'];
        self::assertIsArray($dependencies);
        self::assertArrayHasKey('factories', $dependencies);

        $factories = $dependencies['factories'];
        self::assertIsArray($factories);
        self::assertArrayHasKey(PluginManager::class, $factories);

        self::assertArrayHasKey('view_helpers', $config);

        $viewHelpers = $config['view_helpers'];
        self::assertIsArray($viewHelpers);
        self::assertArrayHasKey('factories', $viewHelpers);

        $factories = $viewHelpers['factories'];
        self::assertIsArray($factories);
        self::assertArrayHasKey(HtmlElement::class, $factories);

        $aliases = $viewHelpers['aliases'];
        self::assertIsArray($aliases);
        self::assertArrayHasKey('htmlElement', $aliases);
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testReturnedArrayContainsDependencies2(): void
    {
        $dependencies = $this->provider->getDependencyConfig();
        self::assertIsArray($dependencies);
        self::assertArrayHasKey('factories', $dependencies);

        $factories = $dependencies['factories'];
        self::assertIsArray($factories);
        self::assertArrayHasKey(PluginManager::class, $factories);
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testReturnedArrayContainsViewhelpers(): void
    {
        $viewHelpers = $this->provider->getViewHelperConfig();
        self::assertIsArray($viewHelpers);
        self::assertArrayHasKey('factories', $viewHelpers);

        $factories = $viewHelpers['factories'];
        self::assertIsArray($factories);
        self::assertArrayHasKey(HtmlElement::class, $factories);

        $aliases = $viewHelpers['aliases'];
        self::assertIsArray($aliases);
        self::assertArrayHasKey('htmlElement', $aliases);
    }
}
