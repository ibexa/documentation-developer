# Importing historical user tracking data

The Ibexa Personalization solution supports replaying historical user events by adding a special 
parameter to the buy event to simulate the event date.
The `overridetimestamp` parameter is then used as the `datetime` of an event instead of the actual 
timestamp of the request.

For example, you might want to import the buy history of users to avoid problems that result from the lack 
of initial data, where the system is unable to provide adequate recommendations.
This way, you do not have to wait for user profiles to accumulate events from the day you implemented 
the tracking.
Usually, a curl input file is generated. which creates buy requests that are sent to the tracking endpoint.

!!! note "User identifiers"

    Make sure that user identifiers that you use in the import file are identical to the ones used for live 
    tracking, for example, they are the actual user login IDs.

To avoid importing buy events of unspecified users, you must apply some kind of validation.
Therefore, you must add a signature parameter, which is calculated in the following way:

`String signature=md5(encode("<itemtype>&<itemid>&<licensekey>&fullprice=<fullprice>&overridetimestamp=<timestamp>&quantity=<quantity>"));`

!!! caution "Parameter limitations"

    Sending an invalid signature results in the `400 Bad request` response.
    
    To create a signature, parameters must be sent in alphabetical order based on the parameter name.
    Escaped characters must always use upper case letters (for example, `%3A` and not `%3a`)

    Parameters with value "", "null" or "undefined" must be excluded from the signing and cannot be sent in 
    the query string.

    Valid example:
    `https://event.yoochoose.net/api/00000/buy/johndoe/1/11?fullprice=19.99EUR&overridetimestamp=2012-01-01T11%3A00%3A00&quantity=1&signature=55870c7d1a7bb02e25f30f6b88fa73b4`

    Invalid example: 
    `https://event.yoochoose.net/api/00000/buy/johndoe/1/11?fullprice=19.99EUR&overridetimestamp=2012-01-01T11%3A00%3a00&quantity=&signature=d0026f017ae823f19530d93318c5a2f6`
