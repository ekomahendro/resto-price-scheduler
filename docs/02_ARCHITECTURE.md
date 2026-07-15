# ARCHITECTURE

```
resto-price-scheduler

admin/

Dashboard

Product List

Export

Import

Preview

includes/

Admin

Export

Import

Validator

Product

History

Scheduler

services/

Excel

Price Engine

Import Session

History Engine

models/

History

Schedule

Session

vendor/

PhpSpreadsheet

docs/
```

---

Semua perubahan harga akan menggunakan satu engine.

Import

↓

Price Engine

↓

WooCommerce

Scheduler

↓

Price Engine

↓

WooCommerce

REST API

↓

Price Engine

↓

WooCommerce