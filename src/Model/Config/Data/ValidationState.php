<?php

declare(strict_types=1);

/**
 * @author      Philipp Adler
 * @copyright   Copyright (c) 2014-2026 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Infrangible\CatalogProductFilterUrl\Model\Config\Data;

use Magento\Framework\Config\ValidationStateInterface;

/**
 * catalog_product_filter_url.xml is not validated, it has no schema.
 */
class ValidationState implements ValidationStateInterface
{
    /**
     * The files are not validated.
     *
     * @return bool
     */
    public function isValidationRequired(): bool
    {
        return false;
    }
}
