# Scheduled Content - Magento Extension  
  
Set different content for each period and show it where you want  
Supports multiple stores

## Install:  
  
Copy all data from app directory to your magento project  
Or install extension using [modman](https://github.com/hws47a/modman-relative-links)

## Usage:  
  
* Add content on "Custom Modules -> Scheduled Content" page with some `<identifier>`  
For each content item you can specify:    
  * Identifier  
  * Store (isn't showed in single store mode)
  * Content  
  * Start Date
  * End Date
* Show content:  
  * In CMS block or page with `{{block type="scheduledContent/data" data_id="<identifier>"}}`  
  * In Layout `<block type="scheduledContent/data" data_id="<identifier>" />`  
* After showing content for this day saves to Block HTML cache. To clear cache for one block - use "Save and Apply" button, for all blocks - "Apply All" button.
  
It shows content with needed Identifier, for current store, when Start Date <= current date <= End Date
