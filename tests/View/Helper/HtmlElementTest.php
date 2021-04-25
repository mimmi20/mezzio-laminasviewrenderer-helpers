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

namespace MezzioTest\LaminasViewHelper\View\Helper;

use Laminas\View\Helper\EscapeHtml;
use Laminas\View\Helper\EscapeHtmlAttr;
use Mezzio\LaminasViewHelper\View\Helper\HtmlElement;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

final class HtmlElementTest extends TestCase
{
    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testOpen(): void
    {
        $expected = '<a id="testIdEscaped" classEscaped="testClassEscaped" hrefEscaped="#Escaped" targetEscaped="_blankEscaped" onClick=\'{"a":"b"}\' data-test="test-class1 test-class2">';

        $id       = 'testId';
        $class    = 'test-class';
        $href     = '#';
        $target   = '_blank';
        $onclick  = (object) ['a' => 'b'];
        $testData = ['test-class1', 'test-class2'];

        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::exactly(6))
            ->method('__invoke')
            ->withConsecutive(
                ['id'],
                ['class'],
                ['href'],
                ['target'],
                ['onClick'],
                ['data-test']
            )
            ->willReturnOnConsecutiveCalls(
                'id',
                'classEscaped',
                'hrefEscaped',
                'targetEscaped',
                'onClick',
                'data-test'
            );

