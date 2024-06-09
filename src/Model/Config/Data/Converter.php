<?php

declare(strict_types=1);

namespace Infrangible\CatalogProductFilterUrl\Model\Config\Data;

use DOMDocument;
use DOMNode;
use Magento\Framework\Config\ConverterInterface;

/**
 * @author      Philipp Adler
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Converter
    implements ConverterInterface
{
    /**
     * Convert config
     *
     * @param DOMDocument $source
     *
     * @return array
     */
    public function convert($source): array
    {
        $result = [];

        /** @var DOMNode $childNode */
        foreach ($source->childNodes as $childNode) {
            if ($childNode->nodeName === 'config') {
                /** @var DOMNode $childChildNode */
                foreach ($childNode->childNodes as $childChildNode) {
                    $this->addAction($result, $childChildNode);
                }
            }
        }

        return $result;
    }

    /**
     * @param array   $result
     * @param DOMNode $childChildNode
     */
    private function addAction(array &$result, DOMNode $childChildNode)
    {
        if ($childChildNode->nodeName === 'catalog_product_filter_url') {
            foreach ($childChildNode->childNodes as $childChildChildNode) {
                $id = null;
                $action = null;

                if ($childChildChildNode->nodeName === 'action') {
                    $attributes = $childChildChildNode->attributes;

                    if ($attributes) {
                        $idNode = $attributes->getNamedItem('id');

                        if ($idNode) {
                            $id = (string) $idNode->nodeValue;
                        }

                        $action = (string) $childChildChildNode->nodeValue;

                        if (empty($id)) {
                            $id = $action;
                        }
                    }
                }

                if (!empty($id) && !empty($action)) {
                    $result['catalog_product_filter_url'][$id] = $action;
                }
            }
        }
    }
}
