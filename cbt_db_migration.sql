-- This SQL script is required to update the database schema for the new CBT features.
-- Please execute this command on your database to add the 'term_id_number' column
-- to the 'sm_cbt_scheldule_lists' table.

ALTER TABLE `sm_cbt_scheldule_lists`
ADD COLUMN `term_id_number` VARCHAR(255) NULL DEFAULT NULL AFTER `subject_code`;

-- Note: This change is essential for the term-based filtering, cloning, and past questions features to work correctly. 