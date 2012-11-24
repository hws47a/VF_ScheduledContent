# Scheduled Content - Magento Extension  
  
Set different content for each period and show it where you want  

## Install:  
  
Copy all data from app directory to your magento project  
Or install extension using [modman](https://github.com/hws47a/modman-relative-links)

## Usage:  
  
* Add content on "Custom Modules -> Scheduled Content" page with some `<identifier>`
  
* Show content:  
  
  * In CMS block or page with `{{block type="scheduledContent/data" data_id="<identifier>"}}`  
  * In Layout `<block type="scheduledContent/data" data_id="<identifier>" />`  
  
* After showing content for this day saves to Block HTML cache  
  