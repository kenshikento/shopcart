-- DROP TABLE --

DROP TABLE transaction;
DROP TABLE orderitem;
DROP TABLE customer;
DROP TABLE quantityitems;
DROP TABLE product;

DROP TABLE orders;
-- CREATE TABLE --
CREATE TABLE product (
	id INT NOT NULL AUTO_INCREMENT ,
	title VARCHAR(35),
	image VARCHAR(255),
	description VARCHAR(255),
	price int,
	PRIMARY KEY(id)
);

CREATE TABLE customer(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR (35),
	email VARCHAR (255),
	phonenum int,
	PRIMARY KEY(id)
);



CREATE TABLE quantityitems(
	id INT NOT NULL AUTO_INCREMENT,
	quantity INT NOT NULL,
	productID INT NOT NULL,
	totalamount INT NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(productID) REFERENCES product(id)
);



CREATE TABLE orderitem (
	id INT NOT NULL AUTO_INCREMENT ,
	customerID INT NOT NULL,
	date TIMESTAMP NOT NULL, 
	PRIMARY KEY(id),
	FOREIGN KEY(customerID)  REFERENCES customer(id)
);

CREATE TABLE transaction(
	id INT NOT NULL AUTO_INCREMENT,
	quantityID INT NOT NULL,
	orderuserid INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (quantityID) REFERENCES quantityitems(id),
	FOREIGN KEY (orderuserid) REFERENCES orderitem(id)
);


-- ignore--
CREATE TABLE orders (
	id INT NOT NULL AUTO_INCREMENT,
	customerID INT NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(customerID) REFERENCES customer(id)
);
-- INSERT --

-- PRODUCT --
INSERT INTO product(title,image,description,price)
VALUES ('apple','images/apple.jpg','apple',1);

INSERT INTO product(title,image,description,price)
VALUES ('android','images/orange.jpg','android',12);

INSERT INTO product(title,image,description,price)
VALUES ('Java','images/apple.jpg','java',1);

INSERT INTO product(title,image,description,price)
VALUES ('angular js','images/apple.jpg','angular',1);

INSERT INTO product(title,image,description,price)
VALUES ('php','images/apple.jpg','php',1);

INSERT INTO product(title,image,description,price)
VALUES ('html','images/apple.jpg','html',1);

-- CUSTOMER --

INSERT INTO customer(name,email,phonenum)
VALUES ('ken','ken.com',077770213);

INSERT INTO customer(name,email,phonenum)
VALUES ('justin','justin.com',04324324);

INSERT INTO customer(name,email,phonenum)
VALUES ('flankle','flankle.com',432432423);

INSERT INTO customer(name,email,phonenum)
VALUES ('twit','twit.com',4324324324);


-- Quantityitems --
-- Apple 10 products
INSERT INTO quantityitems(quantity,productID)
VALUES (10,1); 

INSERT INTO quantityitems(quantity,productID)
VALUES (5,2);

INSERT INTO quantityitems(quantity,productID)
VALUES (2,3);

INSERT INTO quantityitems(quantity,productID)
VALUES (20,4);

-- orders -- 
INSERT INTO orders(customerID)
VALUES (1);

INSERT INTO orders(customerID)
VALUES (2);

INSERT INTO orders(customerID)
VALUES (3);

INSERT INTO orders(customerID)
VALUES (4);

-- ORDER ITEMS --

INSERT INTO orderitem (orderID,date)
VALUES (1,now());

INSERT INTO orderitem (orderID,date)
VALUES (2,now());

INSERT INTO orderitem (orderID,date)
VALUES (4,now());

INSERT INTO orderitem (orderID,date)
VALUES (3,now());

INSERT INTO orderitem (orderID,date)
VALUES (2,now());


-- transaction --

INSERT INTO transaction (quantityID,orderID)
VALUES (1,4);

INSERT INTO transaction (quantityID,orderID)
VALUES (2,3);

INSERT INTO transaction (quantityID,orderID)
VALUES (3,2);

INSERT INTO transaction (quantityID,orderID)
VALUES (4,1);

/*INSERT INTO transaction (quantityID,orderitemID)
VALUES (1,12);

INSERT INTO transaction (quantityID,orderitemID)
VALUES (1,12);

INSERT INTO transaction (quantityID,orderitemID)
VALUES (1,12);
*/


-- update --

UPDATE orderitem SET  


-- SELECT --

SELECT * FROM orderitem INNER JOIN customer WHERE customer.id = 1;
SELECT * FROM orderitem LEFT JOIN customer WHERE date BETWEEN '2017-10-18 15:11:16' and '2017-11-15 16:11:16' and customer.id = 2;

SELECT * FROM orderitem, transaction INNER JOIN customer On customer.id = 1  and orderitem.date BETWEEN '2018-03-23 20:20:0' AND '2018-03-23 20:24:09' ;

SELECT Orders.OrderID, Customers.CustomerName FROM Orders INNER JOIN Customers ON Orders.CustomerID = Customers.CustomerID;
SELECT transaction.id, C



select *
from
    tableA a
        inner join
    tableB b
        on a.common = b.common
        inner join 
    TableC c
        on b.common = c.common


