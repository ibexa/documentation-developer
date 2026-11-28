---
description: Manage webhooks and their delivery log with the PHP API and the REST API.
month_change: false
---

# Webhooks API

You can manage webhooks, browse their delivery log, send test deliveries, and re-send deliveries with the [PHP API](#php-api) and the [REST API](#rest-api).
Both APIs check the [`webhook` policies](permissions/policies.md#webhooks) of the current user.

!!! note

    This page is about webhooks management.
    To create a new webhook event type, see [Extend webhooks](extend_webhooks.md).

## PHP API

### Manage webhooks

To manage webhooks, use the [`WebhookServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Webhooks-Service-WebhookServiceInterface.html) service.

The following methods are available:

| Method | Required policy | Description |
|---|---|---|
| `createWebhook(WebhookCreateStruct $struct): Webhook` | `webhook/create` | Creates a webhook owned by the current user and generates its signing secret. |
| `loadWebhook(int $id): Webhook` | `webhook/read` | Loads a webhook by its ID. |
| `loadWebhooks(?int $limit = null, int $offset = 0): array` | `webhook/read` | Loads a list of webhooks. |
| `countWebhooks(): int` | `webhook/read` | Returns the number of webhooks. |
| `updateWebhook(int $id, WebhookUpdateStruct $struct): Webhook` | `webhook/update` | Updates a webhook. Properties set to `null` remain unchanged. |
| `deleteWebhook(int $id): void` | `webhook/delete` | Deletes a webhook together with its delivery log. |
| `regenerateSecret(int $id): Webhook` | `webhook/update` | Generates a new signing secret. The previous secret stops working immediately. |

When you create or update a webhook, the service validates that:

- the URL is an absolute URL with the `http` or `https` scheme
- the webhook subscribes to at least one event type

If validation fails, the service throws an `InvalidWebhookException`.

The following example creates a webhook that notifies an external system when articles in a specific subtree are published or deleted:

``` php
use Ibexa\Contracts\Webhooks\Service\WebhookServiceInterface;
use Ibexa\Contracts\Webhooks\Value\WebhookCreateStruct;
use Ibexa\Contracts\Webhooks\Value\WebhookFilters;

$createStruct = new WebhookCreateStruct();
$createStruct->name = 'CRM integration';
$createStruct->url = 'https://crm.example.com/hooks/ibexa';
$createStruct->eventTypes = ['content.published', 'content.deleted'];
$createStruct->filters = new WebhookFilters(
    contentTypeIdentifiers: ['article'],
    sectionIds: [1],
    subtreePathStrings: ['/1/2/'],
);

$webhook = $this->webhookService->createWebhook($createStruct);
```

To disable a webhook, update its `enabled` property:

``` php
use Ibexa\Contracts\Webhooks\Value\WebhookUpdateStruct;

$updateStruct = new WebhookUpdateStruct();
$updateStruct->enabled = false;

$this->webhookService->updateWebhook($webhook->id, $updateStruct);
```

!!! note "Signing secret"

    The `Webhook::$secret` property contains the signing secret in its encrypted form.
    To share the plaintext secret with the receiving system, decrypt it with the `SecretEncrypterInterface` service right after you create the webhook or regenerate its secret.

### Value objects

| Class | Description |
|---|---|
| [`Webhook`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Webhooks-Value-Webhook.html) | Read-only representation of a webhook: `id`, `name`, `url`, `secret` (encrypted), `enabled`, `eventTypes`, `filters`, `ownerId`, `consecutiveFailures`, `disabledReason`, `disabledAt`, `createdAt`, `modifiedAt`. |
| [`WebhookCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Webhooks-Value-WebhookCreateStruct.html) | Data of a new webhook: `name`, `url`, `enabled` (default `true`), `eventTypes`, `filters`. |
| [`WebhookUpdateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Webhooks-Value-WebhookUpdateStruct.html) | Changes to a webhook. Properties set to `null` remain unchanged. |
| [`WebhookFilters`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Webhooks-Value-WebhookFilters.html) | Filters of a webhook: `contentTypeIdentifiers`, `sectionIds`, `subtreePathStrings`. |
| [`WebhookDelivery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Webhooks-Value-WebhookDelivery.html) | Entry of the delivery log: `id`, `webhookId`, `eventType`, `status`, `attempt`, `responseCode`, `durationMs`, `error`, `requestPayload`, `isTest`, `createdAt`, `deliveredAt`. |
| [`DeliveryStatus`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Webhooks-Value-DeliveryStatus.html) | Enumeration of delivery statuses: `Pending`, `Success`, `Failed`, `Skipped`. |

`WebhookDelivery::$attempt` is the number of failed attempts made so far, and `WebhookDelivery::$requestPayload` contains the JSON envelope exactly as it's sent in the request body.
For more information about the envelope, see [Webhook payload reference](webhook_payload_reference.md#envelope).

### Browse the delivery log

| Method | Required policy | Description |
|---|---|---|
| `loadDeliveries(int $webhookId, ?int $limit = null, int $offset = 0, ?string $status = null): array` | `webhook/read` | Loads deliveries of a webhook, newest first, optionally limited to the given status. |
| `countDeliveries(int $webhookId, ?string $status = null): int` | `webhook/read` | Returns the number of deliveries of a webhook. |
| `loadDelivery(string $id, ?int $webhookId = null): WebhookDelivery` | `webhook/read` | Loads a delivery by its ID. If you pass a webhook ID, the delivery must belong to that webhook. |

The following example loads the 10 most recent failed deliveries of a webhook:

``` php
use Ibexa\Contracts\Webhooks\Value\DeliveryStatus;

$failedDeliveries = $this->webhookService->loadDeliveries(
    $webhook->id,
    limit: 10,
    status: DeliveryStatus::Failed->value,
);
```

### Send test deliveries

`sendTest(int $id): WebhookDelivery` queues a [test delivery](webhook_payload_reference.md#test-deliveries) and returns it with the `pending` status.
It requires the `webhook/test` policy.

### Re-send deliveries

`resendDelivery(string $deliveryId, ?int $webhookId = null): WebhookDelivery` creates a new delivery with the payload of the original one, queues it, and returns it with the `pending` status.
It requires the `webhook/update` policy.
For more information, see [Re-sent deliveries](webhook_payload_reference.md#re-sent-deliveries).

### Event types

To list the event types that webhooks can subscribe to, use the [`WebhookEventTypeRegistryInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Webhooks-Event-WebhookEventTypeRegistryInterface.html) service:

| Method | Description |
|---|---|
| `allByGroup(): array` | Returns all event types, grouped by their group name. |
| `getByIdentifier(string $identifier): WebhookEventType` | Returns the event type with the given identifier, for example, `content.published`. |
| `getByEventClass(string $eventClass): WebhookEventType` | Returns the event type mapped to the given repository event class. |
| `has(string $eventClass): bool` | Checks whether an event type is mapped to the given repository event class. |

### Exceptions

| Exception | Thrown when |
|---|---|
| `InvalidWebhookException` | the URL or the event types of a webhook are invalid, or a test is requested for a webhook without event types |
| `WebhookNotFoundException` | a webhook with the given ID doesn't exist |
| `DeliveryNotFoundException` | a delivery with the given ID doesn't exist or doesn't belong to the given webhook |
| `WebhookEventTypeNotFoundException` | an event type with the given identifier or event class doesn't exist |
| `UnauthorizedException` | the current user doesn't have the required policy |

All webhook-specific exceptions are placed in the `Ibexa\Contracts\Webhooks\Exception` namespace.

## REST API

The REST API exposes the following endpoints.
For details, including request and response schemas, see the [REST API reference](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Webhooks).

| Method | Endpoint | Description | Required policy |
|---|---|---|---|
| `GET` | `/webhooks` | List webhooks. Supports the `offset` and `limit` query parameters. | `webhook/read` |
| `POST` | `/webhooks` | Create a webhook. | `webhook/create` |
| `GET` | `/webhooks/{webhookId}` | Load a webhook. | `webhook/read` |
| `PATCH` | `/webhooks/{webhookId}` | Update a webhook. Only the properties included in the request are changed. | `webhook/update` |
| `DELETE` | `/webhooks/{webhookId}` | Delete a webhook together with its delivery log. | `webhook/delete` |
| `POST` | `/webhooks/{webhookId}/test` | Send a test delivery. Returns `202 Accepted`. | `webhook/test` |
| `GET` | `/webhooks/{webhookId}/deliveries` | List deliveries, newest first. Supports the `offset`, `limit`, and `status` query parameters. | `webhook/read` |
| `GET` | `/webhooks/{webhookId}/deliveries/{deliveryId}` | Load a delivery. | `webhook/read` |
| `POST` | `/webhooks/{webhookId}/deliveries/{deliveryId}/resend` | Re-send a delivery. Returns `202 Accepted`. | `webhook/update` |
| `GET` | `/webhook-event-types` | List the available event types, grouped. | `webhook/read` |

All endpoints are relative to the REST API prefix, by default `/api/ibexa/v2`.
Requests that modify data require the `X-CSRF-Token` header when you use [session authentication](rest_api_authentication.md#session-based-authentication).

### Create webhook

To create a webhook, send a `POST` request with the `application/vnd.ibexa.api.WebhookCreate+json` content type:

``` bash
curl -X POST https://<yourdomain>/api/ibexa/v2/webhooks \
    -H 'Content-Type: application/vnd.ibexa.api.WebhookCreate+json' \
    -H 'Accept: application/vnd.ibexa.api.Webhook+json' \
    -H 'X-CSRF-Token: <csrf_token>' \
    --cookie '<session_cookie>' \
    -d '{
        "WebhookCreate": {
            "name": "CRM integration",
            "url": "https://crm.example.com/hooks/ibexa",
            "enabled": true,
            "eventTypes": ["content.published", "content.deleted"],
            "filters": {
                "contentTypeIdentifiers": ["article"],
                "sectionIds": [1],
                "subtreePathStrings": ["/1/2/"]
            }
        }
    }'
```

`name` and `url` are required.
`enabled` defaults to `true`, and `filters` defaults to no filters.

The `201 Created` response contains the created webhook, including the plaintext signing secret in the `secret` property:

``` json
{
    "Webhook": {
        "_media-type": "application/vnd.ibexa.api.Webhook+json",
        "_href": "/api/ibexa/v2/webhooks/1",
        "id": 1,
        "name": "CRM integration",
        "url": "https://crm.example.com/hooks/ibexa",
        "secret": "4a486cdd6b0c3136f2305e3dc7fbaff06996dcc73c1f24eb7944890474731e17",
        "enabled": true,
        "eventTypes": ["content.published", "content.deleted"],
        "filters": {
            "contentTypeIdentifiers": ["article"],
            "sectionIds": [1],
            "subtreePathStrings": ["/1/2/"]
        },
        "ownerId": 14,
        "consecutiveFailures": 0,
        "disabledReason": null,
        "disabledAt": null,
        "createdAt": "2026-08-28T10:15:30+00:00",
        "modifiedAt": "2026-08-28T10:15:30+00:00"
    }
}
```

!!! caution "Store the signing secret"

    The signing secret is returned only in the response to the `POST /webhooks` request.
    No other endpoint returns it.
    If you lose it, regenerate it in the back office.

### Update webhook

To update a webhook, send a `PATCH` request with the `application/vnd.ibexa.api.WebhookUpdate+json` content type and only the properties that you want to change:

``` json
{
    "WebhookUpdate": {
        "name": "CRM integration (staging)",
        "enabled": false
    }
}
```

When you include `filters`, the whole filter set is replaced, and filter lists that you omit are cleared.
