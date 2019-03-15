# GraphQL operations

Operations on content are performed using [mutations](https://graphql.org/learn/queries/#mutations).
They include creating, updating and deleting Content items.

The schema contains two mutations per Content type, e.g. `createFolder` and `updateFolder`.
You can also make use of the generic `deleteContent` and `uploadFiles` mutations.

## Creating content

To create a new Folder as a child of Location `2`:

```
mutation createFolder {
  createFolder(
    parentLocationId: 2,
    input: {
      name: "New Folder",

    }
  ) {
    id
  }
}
```

```
{
  "data": {
    "updateFolder": {
      "id": "RG9tYWluQ29udGVudDo2NA=="
    }
  }
}
```

## Updating content

To modify the name of a Folder Content item:

```
mutation updateFolder {
  updateFolder(
    contentId: 64
    input: {
      name: "New Folder name"
    }
  ) {
    id
  }
}
```

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

TODO `versionNo`

## Deleting content

You can delete any Content item by providing its `id` or `contentId`:

```
mutation deleteBlogPost {
  deleteContent(contentId: 64) {
    id
    contentId
  }
}
```

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

TODO
