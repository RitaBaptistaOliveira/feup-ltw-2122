PRAGMA Foreign_keys = OFF;

DROP TABLE IF EXISTS User;
CREATE TABLE User(
    idUser      INTEGER PRIMARY KEY,
    username    TEXT    NOT NULL UNIQUE,
    screenName  TEXT    NOT NULL,
    password    TEXT    NOT NULL,
    phoneNumber INTEGER UNIQUE    NOT NULL,
    imageExtension    TEXT,
    address     TEXT
);

DROP TABLE IF EXISTS Customer;
CREATE TABLE Customer(
    idCustomer    INTEGER CONSTRAINT FK1 REFERENCES User (idUser)
);

DROP TABLE IF EXISTS RestaurantOwner;
CREATE TABLE RestaurantOwner(
    idRestaurantOwner    INTEGER CONSTRAINT FK1 REFERENCES User (idUser)
);

DROP TABLE IF EXISTS Restaurant;
CREATE TABLE Restaurant (
    idRestaurant  INTEGER PRIMARY KEY,
    name          TEXT    NOT NULL,
    address       TEXT    NOT NULL,
    idCategory    INTEGER CONSTRAINT FK1 REFERENCES RestaurantCategory (idCategoryR),
    imageExtension         TEXT,
    idOwner       INTEGER CONSTRAINT FK1 REFERENCES RestaurantOwner (idRestaurantOwner)
);

DROP TABLE IF EXISTS Product;
CREATE TABLE Product (
    idProduct     INTEGER PRIMARY KEY,
    name          TEXT    NOT NULL,
    idCategory    INTEGER CONSTRAINT FK1 REFERENCES ProductCategory (idCategoryP),
    price         REAL NOT NULL,
    imageExtension         TEXT,
    idRestaurant  INTEGER CONSTRAINT FK1 REFERENCES Restaurant (idRestaurant)
);

DROP TABLE IF EXISTS Menu;
CREATE TABLE Menu (
    idMenu    INTEGER PRIMARY KEY,
    name      TEXT,
    price     REAL,
    imageExtension     TEXT,
    idRestaurant  INTEGER CONSTRAINT FK1 REFERENCES Restaurant (idRestaurant)
);

DROP TABLE IF EXISTS MenuProduct;
CREATE TABLE MenuProduct (
    idMenu     INTEGER CONSTRAINT FK1 REFERENCES Menu (idMenu),
    idProduct  INTEGER CONSTRAINT FK2 REFERENCES Product (idProduct)
);

DROP TABLE IF EXISTS Purchase;
CREATE TABLE Purchase (
    idOrder       INTEGER PRIMARY KEY,
    state         TEXT    NOT NULL,
    total         REAL    NOT NULL,
    date          TEXT    NOT NULL,
    idCustomer    INTEGER CONSTRAINT FK1 REFERENCES Customer (idCustomer),
    idRestaurant  INTEGER CONSTRAINT FK2 REFERENCES Restaurant (idRestaurant)
);

DROP TABLE IF EXISTS OrderProduct;
CREATE TABLE OrderProduct (
    idOrder    INTEGER CONSTRAINT FK1 REFERENCES Purchase (idOrder),
    idProduct  INTEGER CONSTRAINT FK2 REFERENCES Product (idProduct),
    quantity   INTEGER NOT NULL
);

DROP TABLE IF EXISTS OrderMenu;
CREATE TABLE OrderMenu (
    idOrder    INTEGER CONSTRAINT FK1 REFERENCES Purchase (idOrder),
    idMenu     INTEGER CONSTRAINT FK2 REFERENCES Menu (idMenu),
    quantity   INTEGER NOT NULL
);

DROP TABLE IF EXISTS Review;
CREATE TABLE Review (
    idCustomer    INTEGER CONSTRAINT FK1 REFERENCES Customer (idCustomer),
    idRestaurant  INTEGER CONSTRAINT FK2 REFERENCES Restaurant (idRestaurant),
    date          TEXT    NOT NULL,
    description   TEXT,
    rating        INTEGER NOT NULL,
    response      TEXT
);

DROP TABLE IF EXISTS FavoriteProduct;
CREATE TABLE FavoriteProduct (
    idCustomer     INTEGER CONSTRAINT FK1 REFERENCES Customer (idCustomer),
    idProduct   INTEGER CONSTRAINT FK2 REFERENCES Product (idProduct),
    PRIMARY KEY (
        idCustomer,
        idProduct
    )
);

DROP TABLE IF EXISTS FavoriteMenu;
CREATE TABLE FavoriteMenu (
    idCustomer     INTEGER CONSTRAINT FK1 REFERENCES Customer (idCustomer),
    idMenu   INTEGER CONSTRAINT FK2 REFERENCES Menu (idMenu),
    PRIMARY KEY (
        idCustomer,
        idMenu
    )
);

DROP TABLE IF EXISTS FavoriteRestaurant;
CREATE TABLE FavoriteRestaurant (
    idCustomer     INTEGER CONSTRAINT FK1 REFERENCES Customer (idCustomer),
    idRestaurant   INTEGER CONSTRAINT FK2 REFERENCES Restaurant (idRestaurant),
    PRIMARY KEY (
        idCustomer,
        idRestaurant
    )
);

DROP TABLE IF EXISTS ProductCategory;
CREATE TABLE ProductCategory (
    idCategoryP    INTEGER PRIMARY KEY, 
    name           TEXT NOT NULL
);

DROP TABLE IF EXISTS RestaurantCategory;
CREATE TABLE RestaurantCategory (
    idCategoryR    INTEGER PRIMARY KEY, 
    name           TEXT NOT NULL
);

