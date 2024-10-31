<?php

declare(strict_types=1);

namespace Infrangible\CatalogProductFilterUrl\Helper;

use FeWeDev\Base\Variables;
use Infrangible\Core\Helper\Attribute;
use Magento\Catalog\Api\Data\EavAttributeInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\Request\Http;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Data
{
    /** @var Attribute */
    protected $attributeHelper;

    /** @var Http */
    protected $request;

    /** @var Variables */
    protected $variables;

    /** @var string|null */
    private $query = null;

    public function __construct(Attribute $attributeHelper, Http $request, Variables $variables)
    {
        $this->attributeHelper = $attributeHelper;
        $this->request = $request;
        $this->variables = $variables;
    }

    public function extractQuery(): string
    {
        if ($this->query === null) {
            $pairs = [];
            $params = $this->request->getParams();

            foreach ($params as $code => $value) {
                if ($this->isProductAttribute($this->variables->stringValue($code))) {
                    try {
                        $attribute = $this->attributeHelper->getAttribute(
                            Product::ENTITY,
                            $this->variables->stringValue($code)
                        );

                        $code = $attribute->getAttributeCode();
                    } catch (\Exception $exception) {
                    }

                    if (! is_array($value)) {
                        $value = [$value];
                    }

                    foreach ($value as $valueValue) {
                        $pairs[] = sprintf(
                            '%s=%s',
                            $code,
                            $valueValue
                        );
                    }
                }
            }

            $this->query = implode(
                '&',
                $pairs
            );
        }

        return $this->query;
    }

    public function isProductAttribute(string $code): bool
    {
        try {
            $attribute = $this->attributeHelper->getAttribute(
                Product::ENTITY,
                $code
            );

            if ($attribute instanceof EavAttributeInterface &&
                ($attribute->getIsFilterable() == 1 || $attribute->getIsFilterable() == 2)) {

                return true;
            }
        } catch (\Exception $exception) {
            // fall-through
        }

        return false;
    }
}
