<?php

declare(strict_types=1);

namespace Infrangible\CatalogProductFilterUrl\Model\Config\Data;

use Magento\Framework\Config\Dom;
use Magento\Framework\Config\FileResolverInterface;
use Magento\Framework\Config\Reader\Filesystem;

/**
 * @author      Philipp Adler
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Reader
    extends Filesystem
{
    /** @var array */
    protected $_idAttributes = [
        '/config/catalog_product_filter_url/action' => 'id'
    ];

    /**
     * @param FileResolverInterface $fileResolver
     * @param Converter             $converter
     * @param SchemaLocator         $schemaLocator
     * @param ValidationState       $validationState
     * @param array                 $idAttributes
     * @param string                $domDocumentClass
     * @param string                $defaultScope
     */
    public function __construct(
        FileResolverInterface $fileResolver,
        Converter $converter,
        SchemaLocator $schemaLocator,
        ValidationState $validationState,
        $idAttributes = [],
        $domDocumentClass = Dom::class,
        $defaultScope = 'global'
    ) {
        parent::__construct(
            $fileResolver,
            $converter,
            $schemaLocator,
            $validationState,
            'catalog_product_filter_url.xml',
            $idAttributes,
            $domDocumentClass,
            $defaultScope
        );
    }
}
