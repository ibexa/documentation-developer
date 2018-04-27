# Extending eZ Platform

The back-end interface is produced by [PlatformUIBundle](https://github.com/ezsystems/PlatformUIBundle) which provides a JavaScript Single Page Application based on [the YUI App Framework](http://yuilibrary.com/yui/docs/app/). This interface is accessible in your browser at `http://[uri_of_platform]/ez`.

## Technical architecture

The PlatformUI application code is divided into different types of components:

- **Application:** this is the top level component, the PlatformUI application is an instance of it. It is responsible for authenticating the user and for handling the routing.
- **Models:** models are the main objects handled by the application, they represent our main domain objects (Content, Location, Content Type, etc.)
- **View services:** view services act between the Application and the Views. They are configured on the routes and the main responsibility of a view service is to provide the model (or other data) to the views and to perform the operations requested by the user (removing a Content item, copying, etc.)
- **Views:** views generate the user interface and handle the user interaction (clicking, form submitting, etc.). A view can have several sub-views which can have further sub-views themselves.
- **Plugins:** plugins can enhance the application, the view services or the views, for instance to provide additional features or to tweak the behavior of the plugged component.

The following chart depicts the interaction between those components:

![Overview of PlatformUI component structure](img/architecture_platformui.png)

### Views: main view, sub-view, side view

The views represent a large part of the application and each of them can be used in three different contexts:

1. As the main view
1. As a sub-view of another (sub-)view
1. As a side view

#### Main view

A view used as a main view is configured at the route level to be displayed when the user navigates to that route.

For instance, when reaching `/ez`, the user is redirected to the `loginForm` route (`/ez#/login`), which is configured in the following way in the application component:

```
{
     name: "loginForm",
     path: "/login",
     service: Y.eZ.LoginFormViewService,
     sideViews: {'navigationHub': false, 'discoveryBar': false},
     view: 'loginFormView',
     callbacks: ['open', 'handleSideViews', 'handleMainView']
}
```

Among others things, this means the view `loginFormView` will be used as the main view when this route is matched. `loginFormView` is actually [the identifier of the view metadata registered in the `view` property of the Application](http://yuilibrary.com/yui/docs/app/#declaring-views).

#### Sub-view

To avoid having huge main views doing too many things in the application, the views are divided into smaller parts called sub-views.

![Sub-view](img/sub_views.png)

For instance, the view used to display a Location is divided into several views at several levels, it contains:

- An action bar view for the right toolbar, which contains:
    - a view for the Minimize button
    - a view for the Create button which contains:
        - a view to list and select a Content Type
    - a view for the Edit button
    - ...
- A Location View tab view which contains:
    - the Raw Content View to display the fields which contains:
        - A view for each fields
        - ...
- A Location Details tab view
- ...
- A sub-item list view

#### Side view

A view can also be used as a side view. As its name suggests, a side view can represent anything that is not part of the main view.

For instance, when displaying a Location, the top menu (the Navigation hub) or the left toolbar (the Discovery Bar) are side views.

![Location view](img/locationview.png)

The side views are also used for various widgets providing a service used several times in the application, such as the Universal Discovery Widget.

### View services

The view services act between the application and the views for both the main views and the side views. They are responsible for providing the required data needed by a main view or a side view to be rendered. A view service will also receive the events triggered by the view to react or provide additional data. For that, the view services receive an instance of the JavaScript REST Client.

## How are pages generated?

Depending on the part of the PlatformUI application you are using, the page may be generated in two different ways. From an end-user perspective, this is almost transparent but as a developer it is important to understand how the page is generated to be able to extend it.

### Browser-side rendering

The pages in the content part (as opposed to admin-related pages) are fully rendered in the browser. For instance, when displaying a Location in PlatformUI, the corresponding view service loads the Location model and the *related* models (Content, Content Type, etc.) with the eZ Platform REST API (through the JavaScript REST Client) and gives them the LocationView to be displayed directly by this view and/or by its sub-views. If you open the browser developer tools in the network panel, you can see the REST requests needed to build the page and they only contain a JSON structure.

![Network panel with REST requests](img/network_panel.png)

### Server-side rendering

The pages in the admin are built in a more traditional way as they are partly rendered server side. For those pages, the view service fetches one (or several) HTML fragment(s) from the server. This HTML fragment follows a very simple structure and can be generated by any means on the server. In PlatformUI this is done in a quite standard Symfony controller. By opening the browser developer tools in the network panel you can see the requests needed to build the section list page.

![Network panel](img/network_panel2.png)

## UI Components

### Navigation hub

The Navigation hub is a side view displaying the top menu.

![Navigation hub](img/nav_hub.png)

It displays 4 **Navigation zones**:

- *Content*
- *Page*
- *Performance*
- *Admin Panel*

A zone can contain an arbitrary number of **Navigation zone items**. By default, the *Content* zone has 2 navigation items: *Content structure* and *Media library*.

### Bar views: Discovery Bar View, Action Bar View, Edit Action Bar View

Bar views provide a set of potential actions for the user.

![Location view](img/locationview2.png)

When navigating in the Content zone, the **Discovery Bar View** enables you to browse through content while the **Action Bar View** on the right enables you to act on the Content item being viewed (edit, move, copy, etc.).

When editing a Content item, the **Edit Action Bar View** on the right enables you to act on the Content item being edited.

### Universal Discovery Widget

![Universal Discovery Widget](img/udw.png)

The Universal Discovery Widget is a side view triggered when the user needs to pick a Content item (or a Location). It can provide several **Discovery Methods**. By default, *Browse* and *Search* are available.
