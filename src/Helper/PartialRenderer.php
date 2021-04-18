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

use Laminas\View\Exception;
use Laminas\View\Exception\InvalidArgumentException;
use Laminas\View\Exception\RuntimeException;
use Laminas\View\Model\ModelInterface;
use Mezzio\LaminasView\LaminasViewRenderer;

use function count;
use function is_array;

final class PartialRenderer implements PartialRendererInterface
{
    private LaminasViewRenderer $renderer;

    public function __construct(LaminasViewRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

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
    public function render($partial, array $params): string
    {
        if (null === $partial || '' === $partial || [] === $partial) {
            throw new Exception\RuntimeException(
                'Unable to render partial: No partial view script provided'
            );
        }

        if (is_array($partial)) {
            if (2 !== count($partial)) {
                throw new Exception\InvalidArgumentException(
                    'Unable to render partial: A view partial supplied as '
                    . 'an array must contain one value: the partial view script'
                );
            }

            $partial = $partial[0];
        }

        $model = $params;

        if ($partial instanceof ModelInterface) {
            $model   = $partial->setVariables($model);
            $partial = $model->getTemplate();
        }

        return $this->renderer->render($partial, $model);
    }
}
