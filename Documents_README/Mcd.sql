
-- Table: user
DROP TABLE IF EXISTS user;
CREATE TABLE user (
    user_id       INT AUTO_INCREMENT PRIMARY KEY,
    username      VARCHAR(50) NOT NULL,
    firstname     VARCHAR(50) NOT NULL,
    lastname      VARCHAR(50) NOT NULL,
    email         VARCHAR(100) NOT NULL,
    password      VARCHAR(255) NOT NULL,
    phone_number  VARCHAR(20) NOT NULL,
    adress        VARCHAR(255) NOT NULL,
    role          VARCHAR(50) NOT NULL,
    credit        INT NOT NULL,
    preference_id INT UNIQUE
) ENGINE=InnoDB;


-- Table: preference
CREATE TABLE preference (
    preference_id     INT AUTO_INCREMENT PRIMARY KEY,
    animals           BOOLEAN NOT NULL,
    smoker            BOOLEAN N OT NULL,
    music             BOOLEAN NOT NULL,
    disbled_equipment BOOLEAN NOT NULL,
    trailer           BOOLEAN NOT NULL,
    usb_charger       BOOLEAN NOT NULL,
    tablet            BOOLEAN NOT NULL,
    user_id_have      INT UNIQUE NOT NULL,
    CONSTRAINT fk_preference_user FOREIGN KEY (user_id_have) REFERENCES user(user_id)
) ENGINE=InnoDB;

-- Table: avis
CREATE TABLE avis (
    avis_id      INT AUTO_INCREMENT PRIMARY KEY,
    comment      TEXT NOT NULL,
    note         INT NOT NULL,
    user_id_file INT NOT NULL,
    CONSTRAINT fk_avis_user FOREIGN KEY (user_id_file) REFERENCES user(user_id)
) ENGINE=InnoDB;

-- Table: route
CREATE TABLE route (
    route_id        INT AUTO_INCREMENT PRIMARY KEY,
    departure_town  VARCHAR(255) NOT NULL,
    arrival_town    VARCHAR(255) NOT NULL,
    departure_day   DATETIME NOT NULL,
    departure_time  TIMESTAMP NOT NULL,
    travel_time     INT NOT NULL,
    correspondence  VARCHAR(50) NOT NULL,
    user_id_define  INT NOT NULL,
    CONSTRAINT fk_route_user FOREIGN KEY (user_id_define) REFERENCES user(user_id)
) ENGINE=InnoDB;

-- Table: brand
CREATE TABLE brand (
    brand_id         INT AUTO_INCREMENT PRIMARY KEY,
    model            VARCHAR(255) NOT NULL,
    motorization     VARCHAR(255) NOT NULL,
    number_place     INT NOT NULL,
    category         VARCHAR(255) NOT NULL,
    air_conditioning BOOLEAN NOT NULL,
    luggage_rack     BOOLEAN NOT NULL,
    gps              BOOLEAN NOT NULL
) ENGINE=InnoDB;

-- Table: vehicle
CREATE TABLE vehicle (
    vehicle_id           INT AUTO_INCREMENT PRIMARY KEY,
    year                 VARCHAR(255) NOT NULL,
    status               VARCHAR(255) NOT NULL,
    kilometer            INT NOT NULL,
    is_actif             BOOLEAN NOT NULL,
    user_id_own          INT NOT NULL,
    brand_id_to_be_bound INT NOT NULL,
    INDEX vehicle_idx_isactif (is_actif),
    CONSTRAINT fk_vehicle_user FOREIGN KEY (user_id_own) REFERENCES user(user_id),
    CONSTRAINT fk_vehicle_brand FOREIGN KEY (brand_id_to_be_bound) REFERENCES brand(brand_id)
) ENGINE=InnoDB;

-- Table: book
CREATE TABLE book (
    route_id INT NOT NULL,
    user_id  INT NOT NULL,
    PRIMARY KEY (route_id, user_id),
    CONSTRAINT fk_book_route FOREIGN KEY (route_id) REFERENCES route(route_id),
    CONSTRAINT fk_book_user  FOREIGN KEY (user_id) REFERENCES user(user_id)
) ENGINE=InnoDB;
