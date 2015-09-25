ALTER TABLE `video_collections`.`vc_videos` ADD COLUMN `browsed_video` VARCHAR(50) NULL AFTER `updated_at`; 
ALTER TABLE `video_collections`.`vc_videos` ADD COLUMN `browsed_imagecode` VARCHAR(50) NULL AFTER `browsed_video`; 
