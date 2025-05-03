CREATE TABLE user (
    id int(10) unsigned NOT NULL AUTO_INCREMENT,
    email varchar(100) DEFAULT NULL,
    first_name varchar(100) DEFAULT NULL,
    last_name varchar(100) DEFAULT NULL,
    password varchar(100) DEFAULT NULL,
    facebook_id varchar(50) DEFAULT NULL,
    user_image varchar(200) DEFAULT NULL,
    device_token varchar(255) DEFAULT NULL,
    device_type enum ('0', '1') NOT NULL COMMENT '0- Android,  1- IOS',
    created_date datetime NOT NULL,
    modified_date datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    is_delete enum ('0', '1') NOT NULL DEFAULT '0',
    is_test enum ('0', '1') NOT NULL DEFAULT '0',
    guid varchar(100) DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY (email)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
