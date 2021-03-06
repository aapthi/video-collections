ALTER TABLE `video_collections`.`vc_videos` ADD COLUMN `browsed_video` VARCHAR(50) NULL AFTER `updated_at`; 
ALTER TABLE `video_collections`.`vc_videos` ADD COLUMN `browsed_imagecode` VARCHAR(50) NULL AFTER `browsed_video`;
ALTER TABLE `video_collections`.`vc_user_details` ADD COLUMN `public_or_private` INT(10) NULL AFTER `alter_number`; 
 ALTER TABLE `video_collections`.`vc_user_details` ADD COLUMN `fb_profile_link` VARCHAR(100) NULL AFTER `public_or_private`; 
 ALTER TABLE `video_collections`.`vc_user_details` ADD COLUMN `message` TEXT NULL AFTER `fb_profile_link`; 
 ALTER TABLE `video_collections`.`vc_user_details` ADD COLUMN `skills` VARCHAR(100) NULL AFTER `message`;   
 ALTER TABLE `video_collections`.`vc_user_details` CHANGE `fb_profile_link` `fb_profile_link` TEXT CHARSET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `video_links` `video_links` TEXT CHARSET latin1 COLLATE latin1_swedish_ci NULL; 
 ALTER TABLE `video_collections`.`vc_user_details` ADD COLUMN `user_profile_photo` VARCHAR(150) NULL AFTER `video_links`;
CREATE TABLE `video_collections`.`vc_user_pics`( `vp_id` INT NOT NULL AUTO_INCREMENT, `vp_u_id` INT, `vp_pics` VARCHAR(150), `vp_created_at` DATETIME, `vp_updated_at` DATETIME, `vp_status` INT, PRIMARY KEY (`vp_id`) ); 
 CREATE TABLE `video_collections`.`vc_user_videos`( `v_v_id` INT NOT NULL AUTO_INCREMENT, `v_user_id` INT, `v_video_link` TEXT, `v_updated_at` DATETIME, `v_created_at` DATETIME, PRIMARY KEY (`v_v_id`) );
ALTER TABLE `video_collections`.`vc_user_details` ADD COLUMN `ph_pub_pri` VARCHAR(150) NULL AFTER `home_phone`; 
 ALTER TABLE `video_collections`.`vc_user_details` ADD COLUMN `work_pub_pri` VARCHAR(50) NULL AFTER `ph_pub_pri`, ADD COLUMN `home_pub_pri` VARCHAR(50) NULL AFTER `work_pub_pri`; 

-->15
ALTER TABLE `video_collections`.`vc_user_details` ADD COLUMN `gender` VARCHAR(50) NULL AFTER `languages`;  
ALTER TABLE `video_collections`.`vc_user_details` ADD COLUMN `user_check_data` SMALLINT(5) NULL AFTER `user_photo`; 
ALTER TABLE `video_collections`.`vc_user_details` CHANGE `user_check_data` `user_check_data` SMALLINT(5) DEFAULT 0 NULL; 

ALTER TABLE `sfaddaco_sfadda`.`user` ADD FULLTEXT INDEX `username` (`username`); 
ALTER TABLE `sfaddaco_sfadda`.`user` ENGINE=MYISAM; 


Create Table


