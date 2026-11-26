<?php

declare(strict_types=1);

/**
 * @author      Philipp Adler
 * @copyright   Copyright (c) 2014-2026 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Infrangible\CatalogProductFilterUrl\Model\Config;

use Infrangible\CatalogProductFilterUrl\Model\Config\Data\Reader;
use Magento\Framework\Config\CacheInterface;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * The actions of catalog_product_filter_url.xml of all modules, cached.
 */
class Data extends \Magento\Framework\Config\Data
{
    /**
     * @param Reader $reader
     * @param CacheInterface $cache
     * @param SerializerInterface|null $serializer
     */
    public function __construct(
        Reader $reader,
        CacheInterface $cache,
        ?SerializerInterface $serializer = null
    ) {
        parent::__construct(
            $reader,
            $cache,
            'catalog_product_filter_url_config',
            $serializer
        );
    }
}
