<?php
/**
 * VF extension for Magento
 *
 * Add scheduled content data store table
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the VF ScheduledContent module to newer versions in the future.
 * If you wish to customize the VF ScheduledContent module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   VF
 * @package    VF_ScheduledContent
 * @copyright  Copyright (C) 2012 Vladimir Fishchenko (http://fishchenko.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @var $this Mage_Core_Model_Resource_Setup
 */

$installer = $this;
$installer->startSetup();

$installer->run("
CREATE TABLE {$this->getTable('scheduledContent/data_store')} (
  data_id int(11) unsigned NOT NULL,
  store_id smallint(5) unsigned NOT NULL,
  PRIMARY KEY (data_id,store_id),
  CONSTRAINT FK_SCHEDULED_CONTENT_DATA_STORE_DATA FOREIGN KEY (data_id)
  REFERENCES {$this->getTable('scheduledContent/data')} (data_id)
  ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT FK_SCHEDULED_CONTENT_DATA_STORE_STORE FOREIGN KEY (store_id)
  REFERENCES {$this->getTable('core/store')} (store_id)
  ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Scheduled Data to Stores';
");

$installer->endSetup();
