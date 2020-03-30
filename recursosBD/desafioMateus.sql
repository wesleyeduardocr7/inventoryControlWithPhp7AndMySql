use inventorycontrol;

show tables;

insert into tb_branch (id,address,telephone,manager) values (12,'Santa Ines','32146598','Rodrigo');
insert into tb_branch (id,address,telephone,manager) values (42,'Santa Luzia','965565','Antonio');
insert into tb_branch (id,address,telephone,manager) values (60,'Bacabal','945132','Gabriel');
insert into tb_branch (id,address,telephone,manager) values (9,'Imperatriz','42156465','Luis');
insert into tb_branch (id,address,telephone,manager) values (14,'Caxias','6944521','Paulo');
insert into tb_branch (id,address,telephone,manager) values (45,'Balsas','656598','Lima');
insert into tb_branch (id,address,telephone,manager) values (55,'Alto Alegre','9855498','Alan');
insert into tb_branch (id,address,telephone,manager) values (84,'Picos','1115478','Cristiano');
insert into tb_branch (id,address,telephone,manager) values (49,'Santa Rita','46852598','Leticia');
insert into tb_branch (id,address,telephone,manager) values (145,'São Paulo','1112598','José');

insert into tb_product (name,unityprice,totalamount) values ('Fusion',55.564,3);
insert into tb_product (name,unityprice,totalamount) values ('Corola',35.564,10);
insert into tb_product (name,unityprice,totalamount) values ('Ferrari',125.564,2);
insert into tb_product (name,unityprice,totalamount) values ('Palio',15.564,11);
insert into tb_product (name,unityprice,totalamount) values ('Hilux',9000,123);
insert into tb_product (name,unityprice,totalamount) values ('Punto',69000,168);
insert into tb_product (name,unityprice,totalamount) values ('Astra',45212,100);
insert into tb_product (name,unityprice,totalamount) values ('Sentra',74564,256);
insert into tb_product (name,unityprice,totalamount) values ('Siena',79000,42);
insert into tb_product (name,unityprice,totalamount) values ('Bravo',15212,126);
insert into tb_product (name,unityprice,totalamount) values ('Frontier',44564,11);

insert into tb_stock (id,idbranch,idproduct) values (12,9,5);
insert into tb_stock (id,idbranch,idproduct) values (13,12,6);
insert into tb_stock (id,idbranch,idproduct) values (41,60,6);
insert into tb_stock (id,idbranch,idproduct) values (47,14,5);
insert into tb_stock (id,idbranch,idproduct) values (84,60,5);
insert into tb_stock (id,idbranch,idproduct) values (10,45,10);
insert into tb_stock (id,idbranch,idproduct) values (15,60,11);

insert into tb_stockorder (idstock,ordertype,situation) values (13,'entrada','pendente');
insert into tb_stockorder (idstock,ordertype,situation) values (47,'saida','pendente');
insert into tb_stockorder (idstock,ordertype,situation) values (10,'entrada','pendente');
insert into tb_stockorder (idstock,ordertype,situation) values (10,'saida','pendente');
insert into tb_stockorder (idstock,ordertype,situation) values (15,'entrada','pendente');

insert into tb_stockorderitem (idstockorder,idproduct,requestedquantity) values (5,5,10);

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_product_save`(
pdesperson VARCHAR(64), 
pdeslogin VARCHAR(64), 
pdespassword VARCHAR(256), 
pdesemail VARCHAR(128), 
pnrphone BIGINT, 
pinadmin TINYINT
)
BEGIN
  
    DECLARE vidperson INT;
    
  INSERT INTO tb_persons (desperson, desemail, nrphone)
    VALUES(pdesperson, pdesemail, pnrphone);
    
    SET vidperson = LAST_INSERT_ID();
    
    INSERT INTO tb_users (idperson, deslogin, despassword, inadmin)
    VALUES(vidperson, pdeslogin, pdespassword, pinadmin);
    
    SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = LAST_INSERT_ID();
    
END

select * from tb_stockorder;

select b.id as FilialCode,s.id as StockCode , b.manager as FilialManager, p.name as NameProduct, p.totalAmount
from branch b inner join stockcontrol s on b.id = s.idBranch
inner join product p on s.idProduct = p.id;


###########################################################################################################




select * from tb_stockorderitem;



update tb_product p inner join tb_stockorderitem soi on p.id = soi.idproduct
inner join tb_stockorder so on soi.idstockorder = so.id
inner join tb_stock s on s.id = so.idstock
set p.totalamount = p.totalamount + 10, so.situation = 'concluido'
where so.id = 5;

update tb_product set totalamount = totalamount + 50 where id = 5;

select * from tb_product;

select  p.name,p.totalamount
from tb_product p 
inner join tb_stockorderitem soi on p.id = soi.idproduct
inner join tb_stockorder so on soi.idstockorder = so.id
inner join tb_stock s on s.id = so.idstock
where so.id = 5;

update product prod inner join stockorderitem itemped on prod.id = itemped.idproduct
inner join stockorder ped on itemped.idstockorder = ped.id
inner join stock e on e.id = ped.idStock
set prod.totalAmount = prod.totalAmount + 2, ped.situation = 'concluido'
where ped.id = 1;

select  prod.name,prod.totalAmount
from product prod 
inner join stockorderitem itemped on prod.id = itemped.idproduct
inner join stockorder ped on itemped.idstockorder = ped.id
inner join stock e on e.id = ped.idStock
where ped.id = 1;
###########################################################################################################


###########################################################################################################
insert into stockorderitem (idstockorder,idproduct,quantidadeSolicitada) values (3,2,5);

select  prod.name,prod.totalAmount
from product prod 
inner join stockorderitem itemped on prod.id = itemped.idproduct
inner join stockorder ped on itemped.idstockorder = ped.id
inner join stock e on e.id = ped.idStock
where ped.id = 3;

update product prod inner join stockorderitem itemped on prod.id = itemped.idproduct
inner join stockorder ped on itemped.idstockorder = ped.id
inner join stock e on e.id = ped.idStock
set prod.totalAmount = prod.totalAmount - 5, ped.situation = 'concluido'
where ped.id = 3;

select  prod.name,prod.totalAmount
from product prod 
inner join stockorderitem itemped on prod.id = itemped.idproduct
inner join stockorder ped on itemped.idstockorder = ped.id
inner join stock e on e.id = ped.idStock
where ped.id = 3;
###########################################################################################################

##CONSULTAS SQL

select * from branch;
select * from product;
select * from stockcontrol;
select * from stockorder;
select * from stockorderitem;

## Escrever uma consulta que retorne todos os products com quantidade maior ou igual a 100
select * from product where totalAmount >= 100;

## Escrever consulta que liste todos os campos para o domínio stockorder e stockorderitem filtrando apenas o product de código 7
select * from stockorder p
inner join stockorderitem i
on p.id = i.idstockorder
where i.idproduct = 5;

select * from tb_product where totalamount >= 100;

select * from tb_branch;

select * from tb_stock;


select p.name, p.totalamount from tb_product p inner join tb_stock s on p.id = s.idproduct
where s.idbranch = 60; 


select * from tb_stockorder so inner join tb_stockorderitem soi on so.id = soi.idstockorder where idproduct = 5;




