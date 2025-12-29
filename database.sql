-- Vegas Digital Menu Database Schema
-- Create database
CREATE DATABASE IF NOT EXISTS vegas_menu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE vegas_menu;

-- Create products table
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    disponivel BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_categoria (categoria),
    INDEX idx_disponivel (disponivel)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user (admin:admin)
-- IMPORTANT: Change this password immediately after installation!
INSERT INTO admin_users (username, password) VALUES ('admin', '$2y$10$uc.UVdewEcbJsquhKde1LuA3rEQeIVGjqFztuKnA8d2vU0BrvvCQq');

-- Insert products data
-- 1 - PORÇÕES EXTRAS
INSERT INTO produtos (nome, descricao, preco, categoria) VALUES
('Porção de Fritas', 'Batatas fritas crocantes', 15.00, 'Porções Extras'),
('Porção de Onion Rings', 'Anéis de cebola empanados', 18.00, 'Porções Extras'),
('Porção de Nuggets', '10 nuggets de frango', 20.00, 'Porções Extras'),
('Porção de Polenta Frita', 'Polenta frita crocante', 16.00, 'Porções Extras'),
('Porção de Mandioca Frita', 'Mandioca frita', 17.00, 'Porções Extras');

-- 2 - BEBIDAS
INSERT INTO produtos (nome, descricao, preco, categoria) VALUES
('Coca-Cola Lata 350ml', 'Refrigerante Coca-Cola', 6.00, 'Bebidas'),
('Guaraná Antarctica Lata 350ml', 'Refrigerante Guaraná', 6.00, 'Bebidas'),
('Sprite Lata 350ml', 'Refrigerante Sprite', 6.00, 'Bebidas'),
('Fanta Laranja Lata 350ml', 'Refrigerante Fanta', 6.00, 'Bebidas'),
('Água Mineral 500ml', 'Água mineral sem gás', 4.00, 'Bebidas'),
('Água com Gás 500ml', 'Água mineral com gás', 5.00, 'Bebidas'),
('Suco Natural Laranja', 'Suco de laranja natural', 10.00, 'Bebidas'),
('Suco Natural Limão', 'Suco de limão natural', 10.00, 'Bebidas'),
('Suco Natural Morango', 'Suco de morango natural', 12.00, 'Bebidas'),
('Red Bull 250ml', 'Energético Red Bull', 15.00, 'Bebidas');

-- 3 - CERVEJAS
INSERT INTO produtos (nome, descricao, preco, categoria) VALUES
('Heineken Long Neck 330ml', 'Cerveja Heineken', 12.00, 'Cervejas'),
('Budweiser Long Neck 330ml', 'Cerveja Budweiser', 11.00, 'Cervejas'),
('Stella Artois Long Neck 330ml', 'Cerveja Stella Artois', 13.00, 'Cervejas'),
('Corona Extra 330ml', 'Cerveja Corona', 14.00, 'Cervejas'),
('Brahma Duplo Malte 350ml', 'Cerveja Brahma Duplo Malte', 10.00, 'Cervejas'),
('Skol Lata 350ml', 'Cerveja Skol', 8.00, 'Cervejas'),
('Brahma Lata 350ml', 'Cerveja Brahma', 8.00, 'Cervejas'),
('Antarctica Lata 350ml', 'Cerveja Antarctica', 8.00, 'Cervejas');

-- 4 - LANCHES
INSERT INTO produtos (nome, descricao, preco, categoria) VALUES
('X-Burger', 'Hambúrguer, queijo, alface, tomate', 25.00, 'Lanches'),
('X-Salada', 'Hambúrguer, queijo, alface, tomate, presunto', 28.00, 'Lanches'),
('X-Bacon', 'Hambúrguer, queijo, bacon, alface, tomate', 30.00, 'Lanches'),
('X-Egg', 'Hambúrguer, queijo, ovo, alface, tomate', 28.00, 'Lanches'),
('X-Tudo', 'Hambúrguer, queijo, bacon, ovo, presunto, alface, tomate', 35.00, 'Lanches'),
('Cheeseburger Duplo', 'Dois hambúrgueres, queijo duplo', 38.00, 'Lanches'),
('Veggie Burger', 'Hambúrguer vegetariano, queijo, vegetais', 30.00, 'Lanches'),
('Chicken Burger', 'Frango grelhado, queijo, alface, tomate', 28.00, 'Lanches');

-- 5 - PIZZAS
INSERT INTO produtos (nome, descricao, preco, categoria) VALUES
('Pizza Margherita', 'Molho, mussarela, tomate, manjericão', 45.00, 'Pizzas'),
('Pizza Calabresa', 'Molho, mussarela, calabresa, cebola', 48.00, 'Pizzas'),
('Pizza Portuguesa', 'Molho, mussarela, presunto, ovos, cebola, azeitona', 52.00, 'Pizzas'),
('Pizza Quatro Queijos', 'Molho, mussarela, provolone, gorgonzola, parmesão', 55.00, 'Pizzas'),
('Pizza Frango com Catupiry', 'Molho, mussarela, frango, catupiry', 50.00, 'Pizzas'),
('Pizza Bacon', 'Molho, mussarela, bacon', 50.00, 'Pizzas'),
('Pizza Vegetariana', 'Molho, mussarela, vegetais variados', 48.00, 'Pizzas'),
('Pizza Pepperoni', 'Molho, mussarela, pepperoni', 52.00, 'Pizzas');

