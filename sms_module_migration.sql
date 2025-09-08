-- This SQL script is required to update the database schema for the SMS module enhancements.
-- Please execute this command on your database to add the necessary columns for pricing
-- and charges to the 'sm_sms_settings' table.

ALTER TABLE `sm_sms_settings`
ADD COLUMN `price_per_sms` VARCHAR(255) NOT NULL DEFAULT '0' AFTER `account_name`,
ADD COLUMN `payment_charges` VARCHAR(255) NOT NULL DEFAULT '0' AFTER `price_per_sms`;

-- Additionally, this script adds the 'wallet_balance' column to the school details table,
-- which is essential for managing per-school SMS credits.

ALTER TABLE `sm_school_details`
ADD COLUMN `wallet_balance` INT(11) NOT NULL DEFAULT 0 AFTER `language`;

--
-- Add last_login column to all user tables for weekly reporting feature
--
ALTER TABLE `sm_super_moderators` ADD `last_login` DATETIME NULL DEFAULT NULL;
ALTER TABLE `sm_moderators` ADD `last_login` DATETIME NULL DEFAULT NULL;
ALTER TABLE `sm_admin_staffs` ADD `last_login` DATETIME NULL DEFAULT NULL;
ALTER TABLE `sm_teachers` ADD `last_login` DATETIME NULL DEFAULT NULL;
ALTER TABLE `sm_parents` ADD `last_login` DATETIME NULL DEFAULT NULL;
ALTER TABLE `sm_students` ADD `last_login` DATETIME NULL DEFAULT NULL;
