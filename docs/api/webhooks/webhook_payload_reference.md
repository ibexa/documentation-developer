---
description: Structure of webhook requests, available event types, and how to verify webhook signatures in the receiving application.
month_change: false
---

# Webhook payload reference

Every webhook delivery is an HTTP `POST` request sent to the payload URL of the webhook.
The request carries a JSON body, called the envelope, and a set of headers that identify and sign the delivery.

Use this reference when you build an application that receives webhooks from [[= product_name =]].

## Request headers

| Header | Example value | Description |
|---|---|---|
| `Content-Type` | `application/json` | Always `application/json`. |
| `X-Cohesivo-Event` | `content.published` | Identifier of the [event type](#event-types). |
| `X-Cohesivo-Delivery` | `0198f0c2-6b1e-7c3a-9d4e-1f2a3b4c5d6e` | UUID of the delivery, as shown in the delivery log. |
| `X-Cohesivo-Timestamp` | `1756376400` | Unix timestamp, in seconds, of the moment the request was sent. |
| `X-Cohesivo-Signature` | `sha256=a3f5…` | HMAC signature of the request, in the `<algorithm>=<hex digest>` format. |

The name of the signature header and the hashing algorithm can be [changed in configuration](configure_webhooks.md#configuration-reference).

## Envelope

The request body is a JSON object with the following properties:

| Property | Type | Description |
|---|---|---|
| `id` | string | UUID of the delivery for which the envelope was created. It doesn't change when the delivery is re-sent, so you can use it to detect duplicates. |
| `event` | string | Identifier of the [event type](#event-types), for example, `content.published`. |
| `occurredAt` | string | Date and time when the event occurred, in the RFC 3339 format. |
| `actor.id` | integer or `null` | ID of the user who triggered the event, or `null` if the event was triggered by the system. |
| `actor.type` | string | `user` when `actor.id` is set, `system` otherwise. |
| `identifiers` | object | Identifiers of the affected content, location, or other objects. The keys depend on the [event type](#event-types). |
| `links` | object | REST API URIs of the affected objects. See [Links](#links). |

`identifiers` and `links` are always JSON objects.
When they have no members, they're serialized as `{}`.

The envelope is encoded once, when the delivery is created, and the same bytes are sent with every attempt, so the signature always covers exactly the body that you receive.

A machine-readable [JSON Schema](https://json-schema.org/) of the envelope is available in the REST API reference as the `WebhookPayload` schema.

### Example envelope

The following example shows a `content.published` delivery triggered by the user with ID 14:

``` json
{
    "id": "0198f0c2-6b1e-7c3a-9d4e-1f2a3b4c5d6e",
    "event": "content.published",
    "occurredAt": "2026-08-28T10:20:00+00:00",
    "actor": {
        "id": 14,
        "type": "user"
    },
    "identifiers": {
        "contentId": 42,
        "languageCode": "eng-GB",
        "locationId": 58,
        "versionNo": 3,
        "languageCodes": ["eng-GB", "ger-DE"]
    },
    "links": {
        "content": "/api/ibexa/v2/content/objects/42",
        "location": "/api/ibexa/v2/content/locations/58"
    }
}
```

### Identifiers

The following keys can appear in the `identifiers` object:

| Key | Type | Description |
|---|---|---|
| `contentId` | integer | ID of the content item. |
| `languageCode` | string | Main language code of the content item. |
| `locationId` | integer | ID of the affected location. For events that concern a content item, it's the ID of its main location, if the content item has one. |
| `versionNo` | integer | Number of the version that the event concerns. |
| `languageCodes` | array of strings | Language codes of all translations in the version. |
| `objectStateId` | integer | ID of the object state. |
| `objectStateIdentifier` | string | Identifier of the object state. |
| `objectStateGroupId` | integer | ID of the object state group. |
| `objectStateGroupIdentifier` | string | Identifier of the object state group. |

Event types added by developers can include other keys.
For more information, see [Extend webhooks](extend_webhooks.md#custom-extractor).

### Links

The `links` object contains URIs of REST API resources that you can use to fetch more data about the affected objects:

| Key | URI pattern | Present when |
|---|---|---|
| `content` | `/api/ibexa/v2/content/objects/<contentId>` | `identifiers.contentId` is set |
| `location` | `/api/ibexa/v2/content/locations/<locationId>` | `identifiers.locationId` is set |

The URIs are relative to the host of [[= product_name =]].
To access the resources, the receiving application must [authenticate](rest_api_authentication.md) as a user with sufficient permissions.

!!! note "Deleted content"

    For events such as `content.deleted`, `location.deleted`, or `trash.emptied`, the linked resources might no longer exist when the receiver processes the delivery.

## Event types

The following event types are available out of the box.
The **Identifiers** column lists the keys of the [`identifiers`](#identifiers) object, and the **Filters** column indicates whether [content type, section, and subtree filters](webhooks_guide.md#filters) apply to the event.

| Event type | Triggered when | Identifiers | Filters |
|---|---|---|---|
| `content.published` | a content version is published | `contentId`, `languageCode`, `locationId`, `versionNo`, `languageCodes` | Yes |
| `content.created` | a content item (its first draft) is created | `contentId`, `languageCode`, `locationId`, `versionNo`, `languageCodes` | Yes |
| `content.deleted` | a content item is deleted | `contentId`, `languageCode`, `locationId` | Yes |
| `content.hidden` | a content item is hidden | `contentId`, `languageCode`, `locationId` | Yes |
| `content.revealed` | a content item is revealed | `contentId`, `languageCode`, `locationId` | Yes |
| `content.copied` | a content item is copied; identifiers refer to the copy | `contentId`, `languageCode`, `locationId`, `versionNo`, `languageCodes` | Yes |
| `content.metadata_updated` | content metadata, such as the owner, main language, or publication date, is updated | `contentId`, `languageCode`, `locationId`, `versionNo`, `languageCodes` | Yes |
| `trash.trashed` | a location is sent to trash | `contentId`, `languageCode`, `locationId` | Yes |
| `trash.recovered` | an item is restored from trash | `contentId`, `languageCode`, `locationId` | Yes |
| `trash.emptied` | the trash is emptied | none | No |
| `location.created` | a location is created | `contentId`, `languageCode`, `locationId` | Yes |
| `location.moved` | a subtree is moved | `contentId`, `languageCode`, `locationId` | Yes |
| `location.deleted` | a location is deleted | `contentId`, `languageCode`, `locationId` | Yes |
| `location.hidden` | a location is hidden | `contentId`, `languageCode`, `locationId` | Yes |
| `location.unhidden` | a location is revealed | `contentId`, `languageCode`, `locationId` | Yes |
| `location.swapped` | two locations are swapped | none | No |
| `user.created` | a user is created | `contentId`, `languageCode`, `locationId`, `versionNo`, `languageCodes` | Yes |
| `user.updated` | a user is updated | `contentId`, `languageCode`, `locationId`, `versionNo`, `languageCodes` | Yes |
| `user.deleted` | a user is deleted | `contentId`, `languageCode`, `locationId`, `versionNo`, `languageCodes` | Yes |
| `section.assigned` | a section is assigned to a content item; the section filter matches the newly assigned section | `contentId`, `languageCode`, `locationId` | Yes |
| `object_state.set` | an object state is set on a content item | `contentId`, `languageCode`, `locationId`, `objectStateId`, `objectStateIdentifier`, `objectStateGroupId`, `objectStateGroupIdentifier` | Yes |

For `location.*` and `trash.*` events, `locationId` is the ID of the affected location, and the subtree filter is evaluated against that location.
For other events, the subtree filter is evaluated against the main location of the content item.

`locationId` is omitted if the content item has no main location, for example, for a draft that has never been published.

To get the list of event types available in your installation, including custom ones, use the `GET /api/ibexa/v2/webhook-event-types` [REST API endpoint](webhooks_api.md#rest-api).

## Test deliveries

A test delivery, sent from the back office or with the [REST API](webhooks_api.md#rest-api), uses the first event type that the webhook subscribes to, and the user who requested the test as the actor.
Its `identifiers` and `links` objects are empty:

``` json
{
    "id": "0198f0c2-6b1e-7c3a-9d4e-1f2a3b4c5d6e",
    "event": "content.published",
    "occurredAt": "2026-08-28T10:20:00+00:00",
    "actor": {
        "id": 14,
        "type": "user"
    },
    "identifiers": {},
    "links": {}
}
```

Make sure that your receiver accepts such requests, for example, by responding with `204 No Content` without processing them.

## Re-sent deliveries

When a delivery is re-sent, a new delivery with a new ID is created, but it reuses the original envelope.
As a result:

- the `X-Cohesivo-Delivery` header contains the ID of the new delivery
- the `id`, `occurredAt`, and `actor` properties of the envelope keep their original values
- the `X-Cohesivo-Timestamp` header and the signature are computed when the request is sent

Use the envelope `id` as an idempotency key to avoid processing the same event twice.

## Signature verification

### How the signature is computed

The signature is an HMAC of the timestamp and the raw request body, joined with a dot:

```
HMAC-SHA256(secret, timestamp + "." + rawBody)
```

Where:

- `secret` is the signing secret of the webhook, displayed once after the webhook is created or its secret is regenerated
- `timestamp` is the value of the `X-Cohesivo-Timestamp` header
- `rawBody` is the request body exactly as received, before any JSON parsing

The hex-encoded digest is sent in the `X-Cohesivo-Signature` header, prefixed with the name of the algorithm, for example, `sha256=a3f5…`.

To verify a request:

1. Read the timestamp header and reject the request if the timestamp is too old.
1. Compute the HMAC of `<timestamp>.<rawBody>` with the signing secret.
1. Compare the result with the digest from the signature header, using a constant-time comparison function.

!!! caution "Use the raw body"

    Compute the signature over the raw body.
    If you decode and re-encode the JSON before verification, the bytes might differ, for example, in whitespace or character escaping, and the verification fails.

### Verify signature in PHP

``` php
<?php

function verifyWebhookSignature(
    string $rawBody,
    string $signatureHeader,
    string $timestampHeader,
    string $secret,
    int $maxAgeSeconds = 300,
): bool {
    $timestamp = (int) $timestampHeader;

    // Replay protection: reject requests older than $maxAgeSeconds
    if (abs(time() - $timestamp) > $maxAgeSeconds) {
        return false;
    }

    if (!str_contains($signatureHeader, '=')) {
        return false;
    }
    [$algo, $expected] = explode('=', $signatureHeader, 2);

    $computed = hash_hmac($algo, $timestamp . '.' . $rawBody, $secret);

    return hash_equals($computed, $expected);
}
```

The following example shows how to use the function in a Symfony controller:

``` php
$isValid = verifyWebhookSignature(
    $request->getContent(),
    (string) $request->headers->get('X-Cohesivo-Signature'),
    (string) $request->headers->get('X-Cohesivo-Timestamp'),
    $webhookSecret,
);

if (!$isValid) {
    return new Response('Invalid signature', Response::HTTP_FORBIDDEN);
}

$payload = json_decode($request->getContent(), true, flags: JSON_THROW_ON_ERROR);
```

### Verify signature in Node.js

``` js
const crypto = require('crypto');

function verifyWebhookSignature(rawBody, headers, secret, maxAgeSeconds = 300) {
    const signatureHeader = headers['x-cohesivo-signature'] ?? '';
    const timestamp = parseInt(headers['x-cohesivo-timestamp'] ?? '0', 10);

    // Replay protection
    if (Math.abs(Date.now() / 1000 - timestamp) > maxAgeSeconds) {
        return false;
    }

    const separator = signatureHeader.indexOf('=');
    if (separator === -1) {
        return false;
    }

    const algo = signatureHeader.slice(0, separator);
    const expected = Buffer.from(signatureHeader.slice(separator + 1));
    const computed = Buffer.from(
        crypto.createHmac(algo, secret).update(`${timestamp}.${rawBody}`).digest('hex')
    );

    return computed.length === expected.length && crypto.timingSafeEqual(computed, expected);
}
```

### Replay protection

The `X-Cohesivo-Timestamp` header allows the receiver to reject requests that were captured and sent again by an attacker.
The examples above reject requests whose timestamp differs from the current time by more than 300 seconds.
Keep the clocks of the receiving servers synchronized, and avoid tolerance windows longer than 600 seconds.

## Best practices for receivers

- Respond with a `2xx` status code as soon as you've verified and stored the request, and process it in the background.
Requests that take longer than the [configured timeout](configure_webhooks.md#configuration-reference) are considered failed.
- Make processing idempotent.
Because of retries and re-sending, the same event can be delivered more than once.
Use the envelope `id` to detect duplicates.
- Don't rely on the order of deliveries.
Retries can cause events to arrive in a different order than the one in which they occurred.
Use `occurredAt`, or fetch the current state of the object from the REST API.
- Use HTTPS payload URLs, so that payloads aren't transmitted in plain text.
