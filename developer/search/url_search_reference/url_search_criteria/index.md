# URL Search Criteria reference

URL Search Criteria help define and fine-tune search queries for URLs.

URL Search Criteria are only supported by [URL Search (`URLService::findUrls`)](../../../content_management/url_management/url_api/index.md).

| URL criteria                                                                                                          | URL based on                                                                                  |
| --------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------- |
| [LogicalAnd](../logicaland_url_criterion/index.md)               | Implements a logical AND Criterion. It matches if ALL of the provided Criteria match.         |
| [LogicalNot](../logicalnot_url_criterion/index.md)               | Implements a logical NOT Criterion. It matches if the provided Criterion doesn't match.       |
| [LogicalOr](../logicalor_url_criterion/index.md)                 | Implements a logical OR Criterion. It matches if at least one of the provided Criteria match. |
| [MatchAll](../matchall_url_criterion/index.md)                   | Returns all URL results.                                                                      |
| [MatchNone](../matchnone_url_criterion/index.md)                 | Returns no URL results.                                                                       |
| [Pattern](../pattern_url_criterion/index.md)                     | Matches URLs that contain a pattern.                                                          |
| [SectionId](../sectionid_url_criterion/index.md)                 | Matches URLs from content placed in the Section with the specified ID.                        |
| [SectionIdentifier](../sectionidentifier_url_criterion/index.md) | Matches URLs from content placed in Sections with the specified identifiers.                  |
| [Validity](../validity_url_criterion/index.md)                   | Matches URLs based on validity flag.                                                          |
| [VisibleOnly](../visibleonly_url_criterion/index.md)             | Matches URLs from published content.                                                          |
