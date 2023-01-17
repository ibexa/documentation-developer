---
description: Reindexing lets you create or refresh the search engine index.
---

# Search reindexing

To (re)create or refresh the search engine index for configured search engines (per SiteAccess repository), use the `php bin/console ibexa:reindex` command.

Some examples of common usage:
```bash
# Reindex the whole index using parallel process (by default starts by purging the whole index)
# (with the 'auto' option which detects the number of CPU cores -1, default behavior)
php bin/console ibexa:reindex --processes=auto

# Refresh a part of the subtree (implies --no-purge)
php bin/console ibexa:reindex --subtree=2

# Refresh content updated since a date (implies --no-purge)
php bin/console ibexa:reindex --since=yesterday

# Refresh (or delete when not found) content by IDs (implies --no-purge)
php bin/console ibexa:reindex --content-ids=3,45,33
```

For further info on possible options, see `php bin/console ibexa:reindex --help`.
