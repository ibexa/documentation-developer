---
target_version: '3.2'
latest_tag: '3.2.8'
---

# Update the app to v3.2

!!! caution

    Before you start updating to v3.3, make sure that you are currently using the latest version of v2.5 (v[[= latest_tag_2_5 =]]).
    If not, refer to the [update guide for v2.5](update_db_to_2.5.md#d-update-to-v25).

To move from v2.5 to v3.3, first, you need to bring the app to version v3.2.

## 1. Check out a version

[[% include 'snippets/update/check_out_version.md' %]]

## 2. Resolve conflicts

[[% include 'snippets/update/merge_composer.md' %]]

## 3. Update the app

[[% include 'snippets/update/update_app.md' %]]

## Next steps

Now, proceed to the next step, [updating the code to v3.0](adapt_code_to_v3.md).
