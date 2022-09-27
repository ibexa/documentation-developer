---
description: One-page checkout form covers providing customer information, addresses, payment and shipping methods.
edition: commerce
---

# Checkout

[[= product_name =]] provides a multi-step checkout process that takes place on one page.

![](checkout.png)

## Email templates

Local order [confirmation emails](order_confirmation.md) are based on the standard order confirmation email templates:
`checkout/Email/order_confirmation.txt.twig` and `checkout/Email/order_confirmation.html.twig`

## PDF invoice

At the end of the local checkout process, the shop generates and stores invoice data, and generates a PDF with the invoice information.
Then this information is sent by email.

The PDF is created using [`wkhtmltopdf`](http://wkhtmltopdf.org).
You must install the latest stable version of`wkhtmltopdf` on the server.

You can configure the path where `wkhtmltopdf` is located in `LocalOrderManagementBundle/Resources/config/local_order_management.yml`:

``` yaml
ibexa.commerce.site_access.config.order.management.local.default.wkhtmltopdf_server_path: '/usr/bin/wkhtmltopdf'
```

The PDF content (and the header and/or footer) is stored as HTML and removed directly after usage.

The first part of the PDF filename is translatable (`common.invoice_`) and the second part consists of a prefix and the invoice number.

### Invoice header and footer

By default, the invoice PDF contains one header at the beginning and one footer at the end of the document.

You can also configure the header and footer to be placed on each PDF page:

``` yaml
ibexa_commerce_local_order_management.default.generate_footer_for_pdf: true
ibexa_commerce_local_order_management.default.generate_header_for_pdf: true
```

In this case, the header and/or footer are generated using these separate templates:

- `src/bundle/Eshop/Resources/views/Invoice/header.html.twig`
- `src/bundle/Eshop/Resources/views/Invoice/footer.html.twig`