INSERT INTO User (idUser, username, screenName, password, phoneNumber, imageExtension, address)
VALUES 
   (1, "GGgoode", "Joana", "$2y$10$egSn.ZfnpW7vF4N/uUNAQuy6d7VgQ5NQBgiWwRlkp.OrhZShq/qsu", 912345678, "png", "Mine Street 500"),
   (2, "UNWT", "João", "$2y$10$egSn.ZfnpW7vF4N/uUNAQuy6d7VgQ5NQBgiWwRlkp.OrhZShq/qsu", 923456789, "png", "11th Street 20"),
   (3, "AAA", "Liliana", "$2y$10$egSn.ZfnpW7vF4N/uUNAQuy6d7VgQ5NQBgiWwRlkp.OrhZShq/qsu", 934567891, "png", "House Avenue 52"),
   (4, "ROwner", "Marcos" , "$2y$10$egSn.ZfnpW7vF4N/uUNAQuy6d7VgQ5NQBgiWwRlkp.OrhZShq/qsu", 226666666, "png", "New Street 63"),
   (5, "Resss", "Sofia Silva", "$2y$10$egSn.ZfnpW7vF4N/uUNAQuy6d7VgQ5NQBgiWwRlkp.OrhZShq/qsu", 225557575, "png", "City Avenue 54");
   
INSERT INTO Customer (idCustomer)
VALUES 
   (1),
   (2),
   (3);
   
INSERT INTO RestaurantOwner (idRestaurantOwner)
VALUES 
   (4),
   (5);
   
INSERT INTO Restaurant (idRestaurant, name, address, idCategory, imageExtension, idOwner)
VALUES
   (1, "Sushi House", "New Street 63 63", 2, "png", 4),
   (2, "Mamma's Pizzeria", "Dove Street 545", 1,"png", 5),
   (3, "Sushi", "New Street 6", 2, "png", 4);

INSERT INTO Product (idProduct, name, idCategory, price, imageExtension, idRestaurant)
VALUES
   (1, "Water 33cl", 1, 1.50, "png", 1),
   (2, "Coca-Cola 33ml", 1, 1.70, "png", 1),
   (3, "Sake", 1, 5.60, "png", 1),
   (4, "Spring rolls",3, 4.00, "png", 1),
   (5, "Sweet and Sour Pork", 3, 4.30, "png", 1),
   (6, "Sashimi", 15.50,3, "png", 1),
   (7, "Sashimi Deluxe", 3, 25.00, "png", 1),
   (8, "Sushi", 3, 14.50, "png", 1),
   (9, "Sushi Deluxe",3, 24.50, "png", 1),
   (10, "Handmade Mochi", 2, 6.00, "png", 1),
   (11, "Strawberry Shortcake", 2, 4.50, "png", 1),
   (12, "Vegetarian", 3, 9.50, "png", 2),
   (13, "Mulberry", 3, 10.50, "png", 2),
   (14, "Brooklyn Style", 3, 13.45, "png", 2),
   (15, "Doppio Pepperoni", 3,  12.50, "png", 2),
   (16, "Lasagna", 3, 12.55, "png", 2),
   (17, "Tortellini", 3, 11.20, "png", 2),
   (18, "Water 33cl", 1, 1.60, "png", 2),
   (19, "Pepsi", 1, 1.90, "png", 2),
   (20, "Wine", 1, 15.50, "png", 2),
   (21, "Gelato", 2, 4.55, "png", 2),
   (22, "Tiramisu", 2, 6.50, "png", 2),
   (23, "Panna Cotta", 3, 7.60, "png", 2);

INSERT INTO Menu (idMenu, name, price, imageExtension, idRestaurant)
VALUES
   (1, "Sushi Menu", 22.00, "png", 1),
   (2, "Sashimi Menu", 23.00, "png", 3),
   (3, "Lasagna Menu", 16.50, "png", 2),
   (4, "Brooklyn Menu", 18.00, "png", 2);

INSERT INTO MenuProduct(idMenu, idProduct)
VALUES
   (1, 3),
   (1, 4),
   (1, 8),
   (2, 6),
   (2, 3),
   (2, 10),
   (3, 16),
   (3, 19),
   (3, 22),
   (4, 14),
   (4, 19),
   (4, 23);

INSERT INTO Purchase(idOrder, state, total, date, idCustomer, idRestaurant)
VALUES
   (1, "Delivered", 27.00, "2022-04-27", 1, 1),
   (2, "Delivered", 29.50, "2022-03-25", 2, 2),
   (3, "Delivered", 29.50, "2022-03-25", 2, 2);

INSERT INTO OrderProduct(idOrder, idProduct, quantity)
VALUES
   (1, 4, 1),
   (2, 22, 2);

INSERT INTO OrderMenu(idOrder, idMenu, quantity)
VALUES
   (1, 1, 1),
   (2, 3, 1);

INSERT INTO Review(idCustomer, idRestaurant, date, description, rating, response)
VALUES
   (1, 1, "01/05/2022", "Love the food!", 5, NULL),
   (2, 1, "03/05/2022", "Food was whatever, loved the tiramisu tho", 4, NULL);

INSERT INTO FavoriteProduct(idCustomer, idProduct)
VALUES
   (1, 3),
   (2, 22);

INSERT INTO FavoriteRestaurant(idCustomer, idRestaurant)
VALUES
   (1, 1);

INSERT INTO FavoriteMenu(idCustomer, idMenu)
VALUES
   (1, 2);

INSERT INTO RestaurantCategory(idCategoryR, name)
VALUES
    (1, "Italian"),
    (2, "Asian");

INSERT INTO ProductCategory(idCategoryP, name)
VALUES
    (1, "Drink"),
    (2, "Dessert"),
    (3, "Dish");


