<?php

declare(strict_types=1);

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2026 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Infrangible\CatalogProductFilterUrl\Test\Unit\Plugin\Catalog\Model;

use Infrangible\CatalogProductFilterUrl\Helper\Data as Helper;
use Infrangible\CatalogProductFilterUrl\Model\Config\Data;
use Infrangible\CatalogProductFilterUrl\Plugin\Catalog\Model\Product;
use Magento\Catalog\Model\Product as CatalogProduct;
use Magento\Framework\App\Request\Http;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests the applied filters as fragment of product URLs.
 */
#[AllowMockObjectsWithoutExpectations]
class ProductTest extends TestCase
{
    /**
     * Returns actions, queries and the expected URL.
     *
     * @return array<string, array{string, string, string}>
     */
    public static function urlProvider(): array
    {
        return [
            'category with filters'    => ['catalog_category_view', 'color=60&93=60', '/tank.html#color=60&93=60'],
            'search with filters'      => [
                'catalogsearch_result_index',
                'size=168&144=168',
                '/tank.html#size=168&144=168'
            ],
            'category without filters' => ['catalog_category_view', '', '/tank.html'],
            'other action'             => ['catalog_product_view', 'color=60&93=60', '/tank.html']
        ];
    }

    /**
     * Tests the URL of the product.
     *
     * @dataProvider urlProvider
     *
     * @param string $action
     * @param string $query
     * @param string $expected
     *
     * @return void
     */
    #[DataProvider('urlProvider')]
    public function testProductUrl(string $action, string $query, string $expected): void
    {
        $helper = $this->createStub(Helper::class);
        $helper->method('extractQuery')->willReturn($query);

        $config = $this->createStub(Data::class);
        $config->method('get')->willReturn(
            ['category' => 'catalog_category_view', 'search' => 'catalogsearch_result_index']
        );

        $request = $this->createStub(Http::class);
        $request->method('getFullActionName')->willReturn($action);

        $this->assertSame(
            $expected,
            (new Product($helper, $config, $request))->afterGetProductUrl(
                $this->createStub(CatalogProduct::class),
                '/tank.html'
            )
        );
    }
}
