1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)
4.  [Search](Search_31429673.html)

# Search Criteria Reference 

Created by Dominika Kurek, last modified by André Rømcke on Dec 12, 2016

**Criteria** are the filters for Content and Location Search, for generic use of API Search see [Search Criteria and Sort Clauses](Search_31429673.html#Search-SearchCriteriaandSortClauses) .

A Criterion consist of two parts just like SortClause and FacetBuilder:

-   The API Value: `Criterion`
-   Specific handler per search engine: `Criterion Handler`

`Criterion` represents the value you use in the API, while `CriterionHandler` deals with the business logic in the background translating the value to something the Search engine can understand.

Implementation and availability of a handler typically depends on search engine capabilities and limitations, currently only Legacy (SQL) Search Engine exists, and for instance its support for FullText and Field Criterion is not optimal and it is advised to avoid heavy use of these until future search engine arrives.

### Common concepts for most Criteria

For how to use each and every Criterion see the list below, as it depends on the Criterion Value constructor, but *in general* you should be aware of the following common concepts:

-   `target`: Exposed if the given Criterion supports targeting a specific sub field, example: FieldDefinition or Meta Data identifier
-   `value`: The value(s) to *filter* on, this is typically a  `scalar` or `array` of` scalars.`
-   `operator`: Exposed on some Criteria
    -   All operators can be seen as constants on `eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator`, at time of writing: `IN, EQ, GT, GTE, LT, LTE, LIKE, BETWEEN, CONTAINS`
    -   Most Criteria do not expose this and select `EQ` **or** `IN` depending on if value is `scalar` **or** `array`
    -   `IN` & `BETWEEN         `always acts on an `array` of values, while the other operators act on single `scalar` value
-    `valueData` : Additional value data, required by some Criteria, MapLocationDistance for instance

 

In the Legacy search engine, the field index/sort key column is limited to 255 characters by design.
Due to this storage limitation, searching content using the eZ Country Field Type or Keyword when there are multiple values selected may not return all the expected results.

### List of Criteria

The list below reflects Criteria available in the `eZ\Publish\API\Repository\Values\Content\Query\Criterion` namespace (it is also possible to make a custom Criterion):

#### Only for LocationSearch

<table>
<thead>
<tr class="header">
<th>Criterion</th>
<th>Constructor arguments description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>Location\Depth</code></td>
<td><code>operator</code> (<code>IN, EQ, GT, GTE, LT, LTE, BETWEEN</code>), <code>value</code> being the Location depth(s) as an integer(s).</td>
</tr>
<tr class="even">
<td><code>Location\IsMainLocation</code></td>
<td>Whether or not the Location is a Main Location<br />
<code>value</code> (<code>Location\IsMainLocation::MAIN</code>, <code>Location\IsMainLocation::NOT_MAIN</code>).</td>
</tr>
<tr class="odd">
<td><code>Location\Priority</code></td>
<td>Priorities are integers that can be used for sorting in ascending or descending order. What is higher or lower priority in relation to the priority number is left to the user choice.<br />
<code>operator</code> (<code>GT, GTE, LT, LTE, BETWEEN</code>), <code>value</code> being the location priority(s) as an integer(s).</td>
</tr>
</tbody>
</table>

 

#### Common

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Criterion</th>
<th>Constructor arguments description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>ContentId</code></td>
<td><span> <code>value </code>being scalar(s) representing the Content id.</span></td>
</tr>
<tr class="even">
<td><code>ContentTypeGroupId</code></td>
<td><code>value </code>being <span> scalar(s) representing the Content Typ eGroup id.</span></td>
</tr>
<tr class="odd">
<td><code>ContentTypeId</code></td>
<td><code>value </code>being <span> scalar(s) representing the Content Type id.</span></td>
</tr>
<tr class="even">
<td><code>           ContentTypeIdentifier                </code></td>
<td><code>value </code>being <span> string(s) representing the Content Type identifier, example: &quot;article&quot;.</span></td>
</tr>
<tr class="odd">
<td><code>DateMetadata</code></td>
<td><span> <code>target (</code> <code>DateMetadata</code> </span> <span> <code>::MODIFIED</code> <code>, DateMetadata</code> </span> <code>::CREATED), operator</code> (<code>IN, EQ, GT, GTE, LT, LTE</code>, <code>           BETWEEN</code>), <code>           value</code> being <span>integer</span>(s) representing unix timestamp.</td>
</tr>
<tr class="even">
<td><code>Field</code></td>
<td><p><span> <code>target</code> <code>(</code>FieldDefinition identifier</span> <code>), operator</code> <span> (</span> <code>                   IN, EQ, GT, GTE, LT, LTE</code>, LIKE, <span> </span> <code>             BETWEEN, CONTAINS</code>), <code>             value</code> <span> being</span> <span> scalar(s) relevant for the field.</span></p></td>
</tr>
<tr class="odd">
<td><code>FieldRelation</code></td>
<td><span> <code>target</code> <code>(</code>FieldDefinition identifier</span> <code>), operator</code> <span> (</span> <code>                 IN</code> <code>                 , CONTAINS</code>), <code>                 value</code> <span> being</span> <span> array of scalars representing Content id of relation.<br />
<em>Use of <code>IN</code> means relation needs to have one of the provided ID's, while <code>CONTAINS</code> implies it needs to have all provided id's.</em> </span></td>
</tr>
<tr class="even">
<td><code>FullText</code></td>
<td><p><code>value</code> being the string to search for, <code>properties</code> is array to set additional properties for use with future search engines like Solr/ElasticSearch.</p></td>
</tr>
<tr class="odd">
<td><code>LanguageCode</code></td>
<td><code>value</code> being string(s) representing Language Code(s) on the Content (<em>not</em> on <a href="https://jira.ez.no/browse/EZP-23524" class="external-link">Fields</a>), <code>matchAlwaysAvailable</code> as boolean.</td>
</tr>
<tr class="even">
<td><code>LocationId</code></td>
<td><code>value</code> being <span> scalar(s) representing the Location id.</span></td>
</tr>
<tr class="odd">
<td><code>LocationRemoteId</code></td>
<td><code>value</code> being <span> string(s) representing the Location Remote id.</span></td>
</tr>
<tr class="even">
<td><code>LogicalAnd</code></td>
<td>A <span> <code>LogicalOperator</code> that takes <code>array</code> of other Criteria, makes sure all Criteria match.</span></td>
</tr>
<tr class="odd">
<td><code>LogicalNot</code></td>
<td><span>A </span> <span> <code>LogicalOperator</code> that takes <code>array</code> of other Criteria, makes sure none of the Criteria match.</span></td>
</tr>
<tr class="even">
<td><code>LogicalOr</code></td>
<td><span>A </span> <span> <code>LogicalOperator</code> that takes <code>array</code> of other Criteria, makes sure one of the Criteria match.</span></td>
</tr>
<tr class="odd">
<td><code>MapLocationDistance</code></td>
<td><span> <code>target</code> <code>(</code>FieldDefinition identifier</span> <code>), operator</code> <span> (</span> <code>           IN, EQ, GT, GTE, LT, LTE</code>, <code>           BETWEEN</code>), <code> distance</code> <span> as</span> <span> float(s) from a position using <code> latitude            </code> <span> as</span> <span> float</span> <code>,</code> <code>             longitude</code> <span> as</span> <span> float as arguments<br />
</span> </span></td>
</tr>
<tr class="even">
<td><code>MatchAll</code></td>
<td><em>No arguments, mainly for internal use when no <code>filter</code> or <code>query</code> is provided on <code>Query</code> object.</em></td>
</tr>
<tr class="odd">
<td><code>MatchNone</code></td>
<td><em><em>No arguments, m</em>ainly for internal use by <a href="BlockingLimitation_31430461.html">BlockingLimitation</a>.</em></td>
</tr>
<tr class="even">
<td><code>ObjectStateId</code></td>
<td><code>value</code> being <span> string(s) representing the Content ObjectState id.</span></td>
</tr>
<tr class="odd">
<td><code>ParentLocationId</code></td>
<td><p><span>value being scalar(s) representing the Parent's Location id</span></p></td>
</tr>
<tr class="even">
<td><code>RemoteId</code></td>
<td><code>value</code> being <span> string(s) representing the Content Remote id.</span></td>
</tr>
<tr class="odd">
<td><code>SectionId</code></td>
<td><code>value</code> being <span> scalar(s) representing the Content Section id.</span></td>
</tr>
<tr class="even">
<td><code>Subtree</code></td>
<td><code>value</code> being <span> string(s) representing the Location id in which you can filter. <em>If the Location Id is  /1/2/20/42, you will filter everything under 42.</em><br />
</span></td>
</tr>
<tr class="odd">
<td><code>UserMetadata</code></td>
<td><span> <code>target (UserMetadata           </code> </span> <span> <code>::OWNER</code> <code>, UserMetadata           </code> </span> <code>::GROUP , UserMetadata</code> <code>::MODIFIER</code>), <code>operator</code> (<code>IN, EQ</code> <code>),</code> <code> value</code> <span> being </span> <span>scalars</span> <span>(s) representing the User or User Group id(s).</span></td>
</tr>
<tr class="even">
<td><code>Visibility</code></td>
<td><span> <code>value (Visibility           </code> </span> <span> <code>::VISIBLE</code> <code>, Visibility           </code> </span> <code>::HIDDEN),</code> <em>Note: This acts on all assigned locations when used with ContentSearch, meaning hidden content will be returned if it has a location which is visible. Use LocationSearch to avoid this.</em></td>
</tr>
</tbody>
</table>

#### In this topic:

-   [Common concepts for most Criteria](#SearchCriteriaReference-CommonconceptsformostCriteria)
-   [List of Criteria](#SearchCriteriaReference-ListofCriteria)






