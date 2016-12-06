#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: User
#------------------------------------------------------------

CREATE TABLE User(
        id_user          int (11) Auto_increment  NOT NULL ,
        nom_user         Varchar (25) ,
        prenom_user      Varchar (25) ,
        N_INE            Varchar (25) ,
        e_mail           Varchar (25) ,
        mot_de_passe     Varchar (25) ,
        date_naissance   Date ,
        filiere          Varchar (25) ,
        id_type_user     Int ,
        id_etablissement Int ,
        id_sexe          Int ,
        PRIMARY KEY (id_user )
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: Type_user   
#------------------------------------------------------------

CREATE TABLE Type_user(
        id_type_user int Auto_increment NOT NULL,
        libelle_type_user Varchar(25) NOT NULL,
        PRIMARY KEY (id_type_user)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Etablissement
#------------------------------------------------------------

CREATE TABLE Etablissement(
        id_etablissement   int (11) Auto_increment  NOT NULL ,
        nom_etablissement  Varchar (25) ,
        lieu_etablissement Varchar (25) ,
        PRIMARY KEY (id_etablissement )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Matiere
#------------------------------------------------------------

CREATE TABLE Matiere(
        id_matiere  int (11) Auto_increment  NOT NULL ,
        nom_matiere Varchar (25) ,
        PRIMARY KEY (id_matiere )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Cours
#------------------------------------------------------------

CREATE TABLE Cours(
        id_cours          int (11) Auto_increment  NOT NULL ,
        nom_cours         Varchar (25) ,
        description_cours Varchar (500) ,
        id_user           Int ,
        id_matiere        Int ,
        PRIMARY KEY (id_cours )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Evenement
#------------------------------------------------------------

CREATE TABLE Evenement(
        id_evenement          int (11) Auto_increment  NOT NULL ,
        date_evenement        Date ,
        lieu_evenement        Varchar (25) ,
        description_evenement Varchar (25) ,
        PRIMARY KEY (id_evenement )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Objet
#------------------------------------------------------------

CREATE TABLE Objet(
        id_objet          int (11) Auto_increment  NOT NULL ,
        description_objet Varchar (25) ,
        lieu_objet        Varchar (25) ,
        prix_objet        Double ,
        id_user           Int NOT NULL ,
        PRIMARY KEY (id_objet ,id_user )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Covoiturage
#------------------------------------------------------------

CREATE TABLE Covoiturage(
        id_covoiturage   int (11) Auto_increment  NOT NULL ,
        depart           Varchar (25) ,
        arrive           Varchar (25) ,
        prix_covoiturage Double ,
        date_covoiturage Date ,
        id_user          Int ,
        PRIMARY KEY (id_covoiturage )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Collocation
#------------------------------------------------------------

CREATE TABLE Collocation(
        id_collocation          int (11) Auto_increment  NOT NULL ,
        description_collocation Varchar (25) ,
        prix_collocation        Double ,
        lieu_collocation        Varchar (25) ,
        id_user                 Int ,
        PRIMARY KEY (id_collocation )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Sexe
#------------------------------------------------------------

CREATE TABLE Sexe(
        id_sexe      int (11) Auto_increment  NOT NULL ,
        libelle_sexe Int ,
        PRIMARY KEY (id_sexe )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Emploi
#------------------------------------------------------------

CREATE TABLE Emploi(
        id_emploi          int (11) Auto_increment  NOT NULL ,
        poste_emploi       Varchar (25) ,
        date_debut_emploi  Date ,
        date_fin_emploi    Date ,
        description_emploi Varchar (25) ,
        type_emploi        Varchar (25) ,
        PRIMARY KEY (id_emploi )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: propose
#------------------------------------------------------------

CREATE TABLE Propose(
        id_user   Int NOT NULL ,
        id_emploi Int NOT NULL ,
        PRIMARY KEY (id_user ,id_emploi )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: participe
#------------------------------------------------------------

CREATE TABLE Participe(
        id_evenement Int NOT NULL ,
        id_user      Int NOT NULL ,
        PRIMARY KEY (id_evenement ,id_user )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: enseigne
#------------------------------------------------------------

CREATE TABLE Enseigne(
        id_user    Int NOT NULL ,
        id_matiere Int NOT NULL ,
        PRIMARY KEY (id_user ,id_matiere )
)ENGINE=InnoDB;

ALTER TABLE User ADD CONSTRAINT FK_User_id_Etablissement FOREIGN KEY (id_etablissement) REFERENCES Etablissement(id_etablissement);
ALTER TABLE User ADD CONSTRAINT FK_User_id_sexe FOREIGN KEY (id_sexe) REFERENCES Sexe(id_sexe);
ALTER TABLE User ADD CONSTRAINT FK_User_id_type_user FOREIGN KEY (id_type_user) REFERENCES Type_user(id_type_user);
ALTER TABLE Cours ADD CONSTRAINT FK_Cours_id_user FOREIGN KEY (id_user) REFERENCES User(id_user);
ALTER TABLE Cours ADD CONSTRAINT FK_Cours_id_matiere FOREIGN KEY (id_matiere) REFERENCES Matiere(id_matiere);
ALTER TABLE Objet ADD CONSTRAINT FK_Objet_id_user FOREIGN KEY (id_user) REFERENCES User(id_user);
ALTER TABLE Covoiturage ADD CONSTRAINT FK_Covoiturage_id_user FOREIGN KEY (id_user) REFERENCES User(id_user);
ALTER TABLE Collocation ADD CONSTRAINT FK_Collocation_id_user FOREIGN KEY (id_user) REFERENCES User(id_user);
ALTER TABLE Propose ADD CONSTRAINT FK_Propose_id_user FOREIGN KEY (id_user) REFERENCES User(id_user);
ALTER TABLE Propose ADD CONSTRAINT FK_Propose_id_emploi FOREIGN KEY (id_emploi) REFERENCES Emploi(id_emploi);
ALTER TABLE Participe ADD CONSTRAINT FK_Participe_id_evenement FOREIGN KEY (id_evenement) REFERENCES Evenement(id_evenement);
ALTER TABLE Participe ADD CONSTRAINT FK_Participe_id_user FOREIGN KEY (id_user) REFERENCES User(id_user);
ALTER TABLE Enseigne ADD CONSTRAINT FK_Enseigne_id_user FOREIGN KEY (id_user) REFERENCES User(id_user);
ALTER TABLE Enseigne ADD CONSTRAINT FK_Enseigne_id_matiere FOREIGN KEY (id_matiere) REFERENCES Matiere(id_matiere);


