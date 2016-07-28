CREATE SCHEMA shop;

USE shop;

CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, ean VARCHAR(13) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, image_path VARCHAR(500) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE basket (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE basket_position (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, basket_id INT DEFAULT NULL, count INT DEFAULT NULL, INDEX IDX_2283EB257294869C (article_id), INDEX IDX_2283EB251BE1FB52 (basket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, last_used_delivery_address_id INT DEFAULT NULL, last_used_email_address_id INT DEFAULT NULL, last_used_invoice_address_id INT DEFAULT NULL, is_registered TINYINT(1) DEFAULT NULL, customer_string VARCHAR(256) DEFAULT NULL, password VARCHAR(256) DEFAULT NULL, birthday DATE DEFAULT NULL, INDEX IDX_81398E091765152C (last_used_invoice_address_id), INDEX IDX_81398E0936413CE3 (last_used_email_address_id), INDEX IDX_81398E09EEE96188 (last_used_delivery_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE delivery_address (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, first_name VARCHAR(45) NOT NULL, last_name VARCHAR(45) NOT NULL, street VARCHAR(45) NOT NULL, zip VARCHAR(45) NOT NULL, city VARCHAR(45) NOT NULL, INDEX IDX_750D05F9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE email_address (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, address VARCHAR(128) NOT NULL, INDEX IDX_B08E074E9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE invoice_address (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, first_name VARCHAR(45) NOT NULL, last_name VARCHAR(45) NOT NULL, street VARCHAR(45) NOT NULL, zip VARCHAR(45) NOT NULL, city VARCHAR(45) NOT NULL, INDEX IDX_FF9759529395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE logistic_partner (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, email_address_id INT DEFAULT NULL, invoice_address_id INT DEFAULT NULL, delivery_address_id INT DEFAULT NULL, logistic_partner_id INT DEFAULT NULL, basket_id INT DEFAULT NULL, payment_method_id INT DEFAULT NULL, INDEX basket_id_idx (basket_id), INDEX invoice_address_id_idx (invoice_address_id), INDEX delivery_address_id_idx (delivery_address_id), INDEX order_customer_id_idx (customer_id), INDEX order_email_address_id_idx (email_address_id), INDEX order_payment_method_id_idx (payment_method_id), INDEX order_logistic_partner_id_idx (logistic_partner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE payment_method (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE basket_position ADD CONSTRAINT FK_2283EB257294869C FOREIGN KEY (article_id) REFERENCES article (id);
ALTER TABLE basket_position ADD CONSTRAINT FK_2283EB251BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id);
ALTER TABLE customer ADD CONSTRAINT FK_81398E09EEE96188 FOREIGN KEY (last_used_delivery_address_id) REFERENCES delivery_address (id);
ALTER TABLE customer ADD CONSTRAINT FK_81398E09s36413CE3 FOREIGN KEY (last_used_email_address_id) REFERENCES email_address (id);
ALTER TABLE customer ADD CONSTRAINT FK_81398E091765152C FOREIGN KEY (last_used_invoice_address_id) REFERENCES invoice_address (id);
ALTER TABLE delivery_address ADD CONSTRAINT FK_750D05F9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id);
ALTER TABLE email_address ADD CONSTRAINT FK_B08E074E9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id);
ALTER TABLE invoice_address ADD CONSTRAINT FK_FF9759529395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id);
ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id);
ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE59045DAA FOREIGN KEY (email_address_id) REFERENCES email_address (id);
ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEC6BDFEB FOREIGN KEY (invoice_address_id) REFERENCES invoice_address (id);
ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEEBF23851 FOREIGN KEY (delivery_address_id) REFERENCES delivery_address (id);
ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE5EA3DCBF FOREIGN KEY (logistic_partner_id) REFERENCES logistic_partner (id);
ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE1BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id);
ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE5AA1164F FOREIGN KEY (payment_method_id) REFERENCES payment_method (id);
