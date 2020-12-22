# Search synonyms [[% include 'snippets/commerce_badge.md' %]]

Synonyms enable different phrase inputs that have the same meaning.

For example, you have products with gigabyte specification (such as a 250 gigabyte hard drive).
You cannot expect users to always spell out "gigabyte", so you can add synonyms for the word:
"gigabyte", "giga byte", "gb", "Gb", "gigab", "gbyte", and so on.

Every time the user searches for any of those synonyms, the search engine also finds all the synonyms.
For example, user search for "1 gb" returns "1 gigabyte".

The synonyms are defined in the `synonyms.txt` file which can be found inside Solr collection `directory/conf`.

After you modify `synonyms.txt`, you have to restart Solr.

## Solr managed resources

With this method you create a managed synonym resource that can be updated via REST.

!!! tip

    For more information about Solr managed resources, see [Solr documentation.](https://lucene.apache.org/solr/guide/7_1/managed-resources.html)

``` xml
<fieldType name="managed_en" class="solr.TextField" positionIncrementGap="100">
  <analyzer>
    <tokenizer class="solr.StandardTokenizerFactory"/>
    <filter class="solr.ManagedSynonymFilterFactory" managed="english" />
  </analyzer>
</fieldType>
```

You must place this definition in the `schema.xml` file. 
It defines `solr.ManagedSynonymFilterFactory` for synonym main class instead of `SynonymFilterFactory`.

Now you have to replace the current definition of this dynamic field with definitions for the fields that you want to use as synonyms:

``` xml
<dynamicField name="*_s" type="managed_en" indexed="true" stored="true" multiValued="true"/>
```

You can also define it with another name:

``` xml
<dynamicField name="*value_s" type="managed_en" indexed="true" stored="true" multiValued="true"/>
```

If you omit this, the synonym definition is taken from `language-fielddefinition.xml`:

``` xml
<fieldType name="text" class="solr.TextField" positionIncrementGap="100">
  <analyzer type="index">
    <tokenizer class="solr.StandardTokenizerFactory"/>
    <filter class="solr.StopFilterFactory" ignoreCase="true" words="stopwords.txt" enablePositionIncrements="true" />
    <filter class="solr.LowerCaseFilterFactory"/>
  </analyzer>
  <analyzer type="query">
    <tokenizer class="solr.StandardTokenizerFactory"/>
    <filter class="solr.StopFilterFactory" ignoreCase="true" words="stopwords.txt" enablePositionIncrements="true" />
    <filter class="solr.SynonymFilterFactory" synonyms="synonyms.txt" ignoreCase="true" expand="true"/>
    <filter class="solr.LowerCaseFilterFactory"/>
  </analyzer>
</fieldType>
```

To add a new synonym, use the following cURL call:

``` bash
curl -XPUT "<http://localhost:8983/solr/collection1/schema/analysis/synonyms/english>" -H 'Content-type:application/json' --data-binary '{"word":\["synonym1","synonym2"\]}'
```

With the current version of Solr, if you use managed synonyms you have to use the one-to-many synonyms definition.
In the example above, a search for `word`, `synonym1`, or `synonym2` match any records containing `word` but a search for `word` or `synonym1` never returns results with the words `synonym1` or `synonym2`.

If you decide to use the synonym file, you can define synonyms of the same level.
As a result, any synonym matches any other in the search result.

```
// Create synonyms REST  
// curl -XPUT -H 'Content-type:application/json' --data-binary '{"class":"org.apache.solr.rest.schema.analysis.ManagedSynonymFilterFactory$SynonymManager"}' "<http://localhost:8983/solr/collection1/schema/analysis/synonyms/german>"

// Put value to synonyms  
// curl -X PUT -H 'Content-type:application/json' --data-binary '{"mad":\["angry","upset"\]}' "<http://localhost:8983/solr/collection1/schema/analysis/synonyms/german>"

// Delete all german synonyms  
// curl -XDELETE "<http://localhost:8983/solr/collection1/schema/analysis/synonyms/german>"

// List all german synonyms  
// curl '<http://localhost:8983/solr/collection1/schema/analysis/synonyms/german>'

// Delete a single element  
// curl -X DELETE "<http://localhost:8983/solr/collection1/schema/analysis/synonyms/german/mad>"
```

Create a managed resource using schema XML for stop words and synonyms.

``` xml
<fieldType name="managed_en" class="solr.TextField" positionIncrementGap="100">
  <analyzer>
    <tokenizer class="solr.StandardTokenizerFactory"/>
    <filter class="solr.ManagedStopFilterFactory" managed="english" />
    <filter class="solr.ManagedSynonymFilterFactory" managed="english" />
  </analyzer>
</fieldType>
```

Create using REST API:

```
curl -XPUT -H 'Content-type:application/json' --data-binary '{"class":"org.apache.solr.rest.schema.analysis.ManagedWordSetResource"}' "<http://localhost:8983/solr/collection1/schema/analysis/stopwords/german>"

curl -XPUT "http://localhost:8983/solr/collection1/schema/analysis/stopwords/german" -H 'Content-type:application/json' --data-binary '["foo"]'

curl "<http://localhost:8983/solr/collection1/schema/managed>"

curl -XDELETE "<http://localhost:8983/solr/collection1/schema/analysis/stopwords/german>"
```
