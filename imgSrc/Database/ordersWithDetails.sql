/* order head for single user */ 
SELECT * FROM `order` WHERE `idUser` = '10000'

/* order item detail for one order */

SELECT
	`orderitem`.`productNumber`,
	`product`.`productName`,
	`product`.`description`,
	`product`.`productType`,
	`orderitem`.`quantity`,
	`product`.`priceDKK`,
	`orderitem`.`priceDKK` AS totalPriceDKK
FROM `orderitem`
JOIN `product`
ON `orderitem`.`productNumber` = `product`.`productNumber`
WHERE `idOrder` = '10015'


/* users rights by orders (active 1) for user 10000 */
SELECT 
	`product`.`productNumber`,
	`product`.`productType`,
	`pright`.`active`,
	`pright`.`expires`
FROM 
	(SELECT 
		`order`.`active`,
		`order`.`expires`,
		`orderitem`.`productNumber`
	FROM `order`
	JOIN `orderitem`
	ON `order`.`idOrder` = `orderitem`.`idOrder`
	WHERE `order`.`idUser` = '10000') AS pright
JOIN `product`
ON `pright`.`productNumber` = `product`.`productNumber`
WHERE `active` = 1

/* showing only paid mailsigner for user 10000 */
SELECT 
	`product`.`productNumber`,
	`product`.`productType`,
	`pright`.`active`,
	`pright`.`expires`
FROM 
	(SELECT 
		`order`.`active`,
		`order`.`expires`,
		`orderitem`.`productNumber`
	FROM `order`
	JOIN `orderitem`
	ON `order`.`idOrder` = `orderitem`.`idOrder`
	WHERE `order`.`idUser` = '10000') AS pright
JOIN `product`
ON `pright`.`productNumber` = `product`.`productNumber`
WHERE `active` = 1 AND `productType` = 'MailSigner'

/* showing only paid signatures for user 10000 */
SELECT 
	`product`.`productNumber`,
	`product`.`productType`,
	`pright`.`active`,
	`pright`.`expires`
FROM 
	(SELECT 
		`order`.`active`,
		`order`.`expires`,
		`orderitem`.`productNumber`
	FROM `order`
	JOIN `orderitem`
	ON `order`.`idOrder` = `orderitem`.`idOrder`
	WHERE `order`.`idUser` = '10000') AS pright
JOIN `product`
ON `pright`.`productNumber` = `product`.`productNumber`
WHERE `active` = 1 AND `productType` = 'Signature'

/* show all users rights for display in panel. for user 10000 */
SELECT 
	`product`.`productNumber`,
	`product`.`productName`,
	`product`.`description`,
	`product`.`imageLocation`,
	`product`.`productType`,
	`pright`.`expires`
FROM 
	(SELECT 
		`order`.`active`,
		`order`.`expires`,
		`orderitem`.`productNumber`
	FROM `order`
	JOIN `orderitem`
	ON `order`.`idOrder` = `orderitem`.`idOrder`
	WHERE `order`.`idUser` = '10000') AS pright
JOIN `product`
ON `pright`.`productNumber` = `product`.`productNumber`
WHERE `active` = 1 AND `productType` = 'Signature'