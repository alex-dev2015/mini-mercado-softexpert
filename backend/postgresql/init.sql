CREATE TABLE product_type
(
    id                SERIAL PRIMARY KEY,
    product_type_name VARCHAR(255)  NOT NULL,
    icms              NUMERIC(6, 4) NOT NULL,
    pis               NUMERIC(6, 4) NOT NULL,
    ipi               NUMERIC(6, 4) NOT NULL
);

CREATE TABLE products
(
    id           SERIAL PRIMARY KEY,
    product_name VARCHAR(255)   NOT NULL,
    price        NUMERIC(10, 2) NOT NULL,
    type_id      INTEGER        NOT NULL,
    FOREIGN KEY (type_id) REFERENCES product_type (id)
);

CREATE TABLE sales
(
    id           SERIAL PRIMARY KEY,
    amount_sales NUMERIC(10, 2) NOT NULL,
    amount_taxes NUMERIC(10, 2) NOT NULL,
    date         DATE           NOT NULL
);

CREATE TABLE products_sales
(
    id            SERIAL PRIMARY KEY,
    sale_id       INTEGER        NOT NULL,
    product_id    INTEGER        NOT NULL,
    unitary_value NUMERIC(10, 2) NOT NULL,
    amount        NUMERIC(10, 2) NOT NULL,
    quantity      INTEGER        NOT NULL,
    tax           NUMERIC(10, 2),
    FOREIGN KEY (sale_id) REFERENCES sales (id),
    FOREIGN KEY (product_id) REFERENCES products (id)
);

CREATE TABLE users
(
    id       SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO product_type (product_type_name, icms, pis, ipi)
VALUES ('Tipo 1', 0.18, 0.01, 0.05);

INSERT INTO products (product_name, price, type_id)
VALUES ('Produto 1', 10.99, 1);

INSERT INTO sales (amount_sales, amount_taxes, date)
VALUES (100.00, 10.00, '2023-06-03');

INSERT INTO products_sales (sale_id, product_id, unitary_value, amount, quantity, tax)
VALUES (1, 1, 10.99, 10.99, 1, 1.00);

INSERT INTO users (username, password)
VALUES ('admin@softexpert.com', '$2y$10$tQoh5MheXzVSznyg3fsxYOLilqy.zCie2R5MGOm1EpVTcsGOzjR1q');
