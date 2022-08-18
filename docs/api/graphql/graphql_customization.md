---
description: Customize your GraphQL API with a custom schema.
---

# GraphQL customization

## Custom schema

You can customize the GraphQL schema that is generated from your repository.

You can use it if your application requires custom GraphQL resources, for instance for Doctrine entities.

To do so, create a `config/graphql/types/Query.types.yaml` file. It will be used as the GraphQL query root.

In that file, add new fields that use any custom type or custom logic you require, based
on [overblog/GraphQLBundle](https://github.com/overblog/GraphQLBundle).

The custom schema should be created only after generating other schemas to avoid problems, especially if the custom schema depends on other schema elements. For example:
`Type "Domain" inherited by "Query" not found.`.
To avoid this problem during deployment, add the generated schemas to the repository.
Update the schema in the event of any changes related to GraphQL as well as when changing the environment, for example from `dev` to `prod`.
### Configuration

You can include the [[= product_name =]] schema in two ways: either through inheritance or composition.

#### Inheritance

To use inheritance, apply the following configuration in `config/graphql/types/Query.types.yaml`:

``` yaml
Query:
    type: object
    inherits:
        - Domain
    config:
        fields:
            customField:
                type: object
```

#### Composition

To use composition, define [[= product_name =]] schema as a field in your custom schema.
For example, in `config/graphql/types/Query.types.yaml`:

``` yaml
Query:
    type: object
    config:
        fields:
            myCustomField: {}
            myOtherCustomField: {}
            ibexa:
                type: Domain
```

### Custom mutations

Custom mutations are created in the same way as custom query configuration.
A `config/graphql/types/Mutation.types.yaml` file will be used as the source for mutation definitions in your schema.

``` yaml
Mutation:
    type: object
    inherits: [PlatformMutation]
    config:
        fields:
            createSomething:
                builder: Mutation
                builderConfig:
                        inputType: CreateSomethingInput
                        payloadType: SomethingPayload
                        mutateAndGetPayload: '@=mutation('CreateSomething', [value])'

CreateSomethingInput:
    type: relay-mutation-input
    config:
        fields:
            name:
                type: String

SomethingPayload:
    type: object
    config:
        fields:
            name:
                type: String

```

## Custom field name

You can customize the name used by GraphQL as the content field name.

Use this setting to avoid conflicts with Field names that derive from a Content Type definition.

``` yaml
parameters:
    ibexa_graphql.schema.content.field_name.override:
        id: id_
```
