<?php declare(strict_types=1);
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Test class for \Magento\Backend\Model\Url
 */
namespace Magento\Backend\Test\Unit\Block\Widget\Grid;

use Magento\Backend\Block\Widget\Grid\ColumnSet;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Data\Collection;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\View\Layout;
use PHPUnit\Framework\TestCase;

class ExtendedTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    protected $_objectManager;

    protected function setUp(): void
    {
        $this->_objectManager = new ObjectManager($this);
    }

    public function testPrepareLoadedCollection()
    {
        $request = $this->createPartialMock(Http::class, ['has']);
        $request->expects($this->any())->method('has')->will($this->returnValue(null));

        $columnSet = $this->createMock(ColumnSet::class);
        $layout = $this->createMock(Layout::class);
        $layout->expects($this->any())->method('getChildName')->will($this->returnValue('grid.columnSet'));
        $layout->expects($this->any())->method('getBlock')->will($this->returnValue($columnSet));

        $collection = $this->createMock(Collection::class);
        $collection->expects($this->atLeastOnce())->method('isLoaded')->will($this->returnValue(true));
        $collection->expects($this->atLeastOnce())->method('clear');
        $collection->expects($this->atLeastOnce())->method('load');

        /** @var Extended $block */
        $block = $this->_objectManager->getObject(
            Extended::class,
            ['request' => $request, 'layout' => $layout]
        );

        $block->setCollection($collection);
        $block->getPreparedCollection();
    }
}
