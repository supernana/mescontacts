/* raw password is 'john' */
insert into t_user values
(1, 'JohnDoe', '$2y$13$F9v8pl5u5WMrCorP9MLyJeyIsOLj.0/xqKd/hqa5440kyeB7FQ8te', 'YcM=A$nsYzkyeDVjEUa7W9K', 'ROLE_USER');
/* raw password is 'jane' */
insert into t_user values
(2, 'JaneDoe', '$2y$13$qOvvtnceX.TjmiFn4c4vFe.hYlIVXHSPHfInEG21D99QZ6/LM70xa', 'dhMTBkzwDKxnD;4KNs,4ENy', 'ROLE_USER');

insert into t_contact values 
(1, 1, "Dupont", "Jean", "j.dupont@monmail.fr");
insert into t_contact values 
(2, 1, "Demon", "Marise", "choupinette75@totomail.fr");
insert into t_contact values 
(3, 1, "Aumone", "Alice", "aumone@gmail.com");
insert into t_contact values 
(4, 2, "Pluriel", "Louis-Philipe", "lpp@orange.com");

insert into t_adresse values 
(1, 1, "15 rue des faubourg", "75015", "Paris");
insert into t_adresse values 
(2, 2, "2 grande rue", "77580", "Crecy la chapelle");
insert into t_adresse values 
(3, 3, "254 boulevard Haussman", "33001", "Bordeaux");
insert into t_adresse values 
(4, 4, "8 allée de la pinsonnière", "28100", "Dreux");
insert into t_adresse values 
(5, 2, "1 place des lilas", "21200", "Beaune");
insert into t_adresse values 
(6, 2, "9 impasse des marquises", "75001", "Paris");