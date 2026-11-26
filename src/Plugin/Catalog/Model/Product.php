<?php

declare(strict_types=1);

/**
 * @author      Philipp Adler
 * @copyright   Copyright (c) 2014-2026 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Infrangible\CatalogProductFilterUrl\Plugin\Catalog\Model;

use Infrangible\CatalogProductFilterUrl\Helper\Data as Helper;
use Infrangible\CatalogProductFilterUrl\Model\Config\Data;
use Magento\Catalog\Model\Product as CatalogProduct;
use Magento\Framework\App\Request\Http;

/**
 * Adds the applied filters of the layered navigation as URL fragment to the links of products in the product lists of
 * the actions in catalog_product_filter_url.xml (category and search result pages).
 */
class Product
{
    /**
     * @param Helper $helper
     * @param Data $config
     * @param Http $request
     */
    public function __construct(
        protected Helper $helper,
        protected Data $config,
        protected Http $request
    ) {
    }

    /**
     * Adds the applied filters to the URL of the product.
     *
     * @noinspection PhpUnusedParameterInspection
     *
     * @param CatalogProduct $subject
     * @param string $result
     *
     * @return string
     */
    public function afterGetProductUrl(CatalogProduct $subject, string $result): string
    {
        if (! $this->isValidAction()) {
            return $result;
        }

        $query = $this->helper->extractQuery();

        // as fragment, a parameter would be URL-encoded; a browser ignores it if the URL has a fragment already
        return $query === '' ? $result : sprintf('%s#%s', $result, $query);
    }

    /**
     * Checks whether the current action shows product lists with filters.
     *
     * @return bool
     */
    private function isValidAction(): bool
    {
        $actions = $this->config->get('catalog_product_filter_url');

        return is_array($actions) && in_array($this->request->getFullActionName(), $actions, true);
    }
}
