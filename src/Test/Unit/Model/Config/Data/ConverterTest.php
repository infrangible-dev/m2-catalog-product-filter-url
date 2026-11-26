<?php

declare(strict_types=1);

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2026 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Infrangible\CatalogProductFilterUrl\Test\Unit\Model\Config\Data;

use DOMDocument;
use Infrangible\CatalogProductFilterUrl\Model\Config\Data\Converter;
use PHPUnit\Framework\TestCase;

/**
 * Tests reading catalog_product_filter_url.xml.
 */
class ConverterTest extends TestCase
{
    /**
     * The actions are returned by ID, actions without ID by their name; empty actions are left out.
     *
     * @return void
     */
    public function testConvert(): void
    {
        $document = new DOMDocument();
        $document->loadXML(
            '<config><catalog_product_filter_url>' .
            '<action id="category">catalog_category_view</action>' .
            '<action> catalogsearch_result_index </action>' .
            '<action id="empty"></action>' .
            '</catalog_product_filter_url></config>'
        );

        $this->assertSame(
            [
                'catalog_product_filter_url' => [
                    'category'                   => 'catalog_category_view',
                    'catalogsearch_result_index' => 'catalogsearch_result_index'
                ]
            ],
            (new Converter())->convert($document)
        );
    }

    /**
     * The file of this module configures the category and the search result pages.
     *
     * @return void
     */
    public function testModuleFile(): void
    {
        $document = new DOMDocument();
        $document->load(__DIR__ . '/../../../../../etc/catalog_product_filter_url.xml');

        $this->assertSame(
            [
                'catalog_product_filter_url' => [
                    'category' => 'catalog_category_view',
                    'search'   => 'catalogsearch_result_index'
                ]
            ],
            (new Converter())->convert($document)
        );
    }
}
