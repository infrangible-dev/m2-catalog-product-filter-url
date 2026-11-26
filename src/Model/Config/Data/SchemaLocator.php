<?php

declare(strict_types=1);

/**
 * @author      Philipp Adler
 * @copyright   Copyright (c) 2014-2026 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Infrangible\CatalogProductFilterUrl\Model\Config\Data;

use Magento\Framework\Config\SchemaLocatorInterface;

/**
 * catalog_product_filter_url.xml has no schema.
 */
class SchemaLocator implements SchemaLocatorInterface
{
    /**
     * Returns no schema of the merged files.
     *
     * @return string|null
     */
    public function getSchema(): ?string
    {
        return null;
    }

    /**
     * Returns no schema of the single files.
     *
     * @return string|null
     */
    public function getPerFileSchema(): ?string
    {
        return null;
    }
}
