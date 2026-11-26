<?php

declare(strict_types=1);

/**
 * @author      Philipp Adler
 * @copyright   Copyright (c) 2014-2026 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Infrangible\CatalogProductFilterUrl\Model\Config\Data;

use DOMDocument;
use DOMNode;
use Magento\Framework\Config\ConverterInterface;

/**
 * Converts catalog_product_filter_url.xml into the full action names by ID: <action id="category">catalog_category_view
 * </action>; without ID, the full action name is the ID.
 */
class Converter implements ConverterInterface
{
    /**
     * Returns the full action names by ID in "catalog_product_filter_url".
     *
     * @param DOMDocument $source
     *
     * @return array<string, array<string, string>>
     */
    public function convert($source): array
    {
        $result = [];

        foreach ($source->childNodes as $childNode) {
            if ($childNode->nodeName !== 'config') {
                continue;
            }

            foreach ($childNode->childNodes as $sectionNode) {
                if ($sectionNode->nodeName === 'catalog_product_filter_url') {
                    $result = $this->addActions($result, $sectionNode);
                }
            }
        }

        return $result;
    }

    /**
     * Adds the actions of the node.
     *
     * @param array $result
     * @phpstan-param array<string, array<string, string>> $result
     * @param DOMNode $sectionNode
     *
     * @return array<string, array<string, string>>
     */
    private function addActions(array $result, DOMNode $sectionNode): array
    {
        foreach ($sectionNode->childNodes as $actionNode) {
            if ($actionNode->nodeName !== 'action') {
                continue;
            }

            $action = trim((string)$actionNode->nodeValue);
            $id = trim((string)$actionNode->attributes?->getNamedItem('id')?->nodeValue);

            if ($action !== '') {
                $result[ 'catalog_product_filter_url' ][ $id === '' ? $action : $id ] = $action;
            }
        }

        return $result;
    }
}
