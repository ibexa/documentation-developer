# Updating from <1.7

Apply the following database update script:

`mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-6.7.7-to-6.7.8.sql`

!!! note

    During database update, you have to go through all the changes between your current version and your final version
    **e.g. during update from v2.2 to v2.5 you have to perform all the steps from: <2.3, <2.4 and <2.5**.
    Only after applying all changes your database will work properly.

## Changes to Solr Bundle

Solr Bundle v1.4 introduced among other things index time boosting feature, this involves a slight change to the Solr scheme that will need to be applied to your config.

To make sure indexing continues to work, apply the following change, restart Solr and reindex your content:

``` xml
diff --git a/lib/Resources/config/solr/schema.xml b/lib/Resources/config/solr/schema.xml
index 49a17a9..80c4cd7 100644
--- a/lib/Resources/config/solr/schema.xml
+++ b/lib/Resources/config/solr/schema.xml
@@ -92,7 +92,7 @@ should not remove or drastically change the existing definitions.
     <dynamicField name="*_s" type="string" indexed="true" stored="true"/>
     <dynamicField name="*_ms" type="string" indexed="true" stored="true" multiValued="true"/>
     <dynamicField name="*_l" type="long" indexed="true" stored="true"/>
-    <dynamicField name="*_t" type="text" indexed="true" stored="true"/>
+    <dynamicField name="*_t" type="text" indexed="true" stored="true" multiValued="true" omitNorms="false"/>
     <dynamicField name="*_b" type="boolean" indexed="true" stored="true"/>
     <dynamicField name="*_mb" type="boolean" indexed="true" stored="true" multiValued="true"/>
     <dynamicField name="*_f" type="float" indexed="true" stored="true"/>
@@ -104,13 +104,6 @@ should not remove or drastically change the existing definitions.
     <dynamicField name="*_c" type="currency" indexed="true" stored="true"/>

     <!--
-      Full text field is indexed through proxy fields matching '*_fulltext' pattern.
-    -->
-    <field name="text" type="text" indexed="true" multiValued="true" stored="false"/>
-    <dynamicField name="*_fulltext" type="text" indexed="false" multiValued="true" stored="false"/>
-    <copyField source="*_fulltext" dest="text" />
-
-    <!--
       This field is required since Solr 4
     -->
     <field name="_version_" type="long" indexed="true" stored="true" multiValued="false" />
```

You can now follow the steps from [Updating from <1.13](4_update_1.13.md).