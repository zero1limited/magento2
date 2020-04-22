<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Tax\Test\Unit\Model\TaxClass\Type;

use Magento\Catalog\Model\Product;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testIsAssignedToObjects()
    {
        $collectionClassName = AbstractCollection::class;
        $collectionMock = $this->getMockBuilder($collectionClassName)
            ->setMethods(['addAttributeToFilter', 'getSize'])->disableOriginalConstructor()->getMock();
        $collectionMock->expects($this->once())->method('addAttributeToFilter')
            ->with($this->equalTo('tax_class_id'), $this->equalTo(1))->willReturnSelf();
        $collectionMock->expects($this->once())->method('getSize')
            ->willReturn(1);

        $productMock = $this->getMockBuilder(Product::class)
            ->setMethods(['getCollection', '__wakeup', 'getEntityId'])
            ->disableOriginalConstructor()->getMock();
        $productMock->expects($this->once())->method('getCollection')->willReturn($collectionMock);

        $objectManagerHelper = new ObjectManager($this);
        /** @var $model \Magento\Tax\Model\TaxClass\Type\Product */
        $model = $objectManagerHelper->getObject(
            \Magento\Tax\Model\TaxClass\Type\Product::class,
            ['modelProduct' => $productMock, 'data' => ['id' => 1]]
        );
        $this->assertTrue($model->isAssignedToObjects());
    }
}
