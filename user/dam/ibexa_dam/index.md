# Ibexa DAM

DAM module interface for uploading and managing image assets.

Editions: Headless

Digital Asset Management is a platform dedicated to editors. It enables storing in central location, organizing, distributing, and sharing media assets across many channels.

Ibexa DAM image picker is developed to work with any web browser that supports modern standards. The minimum screen resolution is 1366 x 768.

List of supported web browsers:

- Mozilla® Firefox® most recent stable version (recommended)
- Google Chrome™ most recent stable version (recommended)
- Chromium™ based browsers such as Microsoft® Edge® and Opera®, most recent stable version, desktop and tablet
- Apple® Safari® most recent stable version, desktop and tablet

## View modes

The main window is available in two display versions: grid and list view.

To change the view mode, in the upper-right corner, click **View** and select the view you need.

### Grid view

Grid view contains image preview, file format, and image size.

### List view

List view contains a thumbnail, title, format, size, dimensions, creation, and update date.

### Sorting

You can sort image assets by alphabetical order or by the creation date. To sort image assets, in the upper-right corner, click **Date** and select the sorting method you need.

## Search assets

### Keyword search

The search option allows to find image assets using a word or phrase. To use it, in the upper part of the screen, click the **Search** field. Enter a search keyword. The platform searches assets for matches based on the keyword, including file title.

### Filter by attributes

With filtering by attributes, you can narrow search results to the following attributes:

- language
- format
- file size
- orientation
- dimensions
- tags (this filter is available only when image assets have tags assigned to)
- date of creation

To use it, in the right-side panel select attributes and click the **Apply** button. You can combine searches by all types of filtering: keyword search and attributes filter.

> **Note: Search engine support**
>
> Filtering works only when Ibexa uses `solr` or `elasticsearch` search engine. Legacy Search Engine (LSE) isn't supported.

### Navigation

Assets are organized and stored in folders. The folder structure serves as another option for filtering assets.

To navigate through folders, go to left-side panel **Folders**, and in the folders tree view, click folder you want to open.

> **Note: Note**
>
> Filtering by attribues and folders is complimentary, it means you have to use these two methods at once to get search results.

### Insert images

To insert an image asset into the HTML editor, find the image with search options, or manually locate the asset in the folder. Next, click the image thumbnail. The selected item is marked with a red dot in the upper-left corner. To confirm the selection, in the bottom toolbar, click **Insert**.

You can only select one image at a time. To deselect the image, click the thumbnail again.
