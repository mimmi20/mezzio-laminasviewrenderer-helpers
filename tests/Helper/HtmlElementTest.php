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

namespace MezzioTest\LaminasViewHelper\Helper;

use Laminas\Config\Config;
use Laminas\View\Helper\EscapeHtml;
use Laminas\View\Helper\EscapeHtmlAttr;
use Mezzio\LaminasViewHelper\Helper\HtmlElement;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

final class HtmlElementTest extends TestCase
{
    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testToHtml(): void
    {
        $expected = '<a id="testIdEscaped" classEscaped="testClassEscaped" hrefEscaped="#Escaped" targetEscaped="_blankEscaped" onClick=\'{"a":"b"}\' data-test="test-class1 test-class2">testLabelTranslatedAndEscaped</a>';

        $escapedTranslatedLabel = 'testLabelTranslatedAndEscaped';
        $id                     = 'testId';
        $class                  = 'test-class';
        $href                   = '#';
        $target                 = '_blank';
        $onclick                = (object) ['a' => 'b'];
        $testData               = ['test-class1', 'test-class2'];

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
            $htmlElement->toHtml(
                $element,
                ['id' => $id, 'title' => '', 'class' => $class, 'href' => $href, 'target' => $target, 'onClick' => $onclick, 'data-test' => $testData],
                $escapedTranslatedLabel
            )
        );
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testToHtmlIgnoringNullAttributes(): void
    {
        $expected = '<a id="testIdEscaped" classEscaped="testClassEscaped" hrefEscaped="#Escaped" targetEscaped="_blankEscaped" onClick=\'{"a":"b"}\' data-test="test-class1 test-class2">testLabelTranslatedAndEscaped</a>';

        $escapedTranslatedLabel = 'testLabelTranslatedAndEscaped';
        $id                     = 'testId';
        $class                  = 'test-class';
        $href                   = '#';
        $target                 = '_blank';
        $onclick                = (object) ['a' => 'b'];
        $testData               = ['test-class1', 'test-class2'];

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
            $htmlElement->toHtml(
                $element,
                ['id' => $id, 'title' => '', 'class' => $class, 'href' => $href, 'target' => $target, 'onClick' => $onclick, 'data-test' => $testData, 'open' => null],
                $escapedTranslatedLabel
            )
        );
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testToHtmlNotIgnoringTrueAttributes(): void
    {
        $expected = '<a id="testIdEscaped" classEscaped="testClassEscaped" hrefEscaped="#Escaped" targetEscaped="_blankEscaped" onClick=\'{"a":"b"}\' constraints="abc" data-test="test-class1 test-class2" openEscaped vonEscaped="xyzEscaped">testLabelTranslatedAndEscaped</a>';

        $escapedTranslatedLabel = 'testLabelTranslatedAndEscaped';
        $id                     = 'testId';
        $class                  = 'test-class';
        $href                   = '#';
        $target                 = '_blank';
        $onclick                = (object) ['a' => 'b'];
        $testData               = ['test-class1', 'test-class2'];

        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::exactly(9))
            ->method('__invoke')
            ->withConsecutive(
                ['id'],
                ['class'],
                ['href'],
                ['target'],
                ['onClick'],
                ['constraints'],
                ['data-test'],
                ['open'],
                ['von']
            )
            ->willReturnOnConsecutiveCalls(
                'id',
                'classEscaped',
                'hrefEscaped',
                'targetEscaped',
                'onClick',
                'constraints',
                'data-test',
                'openEscaped',
                'vonEscaped'
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
                ['xyz']
            )
            ->willReturnOnConsecutiveCalls(
                'testIdEscaped',
                'testClassEscaped',
                '#Escaped',
                '_blankEscaped',
                'test-class1 test-class2',
                'xyzEscaped'
            );

        $element = 'a';

        $htmlElement = new HtmlElement($escapeHtml, $escapeHtmlAttr);

