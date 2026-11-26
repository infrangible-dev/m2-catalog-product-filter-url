<?php

declare(strict_types=1);

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2026 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Infrangible\CatalogProductFilterUrl\Helper;

use FeWeDev\Base\Variables;
use Infrangible\Core\Helper\Attribute;
use Magento\Catalog\Api\Data\EavAttributeInterface;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute as EntityAttribute;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Exception\LocalizedException;

/**
 * The filters of the layered navigation that the request applies, as the query of the URL fragment of product links.
 */
class Data
{
    /** @var string|null the query, once extracted */
    private ?string $query = null;

    /**
     * @param Attribute $attributeHelper
     * @param Http $request
     * @param Variables $variables
     */
    public function __construct(
        protected Attribute $attributeHelper,
        protected Http $request,
        protected Variables $variables
    ) {
    }

    /**
     * Returns the applied filters of the request as query of the URL fragment of product links.
     *
     * Every option is added with the code of its attribute ("color=60"), which the swatches and the Hyvä theme read,
     * and with the ID of its attribute ("93=60"), which the options without swatches read (configurable.js).
     *
     * @return string
     */
    public function extractQuery(): string
    {
        if ($this->query === null) {
            $codePairs = [];
            $idPairs = [];

            foreach ($this->request->getParams() as $code => $value) {
                $attribute = $this->getFilterableAttribute((string)$code);

                if ($attribute === null) {
                    continue;
                }

                foreach (is_array($value) ? $value : [$value] as $optionValue) {
                    $optionValue = is_scalar($optionValue) ? rawurlencode((string)$optionValue) : '';

                    if ($optionValue === '') {
                        continue;
                    }

                    $codePairs[] = sprintf('%s=%s', rawurlencode((string)$attribute->getAttributeCode()), $optionValue);
                    $idPairs[] = sprintf('%d=%s', $this->variables->intValue($attribute->getId()), $optionValue);
                }
            }

            $this->query = implode('&', array_merge($codePairs, $idPairs));
        }

        return $this->query;
    }

    /**
     * Checks whether the code is the code of a product attribute that the layered navigation filters by.
     *
     * @param string $code
     *
     * @return bool
     */
    public function isProductAttribute(string $code): bool
    {
        return $this->getFilterableAttribute($code) !== null;
    }

    /**
     * Returns the product attribute with the code if the layered navigation filters by it (with or without results).
     *
     * @param string $code
     *
     * @return EntityAttribute|null
     */
    private function getFilterableAttribute(string $code): ?EntityAttribute
    {
        try {
            $attribute = $this->attributeHelper->getAttribute(Product::ENTITY, $code);
        } catch (LocalizedException) {
            return null;
        }

        if (! $attribute instanceof EavAttributeInterface) {
            return null;
        }

        return in_array((int)$attribute->getIsFilterable(), [1, 2], true) ? $attribute : null;
    }
}
