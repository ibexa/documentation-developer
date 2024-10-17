# SesProfileData

This field type stores [`CustomerProfileData`] in the User content type.

`CustomerProfileData` must be stored as a serialized string in base64 format,
because it's impossible to store special HTML characters (`<`,`>`, `""`,`''`, `&`) in a text or text area field.

The name of the customer (taken from the contact section) can be used for lists.
To do it, use the name pattern in the content type definition of the User content type.

`customer_profile_data` is the identifier of the field where the profile data is stored.
