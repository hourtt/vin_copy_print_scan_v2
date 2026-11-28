## Product & Compatibility Architecture

- **Catalog (`products`)**: Everything for sale (Printers, Toners, Inks, Papers). Works independently.
- **Directory (`brands` -> `printer_models`)**: Master list of printers for compatibility lookup (no prices/stock).
- **Bridge (`product_compatible_models`)**: Links Toners/Inks to the Printer Models they fit.

### Lookup Flows
- **Browse Store:** `Category` -> `Products` (filterable by `Brand`)
- **Find by Printer:** `Brand` -> `PrinterModel` -> `product_compatible_models` -> `Compatible Products`