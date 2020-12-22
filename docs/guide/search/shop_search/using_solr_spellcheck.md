# Solr spellcheck [[% include 'snippets/commerce_badge.md' %]]

!!! caution

    Solr spellcheck works only if you are using the eContent data provider.

### Step 1: Configure Solr core

Make sure your Solr core is configured correctly. Restart Solr if you did any changes.

Look for the `solrconfig.xml` file inside your Solr core directory:

`/solr/server/ez/template/solrconfig.xml`

Add the following lines to the `requestHandler` named `/select`.

``` xml hl_lines="2 3 4"
<requestHandler name="/select" class="solr.SearchHandler">
<arr name="last-components">
  <str>spellcheck</str>
</arr>
```

Make sure you have also the following element in the XML file:

`<searchComponent name="spellcheck" class="solr.SpellCheckComponent">`

Additional definitions for spellcheck can be configured here,
but spellcheck should also work with the default values.

Go to your root directory and execute the following commands:

``` bash
solr/bin/solr stop -all
solr/bin/solr start
```

### Step 2: Enable spellcheck in configuration

Modify `SearchBundle/Resources/config/econtent_search.yml`:

``` yaml
siso_search.default.solr_spellcheck: true
```

### Step 3: Define search controller behavior

The search engine returns search collation and search term suggestions.

``` php
return array(
    $catalogElements,
    $facetGroups,
    $productSearchResult->numFound,
    $productSearchResult->spellcheckCollation,
    $spellcheckCollationResults,
    $productSearchResult->spellcheckSuggestedTerms
);
```

|||
|--- |--- |
|`$productSearchResult->spellcheckCollation`|(string) The collation text. This is the suggested phrase (should contain the complete phrase if the user searched for more than one term.</br>For example, if user searches for "blac spealer", the collation could be: "black speaker"</br>Collation has text only if it results are not 0.|
|`$spellcheckCollationResults`|The number of hits of collation search.|
|`$productSearchResult->spellcheckSuggestedTerms`|An array of suggested words and their hits.</br>Example: `black => 99`, `spealer => 65`. It is sorted by the number of hits, descending.|

### Step 4: Prepare template

The following Twig template displays these results:

``` html+twig
{% if spellcheckCollationResults is defined and spellcheckCollationResults > 0 %}
  <br/>{{ 'msg.did_you_mean'|st_translate }}
  <a href="{{ path('siso_global_search') }}?query={{ spellcheckCollation }}">{{ spellcheckCollation }}
    (
    {% transchoice spellcheckCollationResults with {'%count%' : spellcheckCollationResults} %}
    {0} No result|[2,Inf[ %count% results|{1} One result
    {% endtranschoice %}
    )
  </a>
{% endif %}
{% if spellcheckSuggestions is defined and spellcheckSuggestions|length > 0 %}
  <ul>{{ 'msg.suggested_words'|st_translate}}:
    {% for word, frequency in spellcheckSuggestions %}
      <li><a href="{{ path('siso_global_search') }}?query={{ word }}">{{ word }}: {{ frequency }}</a></li>
    {% endfor %}
  </ul>
{% endif %}
```
