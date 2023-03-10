!!! caution "Clear the persistance cache"

    Whenever you change the Page blocks or block attributes configuration (add, remove or alter) you need to clear the persistence cache by running `./bin/console cache:pool:clear ...` command. 

    In prod mode, you also need to clear the symfony cache by running `./bin/console c:c`.
    In dev mode, the symfony cache will be rebuilded automatically.