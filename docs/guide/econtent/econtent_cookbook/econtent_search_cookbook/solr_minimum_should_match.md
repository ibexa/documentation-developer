# Solr Minimum Should Match [[% include 'snippets/commerce_badge.md' %]]

Currently Solr's `mm` (Minimum Should Match) parameter only works for eContent search and can be specified with the following parameter:

``` yaml
#Solr minimun match specification string
siso_search.default.min_match_specification_string: '3<80%'
```

For more information about the parameter, see
[Solr reference](https://lucene.apache.org/solr/guide/7_4/the-dismax-query-parser.html#TheDisMaxQueryParser-Themm_MinimumShouldMatch_Parameter)
