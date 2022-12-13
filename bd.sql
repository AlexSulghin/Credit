CREATE TABLE tip_credit(
    id int primary key auto_increment,
    denumire varchar(20),
    conditii varchar(200),
    rata int not null,
    termen int not null
);

CREATE TABLE client(
    id int primary key auto_increment,
    nume varchar(20),
    prenume varchar(20),
    adresa varchar(50),
    telefon varchar(20),
    contact varchar(100)
);

CREATE TABLE credit(
    id int primary key auto_increment,
    id_tip_credit int not null,
    id_client int not null,
    suma numeric not null,
    data_emit date default now(),
    status varchar(20) not null,
    suma_ramasa numeric not null,
    refNr numeric not null
);

CREATE TABLE payments(
    id int primary key auto_increment,
    id_credit int not null,
    suma numeric not null,
    data_plata date default now()
);
