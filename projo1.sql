CREATE DATABASE donorcrud;
USE donorcrud;
CREATE TABLE donor (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    homeaddress VARCHAR(255) NOT NULL,
    fooditem VARCHAR(100) NOT NULL,
    itemquantity VARCHAR(255) NOT NULL,
    itemamount VARCHAR(255) NOT NULL,
    destinationaddress VARCHAR(255) NOT NULL
);