DROP TABLE IF EXISTS user_items;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS items;

CREATE TABLE users (
    id bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name varchar(255) NOT NULL,
    email varchar(255) UNIQUE NOT NULL,
    password varchar(255) NOT NULL,
    gender varchar(16) DEFAULT NULL,
    created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE items (
    id bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code varchar(255) UNIQUE NOT NULL,
    name varchar(255) NOT NULL,
    price int NOT NULL,
    stock int NOT NULL,
    created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_items (
    id bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id bigint UNSIGNED NOT NULL,
    item_id bigint UNSIGNED NOT NULL,
    amount int NOT NULL,
    total_price int NOT NULL,
    created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE user_items
  ADD CONSTRAINT user_items_item_id_fkey FOREIGN KEY (item_id) REFERENCES items (id) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT user_items_user_id_fkey FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE RESTRICT ON UPDATE RESTRICT;