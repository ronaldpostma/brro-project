# Brro custom style, script and functions for projects
## /brro-production 

# 1. File index
1. `brro-project.php`
   - Main plugin file that includes PHP function files, enqueues scripts and styles for both admin and frontend.
   - Handles conditional script and style loading based on page type.
2. `php/brro-project-global-functions.php`
   - Contains global functions for the site, including translations and additional body classes.
3. `php/brro-project-admin-functions.php`
   - Manages admin-specific functionalities such as customizing admin menu and removing editor menus based on user roles.
4. `php/brro-project-homepage-functions.php`
   - Functions specifically for the homepage.
5. `php/brro-project-custom-post-functions.php`
   - Functions related to custom post types.
6. `php/brro-project-search-functions.php`
   - Customize search functionalities such as modifying search queries.

7. `js/brro-project-global-script.js`
   - Global JavaScript functionalities including sticky header effects and back-to-top button.
8. `brro-project-specific-script.js`
   - Specific post type JavaScript functionalities
9. `js/brro-project-wp-admin-script.js`
   - Admin area specific scripts, including limiting excerpt length.

10. `css/brro-project-global-style.css`
   - Global styles for the frontend
11. `brro-project-specific-style.css`
   - Styles for the frontend for specific post type
12. `css/brro-project-wp-admin-style.css`
   - General styles for the WordPress admin area.
13. `css/brro-project-wp-admin-editors-style.css`
   - Additional admin styles specific to certain user roles.
14. `css/brro-project-wp-admin-admin-style.css`
   - Styles specifically for the WordPress administrator role.

# 2. Scope of usability
Base templates with custom styles, scripts and functions for a site developed by Brro.

# 3. Core functions with brro-core
Works alongside the code functions in <a href="https://github.com/ronaldpostma/brro-core" target="_blank">brro-core</a>.

# 4. Development next steps
1. In `js/brro-project-global-script.js` > create the back to top button itself as well, don't rely on an Elementor widget

# 5. License
This project is licensed under the MIT License - see the LICENSE file for details.
