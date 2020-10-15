# Importing historical user tracking data

We support replaying historical user events by adding a special parameter *overridetimestamp* on the buy event to simulate the event date.
This is then used as the datetime of an event instead of the current timestamp of the request.

To give an example: It is often requested to import the buy history of users to avoid the cold start problem and being able to start with good recommendations.
You do not have to wait to build user profiles by collecting events from the day you implemented the tracking.
Usually a curl input file is generated which creates buy requests that are sent to our tracking endpoint.

!!! note "User identifiers"

    Assure that user identifiers being used in an import file are the same that are used in the live tracking, e.g. the user login identifiers!

There must be some validation to avoid importing buy events by any user.
Therefore a signature param needs to be added, which is calculated like following:

`String signature=md5(encode("<itemtype>&<itemid>&<licensekey>&fullprice=<fullprice>&overridetimestamp=<timestamp>&quantity=<quantity>"));`

!!! caution "Params without a value"

    The order of the params to be signed is crucial.
    They must be sent in alphabetical order based on the parameter names to create a signature.
    Encodings must always contain capital letters (e.g. %3A and not %3a)

    If a param value is "" or "null" or "undefined" it needs to be excluded from the signing and must not be sent in the querystring!

    **valid**: `https://event.yoochoose.net/api/00000/buy/johndoe/1/11?fullprice=19.99EUR&overridetimestamp=2012-01-01T11%3A00%3A00&quantity=1&signature=d0026f017ae823f19530d93318c5a2f6`

    **invalid**: `https://event.yoochoose.net/api/00000/buy/johndoe/1/11?fullprice=19.99EUR&overridetimestamp=2012-01-01T11%3A00%3A00&quantity=&signature=d0026f017ae823f19530d93318c5a2f6`

## Example

Given a license key of "8695-1828-92810-5535-4239" and a purchase of certain products, we have the following signature values:

```
https://event.yoochoose.net/api/00000/buy/johndoe/1/11?fullprice=19.99EUR&overridetimestamp=2012-01-01T11%3A00%3A00&quantity=1&signature=d0026f017ae823f19530d93318c5a2f6
https://event.yoochoose.net/api/00000/buy/johndoe/1/94?fullprice=23.99EUR&overridetimestamp=2012-01-02T11%3A00%3A00&quantity=5&signature=53ae5744879d5a3ae833f3ef34109b44
https://event.yoochoose.net/api/00000/buy/johndoe/1/78?fullprice=7.59EUR&overridetimestamp=2012-01-03T11%3A00%3A00&quantity=1&signature=d73e76754fb333e9733936bbd11bb5cd
...
```
