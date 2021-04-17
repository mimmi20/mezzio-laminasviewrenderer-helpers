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

namespace MezzioTest\LaminasView\Helper;

use Interop\Container\ContainerInterface;
use Mezzio\LaminasView\Helper\PartialRenderer;
use Mezzio\LaminasView\Helper\PartialRendererFactory;
use Mezzio\LaminasView\LaminasViewRenderer;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

use function assert;

final class PartialRendererFactoryTest extends TestCase
{
    private PartialRendererFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new PartialRendererFactory();
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testInvocation(): void
    {
        $renderer = $this->createMock(LaminasViewRenderer::class);

        $container = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $container->expects(self::once())
            ->method('get')
            ->with(LaminasViewRenderer::class)
            ->willReturn($renderer);

        assert($container instanceof ContainerInterface);
        $helper = ($this->factory)($container);

        self::assertInstanceOf(PartialRenderer::class, $helper);
    }
}
