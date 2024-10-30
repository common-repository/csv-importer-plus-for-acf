=== CSV Importer Plus for ACF ===
Contributors: mobeenraheem
Tags: csv, import, wordpress csv import, advanced custom fields, acf
Requires at least: 5.8
Tested up to: 6.6
Stable tag: 1.0.7
License: GPLv2 or later

CSV Importer Plus for ACF map and import CSV data into your posts, pages, and custom post types. Support a wide range of standard and ACF fields. 

== Description ==

= CSV Importer Plus for ACF plugin imports data into: =

* ACF (Advanced Custom Fields)
* SCF (Secure Custom Fields)

CSV Importer Plus for ACF is a powerful and user-friendly plugin that allows you to effortlessly map and import CSV data into your posts, pages, and custom post types. With support for a wide range of standard post/page fields and ACF fields, this plugin provides a seamless solution for managing data in WordPress. Unlock even more with the premium version, offering advanced support for 20+ acf fields, including Repeater, Flexible Content, Gallery, WYSIWYG Editor, and more. CSV Importer Plus for ACF is perfect for developers and content creators looking to streamline their workflow and enhance their ACF and content management capabilities.

If you want the plugin to automatically map your CSV columns to fields, make sure to use the below exact CSV column names for the standard fields. You can also manually map your CSV data.

= For standard post fields, the CSV column name will be: =

post_id, post_title, post_content, post_excerpt, post_featured_image, post_categories, post_tags, post_author_usernames, post_author_emails, post_author_passwords, post_status, post_date, post_comments, post_pings

= For standard page fields, the CSV column name will be: =

post_id, post_title, post_date, post_content, post_excerpt, featured_image, post_parent, menu_order, page_template, post_author, post_author_email, author_password, post_status, comments

= For Acf Fields: Use ACF field name. =

CSV Importer Plus for ACF imports data in chunks. You can also set the chunk size from 10 to 100, depending on what your server can handle.

Update check allows you to edit existing posts. If the plugin finds an existing post ID, it updates the post; if not, it creates a new post.

Check out our [documentation and video tutorials](https://bestropro.com/video-tutorials/)

= CSV Importer Plus for ACF =

[youtube https://www.youtube.com/watch?v=eYguKInZd7s /]

= Import following post fields: =

* Title
* Published Date
* Content
* Excerpt
* Featured Image
* Categories
* Tags
* Post Status
* Comments (enable/disable)
* Pings (enable/disable)

= Import following page fields: =

* Title
* Published Date
* Content
* Excerpt
* Featured Image
* Page's Parent
* Page's Order
* Page's Template
* Page Status
* Comments (enable/disable)

= Import following acf fields: =

* Text
* Text Area
* Number
* Range
* Email
* Password
* URL
* Image
* Select
* True / False
* Date Picker

CSV Importer Plus for ACF also generates author accounts with the provided usernames, emails, and passwords.

**** Use UTF-8 encoding in the CSV file if your data has special characters. ****

[Download Sample Data For Free version](https://drive.google.com/file/d/1o1vxT0SfjZKjbSh41QaPuowy4USMQKpH/view?usp=sharing)


= CSV Importer Plus for ACF Pro =

[youtube https://www.youtube.com/watch?v=37Gqt1vL23c /]

In the Pro version, it imports the following ACF fields along with all wp standard fields for posts and pages:

= Import following post fields: =

* Title
* Published Date
* Content
* Excerpt
* Featured Image
* Categories
* Tags
* Post Status
* Comments (enable/disable)
* Pings (enable/disable)

= Import following page fields: =

* Title
* Published Date
* Content
* Excerpt
* Featured Image
* Page's Parent
* Page's Order
* Page's Template
* Page Status
* Comments (enable/disable)

= Import following acf fields: =

* Text
* Text Area
* Number
* Range
* Email
* Password
* URL
* Image
* Select
* True / False
* Date Picker
* File
* Link
* Post Object
* Relationship
* Gallery
* Checkbox
* Radio Button
* Button Group
* WYSIWYG Editor
* oEmbed
* Page Link
* Taxonomy
* User
* Google Map
* Date Time Picker
* Time Picker
* Color Picker
* Icon Picker
* Message
* Flexible Content
* Repeater

[Download Sample Data For Pro version](https://drive.google.com/file/d/1PpG4JIjwawqeKJ9eZ-QXGUC9HDvxXKLm/view?usp=sharing)

[Guaranteed technical support via e-mail for pro users](https://bestropro.com/support/) 

[See the plugin's homepage for more details](https://bestropro.com/).


== Frequently Asked Questions ==

= How do I import data? =

It's pretty simple. Open the plugin page, select the post type, choose the chunk size, and upload your CSV file. If you want to update existing posts, tick the checkbox and press 'Next.' CSV Importer Plus for ACF will automatically map your CSV data if you follow the sample data column names. If not, you can manually select and import your data.

= Where can i download sample data? =

Sample data for the free and Pro versions is provided above.

= Can I import ACF fields into any WordPress post type? =

Yes, you can import posts, pages, and user-created custom post types. 

= Does it show import status and logs? =

Yes, CSV Importer Plus for ACF shows the status after each chunk import in the progress bar. It also shows logs if some fields are not imported successfully.

= How does CSV Importer Plus for ACF work? =

CSV Importer Plus for ACF is quite flexible for importing data. You can map fields, or you don’t have to map some fields. It only imports the fields that are mapped in the mapping form.

= How many acf fields does it import in the free version? =

CSV Importer Plus for ACF imports 11 acf fields covering the basic needs of most users, but if users need more advanced acf fields, we provide them in the Pro version.


= How do I get support? =

You can use the WordPress support forum or the contact us form to reach out. We will get back to you as soon as possible.


== Screenshots ==

1. Select post type, chunk size & upload CSV.
2. Map Form.
3. Map the CSV Fields to standard and ACF fields.
4. View Progress using progress bar.
5. View Status message & logs.


== Changelog ==

= 1.0.0 =
Initial release.

= 1.0.1 =
ACF required message fixed.

= 1.0.2 =
Plugin name change due to the legality of trademarks.

= 1.0.3 =
Added unique function/class/define/namespace/option names.
Removed direct File Access to plugin files

= 1.0.4 =
Closing HTML tags fixed in post content

= 1.0.5 =
Fixed Upgrade subpage slug
Added plugin rate link 

= 1.0.6 =
Duplicate column names error handle

= 1.0.7 =
Updated requires (ACF) or (SCF) notice