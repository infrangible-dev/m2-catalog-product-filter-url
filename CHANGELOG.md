# Changelog

## 2.0.0

### Breaking changes

- Requires Magento 2.4.6 or newer and PHP 8.1 or newer. Older versions of Magento and PHP 7.1 to 8.0 are no longer
  supported; use version 1.x for these.
- Requires `infrangible/m2-core` 5.0, `infrangible/m2-foundation` 3.0 and `fewedev/base` 2.4.3.
- The classes have native types and use constructor property promotion.

### Fixed

- Products whose options are dropdown lists (attributes without swatches) opened without the filtered options: the
  links only carried the attribute codes (`#color=60`), but Magento's dropdown lists read attribute IDs. The links
  carry both now (`#color=60&93=60`).

### Changed

- The filter values in the links are URL-encoded.

### Added

- Unit tests.
