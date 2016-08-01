use chang_dev;

INSERT INTO `user` (`u_id`, `u_name`, `u_mail`, `u_phone`, `u_password_hash`, `u_password_reset_token`, `u_auth_key`, `u_role`, `u_created_at`, `u_updated_at`, `u_is_deleted`) VALUES
(1, 'admin', 'admin@zinza.com.vn', '0123456789', '$2y$13$oRIJni/4Sa2d6wdrmxUAf.AgqD5qQ4Cldq5MVREvHKblINF4ztDna', NULL, NULL, 'ADMIN', NULL, NULL, 0),
(2, 'guest', 'guest@zinza.com.vn', '9876543210', '$2y$13$y7RwNl27htSDzgTmDqNDnOLnZ2dPUkgFmBgpBbajVqIMsMe8XWZsi', NULL, NULL, 'USER', NULL, NULL, 0);
