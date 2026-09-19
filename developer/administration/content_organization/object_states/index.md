# Object states

Object states are user-defined states that can be assigned to content items.

Object states are user-defined states that can be assigned to content items. They're contained in groups.

![Object State group](https://doc.ibexa.co/en/5.0/administration/img/admin_panel_object_state_groups.png "Object state group")

If a state group contains any states, each content item is automatically assigned a state from this group.

You can assign states to content in the back office in the content item's **Technical details** tab.

![Assigning an object state to a content item](https://doc.ibexa.co/en/5.0/administration/img/assigning_an_object_state.png "Assigning an object state to a content item")

By default, Ibexa DXP contains one object state group: **Lock**, with states **Locked** and **Not locked**.

![Lock Object state](https://doc.ibexa.co/en/5.0/administration/img/object_state_lock.png "Lock object state")

Object states can be used in conjunction with [permissions](../../../permissions/permission_overview/index.md), in particular with the [object state limitation](../../../permissions/limitation_reference/index.md#object-state-limitation). Their specific use cases depend on your needs and the setup of your permission system.
