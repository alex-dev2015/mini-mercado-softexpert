CREATE TABLE product_type (
  id SERIAL PRIMARY KEY,
  product_type_name VARCHAR(255) NOT NULL,
  icms NUMERIC(6,4) NOT NULL,
  pis NUMERIC(6,4) NOT NULL,
  ipi NUMERIC(6,4) NOT NULL
);

CREATE TABLE products (
  id SERIAL PRIMARY KEY,
  product_name VARCHAR(255) NOT NULL,
  price NUMERIC(10,2) NOT NULL,
  type_id INTEGER NOT NULL,
  FOREIGN KEY (type_id) REFERENCES product_type(id)
);

CREATE TABLE sales (
  id SERIAL PRIMARY KEY,
  amount_sales NUMERIC(10,2) NOT NULL,
  amount_taxes NUMERIC(10,2) NOT NULL,
  date DATE NOT NULL
);

CREATE TABLE products_sales (
  id SERIAL PRIMARY KEY,
  sale_id INTEGER NOT NULL,
  product_id INTEGER NOT NULL,
  unitary_value NUMERIC(10,2) NOT NULL,
  amount NUMERIC(10,2) NOT NULL,
  quantity INTEGER NOT NULL,
  tax NUMERIC(10,2),
  FOREIGN KEY (sale_id) REFERENCES sales(id),
  FOREIGN KEY (product_id) REFERENCES products(id)
);