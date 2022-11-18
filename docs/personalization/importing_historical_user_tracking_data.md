---
description: Use historical user tracking data to build user profiles and generate better recommendations.
---

# Importing historical user tracking data

The recommendation engine supports replaying historical user events by adding a special parameter *overridetimestamp* on the buy event to simulate the event date.
This is then used as the datetime of an event instead of the current timestamp 
of the request.

To give an example: It is often requested to import the buy history of users 
to avoid the cold start problem and being able to start with good recommendations.
Instead of waiting till the user profile is built by collecting events from the day,
you implemented the tracking.
Usually a curl input file is generated which creates buy requests that are sent 
to the tracking endpoint.

!!! note "User identifiers"

    Ensure that user identifiers used in an import file are the same that 
    are used in the live tracking, for example, the user login identifiers.

There must be some validation to avoid importing buy events by any user.
Therefore a signature parameter needs to be added, which is calculated like the following:

`String signature=md5(encode("<itemtype>&<itemid>&<licensekey>&fullprice=<fullprice>&overridetimestamp=<timestamp>&quantity=<quantity>"));`

!!! caution "Parameters without a value"

    The order of the parameters to be signed is crucial.
    They must be sent in alphabetical order based on the parameter names to create 
    a signature.
    Encodings must always contain capital letters (for example, %3A and not %3a).

    If a parameter value is "" or "null" or "undefined" it needs to be excluded from 
    the signing and must not be sent in the query string.

    **valid**: `https://event.perso.ibexa.co/api/00000/buy/johndoe/1/11?fullprice=19.99EUR&overridetimestamp=2012-01-01T11%3A00%3A00&quantity=1&signature=d0026f017ae823f19530d93318c5a2f6`

    **invalid**: `https://event.perso.ibexa.co/api/00000/buy/johndoe/1/11?fullprice=19.99EUR&overridetimestamp=2012-01-01T11%3A00%3A00&quantity=&signature=d0026f017ae823f19530d93318c5a2f6`

## Example

With a license key of "8695-1828-92810-5535-4239" and a purchase of certain 
products, there can be the following signature values:

```
https://event.perso.ibexa.co/api/00000/buy/johndoe/1/11?fullprice=19.99EUR&overridetimestamp=2012-01-01T11%3A00%3A00&quantity=1&signature=d0026f017ae823f19530d93318c5a2f6
https://event.perso.ibexa.co/api/00000/buy/johndoe/1/94?fullprice=23.99EUR&overridetimestamp=2012-01-02T11%3A00%3A00&quantity=5&signature=53ae5744879d5a3ae833f3ef34109b44
https://event.perso.ibexa.co/api/00000/buy/johndoe/1/78?fullprice=7.59EUR&overridetimestamp=2012-01-03T11%3A00%3A00&quantity=1&signature=d73e76754fb333e9733936bbd11bb5cd
...
```
