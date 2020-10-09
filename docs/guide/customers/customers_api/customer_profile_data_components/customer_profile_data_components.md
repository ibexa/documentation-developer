# Customer profile data components

## Components

The complete model of the customer profile data consists of the following components:

| Component   | Description| Location   |
| ----- | ----- | ----- |
| Model | The customer profile data itself. This is the object that holds all user profile-related data such as first name, last name, customer number, contact number, addresses and so on. Instances of this model only have this data, so they act as a "data entity" within the system.| `EshopBundle/Model/CustomerProfileData`|
| Services | Services to create profile (model) instances. They also provide a mapping service for the deprecated model to avoid compatibility problems of other components that depend on the old model within the system. | `EshopBundle/Services/CustomerProfileData`  |
| Events | Provides profile event definitions. Events are thrown in certain situations (e.g. before or after a customer profile is fetched).| `EshopBundle/Event/CustomerProfileData` |
| Event listener | Provides the implementations of actions which are triggered when an event is thrown. This way you can easily modify profile data (e.g. define a fallback for a case when a data source like the ERP is unavailable). | `EshopBundle/EventListener/CustomerProfileData` |

The customer profile data is strictly separated into the components described above.
An instance of a profile model or a listener will never fetch data itself,
instead the service is always used to enrich or modify profile data.

There is always a customer profile instance in the request as a "data entity".
One or more profile services retrieve (fetch) profile data entities.
All events that are thrown within the profile services are handled by listeners.
These listeners perform actions on the profile data entities under explicit conditions using always the profile services.
