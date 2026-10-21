CREATE TABLE boletos_direccion (
  id_presupuesto int(10) unsigned NOT NULL,
  nombre varchar(60) NOT NULL,
  direccion varchar(60) NOT NULL,
  codigo_postal varchar(10) NOT NULL,
  ciudad varchar(50) NOT NULL,
  PRIMARY KEY  (id_presupuesto)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Direccion por enviar los boletos';

CREATE TABLE ficha_pasajeros (
  id_presupuesto int(10) unsigned NOT NULL,
  num_pass tinyint(1) unsigned NOT NULL,
  nombre varchar(50) NOT NULL,
  apellido varchar(50) NOT NULL,
  nationalidad varchar(50) NOT NULL,
  fecha_nacimiento date NOT NULL,
  lugar_nacimiento varchar(50) NOT NULL,
  typo_doc varchar(30) NOT NULL,
  numero_doc varchar(30) NOT NULL,
  fecha_emission_doc date NOT NULL,
  lugar_emission_doc varchar(50) NOT NULL,
  fecha_expiration_doc date NOT NULL,
  telefono varchar(50) NOT NULL,
  mobile varchar(50) NOT NULL,
  fax varchar(50) NOT NULL,
  email varchar(60) NOT NULL,
  PRIMARY KEY  (id_presupuesto,num_pass)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Ficha pasajeros';
