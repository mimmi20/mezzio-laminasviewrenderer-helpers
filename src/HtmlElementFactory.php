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
use Laminas\View\Helper\EscapeHtml;
use Laminas\View\Helper\EscapeHtmlAttr;
use Laminas\View\HelperPluginManager as ViewHelperPluginManager;
use Psr\Container\ContainerExceptionInterface;

final class HtmlElementFactory
{
    /**
     * @throws ContainerExceptionInterface
     */
    public function __invoke(ContainerInterface $container): HtmlElement
    {
        $plugin = $container->get(ViewHelperPluginManager::class);

        return new HtmlElement(
            $plugin->get(EscapeHtml::class),
            $plugin->get(EscapeHtmlAttr::class)
        );
    }
}