        $escapeHtmlAttr = $this->getMockBuilder(EscapeHtmlAttr::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtmlAttr->expects(self::exactly(5))
            ->method('__invoke')
            ->withConsecutive(
                [$id],
                [$class],
                [$href],
                [$target],
                ['test-class1 test-class2']
            )
            ->willReturnOnConsecutiveCalls(
                'testIdEscaped',
                'testClassEscaped',
                '#Escaped',
                '_blankEscaped',
                'test-class1 test-class2'
            );

        $element = 'a';

        $htmlElement = new HtmlElement($escapeHtml, $escapeHtmlAttr);

        self::assertSame(
            $expected,
            $htmlElement->openTag(
                $element,
                ['id' => $id, 'title' => '', 'class' => $class, 'href' => $href, 'target' => $target, 'onClick' => $onclick, 'data-test' => $testData],
            )
        );
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testToHtmlIgnoringNullAttributes(): void
    {
        $expected = '<a id="testIdEscaped" classEscaped="testClassEscaped" hrefEscaped="#Escaped" targetEscaped="_blankEscaped" onClick=\'{"a":"b"}\' data-test="test-class1 test-class2">';

        $id       = 'testId';
        $class    = 'test-class';
        $href     = '#';
        $target   = '_blank';
        $onclick  = (object) ['a' => 'b'];
        $testData = ['test-class1', 'test-class2'];

        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::exactly(6))
            ->method('__invoke')
            ->withConsecutive(
                ['id'],
                ['class'],
                ['href'],
                ['target'],
                ['onClick'],
                ['data-test']
            )
            ->willReturnOnConsecutiveCalls(
                'id',
                'classEscaped',
                'hrefEscaped',
                'targetEscaped',
                'onClick',
                'data-test'
            );

        $escapeHtmlAttr = $this->getMockBuilder(EscapeHtmlAttr::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtmlAttr->expects(self::exactly(5))
            ->method('__invoke')
            ->withConsecutive(
                [$id],
                [$class],
                [$href],
                [$target],
                ['test-class1 test-class2']
            )
            ->willReturnOnConsecutiveCalls(
                'testIdEscaped',
                'testClassEscaped',
                '#Escaped',
                '_blankEscaped',
                'test-class1 test-class2'
            );

        $element = 'a';

        $htmlElement = new HtmlElement($escapeHtml, $escapeHtmlAttr);

        self::assertSame(
            $expected,
            $htmlElement->openTag(
                $element,
                ['id' => $id, 'title' => '', 'class' => $class, 'href' => $href, 'target' => $target, 'onClick' => $onclick, 'data-test' => $testData, 'open' => null],
            )
        );
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testOpenNotIgnoringTrueAttributes(): void
    {
        $expected = '<a id="testIdEscaped" classEscaped="testClassEscaped" hrefEscaped="#Escaped" targetEscaped="_blankEscaped" onClick=\'{"a":"b"}\' data-test="test-class1 test-class2" openEscaped>';

        $id       = 'testId';
        $class    = 'test-class';
        $href     = '#';
        $target   = '_blank';
        $onclick  = (object) ['a' => 'b'];
        $testData = ['test-class1', 'test-class2'];

        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::exactly(7))
            ->method('__invoke')
            ->withConsecutive(
                ['id'],
                ['class'],
                ['href'],
                ['target'],
                ['onClick'],
                ['data-test'],
                ['open']
            )
            ->willReturnOnConsecutiveCalls(
                'id',
                'classEscaped',
                'hrefEscaped',
                'targetEscaped',
                'onClick',
                'data-test',
                'openEscaped'
            );

        $escapeHtmlAttr = $this->getMockBuilder(EscapeHtmlAttr::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtmlAttr->expects(self::exactly(5))
            ->method('__invoke')
            ->withConsecutive(
                [$id],
                [$class],
                [$href],
                [$target],
                ['test-class1 test-class2']
            )
            ->willReturnOnConsecutiveCalls(
                'testIdEscaped',
                'testClassEscaped',
                '#Escaped',
                '_blankEscaped',
                'test-class1 test-class2'
            );

        $element = 'a';

        $htmlElement = new HtmlElement($escapeHtml, $escapeHtmlAttr);

        self::assertSame(
            $expected,
            $htmlElement->openTag(
                $element,
                ['id' => $id, 'title' => '', 'class' => $class, 'href' => $href, 'target' => $target, 'onClick' => $onclick, 'data-test' => $testData, 'open' => true],
            )
        );
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testClose(): void
    {
        $expected = '</a>';

        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::never())
            ->method('__invoke');

        $escapeHtmlAttr = $this->getMockBuilder(EscapeHtmlAttr::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtmlAttr->expects(self::never())
            ->method('__invoke');

        $element = 'a';

        $htmlElement = new HtmlElement($escapeHtml, $escapeHtmlAttr);

        self::assertSame(
            $expected,
            $htmlElement->closeTag($element)
        );
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testInvoke(): void
    {
        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::never())
            ->method('__invoke');

        $escapeHtmlAttr = $this->getMockBuilder(EscapeHtmlAttr::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtmlAttr->expects(self::never())
            ->method('__invoke');

        $htmlElement = new HtmlElement($escapeHtml, $escapeHtmlAttr);

        self::assertSame(
            $htmlElement,
            ($htmlElement)()
        );
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testOpenWithIntAttributes(): void
    {
        $expected = '<a id="testIdEscaped" classEscaped="testClassEscaped" hrefEscaped="#Escaped" targetEscaped="_blankEscaped" onClick=\'{"a":"b"}\' data-test="test-class1 test-class2" openEscaped valueEscaped="0">';

        $id       = 'testId';
        $class    = 'test-class';
        $href     = '#';
        $target   = '_blank';
        $onclick  = (object) ['a' => 'b'];
        $testData = ['test-class1', 'test-class2'];
        $value    = 0;

        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::exactly(8))
            ->method('__invoke')
            ->withConsecutive(
                ['id'],
                ['class'],
                ['href'],
                ['target'],
                ['onClick'],
                ['data-test'],
                ['open'],
                ['value']
            )
            ->willReturnOnConsecutiveCalls(
                'id',
                'classEscaped',
                'hrefEscaped',
                'targetEscaped',
                'onClick',
                'data-test',
                'openEscaped',
                'valueEscaped'
            );

        $escapeHtmlAttr = $this->getMockBuilder(EscapeHtmlAttr::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtmlAttr->expects(self::exactly(6))
            ->method('__invoke')
            ->withConsecutive(
                [$id],
                [$class],
                [$href],
                [$target],
                ['test-class1 test-class2'],
                [(string) $value]
            )
            ->willReturnOnConsecutiveCalls(
                'testIdEscaped',
                'testClassEscaped',
                '#Escaped',
                '_blankEscaped',
                'test-class1 test-class2',
                (string) $value
            );

        $element = 'a';

        $htmlElement = new HtmlElement($escapeHtml, $escapeHtmlAttr);

        self::assertSame(
            $expected,
            $htmlElement->openTag(
                $element,
                ['id' => $id, 'title' => '', 'class' => $class, 'href' => $href, 'target' => $target, 'onClick' => $onclick, 'data-test' => $testData, 'open' => true, 'value' => $value, 'xxx'],
            )
        );
    }
}
