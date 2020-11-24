# Logging API [[% include 'snippets/commerce_badge.md' %]]

Logging in [[= product_name_com =]] is based on Monolog. There is no separate logging API definition.
For the purpose of persisting logs within a database,
the Monolog API implementation has been extended by Doctrine-based classes and an interface.

## Important service classes and interfaces of Monolog

### Psr\Log\LoggerInterface

`LoggerInterface` is always used as the service for logging. 

The list below contains the logging methods (in order of importance).
Use the `log()` method only if the log level of a message can only be determined at runtime.
For more information about the PSR logging standard, see [the official specification](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md).

``` php
public function emergency($message, array $context = array());
public function alert($message, array $context = array());
public function critical($message, array $context = array());
public function error($message, array $context = array());
public function warning($message, array $context = array());
public function notice($message, array $context = array());
public function info($message, array $context = array());
public function debug($message, array $context = array());
public function log($level, $message, array $context = array());
```

### Monolog\Logger

`Monolog\Logger` implements `LoggerInterface` but, for historical reasons, provides its own logging methods (which correspond to the interface, although are named differently).

!!! note

    Although large parts of the shop rely on `Monolog\Logger` directly, it's recommended that all new implementations rely on the PSR `LoggerInterface` instead of explicitly referring to this class.

## Base classes of Doctrine-based logging

### LogRepositoryInterface

To make database logging possible, a specific Doctrine entity class and its respective repository class must exist
for every type of log records (email log, ERP log).

`LogRepositoryInterface` must be implemented by every repository class in order to work with the Doctrine handler.

#### createNewLog()

The `createNewLog()` method instantiates a new log record entity.
It takes the following parameters:

|Parameter|Description|
|---|---|
|`$logRecord`|The record, as created by Doctrine loggers|
|`$persist`|If `true`, calls `save()` implicitly|

#### save()

The `save()` method persists the given log entity.
It takes the following parameters:

|Parameter|Description|
|---|---|
|`$logEntity`|A log entity, created by `createNewLog()`|

### AbstractOrmLogRepository

This implementation of `LogRepositoryInterface` uses Doctrine's ORM API by deriving from `EntityRepository`.

The class is abstract, but implements the complete `LogRepositoryInterface`.
It is intended to be extended for concrete entity implementations of `AbstractLog` and, therefore, must not be instantiated directly.

It's recommended to extend this class for any ORM-based logging entities.

### AbstractLog

`AbstractLog` is the abstract class for all Log entities.

It cannot be persisted by itself and MUST be derived by, for example, a fully-mapped Doctrine entity class.

The attributes in the class must be considered in any DBMS mapping, as well.

!!! note

    For any deriving class that uses Symfony's annotation-based configuration for object relational mapping,
    the base attributes must be overridden and enriched with the respective ORM tags in their docblocks.

## Monolog extension

The classes that extend Monolog by Doctrine-based persistence do not provide a public API.
Instead, they implement the public API of Doctrine.

### DoctrineFormatter

`DoctrineFormatter` implements `Monolog\Formatter\FormatterInterface`.

This is a Monolog formatter class for the Doctrine handler.
It serializes all non-scalar values, so they can be stored in database fields.

Service definition:

``` xml
<!-- Arguments are define here with their default values. They could be omitted -->
<service id="siso_module.logging_formatter.doctrine" class="Siso\Bundle\ToolsBundle\Service\Logging\DoctrineFormatter">
    <argument type="string">8</argument> <!-- Nesting level for recursion -->
    <argument type="string">php</argument> <!-- Serialize format (php|json) -->
    <argument type="string">true</argument> <!-- Convert exception traces to string instead of array -->
</service>
```

### DoctrineHandler

`DoctrineHandler` extends `Monolog\Handler\AbstractProcessingHandler`.

It is a Monolog handler class that writes log records into Doctrine entities.

Service definition:

``` xml
<!-- A doctrine handler must be assigned to a specific entity class and it's repository -->
<service id="siso_module.log_type.logging_handler.doctrine" class="Siso\Bundle\ToolsBundle\Service\Logging\DoctrineHandler">
    <argument type="service" id="siso_module.log_type.logging_repository.doctrine" /> <!-- The service ID of the repository class -->
    <call method="setFormatter">
        <argument type="service" id="siso_module.logging_formatter.doctrine"/> <!-- The service id of the previously defined DoctrineFormatter -->
    </call>
</service>
```

Handler injection:

``` xml
<service id="siso_module.log_type.logger" class="%monolog.logger.class%">
    <argument>log_channel</argument>
    <!-- Handlers are injected with a method call -->
    <call method="pushHandler">
        <argument type="service" id="siso_module.log_type.logging_handler.doctrine"/>
    </call>
</service>
```

### RequestDataProcessor

`RequestDataProcessor` adds the request, session and user ID to log messages.

Service definition:

``` xml
<service id="siso_tools.logging_processor.request_data" class="%siso_tools.logging_processor.request_data.class%">
    <argument type="service" id="session" />
    <argument type="service" id="ezpublish.api.repository" />
</service>
```

Processor injection:

``` xml
<service id="siso_module.log_type.logger" class="%monolog.logger.class%">
    <argument>log_channel</argument>
    <call method="pushHandler">
        <argument type="service" id="siso_module.log_type.logging_handler.doctrine"/>
    </call>
    <!-- Processors are injected with a method call -->
    <call method="pushProcessor">
        <argument type="collection"> <!-- Processors must be injected as a callback (array(Object, 'methodName')) -->
            <argument type="service" id="siso_tools.logging_processor.request_data" />
            <argument type="string">processRecord</argument>
        </argument>
    </call>
</service>
```
