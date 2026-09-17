---
description: Manage image assets.
month_change: false
---

# Images

Images are an integral part of any website.
They can serve as decoration and convey information.

## Reuse images

You can store images in the media library as independent content items of a generic Image [content type](content_types.md) to reuse them across the system.
You do this by uploading images to an [ImageAsset](imageassetfield.md) field type.

For an ImageAsset field to be reused, you must publish it.
Only then is notification triggered, which states that an image has been published under the location and can now be reused.
After you establish a media library, you can create [Relations](content_relations.md) between the image content item and the main content item that uses it.

## Edit images

When a content item contains fields of the [`ibexa_image`](imageassetfield.md) type, users can perform basic image editing functions with the Image Editor.
For more information, see [User Documentation]([[= user_doc =]]/image_management/edit_images/).

## Embedding images in Rich Text

The [RichText](richtextfield.md) field allows you to embed other content items within the field.

Content items that are identified as images are rendered in the Rich Text field.
