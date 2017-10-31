# Executing long-running console commands

## Description

This page describes how to execute long-running console commands, to make sure they don't run out of memory. An example is a custom import command or the indexing command provided by the [Solr Bundle](../guide/search.md#solr-bundle).

## Solution

### Reducing memory usage

To avoid quickly running out of memory while executing such commands you should make sure to:

1. Always run in prod environment using: `--env=prod`
    1. See [Environments](../guide/environments.md) for further information on Symfony environments.
    1. See [Logging and debug configuration](../guide/devops.md#logging-and-debug-configuration) for some of different features enabled in development environments, which by design uses memory.

1. For logging using monolog, if you use either the default `fingers_crossed`, or `buffer` handler, make sure to specify `buffer_size` to limit how large the buffer grows before it gets flushed:

    ``` yaml
    # config\_prod.yml (snippet, not a full example for monolog config)
    monolog:
        handlers:
            main:
                type: fingers_crossed
                buffer_size: 200
    ```

1.  Run PHP without memory limits using: `php -d memory_limit=-1 app/console <command>`
1.  Disable `xdebug` *(PHP extension to debug/profile php use)* when running the command, this will cause php to use much more memory.

!!! note "Memory will still grow"

    Even when everything is configured like described above, memory will grow for each iteration of indexing/inserting a content item with at least *1kb* per iteration after the initial first 100 rounds. This is expected behavior; to be able to handle more iterations you will have to do one or several of the following:

    - Change the import/index script in question to [use process forking](#process-forking-with-symfony) to avoid the issue.
    - Upgrade PHP: *newer versions of PHP are typically more memory-efficient.*
    - Run the console command on a machine with more memory (RAM).

### Process forking with Symfony

The recommended way to completely avoid "memory leaks" in PHP in the first place is to use processes, and for console scripts this is typically done using process forking which is quite easy to do with Symfony.

The things you will need to do:

1. Change your command so it supports taking slice parameters, like for instance a batch size and a child-offset parameter.
    1. *If defined, child-offset parameter denotes if a process is child, this could have been accomplished with two commands as well.*
    2. *If not defined, it is master process which will execute the processes until nothing is left to process.*

2. Change the command so that the master process takes care of forking child processes in slices.
    1. For execution in-order, [you may look to our platform installer code](https://github.com/ezsystems/ezpublish-kernel/blob/6.2/eZ/Bundle/PlatformInstallerBundle/src/Command/InstallPlatformCommand.php#L230) used to fork out solr indexing after installation to avoid cache issues.
    2. For parallel execution of the slices, [see Symfony doc for further instruction](http://symfony.com/doc/current/components/process.html#process-signals).
