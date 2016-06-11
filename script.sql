ALTER TABLE `video_collections`.`vc_videos` ADD COLUMN `browsed_video` VARCHAR(50) NULL AFTER `updated_at`; 
ALTER TABLE `video_collections`.`vc_videos` ADD COLUMN `browsed_imagecode` VARCHAR(50) NULL AFTER `browsed_video`;
ALTER TABLE `video_collections`.`vc_user_details` ADD COLUMN `public_or_private` INT(10) NULL AFTER `alter_number`; 
 ALTER TABLE `video_collections`.`vc_user_details` ADD COLUMN `fb_profile_link` VARCHAR(100) NULL AFTER `public_or_private`; 
 ALTER TABLE `video_collections`.`vc_user_details` ADD COLUMN `message` TEXT NULL AFTER `fb_profile_link`; 
 ALTER TABLE `video_collections`.`vc_user_details` ADD COLUMN `skills` VARCHAR(100) NULL AFTER `message`;   
 ALTER TABLE `video_collections`.`vc_user_details` CHANGE `fb_profile_link` `fb_profile_link` TEXT CHARSET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `video_links` `video_links` TEXT CHARSET latin1 COLLATE latin1_swedish_ci NULL; 
 ALTER TABLE `video_collections`.`vc_user_details` ADD COLUMN `user_profile_photo` VARCHAR(150) NULL AFTER `video_links`;  
