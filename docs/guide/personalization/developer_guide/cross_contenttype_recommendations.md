# Cross content type recommendations

Currently to receive recommendations for a scenario include url scenario name and the output type.

Preview section -> main restriction only one output type ID can be included.
To receive reco for more than one content type, 
remove `outputtype`, add `crosscontent type parameter to the request
will receive recommendations based on all output types configured/supported in the scenario.

When scenario has configured more than one output type (content type) then the `CrossContentType` parameter can be used to get recommendation items for each output type.

Example of the request

`GET {host}/api/v2/{mandator}/{userId}/{scenarioId}numrecs={numberOfRecommendations}&categorypath=/&crosscontenttype=true`

Example of the response

Scenario preview section
Dynamic targeting and Personalization (page builder blocks)