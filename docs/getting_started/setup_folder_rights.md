# Setup folder rights

!!! note

```en
This setup is part of Manual Installation of eZ Platform.
```


For security reasons, there is no need for web server to have access to write to other directories.

## Set the owner and clean directories

First, change `www-data` to your web server user.

### Clean the cache/ and logs/ directories

```bash
rm -rf var/cache/* var/logs/* var/sessions/*
```

## Use the right option according to your system.

### A. Using ACL on a *Linux/BSD *system that supports chmod +a

**Using ACL on a Linux/BSD system that supports chmod +a**

```bash
sudo chmod +a "www-data allow delete,write,append,file_inherit,directory_inherit" var web/var
sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" var web/var
```

### B. Using ACL on a *Linux/BSD *system that does not support chmod +a

Some systems don't support chmod +a, but do support another utility called setfacl. You may need to enable ACL support on your partition and install setfacl before using it (as is the case with Ubuntu), in this way:

**Using ACL on a Linux/BSD system that does not support chmod +a**

```bash
sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx var web/var
sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx var web/var
```

### C. Using chown on *Linux/BSD/OS X* systems that don't support ACL

Some systems don't support ACL at all. You will need to set your web server's user as the owner of the required directories:

**Using chown on Linux/BSD/OS X systems that don't support ACL**

```bash
sudo chown -R www-data:www-data var web/var
sudo find web/var var -type d | xargs sudo chmod -R 775
sudo find web/var var -type f | xargs sudo chmod -R 664
```

### D. Using chmod on a *Linux/BSD/OS X* system where you can't change owner

If you can't use ACL and aren't allowed to change owner, you can use chmod, making the files writable by everybody. Note that this method really isn't recommended as it allows any user to do anything:

**Using chmod on a Linux/BSD/OS X system where you can't change owner**

```bash
sudo find web/var var -type d | xargs sudo chmod -R 777
sudo find web/var var -type f | xargs sudo chmod -R 666
```

When using chmod, note that newly created files (such as cache) owned by the web server's user may have different/restrictive permissions. In this case, it may be required to change the umask so that the cache and log directories will be group-writable or world-writable (`umask(0002)` or `umask(0000)` respectively).

It may also possible to add the group ownership inheritance flag so new files inherit the current group, and use `775`/`664` in the command lines above instead of world-writable:

**It may also possible to add the group ownership inheritance flag**

```bash
sudo chmod g+s web/var var
```

### E. Setup folder rights on Windows

For your choice of web server you'll need to make sure web server user has read access to `<root-dir>`, and write access to the following directories:

- var/cache
- var/logs