# Warp Theme

A feature-rich WordPress theme inspired by [warp.dev](https://warp.dev) design, fully compatible with Elementor page builder.

## Features

### Design & UI
- **Modern Dark Theme** - Beautiful dark color scheme inspired by warp.dev
- **Responsive Design** - Mobile-first approach with breakpoints at 810px, 1024px, and 1200px
- **Typography** - Inter font family for clean, professional text
- **Smooth Animations** - Scroll animations, parallax effects, and smooth transitions
- **Customizable Colors** - Full color customization via WordPress Customizer

### WordPress Features
- **Theme Support** - Post thumbnails, custom logo, custom background, HTML5 markup
- **Navigation Menus** - Primary, footer, and mobile menu locations
- **Widget Areas** - Sidebar and 4 footer widget areas
- **Translation Ready** - Full i18n support with .pot file
- **SEO Optimized** - Semantic HTML5 markup and proper heading structure
- **Accessibility Ready** - ARIA labels, keyboard navigation, screen reader support

### Elementor Integration
- **Full Elementor Support** - Compatible with Elementor page builder
- **Theme Locations** - Header, footer, single, and archive template support
- **Custom Widgets**:
  - Warp Hero - Full-screen hero sections with CTA buttons
  - Warp Feature - Feature boxes with icons
  - Warp CTA Button - Stylized call-to-action buttons
  - Warp Terminal - Code terminal display widget
- **Custom Colors** - Pre-configured Elementor color palette
- **Responsive Controls** - Mobile, tablet, and desktop breakpoints

### Performance
- **Optimized Loading** - Minimal dependencies, efficient code
- **Lazy Loading** - Images load as they enter viewport
- **Critical CSS** - Inline critical styles for faster initial render
- **Font Display Swap** - Prevent FOIT (Flash of Invisible Text)
- **Deferred JavaScript** - Non-critical scripts load after page render

## Installation

1. Download the theme ZIP file or clone this repository
2. Navigate to WordPress admin → Appearance → Themes
3. Click "Add New" → "Upload Theme"
4. Choose the ZIP file and click "Install Now"
5. Activate the theme

### Requirements
- WordPress 6.0 or higher
- PHP 7.4 or higher
- Elementor 3.0+ (optional but recommended)

## Setup Guide

### 1. Configure Theme Settings

Navigate to **Appearance → Customize** to access theme options:

#### Theme Options
- **Dark Mode** - Enable/disable dark mode (enabled by default)
- **Sticky Header** - Make header stick to top on scroll
- **Smooth Scrolling** - Enable smooth scroll animations

#### Header Options
- **Header Style** - Choose between solid or transparent header
- **Show Search** - Display search icon in header

#### Footer Options
- **Copyright Text** - Custom copyright text for footer

#### Social Links
Add URLs for:
- Twitter
- Facebook
- LinkedIn
- GitHub
- YouTube

#### Typography
- **Body Font Size** - Adjust base font size (12-24px)

#### Layout
- **Container Width** - Set max content width (960-1920px)

### 2. Setup Menus

1. Go to **Appearance → Menus**
2. Create menus and assign to locations:
   - **Primary Menu** - Main navigation (desktop)
   - **Footer Menu** - Footer links
   - **Mobile Menu** - Mobile navigation (fallback to primary if not set)

### 3. Configure Widgets

Navigate to **Appearance → Widgets**:
- **Sidebar** - Main sidebar widget area
- **Footer 1-4** - Four footer columns for widgets

### 4. Add Custom Logo

1. Go to **Appearance → Customize → Site Identity**
2. Upload your logo (recommended: 250x250px max)

## Elementor Setup

### Installing Elementor

1. Go to **Plugins → Add New**
2. Search for "Elementor"
3. Install and activate Elementor Page Builder

### Using Warp Theme Widgets

1. Edit any page with Elementor
2. In the widgets panel, look for **Warp Theme** category
3. Drag widgets into your layout:

#### Warp Hero Widget
- Add title and subtitle
- Configure primary and secondary CTA buttons
- Customize typography and colors

#### Warp Feature Widget
- Add icon (from Font Awesome or upload custom)
- Enter feature title and description
- Style to match your brand

#### Warp CTA Button Widget
- Enter button text and link
- Choose primary or secondary style
- Add target and nofollow options

#### Warp Terminal Widget
- Enter terminal/code content
- Displays in monospace font with terminal styling

### Theme Locations

Configure Elementor templates for theme locations:

1. Go to **Templates → Theme Builder**
2. Create templates for:
   - **Header** - Replace default theme header
   - **Footer** - Replace default theme footer
   - **Single** - Post/page layouts
   - **Archive** - Category/tag archives

## Customization

### Child Theme

Create a child theme for customizations:

1. Create folder: `wp-content/themes/warp-theme-child/`
2. Create `style.css`:

```css
/*
Theme Name: Warp Theme Child
Template: warp-theme
*/
```

3. Create `functions.php`:

```php
<?php
add_action('wp_enqueue_scripts', 'warp_child_enqueue_styles');
function warp_child_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
```

### Custom CSS

Add custom CSS via **Appearance → Customize → Additional CSS**

### Color Scheme

Modify CSS variables in your child theme:

```css
:root {
    --warp-primary-bg: #your-color;
    --warp-primary-text: #your-color;
    --warp-accent: #your-color;
}
```

## File Structure

```
warp-theme/
├── assets/
│   ├── css/
│   │   ├── main.css
│   │   ├── editor-style.css
│   │   ├── elementor-widgets.css
│   │   └── elementor-editor.css
│   ├── js/
│   │   ├── navigation.js
│   │   ├── animations.js
│   │   └── customizer.js
│   └── img/
├── elementor/
│   └── widgets/
│       ├── warp-hero.php
│       ├── warp-feature.php
│       ├── warp-cta-button.php
│       └── warp-terminal.php
├── inc/
│   ├── theme-setup.php
│   ├── enqueue-scripts.php
│   ├── elementor-support.php
│   └── customizer.php
├── template-parts/
│   ├── content/
│   │   ├── content.php
│   │   ├── content-single.php
│   │   ├── content-page.php
│   │   └── content-none.php
│   ├── header/
│   └── footer/
├── languages/
├── functions.php
├── style.css
├── header.php
├── footer.php
├── index.php
├── singular.php
├── page.php
├── single.php
├── archive.php
├── 404.php
├── sidebar.php
├── searchform.php
├── comments.php
├── screenshot.png
└── README.md
```

## Development

### CSS Custom Properties

The theme uses CSS custom properties (variables) for easy customization:

- Colors: `--warp-primary-bg`, `--warp-primary-text`, etc.
- Typography: `--warp-font-primary`, `--warp-font-size-*`, etc.
- Spacing: `--warp-spacing-*`
- Layout: `--warp-container-width`, `--warp-header-height`, etc.
- Transitions: `--warp-transition-*`

### Hooks & Filters

Available WordPress hooks:

- `warp_body_classes` - Modify body classes
- `warp_resource_hints` - Add resource hints
- `warp_content_width` - Change content width

### JavaScript Events

Custom JavaScript events:

- `warp:menuOpen` - Mobile menu opened
- `warp:menuClose` - Mobile menu closed
- `warp:searchOpen` - Search modal opened
- `warp:searchClose` - Search modal closed

## Browser Support

- Chrome (latest 2 versions)
- Firefox (latest 2 versions)
- Safari (latest 2 versions)
- Edge (latest 2 versions)
- Mobile browsers (iOS Safari, Chrome Android)

## Credits

- Design inspiration: [warp.dev](https://warp.dev)
- Font: [Inter](https://fonts.google.com/specimen/Inter)
- Icons: SVG icons (custom)

## License

This theme is licensed under the GPL v2 or later.

> This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

## Support

For issues, questions, or contributions:
- GitHub: [https://github.com/SYNQ-Studio/warp-theme](https://github.com/SYNQ-Studio/warp-theme)
- Issues: [https://github.com/SYNQ-Studio/warp-theme/issues](https://github.com/SYNQ-Studio/warp-theme/issues)

## Changelog

### 1.0.0 - 2025-11-05
- Initial release
- Warp.dev inspired design
- Full Elementor compatibility
- 4 custom Elementor widgets
- Responsive design
- Dark mode support
- Performance optimizations
- Accessibility features
- SEO optimizations
