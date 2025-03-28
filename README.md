# Slots Plugin for WordPress

## Description

Slots Plugin is a comprehensive WordPress plugin designed for creating and managing slot machine-related content with advanced Gutenberg block support and flexible display options.

## Features
 
### Custom Post Type
- Creates a custom post type called "Slot"
- Allows detailed management of slot machine information

### Slot Metadata
Each Slot post includes comprehensive metadata:
- Title
- Description
- Star Rating
- Featured Image
- Provider Name
- Return-to-Player (RTP) Percentage
- Minimum and Maximum Wager Limits

### Gutenberg Blocks

#### 1. Slot Details Block
- Exclusively used with Slot post type
- Dynamically displays slot metadata
- Provides a comprehensive overview of each slot machine

#### 2. Slots Grid Block
- Highly customizable grid display for slots
- Advanced styling options for individual grid elements
- Sorting functionalities:
  - Recent slots
  - Random selection
  - Latest updated slots
- Configurable grid size limit

### Shortcode Support
- `[slots_list]` shortcode for non-Gutenberg compatible sites
- Ensures backward compatibility with classic WordPress themes

## Installation

### Manual Installation
1. Download the plugin ZIP file
2. Navigate to WordPress Admin > Plugins > Add New
3. Click "Upload Plugin"
4. Select the downloaded ZIP file
5. Click "Install Now"
6. Activate the plugin

## Usage

### Creating Slots
1. Navigate to "Slots" in WordPress admin menu
2. Click "Add New Slot"
3. Fill in all relevant metadata
4. Publish the slot

### Using Gutenberg Blocks
- Add "Slot Details" block when editing a Slot post
- Use "Slots Grid" block on any page or post to display slots

### Shortcode
Use `[slots_list]` in classic editor or text widgets to display slots

## Customization

### Slot Grid Block Options
- Limit number of slots displayed
- Choose sorting method
- Customize individual grid element styles

## Requirements
- WordPress 5.0+
- PHP 7.4+

## Compatibility
- Works with most WordPress themes
- Full Gutenberg block editor support

## Frequently Asked Questions

### Can I use the Slot Details block outside of Slot posts?
No, the Slot Details block is designed exclusively for Slot post types.

### How many slots can I display in the grid?
The Slots Grid block allows you to configure the number of slots displayed with a maximum of 20 for each grid.

## Changelog

### 1.0.0
- Initial plugin release
- Added Slot post type
- Implemented Slot Details and Slots Grid Gutenberg blocks
- Added `[slots_list]` shortcode


## Credits
- Developed by [Andre De Carlo]
