<?php

declare(strict_types=1);

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2026 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Infrangible\CatalogProductFilterUrl\Test\Unit\Helper;

use FeWeDev\Base\Variables;
use Infrangible\CatalogProductFilterUrl\Helper\Data;
use Infrangible\Core\Helper\Attribute;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute as CatalogAttribute;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Exception\NoSuchEntityException;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\TestCase;

/**
 * Tests the applied filters as query of the URL fragment.
 */
#[AllowMockObjectsWithoutExpectations]
class DataTest extends TestCase
{
    /**
     * Filters by options are added with the code and the ID of their attribute; other parameters, attributes without
     * filter and empty values are left out.
     *
     * @return void
     */
    public function testExtractQuery(): void
    {
        $helper = $this->createHelper(
            ['color' => '60', 'size' => ['168', ''], 'q' => 'tank', 'sku' => 'WT09', 'p' => '2']
        );

        $this->assertSame('color=60&size=168&93=60&144=168', $helper->extractQuery());
        $this->assertTrue($helper->isProductAttribute('color'));
        $this->assertFalse($helper->isProductAttribute('sku'));
        $this->assertFalse($helper->isProductAttribute('q'));
    }

    /**
     * Without filters the query is empty.
     *
     * @return void
     */
    public function testWithoutFilters(): void
    {
        $this->assertSame('', $this->createHelper(['q' => 'tank'])->extractQuery());
    }

    /**
     * Values are encoded for the URL.
     *
     * @return void
     */
    public function testEncoding(): void
    {
        $this->assertSame('color=a%26b&93=a%26b', $this->createHelper(['color' => 'a&b'])->extractQuery());
    }

    /**
     * Returns the helper for a request with the parameters; color (93) and size (144) are filterable, sku is not.
     *
     * @param array<string, mixed> $params
     *
     * @return Data
     */
    private function createHelper(array $params): Data
    {
        $attributeHelper = $this->createStub(Attribute::class);
        $attributeHelper->method('getAttribute')->willReturnCallback(
            function (string $entityTypeCode, string $code): CatalogAttribute {
                $attributes = [
                    'color' => $this->createAttribute('color', 93, 1),
                    'size'  => $this->createAttribute('size', 144, 2),
                    'sku'   => $this->createAttribute('sku', 74, 0)
                ];

                if (! isset($attributes[ $code ])) {
                    throw new NoSuchEntityException(__('The attribute %1 does not exist.', $code));
                }

                return $attributes[ $code ];
            }
        );

        $request = $this->createStub(Http::class);
        $request->method('getParams')->willReturn($params);

        return new Data($attributeHelper, $request, new Variables());
    }

    /**
     * Returns a product attribute.
     *
     * @param string $code
     * @param int $id
     * @param int $isFilterable
     *
     * @return CatalogAttribute
     */
    private function createAttribute(string $code, int $id, int $isFilterable): CatalogAttribute
    {
        $attribute = $this->createStub(CatalogAttribute::class);
        $attribute->method('getAttributeCode')->willReturn($code);
        $attribute->method('getId')->willReturn((string)$id);
        $attribute->method('getIsFilterable')->willReturn((string)$isFilterable);

        return $attribute;
    }
}