-- 6 - SOBREMESAS
INSERT INTO produtos (nome, descricao, preco, categoria) VALUES
('Petit Gateau', 'Bolinho de chocolate com sorvete', 22.00, 'Sobremesas'),
('Pudim de Leite', 'Pudim caseiro com calda de caramelo', 15.00, 'Sobremesas'),
('Brownie com Sorvete', 'Brownie de chocolate com sorvete', 20.00, 'Sobremesas'),
('Mousse de Chocolate', 'Mousse cremoso de chocolate', 18.00, 'Sobremesas'),
('Mousse de Maracujá', 'Mousse cremoso de maracujá', 18.00, 'Sobremesas'),
('Torta de Limão', 'Torta de limão com merengue', 20.00, 'Sobremesas'),
('Cheesecake', 'Cheesecake cremoso com calda de frutas vermelhas', 24.00, 'Sobremesas'),
('Sorvete (2 bolas)', 'Escolha o sabor', 12.00, 'Sobremesas');

-- 7 - PRATOS EXECUTIVOS
INSERT INTO produtos (nome, descricao, preco, categoria) VALUES
('Filé de Frango Grelhado', 'Filé de frango com arroz, feijão, batata frita e salada', 35.00, 'Pratos Executivos'),
('Bife Acebolado', 'Bife bovino com arroz, feijão, batata frita e salada', 40.00, 'Pratos Executivos'),
('Picanha na Chapa', 'Picanha grelhada com arroz, feijão, batata frita e salada', 55.00, 'Pratos Executivos'),
('Peixe Grelhado', 'Filé de peixe com arroz, batata e legumes', 42.00, 'Pratos Executivos'),
('Lasanha à Bolonhesa', 'Lasanha de carne com molho bolonhesa', 38.00, 'Pratos Executivos'),
('Feijoada Completa', 'Feijoada tradicional com acompanhamentos', 45.00, 'Pratos Executivos'),
('Strogonoff de Carne', 'Strogonoff com arroz e batata palha', 42.00, 'Pratos Executivos'),
('Strogonoff de Frango', 'Strogonoff com arroz e batata palha', 38.00, 'Pratos Executivos');

-- 8 - DRINKS E COQUETÉIS
INSERT INTO produtos (nome, descricao, preco, categoria) VALUES
('Caipirinha', 'Cachaça, limão, açúcar', 18.00, 'Drinks e Coquetéis'),
('Caipiroska', 'Vodka, limão, açúcar', 20.00, 'Drinks e Coquetéis'),
('Mojito', 'Rum, hortelã, limão, açúcar, água com gás', 22.00, 'Drinks e Coquetéis'),
('Piña Colada', 'Rum, creme de coco, suco de abacaxi', 24.00, 'Drinks e Coquetéis'),
('Margarita', 'Tequila, triple sec, suco de limão', 25.00, 'Drinks e Coquetéis'),
('Sex on the Beach', 'Vodka, licor de pêssego, suco de laranja e cranberry', 24.00, 'Drinks e Coquetéis'),
('Cosmopolitan', 'Vodka, triple sec, suco de cranberry, limão', 26.00, 'Drinks e Coquetéis'),
('Gin Tônica', 'Gin, água tônica, limão', 22.00, 'Drinks e Coquetéis'),
('Cuba Libre', 'Rum, coca-cola, limão', 18.00, 'Drinks e Coquetéis'),
('Aperol Spritz', 'Aperol, prosecco, água com gás', 28.00, 'Drinks e Coquetéis');

-- 9 - CAFÉS E CHÁS
INSERT INTO produtos (nome, descricao, preco, categoria) VALUES
('Café Espresso', 'Café expresso tradicional', 6.00, 'Cafés e Chás'),
('Café Americano', 'Café expresso com água quente', 8.00, 'Cafés e Chás'),
('Cappuccino', 'Café expresso com leite vaporizado e espuma', 12.00, 'Cafés e Chás'),
('Café com Leite', 'Café com leite', 8.00, 'Cafés e Chás'),
('Café Latte', 'Café expresso com leite vaporizado', 14.00, 'Cafés e Chás'),
('Mocha', 'Café expresso com chocolate e leite', 16.00, 'Cafés e Chás'),
('Chocolate Quente', 'Chocolate quente cremoso', 12.00, 'Cafés e Chás'),
('Chá Preto', 'Chá preto tradicional', 6.00, 'Cafés e Chás'),
('Chá Verde', 'Chá verde', 7.00, 'Cafés e Chás'),
('Chá de Camomila', 'Chá calmante de camomila', 7.00, 'Cafés e Chás');

-- 10 - PETISCOS
INSERT INTO produtos (nome, descricao, preco, categoria) VALUES
('Bruschetta', 'Torrada com tomate, manjericão e azeite', 18.00, 'Petiscos'),
('Bolinho de Bacalhau', '6 unidades', 25.00, 'Petiscos'),
('Coxinha de Frango', '6 unidades', 20.00, 'Petiscos'),
('Pastel Misto', '4 unidades', 18.00, 'Petiscos'),
('Tábua de Frios', 'Queijos e frios variados', 45.00, 'Petiscos'),
('Calabresa Acebolada', 'Linguiça calabresa com cebola', 28.00, 'Petiscos'),
('Iscas de Peixe', 'Iscas de peixe empanadas', 32.00, 'Petiscos'),
('Torresmo', 'Torresmo crocante', 22.00, 'Petiscos'),
('Dadinho de Tapioca', 'Queijo coalho frito com geleia de pimenta', 24.00, 'Petiscos'),
('Azeitona Recheada', 'Azeitonas recheadas', 12.00, 'Petiscos');
