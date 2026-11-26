# Infrangible Catalog Product Filter Url

Product links on filtered category and search result pages carry the selected filters, so the product page opens with
the matching options of a configurable product already selected: a shopper who filtered by "Color: Yellow" and
"Size: M" does not have to choose them again.

## How it works

- A plugin on `Magento\Catalog\Model\Product::getProductUrl()` appends the filters of the layered navigation that the
  request applies as URL fragment, on the pages of the actions in `etc/catalog_product_filter_url.xml` (category and
  search result pages), for example `/breathe-easy-tank.html#color=60&size=168&93=60&144=168`.
- Every option is added with the code of its attribute (`color=60`), which Magento's swatches and the Hyvä theme read,
  and with the ID of its attribute (`93=60`), which Magento's dropdown lists of configurable options read.
- Only product attributes that the layered navigation filters by are added; other parameters (search term, page,
  sort order) are not.
- The fragment is not sent to the server, so the product page address stays the same for caches and search engines.

Dropdown lists of configurable options depend on each other: an option of the second list is only selected together
with an option of the first one, as Magento selects them.

Other modules can add actions in their own `etc/catalog_product_filter_url.xml`:

```xml
<config>
    <catalog_product_filter_url>
        <action id="brand">brand_page_view</action>
    </catalog_product_filter_url>
</config>
```

For Hyvä themes, the module `infrangible/m2-catalog-product-filter-url-hyva` selects the options on product pages.

## Requirements

- Magento Open Source or Adobe Commerce 2.4.6 or newer
- PHP 8.1 or newer

## Installation

```bash
composer require infrangible/m2-catalog-product-filter-url
bin/magento module:enable Infrangible_CatalogProductFilterUrl
bin/magento setup:upgrade
```

In production mode, also run `bin/magento setup:di:compile`.

## License

Infrangible Catalog Product Filter Url is licensed under the MIT License - see the LICENSE file for details.
