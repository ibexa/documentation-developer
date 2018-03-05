# Set up Folder Rights

Like most things, [Symfony documentation](http://symfony.com/doc/3.4/setup/file_permissions.html) applies here, in this case meaning `var`, `web/var` need to be writable by cli and web server user.
Furthermore, future files and directories created by these two users will need to inherit those access rights. 

!!! caution
    For security reasons, in production there is no need for web server to have access to write to other directories.

!!! tip "Development Setup"
    For development setup you may change your web server config to use same user as the owner of the folder. The instructions below are mainly for production setup. Like Symfony, we first and foremost recommend an approach using ACL.

## A. **Using ACL on a *Linux/BSD* system that supports chmod +a**

Some systems, primarily Mac OS X, supports setting ACL using a `+a` flag on `chmod`. The example below uses a command to try to determine your web server user and set it as `HTTPDUSER`, alternatively change to your actual web server
user if it's non standard:

```bash
rm -rf var/cache/* var/logs/* var/sessions/*
HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
sudo chmod +a "$HTTPDUSER allow delete,write,append,file_inherit,directory_inherit" var web/var
sudo chmod +a "$(whoami) allow delete,write,append,file_inherit,directory_inherit" var web/var
```

## B. **Using ACL on a *Linux/BSD* system that does not support chmod +a**

Some systems (for example Ubuntu) don't support chmod +a, but do support another utility called setfacl. You may need to
[enable ACL support](https://help.ubuntu.com/community/FilePermissionsACLs) on your partition and install setfacl before using it. With it installed example below uses a command to try to determine
your web server user and set it as `HTTPDUSER`, alternatively change to your actual web user if it's non standard:

```bash
HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
# if this does not work, try adding '-n' option
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var web/var
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var web/var
```

## C. **Using chown on *Linux/BSD/OS X* systems that don't support ACL**

Some systems don't support ACL at all. You will need to set your web server's user as the owner of the required
directories, in this setup further symfony console commands against installation should use the web server user
as well to avoid new files being created using another user.  Example uses a command to try to determine your
web server user and set it as `HTTPDUSER`, alternatively change to your actual web server user if it's non standard:

```bash
HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
sudo chown -R "$HTTPDUSER":"$HTTPDUSER" var web/var
sudo find web/var var -type d | xargs sudo chmod -R 775
sudo find web/var var -type f | xargs sudo chmod -R 664
```

## D. **Using chmod on a *Linux/BSD/OS X* system where you can't change owner**

If you can't use ACL and aren't allowed to change owner, you can use chmod, making the files writable by everybody.

!!! warning
    Note that this method really isn't recommended as it allows any user to do anything.

```bash
sudo find web/var var -type d | xargs sudo chmod -R 777
sudo find web/var var -type f | xargs sudo chmod -R 666
```

When using chmod, note that newly created files (such as cache) owned by the web server's user may have different/restrictive permissions.
In this case, it may be required to change the umask so that the cache and log directories will be group-writable or world-writable (`umask(0002)` or `umask(0000)` respectively).

It may also possible to add the group ownership inheritance flag so new files inherit the current group, and use `775`/`664` in the command lines above instead of world-writable:
```bash
sudo chmod g+s web/var var
```

## E. **Setup folder rights on Windows**

For your choice of web server you'll need to make sure web server user has read access to `<root-dir>`, and
write access to the following directories:
- web/var
- var
