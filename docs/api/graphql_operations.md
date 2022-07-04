---
description: Use GraphQL operations to create, update, and delete content.
---

# GraphQL operations

Operations on content in GraphQL are performed using [mutations](https://graphql.org/learn/queries/#mutations).
They include creating, updating, and deleting Content items.

The schema contains two mutations per Content Type, e.g. `createFolder` and `updateFolder`.
You can also make use of the generic `deleteContent` and `uploadFiles` mutations.

## Creating content

Create a new Folder as a child of Location `2` with:

```
mutation createFolder {
  createFolder(
    language: eng_GB
    parentLocationId: 2
    input: {
      name: "New Folder"
    }
  ) {
    id
  }
}
```

Response:

```
{
  "data": {
    "createFolder": {
      "id": "RG9tYWluQ29udGVudDo2NA=="
    }
  }
}
```

## Updating content

Modify the name of a Folder Content item with:

```
mutation updateFolder {
  updateFolder(
    language: eng_GB
    contentId: 64
    input: {
      name: "New Folder name"
    }
  ) {
    id
  }
}
```

Response:

```
{
  "data": {
    "updateFolder": {
      "id": "RG9tYWluQ29udGVudDo2NA=="
    }
  }
}
```

Note that the input for updating a Content item is the same as when creating it, but all fields are optional.

## Deleting content

You can delete any Content item by providing its `contentId` (or its GraphQL opaque ID under `id`):

```
mutation deleteBlogPost {
  deleteContent(contentId: 64) {
    id
    contentId
  }
}
```

Response:

```
{
  "data": {
    "deleteContent": {
      "id": "Rm9sZGVyQ29udGVudDo2NA==",
      "contentId": 64
    }
  }
}
```

## File upload

!!! note

    Uploading binary files is not possible through GraphiQL.
    You can use alternative third-party clients such as [Altair GraphQL](https://altair.sirmuel.design/).

Uploading files makes use of dedicated mutations per Content Type, for example:

```
mutation CreateImage($file: FileUpload!) {
  createImage(
    parentLocationId: 51,
    language: eng_GB,
    input: {
      name: "An image created over GraphQL",
      image: {
        alternativeText: "The alternative text",
        file: $file
      }
    }
  ) {
    _info { id mainLocationId }
    name
    image { fileName alternativeText uri }
  }
}
```

The file is provided as the `$file` variable, defined as an `UploadFile`.

You can include this mutation in a cURL request under `operations`:

``` bash
curl -v -X POST \
  <yourdomain>/graphql \
  -H "Cookie: $AUTH_COOKIE" \
  -F 'operations={"query":"mutation createFile($file: FileUpload!) { ... }","variables":{"file": null}}' \
  -F 'map={"image":["variables.file"]}' \
  -F "image"=@/path/to/image.png
```

For example:

``` bash
curl -v -X POST \
  <yourdomain>/graphql \
  -H "Cookie: $AUTH_COOKIE" \
  -F 'operations={"query":"mutation CreateImage($file: FileUpload!) { createImage( parentLocationId: 51, input: { name: \"An image created over GraphQL\", image: { alternativeText: \"The alternative text\", file: $file } }, language: \"eng-GB\" ) { _info { id mainLocationId } _url name image { fileName alternativeText uri } } }","variables":{"file": null}}' \
  -F 'map={"image":["variables.file"]}' \
  -F "image"=@/path/to/image.png
```

!!! note "Authentication"

    Note that the example above requires you to set your authentication cookie in the `$AUTH_COOKIE` variable.
    See [Authentication](graphql.md#authentication) for more information.

### Uploading multiple files

You can upload multiple files with one operation in a similar way by using the `uploadFiles` mutation.
Here the files are provided in a `$files` variable and listed under `map` in the cURL request.

```
mutation UploadMultipleFiles($files: [FileUpload]!) {
  uploadFiles(
    locationId: 51,
    files: $files,
    language: eng_GB
  ) {
    files {
      _url
      _location {
        id
      }
      ... on ImageContent {
        name
        image {
          uri
        }
      }
      ... on FileContent {
        name
        file {
          uri
        }
      }
      ... on VideoContent {
        name
        file {
          uri
        }
      }
    }
    warnings
  }
}
```

Include this mutation in a cURL request:

``` bash
curl -v -X POST \
  <yourdomain>/graphql \
  -H 'Cookie: $AUTH_COOKIE' \
  -F 'operations={"query": "mutation UploadMultipleFiles($files: [FileUpload]!) { uploadFiles( locationId: 51, files: $files, languageCode: \"eng-GB\" ) { files { _url _location { id } ... on ImageContent { name image { uri } } ... on FileContent { name file { uri } } ... on VideoContent { name file { uri } } } warnings } }", "variables": {"files": [null, null, null, null, null]}}' \
  -F 'map={"image1":["variables.files.0"], "image2":["variables.files.1"], "file1":["variables.files.2"], "file2":["variables.files.3"], "media":["variables.files.4"]}' \
  -F "image1"=@/tmp/files/image1.png \
  -F "image2"=@/tmp/files/image2.png \
  -F "file1"=@/tmp/files/file1.pdf \
  -F "file2"=@/tmp/files/file2.zip \
  -F "media"=@/tmp/files/media.mp4
```
