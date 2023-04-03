CREATE TABLE produtos (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  preco NUMERIC(10,2) NOT NULL,
  tipo_id INTEGER NOT NULL
);

CREATE TABLE tipo_produtos (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(255) NOT NULL
);

CREATE TABLE tributos (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  aliquota NUMERIC(4,2) NOT NULL,
  tipo_id INTEGER NOT NULL
);

CREATE TABLE vendas (
  id SERIAL PRIMARY KEY,
  valor_total NUMERIC(10,2) NOT NULL,
  valor_tributo NUMERIC(10,2) NOT NULL,
  data DATE NOT NULL
);

CREATE TABLE vendas_produtos (
  id SERIAL PRIMARY KEY,
  venda_id INTEGER NOT NULL,
  produto_id INTEGER NOT NULL,
  valor_total NUMERIC(10,2) NOT NULL,
  quantidade INTEGER NOT NULL,
  tributo NUMERIC(10,2),
  FOREIGN KEY (venda_id) REFERENCES vendas(id),
  FOREIGN KEY (produto_id) REFERENCES produtos(id)
);


ALTER TABLE produtos ADD CONSTRAINT fk_tipo_produtos FOREIGN KEY (tipo_id) REFERENCES tipo_produtos(id);
ALTER TABLE tributos ADD CONSTRAINT fk_tipo_produtos FOREIGN KEY (tipo_id) REFERENCES tipo_produtos(id);

INSERT INTO tipo_produtos (nome) VALUES ('Eletrodomesticos'), ('Informatica'), ('Livros');

INSERT INTO tributos (nome, aliquota, tipo_id) VALUES ('ICM', 0.10, 1), ('PIS', 0.01, 1), ('IPI', 0.05, 1), ('ICM', 0.12, 2), ('PIS', 0.02, 2), ('IPI', 0.10, 2), ('ICM', 0.15, 3), ('PIS', 0.03, 3), ('IPI', 0.20, 3);
