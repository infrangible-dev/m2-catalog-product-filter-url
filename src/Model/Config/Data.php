<?php

declare(strict_types=1);

namespace Infrangible\CatalogProductFilterUrl\Model\Config;

use Magento\Framework\Config\CacheInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Infrangible\CatalogProductFilterUrl\Model\Config\Data\Reader;

/**
 * @author      Philipp Adler
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Data
    extends \Magento\Framework\Config\Data
{
    public function __construct(
        Reader $reader,
        CacheInterface $cache,
        SerializerInterface $serializer = null)
    {
        parent::__construct($reader, $cache, 'catalog_product_filter_url_config', $serializer);
    }
}
