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

use Laminas\Json\Json;
use Laminas\View\Helper\EscapeHtml;
use Laminas\View\Helper\EscapeHtmlAttr;
use stdClass;
use Traversable;

use function array_filter;
use function assert;
use function implode;
use function is_array;
use function is_scalar;
use function is_string;
use function iterator_to_array;
use function mb_strlen;
use function mb_strpos;
use function sprintf;

trait HtmlElementTrait
{
    private EscapeHtml $escapeHtml;

    private EscapeHtmlAttr $escapeHtmlAttr;

    public function __construct(EscapeHtml $escapeHtml, EscapeHtmlAttr $escapeHtmlAttr)
    {
        $this->escapeHtml     = $escapeHtml;
        $this->escapeHtmlAttr = $escapeHtmlAttr;
    }

    /**
     * Generate an opening tag
     *
     * @param array<int|string, (array<int, string>|bool|float|int|iterable|stdClass|string|null)> $attribs
     */
    private function open(string $element, array $attribs): string
    {
        return sprintf('<%s%s>', $element, $this->htmlAttribs($attribs));
    }

    /**
     * Return a closing tag
     */
    private function close(string $element): string
    {
        return sprintf('</%s>', $element);
    }

    /**
     * Converts an associative array to a string of tag attributes.
     *
     * @param array<int|string, (array<int, string>|bool|float|int|iterable|stdClass|string|null)> $attribs an array where each key-value pair is converted
     *                                                                                                      to an attribute name and value
     */
    private function htmlAttribs(array $attribs): string
    {
        // filter out empty string values
        $attribs = array_filter(
            $attribs,
            static fn ($value): bool => null !== $value && (!is_string($value) || mb_strlen($value))
        );

        $xhtml = '';

        foreach ($attribs as $key => $val) {
            if (!is_string($key)) {
                continue;
            }

            assert(is_string($key));

            $key = ($this->escapeHtml)($key);

            if (true === $val) {
                $xhtml .= sprintf(' %s', $key);

                continue;
            }

            if (0 === mb_strpos($key, 'on') || ('constraints' === $key) || $val instanceof stdClass) {
                // Don't escape event attributes; _do_ substitute double quotes with singles
                if (!is_scalar($val)) {
                    // non-scalar data should be cast to JSON first
                    $val = Json::encode($val);
                }
            } else {
                if (is_array($val) || $val instanceof Traversable) {
                    if ($val instanceof Traversable) {
                        $val = iterator_to_array($val);
                    }

                    $val = implode(' ', $val);
                } elseif (!is_string($val)) {
                    $val = (string) $val;
                }

                assert(is_string($val));

                $val = ($this->escapeHtmlAttr)($val);
            }

            if (false !== mb_strpos($val, '"')) {
                $xhtml .= sprintf(' %s=\'%s\'', $key, $val);
            } else {
                $xhtml .= sprintf(' %s="%s"', $key, $val);
            }
        }

        return $xhtml;
    }
}
