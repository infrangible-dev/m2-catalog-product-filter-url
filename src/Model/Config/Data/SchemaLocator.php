<?php

declare(strict_types=1);

namespace Infrangible\CatalogProductFilterUrl\Model\Config\Data;

use Magento\Framework\Config\SchemaLocatorInterface;

/**
 * @author      Philipp Adler
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class SchemaLocator implements SchemaLocatorInterface
{
    public function getSchema(): ?string
    {
        return null;
    }

    public function getPerFileSchema(): ?string
    {
        return null;
    }
}
