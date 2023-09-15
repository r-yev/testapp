<?php

return "
    CREATE TABLE IF NOT EXISTS users(
        id int PRIMARY KEY AUTO_INCREMENT,
        firstname VARCHAR(255), 
        lastname VARCHAR(255),
        phone VARCHAR(255),
        email VARCHAR(255) UNIQUE,
        password VARCHAR(255)   
    );
";

