
My Theme - WordPress Theme Template
==================================

Overview
--------
This is a custom WordPress theme template designed for flexibility and easy customization. It uses vanilla CSS and a modular file structure for maintainability.

Installation
------------
1. Copy the `my-theme` folder into your WordPress `wp-content/themes/` directory.
2. In your WordPress admin dashboard, go to Appearance > Themes and activate "My Theme".

File Structure
--------------
- `404.php` - Handles 404 error pages.
- `archive.php` - Displays archive pages (categories, tags, etc.).
- `footer.php` - Theme footer.
- `functions.php` - Main functions file, includes additional PHP from the `functions/` directory.
- `header.php` - Theme header.
- `index.php` - Main template file.
- `page.php` - Default page template.
- `page-blog.php` - Custom blog page template.
- `search.php` - Search results template.
- `single.php` - Single post template.
- `single-{post_type}.php` - Template for custom post types.
- `style.css` - Main stylesheet (required by WordPress).
- `assets/` - Contains images and other assets.
- `functions/` - Modular PHP functions (enqueue scripts, theme setup, etc.).
- `inc/css/` - CSS files for different theme parts (header, footer, etc.).
- `inc/js/` - JavaScript files (global functions, plugins, etc.).
- `template-parts/` - Partial templates for posts and pages.
- `templates/` - Additional templates and components.

Customization
-------------
1. **CSS**: Edit or add CSS files in `inc/css/` for modular styling. The main `style.css` is required for theme info and global styles.
2. **JS**: Add or modify JavaScript in `inc/js/` as needed.
3. **PHP Functions**: Add custom functions in the `functions/` directory. The main `functions.php` loads these automatically.
4. **Templates**: Duplicate and modify template files as needed for custom layouts or post types.

Load More & Pagination
---------------------
- The theme includes AJAX-powered load more functionality (`functions/loadmore.php`, `inc/js/loadmore.js`).
- Pagination templates are in `templates/`.

Minification & Optimization
--------------------------
- HTML output minification is handled by `functions/minify_html_output.php`.
- Unused WordPress block CSS is dequeued in `functions/dequeue_wp_block_library_css.php`.

Other Features
--------------
- Prevent duplicate media uploads: `functions/prevent_duplicate_media_upload.php`
- Remove unwanted <br> tags: `functions/remove_br_cf7.php`, `functions/remove_br_from_content.php`
- WYSIWYG excerpt support: `functions/wysiwyg_excerpt.php`
- Save active plugins list: `functions/save_active_plugins_list.php`

Best Practices
--------------
- Keep your customizations modular by using the `functions/` directory.
- Use the `template-parts/` and `templates/` folders for reusable components.
- Regularly update your CSS and JS in the `inc/` directory for maintainability.

Support
-------
For questions or issues, please contact the theme author or open an issue in your repository.


Template Components (templates/)
-------------------------------
The `templates/` folder contains reusable components and partials to help you build custom layouts and features. Here’s what each file does and how to use them:

- `image.php`: Displays images or image blocks. Use this to standardize image output across your theme.
- `link_btn.php`: Renders styled link buttons. Include this for consistent button styles.
- `loop-loadmore.php`: Handles AJAX-powered load more functionality for post loops. Use with the load more JS and PHP logic.
- `loop-pagination.php`: Template for paginated post loops. Include this in archive or index templates for pagination.
- `pagination.php`: General pagination template for navigating between pages of posts.
- `post_cards.php`: Displays posts in a card layout, useful for grids or featured sections.
- `css/`: Contains CSS files specific to these templates/components.

How to Use Template Components
-----------------------------
To include a template component in your theme files, use the WordPress `get_template_part()` function. For example:

```
<?php get_template_part('templates/post_cards'); ?>
```

You can use this function in any template file (e.g., `index.php`, `archive.php`, `single.php`) to insert the component where needed.

For components with CSS, make sure to enqueue or import the relevant CSS file from `templates/css/` if not already included.

Customize each component as needed to fit your design and requirements. These files are meant to be modular and reusable across your theme.
