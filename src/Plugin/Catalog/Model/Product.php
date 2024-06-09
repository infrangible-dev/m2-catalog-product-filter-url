<?php

declare(strict_types=1);

namespace Infrangible\CatalogProductFilterUrl\Plugin\Catalog\Model;

use Infrangible\CatalogProductFilterUrl\Model\Config\Data;
use Magento\Framework\App\Request\Http;

/**
 * @author      Philipp Adler
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Product
{
    /** @var \Infrangible\CatalogProductFilterUrl\Helper\Data */
    protected $helper;

    /** @var Data */
    protected $config;

    /** @var Http */
    protected $request;

    public function __construct(\Infrangible\CatalogProductFilterUrl\Helper\Data $helper, Data $config, Http $request)
    {
        $this->helper = $helper;
        $this->config = $config;
        $this->request = $request;
    }

    /**
     * @noinspection PhpUnused
     * @noinspection PhpUnusedParameterInspection
     */
    public function afterGetProductUrl(\Magento\Catalog\Model\Product $subject, string $result): string
    {
        // cannot add fragment as parameter since url-encoding is applied
        $suffix = '';

        if ($this->isValidAction()) {
            $query = $this->helper->extractQuery();

            if ($query) {
                $suffix = sprintf('#%s', $query);
            }
        }

        // add fragment part (is ignored if there is already one fragment before the newly added one)
        return sprintf('%s%s', $result, $suffix);
    }

    /**
     * @return bool
     */
    private function isValidAction(): bool
    {
        $fullActionName = $this->request->getFullActionName();

        $config = $this->config->get('catalog_product_filter_url');

        return is_array($config) && in_array($fullActionName, $config);
    }
}