        self::assertSame(
            $expected,
            $htmlElement->toHtml(
                $element,
                ['id' => $id, 'title' => '', 'class' => $class, 'href' => $href, 'target' => $target, 'onClick' => $onclick, 'constraints' => 'abc', 'data-test' => $testData, 'open' => true, 'von' => 'xyz'],
                $escapedTranslatedLabel
            )
        );
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testOpenWithIntAttributes(): void
    {
        $expected = '<a id="testIdEscaped" classEscaped="testClassEscaped" hrefEscaped="#Escaped" targetEscaped="_blankEscaped" onClick=\'{"a":"b"}\' constraints="abc" data-test="test-class1 test-class2" openEscaped valueEscaped="0" vonEscaped="xyzEscaped">testLabelTranslatedAndEscaped</a>';

        $escapedTranslatedLabel = 'testLabelTranslatedAndEscaped';
        $id                     = 'testId';
        $class                  = 'test-class';
        $href                   = '#';
        $target                 = '_blank';
        $onclick                = (object) ['a' => 'b'];
        $testData               = ['test-class1', 'test-class2'];
        $value                  = 0;

        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::exactly(10))
            ->method('__invoke')
            ->withConsecutive(
                ['id'],
                ['class'],
                ['href'],
                ['target'],
                ['onClick'],
                ['constraints'],
                ['data-test'],
                ['open'],
                ['value'],
                ['von']
            )
            ->willReturnOnConsecutiveCalls(
                'id',
                'classEscaped',
                'hrefEscaped',
                'targetEscaped',
                'onClick',
                'constraints',
                'data-test',
                'openEscaped',
                'valueEscaped',
                'vonEscaped'
            );

        $escapeHtmlAttr = $this->getMockBuilder(EscapeHtmlAttr::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtmlAttr->expects(self::exactly(7))
            ->method('__invoke')
            ->withConsecutive(
                [$id],
                [$class],
                [$href],
                [$target],
                ['test-class1 test-class2'],
                [(string) $value],
                ['xyz']
            )
            ->willReturnOnConsecutiveCalls(
                'testIdEscaped',
                'testClassEscaped',
                '#Escaped',
                '_blankEscaped',
                'test-class1 test-class2',
                (string) $value,
                'xyzEscaped'
            );

        $element = 'a';

        $htmlElement = new HtmlElement($escapeHtml, $escapeHtmlAttr);

        self::assertSame(
            $expected,
            $htmlElement->toHtml(
                $element,
                ['id' => $id, 'title' => '', 'class' => $class, 'href' => $href, 'target' => $target, 'onClick' => $onclick, 'constraints' => 'abc', 'data-test' => $testData, 'xxx', 'open' => true, 'value' => $value, 'von' => 'xyz'],
                $escapedTranslatedLabel
            )
        );
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testOpenWithConfigAttributes(): void
    {
        $expected = '<a id="testIdEscaped" classEscaped="testClassEscaped" hrefEscaped="#Escaped" targetEscaped="_blankEscaped" onClick=\'{"a":"b"}\' constraints="abc" data-test="test-class1 test-class2" openEscaped valueEscaped="0" vonEscaped="xyzEscaped">testLabelTranslatedAndEscaped</a>';

        $escapedTranslatedLabel = 'testLabelTranslatedAndEscaped';
        $id                     = 'testId';
        $class                  = 'test-class';
        $href                   = '#';
        $target                 = '_blank';
        $onclick                = (object) ['a' => 'b'];
        $testData               = new Config(['test-class1', 'test-class2']);
        $value                  = 0;

        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::exactly(10))
            ->method('__invoke')
            ->withConsecutive(
                ['id'],
                ['class'],
                ['href'],
                ['target'],
                ['onClick'],
                ['constraints'],
                ['data-test'],
                ['open'],
                ['value'],
                ['von']
            )
            ->willReturnOnConsecutiveCalls(
                'id',
                'classEscaped',
                'hrefEscaped',
                'targetEscaped',
                'onClick',
                'constraints',
                'data-test',
                'openEscaped',
                'valueEscaped',
                'vonEscaped'
            );

        $escapeHtmlAttr = $this->getMockBuilder(EscapeHtmlAttr::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtmlAttr->expects(self::exactly(7))
            ->method('__invoke')
            ->withConsecutive(
                [$id],
                [$class],
                [$href],
                [$target],
                ['test-class1 test-class2'],
                [(string) $value],
                ['xyz']
            )
            ->willReturnOnConsecutiveCalls(
                'testIdEscaped',
                'testClassEscaped',
                '#Escaped',
                '_blankEscaped',
                'test-class1 test-class2',
                (string) $value,
                'xyzEscaped'
            );

        $element = 'a';

        $htmlElement = new HtmlElement($escapeHtml, $escapeHtmlAttr);

        self::assertSame(
            $expected,
            $htmlElement->toHtml(
                $element,
                ['id' => $id, 'title' => '', 'class' => $class, 'href' => $href, 'target' => $target, 'onClick' => $onclick, 'constraints' => 'abc', 'data-test' => $testData, 'xxx', 'open' => true, 'value' => $value, 'von' => 'xyz'],
                $escapedTranslatedLabel
            )
        );
    }
}
