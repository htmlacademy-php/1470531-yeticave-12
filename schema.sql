CREATE
DATABASE yeticave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE
yeticave;

CREATE TABLE users
(
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email      VARCHAR(250) NOT NULL UNIQUE,
    password   TEXT         NOT NULL
);

CREATE TABLE categories
(
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    created_on  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title       VARCHAR(50) NOT NULL UNIQUE,
    symbol_code TEXT
);

CREATE TABLE lots
(
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    created_on      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title           VARCHAR(250)  NOT NULL DEFAULT '',
    description     VARCHAR(1000) NOT NULL DEFAULT '',
    image           TEXT          NOT NULL,
    starting_price  INT UNSIGNED  NOT NULL DEFAULT 0,
    completion_date TIMESTAMP,
    bet_step        INT UNSIGNED  NOT NULL DEFAULT 0,
    user_id         BIGINT UNSIGNED,
    winner_id       BIGINT UNSIGNED,
    category_id     BIGINT UNSIGNED,
    FOREIGN KEY (user_id) REFERENCES users (id)
        ON DELETE SET NULL
        ON UPDATE SET NULL,
    FOREIGN KEY (winner_id) REFERENCES users (id)
        ON DELETE SET NULL
        ON UPDATE SET NULL,
    FOREIGN KEY (category_id) REFERENCES categories (id)
        ON DELETE SET NULL
        ON UPDATE SET NULL
);

CREATE INDEX lot_title ON lots (title);
CREATE INDEX lot_description ON lots (description);

CREATE TABLE bets
(
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    price      INT UNSIGNED NOT NULL,
    lot_id     BIGINT UNSIGNED,
    user_id    BIGINT UNSIGNED,
    FOREIGN KEY (lot_id) REFERENCES lots (id)
        ON DELETE SET NULL
        ON UPDATE SET NULL,
    FOREIGN KEY (user_id) REFERENCES users (id)
        ON DELETE SET NULL
        ON UPDATE SET NULL
);
