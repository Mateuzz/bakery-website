use bakery;

create table users (
    pk_id INT PRIMARY KEY AUTO_INCREMENT,
    name varchar(120) NOT NULL,
    email varchar(120) NOT NULL,
    password varchar(120) NOT NULL,
    birth DATE NOT NULL,
    telephone varchar(40) NOT NULL
);

create table products (
    pk_id INT PRIMARY KEY AUTO_INCREMENT,
    name varchar(60) NOT NULL,
    description varchar(300),
    price numeric(6, 2) NOT NULL,
    stock INT NOT NULL,
    img_url varchar(120)
);

create table orders (
    pk_id INT PRIMARY KEY AUTO_INCREMENT,
    fk_user_id INT NOT NULL,
    order_day DATE NOT NULL,
    delivery DATE,
    payment_method VARCHAR(20) NOT NULL,
    price NUMERIC(8, 2) NOT NULL,
    city varchar(60) NOT NULL,
    district VARCHAR(60) NOT NULL,
    postal VARCHAR(30) NOT NULL,
    street varchar(40) NOT NULL,
    number INT NOT NULL,
    complement varchar(40),

    INDEX fk_user_id_idx (pk_id ASC) VISIBLE,
    constraint fk_order_user_idx
        foreign key (fk_user_id)
        references users(pk_id)
);

create table order_items (
    fk_order_id INT NOT NULL,
    fk_product_id INT NOT NULL,
    quantity INT NOT NULL,

    INDEX fk_product_id_idx (fk_order_id ASC) VISIBLE,
    INDEX fk_order_id_idx (fk_product_id ASC) VISIBLE,
    constraint fk_order_item_order
        foreign key (fk_order_id)
        references orders(pk_id),
    constraint fk_order_item_product
        foreign key (fk_product_id)
            references products(pk_id)
);