# GraphQL customization

## Custom schema

You can customize the GraphQL schema that is generated from your repository.

You can use it if your application requires custom GraphQL resources, for instance for Doctrine entities.

To do so, create an `app/config/graphql/Query.types.yaml` file. It will be used as the GraphQL query root.

In that file, add new fields that use any custom type or custom logic you require, based
on [overblog/GraphQLBundle](https://github.com/overblog/GraphQLBundle).

### Configuration

You can include the [[= product_name =]] schema in two ways: either through inheritance or composition.

#### Inheritance

To use inheritance, apply the following configuration in `app/config/graphql/Query.types.yaml`:

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
For example, in `app/config/graphql/Query.types.yaml`:

``` yaml
Query:
    type: object
    config:
        fields:
            myCustomField: {}
            myOtherCustomField: {}
            ezplatform:
                type: Domain
```

### Custom mutations

Custom mutations are created in the same way as custom query configuration.
An `app/config/graphql/Mutation.types.yaml` file will be used as the source for mutation definitions in your schema.

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
