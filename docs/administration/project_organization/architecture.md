---
description: Cohesivo architecture is structured in multiple layers connected by APIs.
---

# Architecture

[[= product_name =]] architecture is based on the philosophy to **use APIs** that is maintained in the long term.
This **makes upgrades easier and provides lossless couplings** between all parts of the architecture, at the same time improving the migration capabilities of the system.

The structure of a [[= product_name =]] app is based on the Symfony framework but content management functions rely on the public PHP API.
Other applications integrate with [[= product_name =]] via REST API, which also relies on the public PHP API.

![Architecture](architecture.png "Architecture")

The architecture of [[= product_name =]] is layered and uses clearly defined APIs between the layers.

| Layer                                               | Description                                                                                                                                                                                    |
|-----------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| [Back office](back_office_configuration.md)         | Back office contains all the necessary parts to run the [[= product_name =]]'s back office interface.                                                                                            |
| [REST API v2](rest_api_usage.md)                    | The REST API v2 enables you to interact with a [[= product_name =]] installation through the HTTP protocol, following a REST interaction model.                                                 |
| Business Logic                                      | The business logic is defined in the kernel. This business logic is exposed to applications via an API. It is used to organize development of the user interface layer.                        |