-- CONTROL RELEASE -- 
SELECT *
FROM 
	orderitem a
		inner join 
	transaction b 
		on a.id = b.orderuserid
		inner join 
	quantityitems c 
		on b.quantityID = c.id 
		inner join
	product d 
		on c.productID = d.id 
		WHERE customerID = 1 AND  date BETWEEN' 2018-03-23 20:20:0' AND '2018-03-27 20:24:09';




SELECT *
FROM 
	orderitem a
		inner join 
	transaction b 
		on a.id = b.orderuserid
		inner join 
	quantityitems c 
		on b.quantityID = c.id 
		inner join
	product d 
		on c.productID = d.id 
		WHERE customerID = 1;


SELECT a.date,b.id
FROM 
	orderitem a
		inner join 
	transaction b 
		on a.id = b.orderuserid
		inner join 
	quantityitems c 
		on b.quantityID = c.id 
		inner join
	product d 
		on c.productID = d.id 
		WHERE customerID = 1;


SELECT a.date,b.id,d.description
FROM 
	orderitem a
		inner join 
	transaction b 
		on a.id = b.orderuserid
		inner join 
	quantityitems c 
		on b.quantityID = c.id 
		inner join
	product d 
		on c.productID = d.id 
		WHERE a.id = 1;




SELECT a.date,a.id as orderID
FROM 
	orderitem a
		inner join 
	transaction b 
		on a.id = b.orderuserid
		inner join 
	quantityitems c 
		on b.quantityID = c.id 
		inner join
	product d 
		on c.productID = d.id 
		WHERE customerID = 1
		GROUP BY b.id;


		-- last transaction orderid--
SELECT a.id as orderID
FROM 
	orderitem a
		inner join 
	transaction b 
		on a.id = b.orderuserid
		inner join 
	quantityitems c 
		on b.quantityID = c.id 
		inner join
	product d 
		on c.productID = d.id 
		WHERE customerID = 1
		GROUP BY b.id		
		ORDER BY a.id DESC
		LIMIT 1;


-- efficency finding orders customers-- 
SELECT a.id as orderID
FROM 
	orderitem a
		inner join 
	transaction b 
		on a.id = b.orderuserid
		WHERE customerID = 2
		GROUP BY b.id		
		ORDER BY a.id DESC
		LIMIT 1;

-- SELECT last item --

SELECT a.name,b.id as transactionID,b.date,d.quantity,f.title,f.description,f.image,f.price
FROM 
	customer a
		inner join 
	orderitem b
		on a.id = b.customerID
		inner join 
	transaction c
		on b.id = c.orderuserid
		inner join 
	quantityitems d 
		on c.quantityID = d.id 
		inner join
	product f 
		on d.productID = f.id 
		WHERE b.id = 1;
		



-- Search query item -- 

SELECT a.name,b.id as transactionID,b.date,d.quantity,f.title,f.description,f.image,f.price
FROM 
	customer a
		inner join 
	orderitem b
		on a.id = b.customerID
		inner join 
	transaction c
		on b.id = c.orderuserid
		inner join 
	quantityitems d 
		on c.quantityID = d.id 
		inner join
	product f 
		on d.productID = f.id 
		WHERE b.id = 1 and f.title LIKE 'appl%';


-- Search query item by DATE --
SELECT a.name,b.id as transactionID,b.date,d.quantity,f.title,f.description,f.image,f.price
FROM 
	customer a
		inner join 
	orderitem b
		on a.id = b.customerID
		inner join 
	transaction c
		on b.id = c.orderuserid
		inner join 
	quantityitems d 
		on c.quantityID = d.id 
		inner join
	product f 
		on d.productID = f.id 
		WHERE b.id = 1 AND   YEAR(b.date) = 2018;
		266




SELECT a.name,b.id as transactionID,b.date,f.title,f.id as productID,f.description,f.image, COUNT(*)
			FROM 
			customer a
				inner join 
			orderitem b
			on a.id = b.customerID
				inner join 
			transaction c
			on b.id = c.orderuserid
				inner join 
			quantityitems d 
			on c.quantityID = d.id 
				inner join
			product f 
			on d.productID = f.id 
			WHERE b.id = 1 AND   YEAR(b.date) = 2018
		
SELECT a.name,b.id as transactionID,b.date,f.title,f.id as productID,f.description,f.image, COUNT(*)
			FROM 
			customer a
				inner join 
			orderitem b
			on a.id = b.customerID
				inner join 
			transaction c
			on b.id = c.orderuserid
				inner join 
			quantityitems d 
			on c.quantityID = d.id 
				inner join
			product f 
			on d.productID = f.id 
			WHERE b.id = 492 AND   YEAR(b.date) = 2018



			SELECT a.name,b.id as transactionID,b.date,f.title,f.id as productID,f.description,f.image, COUNT(d.quantity),SUM(f.price)
			FROM 
			customer a
				inner join 
			orderitem b
			on a.id = b.customerID
				inner join 
			transaction c
			on b.id = c.orderuserid
				inner join 
			quantityitems d 
			on c.quantityID = d.id 
				inner join
			product f 
			on d.productID = f.id 
			WHERE b.id = 222 AND   YEAR(b.date) = 2018
			GROUP BY productID