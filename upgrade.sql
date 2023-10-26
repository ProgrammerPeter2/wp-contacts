drop table if exists wp_contacts;
create table if not exists wp_contacts_posts
(
	id int(255) auto_increment
		primary key,
	name varchar(255) null,
	sort int(10) not null,
	iskodpost int(2) not null
)
collate=utf8mb3_hungarian_ci;

alter table wp_contacts_posts AUTO_INCREMENT=3;

INSERT INTO wp_contacts_posts (name, sort, iskodpost) VALUES ('Algimnáziumi alelnök', 1, 0);
INSERT INTO wp_contacts_posts ( name, sort, iskodpost) VALUES ('Dekor Team', 0, 1);
INSERT INTO wp_contacts_posts (name, sort, iskodpost) VALUES ('DÖK elnök', 2, 0);
INSERT INTO wp_contacts_posts (name, sort, iskodpost) VALUES ('DÖK tanácsadó', 2, 0);
INSERT INTO wp_contacts_posts (name, sort, iskodpost) VALUES ('Főgimnáziumi alelnök', 1, 0);
INSERT INTO wp_contacts_posts (name, sort, iskodpost) VALUES ('Fotós-videós munkacsoport', 0, 1);
INSERT INTO wp_contacts_posts (name, sort, iskodpost) VALUES ('Hangosítók', 0, 1);
INSERT INTO wp_contacts_posts (name, sort, iskodpost) VALUES ('Rádió', 0, 1);
INSERT INTO wp_contacts_posts (name, sort, iskodpost) VALUES ('Weboldal', 0, 1);
INSERT INTO wp_contacts_posts (name, sort, iskodpost) VALUES ('Zöld DÖK', 0, 1);
INSERT INTO wp_contacts_posts (name, sort, iskodpost) VALUES ('Teaház', 0, 1);
INSERT INTO wp_contacts_posts (name, sort, iskodpost) VALUES ('Programszervezés', 0, 1);


create table if not exists wp_contacts_holders 
(
	id int(255) auto_increment
		primary key,
	post int(255) not null,
	holder varchar(255) not null,
	class varchar(255) not null,
	email varchar(255) null
)
collate=utf8mb3_hungarian_ci;

INSERT INTO wp_contacts_holders (post, holder, class, email) VALUES (4, 'Kleinhappelné Nagy Edit', 'pedagógiai vezető', 'nagy.edit@prohaszka-budakeszi.hu');
INSERT INTO wp_contacts_holders (post, holder, class, email) VALUES (5, 'Végh Levente', '11.A', 'vegavegh@gmail.com');
INSERT INTO wp_contacts_holders (post, holder, class, email) VALUES (3, 'Czajlik Márk', '12.B', 'czajlikmark@gmail.com');
INSERT INTO wp_contacts_holders (post, holder, class, email) VALUES (1, 'Dalotti András', '8.A', null);
INSERT INTO wp_contacts_holders (post, holder, class, email) VALUES (9, 'Horváth Péter', '8.B', 'hp.raszpi@gmail.com');
INSERT INTO wp_contacts_holders (post, holder, class, email) VALUES (5, 'Kállay Dániel', '11.A', null);
INSERT INTO wp_contacts_holders (post, holder, class, email) VALUES (8, 'Lantos Márk', '8.B', null);
INSERT INTO wp_contacts_holders (post, holder, class, email) VALUES (8, 'Sebestyén Barabás', '12.A', null);
INSERT INTO wp_contacts_holders (post, holder, class, email) VALUES (6, 'Nagy Dániel', '8.B', null);
INSERT INTO wp_contacts_holders (post, holder, class, email) VALUES (10, 'Kállay Dániel', '11.A', null);
INSERT INTO wp_contacts_holders (post, holder, class, email) VALUES (2, 'DeVires Áron', '11.B', null);
INSERT INTO wp_contacts_holders (post, holder, class, email) VALUES (7, 'Lantos Márk', '8.B', null);
INSERT INTO wp_contacts_holders (post, holder, class, email) VALUES (7, 'Windisch Fülöp', '11.A', null);
INSERT INTO wp_contacts_holders (post, holder, class, email) VALUES (13, 'Vigassy Gergő', '9.A', null);
INSERT INTO wp_contacts_holders (post, holder, class, email) VALUES (14, 'Végh Levente', '11.A', 'vegavegh@gmail.com');
INSERT INTO wp_contacts_holders (post, holder, class, email) VALUES (14, 'Lantos Márk', '8.B', null);
