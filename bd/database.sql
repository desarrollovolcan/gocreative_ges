CREATE DATABASE IF NOT EXISTS gocreative_ges CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE gocreative_ges;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    rut VARCHAR(50) NULL,
    email VARCHAR(150) NULL,
    phone VARCHAR(50) NULL,
    address VARCHAR(255) NULL,
    giro VARCHAR(150) NULL,
    activity_code VARCHAR(50) NULL,
    commune VARCHAR(120) NULL,
    city VARCHAR(120) NULL,
    logo_color VARCHAR(255) NULL,
    logo_black VARCHAR(255) NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE chile_communes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commune VARCHAR(150) NOT NULL,
    city VARCHAR(150) NOT NULL,
    region VARCHAR(150) NOT NULL,
    UNIQUE KEY uniq_chile_communes_commune (commune),
    INDEX idx_chile_communes_city (city),
    INDEX idx_chile_communes_region (region)
);

INSERT INTO chile_communes (commune, city, region) VALUES
('Arica', 'Arica', 'Arica y Parinacota'),
('Camarones', 'Camarones', 'Arica y Parinacota'),
('Putre', 'Putre', 'Arica y Parinacota'),
('General Lagos', 'General Lagos', 'Arica y Parinacota'),
('Iquique', 'Iquique', 'Tarapacá'),
('Alto Hospicio', 'Alto Hospicio', 'Tarapacá'),
('Pozo Almonte', 'Pozo Almonte', 'Tarapacá'),
('Camiña', 'Camiña', 'Tarapacá'),
('Colchane', 'Colchane', 'Tarapacá'),
('Huara', 'Huara', 'Tarapacá'),
('Pica', 'Pica', 'Tarapacá'),
('Antofagasta', 'Antofagasta', 'Antofagasta'),
('Mejillones', 'Mejillones', 'Antofagasta'),
('Sierra Gorda', 'Sierra Gorda', 'Antofagasta'),
('Taltal', 'Taltal', 'Antofagasta'),
('Calama', 'Calama', 'Antofagasta'),
('Ollagüe', 'Ollagüe', 'Antofagasta'),
('San Pedro de Atacama', 'San Pedro de Atacama', 'Antofagasta'),
('Tocopilla', 'Tocopilla', 'Antofagasta'),
('María Elena', 'María Elena', 'Antofagasta'),
('Copiapó', 'Copiapó', 'Atacama'),
('Caldera', 'Caldera', 'Atacama'),
('Tierra Amarilla', 'Tierra Amarilla', 'Atacama'),
('Chañaral', 'Chañaral', 'Atacama'),
('Diego de Almagro', 'Diego de Almagro', 'Atacama'),
('Vallenar', 'Vallenar', 'Atacama'),
('Alto del Carmen', 'Alto del Carmen', 'Atacama'),
('Freirina', 'Freirina', 'Atacama'),
('Huasco', 'Huasco', 'Atacama'),
('La Serena', 'La Serena', 'Coquimbo'),
('Coquimbo', 'Coquimbo', 'Coquimbo'),
('Andacollo', 'Andacollo', 'Coquimbo'),
('La Higuera', 'La Higuera', 'Coquimbo'),
('Paiguano', 'Paiguano', 'Coquimbo'),
('Vicuña', 'Vicuña', 'Coquimbo'),
('Illapel', 'Illapel', 'Coquimbo'),
('Canela', 'Canela', 'Coquimbo'),
('Los Vilos', 'Los Vilos', 'Coquimbo'),
('Salamanca', 'Salamanca', 'Coquimbo'),
('Ovalle', 'Ovalle', 'Coquimbo'),
('Combarbalá', 'Combarbalá', 'Coquimbo'),
('Monte Patria', 'Monte Patria', 'Coquimbo'),
('Punitaqui', 'Punitaqui', 'Coquimbo'),
('Río Hurtado', 'Río Hurtado', 'Coquimbo'),
('Valparaíso', 'Valparaíso', 'Valparaíso'),
('Casablanca', 'Casablanca', 'Valparaíso'),
('Concón', 'Concón', 'Valparaíso'),
('Juan Fernández', 'Juan Fernández', 'Valparaíso'),
('Puchuncaví', 'Puchuncaví', 'Valparaíso'),
('Quintero', 'Quintero', 'Valparaíso'),
('Viña del Mar', 'Viña del Mar', 'Valparaíso'),
('Isla de Pascua', 'Isla de Pascua', 'Valparaíso'),
('Los Andes', 'Los Andes', 'Valparaíso'),
('Calle Larga', 'Calle Larga', 'Valparaíso'),
('Rinconada', 'Rinconada', 'Valparaíso'),
('San Esteban', 'San Esteban', 'Valparaíso'),
('La Ligua', 'La Ligua', 'Valparaíso'),
('Cabildo', 'Cabildo', 'Valparaíso'),
('Papudo', 'Papudo', 'Valparaíso'),
('Petorca', 'Petorca', 'Valparaíso'),
('Zapallar', 'Zapallar', 'Valparaíso'),
('Quillota', 'Quillota', 'Valparaíso'),
('La Calera', 'La Calera', 'Valparaíso'),
('Hijuelas', 'Hijuelas', 'Valparaíso'),
('La Cruz', 'La Cruz', 'Valparaíso'),
('Nogales', 'Nogales', 'Valparaíso'),
('San Antonio', 'San Antonio', 'Valparaíso'),
('Algarrobo', 'Algarrobo', 'Valparaíso'),
('Cartagena', 'Cartagena', 'Valparaíso'),
('El Quisco', 'El Quisco', 'Valparaíso'),
('El Tabo', 'El Tabo', 'Valparaíso'),
('Santo Domingo', 'Santo Domingo', 'Valparaíso'),
('San Felipe', 'San Felipe', 'Valparaíso'),
('Catemu', 'Catemu', 'Valparaíso'),
('Llaillay', 'Llaillay', 'Valparaíso'),
('Panquehue', 'Panquehue', 'Valparaíso'),
('Putaendo', 'Putaendo', 'Valparaíso'),
('Santa María', 'Santa María', 'Valparaíso'),
('Limache', 'Limache', 'Valparaíso'),
('Olmué', 'Olmué', 'Valparaíso'),
('Quilpué', 'Quilpué', 'Valparaíso'),
('Villa Alemana', 'Villa Alemana', 'Valparaíso'),
('Santiago', 'Santiago', 'Metropolitana de Santiago'),
('Cerrillos', 'Cerrillos', 'Metropolitana de Santiago'),
('Cerro Navia', 'Cerro Navia', 'Metropolitana de Santiago'),
('Conchalí', 'Conchalí', 'Metropolitana de Santiago'),
('El Bosque', 'El Bosque', 'Metropolitana de Santiago'),
('Estación Central', 'Estación Central', 'Metropolitana de Santiago'),
('Huechuraba', 'Huechuraba', 'Metropolitana de Santiago'),
('Independencia', 'Independencia', 'Metropolitana de Santiago'),
('La Cisterna', 'La Cisterna', 'Metropolitana de Santiago'),
('La Florida', 'La Florida', 'Metropolitana de Santiago'),
('La Granja', 'La Granja', 'Metropolitana de Santiago'),
('La Pintana', 'La Pintana', 'Metropolitana de Santiago'),
('La Reina', 'La Reina', 'Metropolitana de Santiago'),
('Las Condes', 'Las Condes', 'Metropolitana de Santiago'),
('Lo Barnechea', 'Lo Barnechea', 'Metropolitana de Santiago'),
('Lo Espejo', 'Lo Espejo', 'Metropolitana de Santiago'),
('Lo Prado', 'Lo Prado', 'Metropolitana de Santiago'),
('Macul', 'Macul', 'Metropolitana de Santiago'),
('Maipú', 'Maipú', 'Metropolitana de Santiago'),
('Ñuñoa', 'Ñuñoa', 'Metropolitana de Santiago'),
('Pedro Aguirre Cerda', 'Pedro Aguirre Cerda', 'Metropolitana de Santiago'),
('Peñalolén', 'Peñalolén', 'Metropolitana de Santiago'),
('Providencia', 'Providencia', 'Metropolitana de Santiago'),
('Pudahuel', 'Pudahuel', 'Metropolitana de Santiago'),
('Quilicura', 'Quilicura', 'Metropolitana de Santiago'),
('Quinta Normal', 'Quinta Normal', 'Metropolitana de Santiago'),
('Recoleta', 'Recoleta', 'Metropolitana de Santiago'),
('Renca', 'Renca', 'Metropolitana de Santiago'),
('San Joaquín', 'San Joaquín', 'Metropolitana de Santiago'),
('San Miguel', 'San Miguel', 'Metropolitana de Santiago'),
('San Ramón', 'San Ramón', 'Metropolitana de Santiago'),
('Vitacura', 'Vitacura', 'Metropolitana de Santiago'),
('Puente Alto', 'Puente Alto', 'Metropolitana de Santiago'),
('Pirque', 'Pirque', 'Metropolitana de Santiago'),
('San José de Maipo', 'San José de Maipo', 'Metropolitana de Santiago'),
('Colina', 'Colina', 'Metropolitana de Santiago'),
('Lampa', 'Lampa', 'Metropolitana de Santiago'),
('Tiltil', 'Tiltil', 'Metropolitana de Santiago'),
('San Bernardo', 'San Bernardo', 'Metropolitana de Santiago'),
('Buin', 'Buin', 'Metropolitana de Santiago'),
('Calera de Tango', 'Calera de Tango', 'Metropolitana de Santiago'),
('Paine', 'Paine', 'Metropolitana de Santiago'),
('Melipilla', 'Melipilla', 'Metropolitana de Santiago'),
('Alhué', 'Alhué', 'Metropolitana de Santiago'),
('Curacaví', 'Curacaví', 'Metropolitana de Santiago'),
('María Pinto', 'María Pinto', 'Metropolitana de Santiago'),
('San Pedro', 'San Pedro', 'Metropolitana de Santiago'),
('Talagante', 'Talagante', 'Metropolitana de Santiago'),
('El Monte', 'El Monte', 'Metropolitana de Santiago'),
('Isla de Maipo', 'Isla de Maipo', 'Metropolitana de Santiago'),
('Padre Hurtado', 'Padre Hurtado', 'Metropolitana de Santiago'),
('Peñaflor', 'Peñaflor', 'Metropolitana de Santiago'),
('Rancagua', 'Rancagua', 'Libertador General Bernardo O\'Higgins'),
('Codegua', 'Codegua', 'Libertador General Bernardo O\'Higgins'),
('Coinco', 'Coinco', 'Libertador General Bernardo O\'Higgins'),
('Coltauco', 'Coltauco', 'Libertador General Bernardo O\'Higgins'),
('Doñihue', 'Doñihue', 'Libertador General Bernardo O\'Higgins'),
('Graneros', 'Graneros', 'Libertador General Bernardo O\'Higgins'),
('Las Cabras', 'Las Cabras', 'Libertador General Bernardo O\'Higgins'),
('Machalí', 'Machalí', 'Libertador General Bernardo O\'Higgins'),
('Malloa', 'Malloa', 'Libertador General Bernardo O\'Higgins'),
('Mostazal', 'Mostazal', 'Libertador General Bernardo O\'Higgins'),
('Olivar', 'Olivar', 'Libertador General Bernardo O\'Higgins'),
('Peumo', 'Peumo', 'Libertador General Bernardo O\'Higgins'),
('Pichidegua', 'Pichidegua', 'Libertador General Bernardo O\'Higgins'),
('Quinta de Tilcoco', 'Quinta de Tilcoco', 'Libertador General Bernardo O\'Higgins'),
('Rengo', 'Rengo', 'Libertador General Bernardo O\'Higgins'),
('Requínoa', 'Requínoa', 'Libertador General Bernardo O\'Higgins'),
('San Vicente', 'San Vicente', 'Libertador General Bernardo O\'Higgins'),
('San Fernando', 'San Fernando', 'Libertador General Bernardo O\'Higgins'),
('Chimbarongo', 'Chimbarongo', 'Libertador General Bernardo O\'Higgins'),
('Lolol', 'Lolol', 'Libertador General Bernardo O\'Higgins'),
('Nancagua', 'Nancagua', 'Libertador General Bernardo O\'Higgins'),
('Palmilla', 'Palmilla', 'Libertador General Bernardo O\'Higgins'),
('Peralillo', 'Peralillo', 'Libertador General Bernardo O\'Higgins'),
('Placilla', 'Placilla', 'Libertador General Bernardo O\'Higgins'),
('Pumanque', 'Pumanque', 'Libertador General Bernardo O\'Higgins'),
('Santa Cruz', 'Santa Cruz', 'Libertador General Bernardo O\'Higgins'),
('Pichilemu', 'Pichilemu', 'Libertador General Bernardo O\'Higgins'),
('La Estrella', 'La Estrella', 'Libertador General Bernardo O\'Higgins'),
('Litueche', 'Litueche', 'Libertador General Bernardo O\'Higgins'),
('Marchihue', 'Marchihue', 'Libertador General Bernardo O\'Higgins'),
('Navidad', 'Navidad', 'Libertador General Bernardo O\'Higgins'),
('Paredones', 'Paredones', 'Libertador General Bernardo O\'Higgins'),
('Talca', 'Talca', 'Maule'),
('Constitución', 'Constitución', 'Maule'),
('Curepto', 'Curepto', 'Maule'),
('Empedrado', 'Empedrado', 'Maule'),
('Maule', 'Maule', 'Maule'),
('Pelarco', 'Pelarco', 'Maule'),
('Pencahue', 'Pencahue', 'Maule'),
('Río Claro', 'Río Claro', 'Maule'),
('San Clemente', 'San Clemente', 'Maule'),
('San Rafael', 'San Rafael', 'Maule'),
('Cauquenes', 'Cauquenes', 'Maule'),
('Chanco', 'Chanco', 'Maule'),
('Pelluhue', 'Pelluhue', 'Maule'),
('Curicó', 'Curicó', 'Maule'),
('Hualañé', 'Hualañé', 'Maule'),
('Licantén', 'Licantén', 'Maule'),
('Molina', 'Molina', 'Maule'),
('Rauco', 'Rauco', 'Maule'),
('Romeral', 'Romeral', 'Maule'),
('Sagrada Familia', 'Sagrada Familia', 'Maule'),
('Teno', 'Teno', 'Maule'),
('Vichuquén', 'Vichuquén', 'Maule'),
('Linares', 'Linares', 'Maule'),
('Colbún', 'Colbún', 'Maule'),
('Longaví', 'Longaví', 'Maule'),
('Parral', 'Parral', 'Maule'),
('Retiro', 'Retiro', 'Maule'),
('San Javier', 'San Javier', 'Maule'),
('Villa Alegre', 'Villa Alegre', 'Maule'),
('Yerbas Buenas', 'Yerbas Buenas', 'Maule'),
('Chillán', 'Chillán', 'Ñuble'),
('Bulnes', 'Bulnes', 'Ñuble'),
('Chillán Viejo', 'Chillán Viejo', 'Ñuble'),
('Cobquecura', 'Cobquecura', 'Ñuble'),
('Coelemu', 'Coelemu', 'Ñuble'),
('Coihueco', 'Coihueco', 'Ñuble'),
('El Carmen', 'El Carmen', 'Ñuble'),
('Ninhue', 'Ninhue', 'Ñuble'),
('Ñiquén', 'Ñiquén', 'Ñuble'),
('Pemuco', 'Pemuco', 'Ñuble'),
('Pinto', 'Pinto', 'Ñuble'),
('Portezuelo', 'Portezuelo', 'Ñuble'),
('Quillón', 'Quillón', 'Ñuble'),
('Quirihue', 'Quirihue', 'Ñuble'),
('Ránquil', 'Ránquil', 'Ñuble'),
('San Carlos', 'San Carlos', 'Ñuble'),
('San Fabián', 'San Fabián', 'Ñuble'),
('San Ignacio', 'San Ignacio', 'Ñuble'),
('San Nicolás', 'San Nicolás', 'Ñuble'),
('Trehuaco', 'Trehuaco', 'Ñuble'),
('Yungay', 'Yungay', 'Ñuble'),
('Concepción', 'Concepción', 'Biobío'),
('Coronel', 'Coronel', 'Biobío'),
('Chiguayante', 'Chiguayante', 'Biobío'),
('Florida', 'Florida', 'Biobío'),
('Hualqui', 'Hualqui', 'Biobío'),
('Lota', 'Lota', 'Biobío'),
('Penco', 'Penco', 'Biobío'),
('San Pedro de la Paz', 'San Pedro de la Paz', 'Biobío'),
('Santa Juana', 'Santa Juana', 'Biobío'),
('Talcahuano', 'Talcahuano', 'Biobío'),
('Tomé', 'Tomé', 'Biobío'),
('Lebu', 'Lebu', 'Biobío'),
('Arauco', 'Arauco', 'Biobío'),
('Cañete', 'Cañete', 'Biobío'),
('Contulmo', 'Contulmo', 'Biobío'),
('Curanilahue', 'Curanilahue', 'Biobío'),
('Los Álamos', 'Los Álamos', 'Biobío'),
('Tirúa', 'Tirúa', 'Biobío'),
('Los Ángeles', 'Los Ángeles', 'Biobío'),
('Antuco', 'Antuco', 'Biobío'),
('Cabrero', 'Cabrero', 'Biobío'),
('Laja', 'Laja', 'Biobío'),
('Mulchén', 'Mulchén', 'Biobío'),
('Nacimiento', 'Nacimiento', 'Biobío'),
('Negrete', 'Negrete', 'Biobío'),
('Quilaco', 'Quilaco', 'Biobío'),
('Quilleco', 'Quilleco', 'Biobío'),
('San Rosendo', 'San Rosendo', 'Biobío'),
('Santa Bárbara', 'Santa Bárbara', 'Biobío'),
('Tucapel', 'Tucapel', 'Biobío'),
('Yumbel', 'Yumbel', 'Biobío'),
('Alto Biobío', 'Alto Biobío', 'Biobío'),
('Temuco', 'Temuco', 'Araucanía'),
('Carahue', 'Carahue', 'Araucanía'),
('Cunco', 'Cunco', 'Araucanía'),
('Curarrehue', 'Curarrehue', 'Araucanía'),
('Freire', 'Freire', 'Araucanía'),
('Galvarino', 'Galvarino', 'Araucanía'),
('Gorbea', 'Gorbea', 'Araucanía'),
('Lautaro', 'Lautaro', 'Araucanía'),
('Loncoche', 'Loncoche', 'Araucanía'),
('Melipeuco', 'Melipeuco', 'Araucanía'),
('Nueva Imperial', 'Nueva Imperial', 'Araucanía'),
('Padre Las Casas', 'Padre Las Casas', 'Araucanía'),
('Perquenco', 'Perquenco', 'Araucanía'),
('Pitrufquén', 'Pitrufquén', 'Araucanía'),
('Pucón', 'Pucón', 'Araucanía'),
('Saavedra', 'Saavedra', 'Araucanía'),
('Teodoro Schmidt', 'Teodoro Schmidt', 'Araucanía'),
('Toltén', 'Toltén', 'Araucanía'),
('Vilcún', 'Vilcún', 'Araucanía'),
('Villarrica', 'Villarrica', 'Araucanía'),
('Cholchol', 'Cholchol', 'Araucanía'),
('Angol', 'Angol', 'Araucanía'),
('Collipulli', 'Collipulli', 'Araucanía'),
('Curacautín', 'Curacautín', 'Araucanía'),
('Ercilla', 'Ercilla', 'Araucanía'),
('Lonquimay', 'Lonquimay', 'Araucanía'),
('Los Sauces', 'Los Sauces', 'Araucanía'),
('Lumaco', 'Lumaco', 'Araucanía'),
('Purén', 'Purén', 'Araucanía'),
('Renaico', 'Renaico', 'Araucanía'),
('Traiguén', 'Traiguén', 'Araucanía'),
('Victoria', 'Victoria', 'Araucanía'),
('Valdivia', 'Valdivia', 'Los Ríos'),
('Corral', 'Corral', 'Los Ríos'),
('Lanco', 'Lanco', 'Los Ríos'),
('Los Lagos', 'Los Lagos', 'Los Ríos'),
('Máfil', 'Máfil', 'Los Ríos'),
('Mariquina', 'Mariquina', 'Los Ríos'),
('Paillaco', 'Paillaco', 'Los Ríos'),
('Panguipulli', 'Panguipulli', 'Los Ríos'),
('La Unión', 'La Unión', 'Los Ríos'),
('Futrono', 'Futrono', 'Los Ríos'),
('Lago Ranco', 'Lago Ranco', 'Los Ríos'),
('Río Bueno', 'Río Bueno', 'Los Ríos'),
('Puerto Montt', 'Puerto Montt', 'Los Lagos'),
('Calbuco', 'Calbuco', 'Los Lagos'),
('Cochamó', 'Cochamó', 'Los Lagos'),
('Fresia', 'Fresia', 'Los Lagos'),
('Frutillar', 'Frutillar', 'Los Lagos'),
('Los Muermos', 'Los Muermos', 'Los Lagos'),
('Llanquihue', 'Llanquihue', 'Los Lagos'),
('Maullín', 'Maullín', 'Los Lagos'),
('Puerto Varas', 'Puerto Varas', 'Los Lagos'),
('Castro', 'Castro', 'Los Lagos'),
('Ancud', 'Ancud', 'Los Lagos'),
('Chonchi', 'Chonchi', 'Los Lagos'),
('Curaco de Vélez', 'Curaco de Vélez', 'Los Lagos'),
('Dalcahue', 'Dalcahue', 'Los Lagos'),
('Puqueldón', 'Puqueldón', 'Los Lagos'),
('Queilén', 'Queilén', 'Los Lagos'),
('Quellón', 'Quellón', 'Los Lagos'),
('Quemchi', 'Quemchi', 'Los Lagos'),
('Quinchao', 'Quinchao', 'Los Lagos'),
('Osorno', 'Osorno', 'Los Lagos'),
('Puerto Octay', 'Puerto Octay', 'Los Lagos'),
('Purranque', 'Purranque', 'Los Lagos'),
('Puyehue', 'Puyehue', 'Los Lagos'),
('Río Negro', 'Río Negro', 'Los Lagos'),
('San Juan de la Costa', 'San Juan de la Costa', 'Los Lagos'),
('San Pablo', 'San Pablo', 'Los Lagos'),
('Chaitén', 'Chaitén', 'Los Lagos'),
('Futaleufú', 'Futaleufú', 'Los Lagos'),
('Hualaihué', 'Hualaihué', 'Los Lagos'),
('Palena', 'Palena', 'Los Lagos'),
('Coyhaique', 'Coyhaique', 'Aysén del General Carlos Ibáñez del Campo'),
('Lago Verde', 'Lago Verde', 'Aysén del General Carlos Ibáñez del Campo'),
('Aysén', 'Aysén', 'Aysén del General Carlos Ibáñez del Campo'),
('Cisnes', 'Cisnes', 'Aysén del General Carlos Ibáñez del Campo'),
('Guaitecas', 'Guaitecas', 'Aysén del General Carlos Ibáñez del Campo'),
('Cochrane', 'Cochrane', 'Aysén del General Carlos Ibáñez del Campo'),
('O\'Higgins', 'O\'Higgins', 'Aysén del General Carlos Ibáñez del Campo'),
('Tortel', 'Tortel', 'Aysén del General Carlos Ibáñez del Campo'),
('Chile Chico', 'Chile Chico', 'Aysén del General Carlos Ibáñez del Campo'),
('Río Ibáñez', 'Río Ibáñez', 'Aysén del General Carlos Ibáñez del Campo'),
('Punta Arenas', 'Punta Arenas', 'Magallanes y de la Antártica Chilena'),
('Laguna Blanca', 'Laguna Blanca', 'Magallanes y de la Antártica Chilena'),
('Río Verde', 'Río Verde', 'Magallanes y de la Antártica Chilena'),
('San Gregorio', 'San Gregorio', 'Magallanes y de la Antártica Chilena'),
('Cabo de Hornos', 'Cabo de Hornos', 'Magallanes y de la Antártica Chilena'),
('Antártica', 'Antártica', 'Magallanes y de la Antártica Chilena'),
('Porvenir', 'Porvenir', 'Magallanes y de la Antártica Chilena'),
('Primavera', 'Primavera', 'Magallanes y de la Antártica Chilena'),
('Timaukel', 'Timaukel', 'Magallanes y de la Antártica Chilena'),
('Natales', 'Natales', 'Magallanes y de la Antártica Chilena'),
('Torres del Paine', 'Torres del Paine', 'Magallanes y de la Antártica Chilena');

CREATE TABLE role_permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    permission_key VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    avatar_path VARCHAR(255) NULL,
    signature TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE user_companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    company_id INT NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    rut VARCHAR(50) NULL,
    email VARCHAR(150) NOT NULL,
    billing_email VARCHAR(150) NULL,
    phone VARCHAR(50) NULL,
    address VARCHAR(255) NULL,
    giro VARCHAR(150) NULL,
    activity_code VARCHAR(50) NULL,
    commune VARCHAR(120) NULL,
    city VARCHAR(120) NULL,
    contact VARCHAR(150) NULL,
    mandante_name VARCHAR(150) NULL,
    mandante_rut VARCHAR(50) NULL,
    mandante_phone VARCHAR(50) NULL,
    mandante_email VARCHAR(150) NULL,
    avatar_path VARCHAR(255) NULL,
    portal_token VARCHAR(64) NULL,
    portal_password VARCHAR(255) NULL,
    notes TEXT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'activo',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    contact_name VARCHAR(150) NULL,
    tax_id VARCHAR(50) NULL,
    email VARCHAR(150) NULL,
    phone VARCHAR(50) NULL,
    address VARCHAR(255) NULL,
    giro VARCHAR(150) NULL,
    activity_code VARCHAR(50) NULL,
    commune VARCHAR(120) NULL,
    city VARCHAR(120) NULL,
    website VARCHAR(150) NULL,
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE product_families (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE product_subfamilies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    family_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (family_id) REFERENCES product_families(id)
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    supplier_id INT NULL,
    family_id INT NULL,
    subfamily_id INT NULL,
    name VARCHAR(150) NOT NULL,
    sku VARCHAR(100) NULL,
    description TEXT NULL,
    price DECIMAL(12,2) NOT NULL DEFAULT 0,
    cost DECIMAL(12,2) NOT NULL DEFAULT 0,
    stock INT NOT NULL DEFAULT 0,
    stock_min INT NOT NULL DEFAULT 0,
    status VARCHAR(20) NOT NULL DEFAULT 'activo',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id),
    FOREIGN KEY (family_id) REFERENCES product_families(id),
    FOREIGN KEY (subfamily_id) REFERENCES product_subfamilies(id)
);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT NULL,
    status VARCHAR(50) NOT NULL,
    start_date DATE NULL,
    delivery_date DATE NULL,
    value DECIMAL(12,2) NULL,
    mandante_name VARCHAR(150) NULL,
    mandante_rut VARCHAR(50) NULL,
    mandante_phone VARCHAR(50) NULL,
    mandante_email VARCHAR(150) NULL,
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

CREATE TABLE project_tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    start_date DATE NULL,
    end_date DATE NULL,
    progress_percent TINYINT UNSIGNED NOT NULL DEFAULT 0,
    completed TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    service_type VARCHAR(50) NOT NULL,
    name VARCHAR(150) NOT NULL,
    cost DECIMAL(12,2) NOT NULL,
    currency VARCHAR(10) NOT NULL DEFAULT 'CLP',
    billing_cycle VARCHAR(20) NOT NULL DEFAULT 'mensual',
    start_date DATE NULL,
    due_date DATE NULL,
    delete_date DATE NULL,
    notice_days_1 INT NOT NULL DEFAULT 15,
    notice_days_2 INT NOT NULL DEFAULT 5,
    status VARCHAR(20) NOT NULL DEFAULT 'activo',
    auto_invoice TINYINT(1) NOT NULL DEFAULT 1,
    auto_email TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

CREATE TABLE service_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE system_services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    service_type_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT NULL,
    cost DECIMAL(12,2) NOT NULL,
    currency VARCHAR(10) NOT NULL DEFAULT 'CLP',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (service_type_id) REFERENCES service_types(id),
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    service_id INT NULL,
    project_id INT NULL,
    numero VARCHAR(50) NOT NULL,
    fecha_emision DATE NOT NULL,
    fecha_vencimiento DATE NOT NULL,
    estado VARCHAR(20) NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    impuestos DECIMAL(12,2) NOT NULL,
    total DECIMAL(12,2) NOT NULL,
    sii_document_type VARCHAR(50) NULL,
    sii_document_number VARCHAR(50) NULL,
    sii_receiver_rut VARCHAR(50) NULL,
    sii_receiver_name VARCHAR(150) NULL,
    sii_receiver_giro VARCHAR(150) NULL,
    sii_receiver_activity_code VARCHAR(50) NULL,
    sii_receiver_address VARCHAR(255) NULL,
    sii_receiver_commune VARCHAR(100) NULL,
    sii_receiver_city VARCHAR(100) NULL,
    sii_tax_rate DECIMAL(5,2) NOT NULL DEFAULT 19,
    sii_exempt_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    notas TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (service_id) REFERENCES services(id),
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

CREATE TABLE quotes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    service_id INT NULL,
    system_service_id INT NULL,
    project_id INT NULL,
    numero VARCHAR(50) NOT NULL,
    fecha_emision DATE NOT NULL,
    estado VARCHAR(20) NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    impuestos DECIMAL(12,2) NOT NULL,
    total DECIMAL(12,2) NOT NULL,
    sii_document_type VARCHAR(50) NULL,
    sii_document_number VARCHAR(50) NULL,
    sii_receiver_rut VARCHAR(50) NULL,
    sii_receiver_name VARCHAR(150) NULL,
    sii_receiver_giro VARCHAR(150) NULL,
    sii_receiver_activity_code VARCHAR(50) NULL,
    sii_receiver_address VARCHAR(255) NULL,
    sii_receiver_commune VARCHAR(100) NULL,
    sii_receiver_city VARCHAR(100) NULL,
    sii_tax_rate DECIMAL(5,2) NOT NULL DEFAULT 19,
    sii_exempt_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    notas TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (service_id) REFERENCES services(id),
    FOREIGN KEY (system_service_id) REFERENCES system_services(id),
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

CREATE TABLE quote_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quote_id INT NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(12,2) NOT NULL,
    total DECIMAL(12,2) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (quote_id) REFERENCES quotes(id)
);

CREATE TABLE chat_threads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    subject VARCHAR(150) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'abierto',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

CREATE TABLE chat_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    thread_id INT NOT NULL,
    sender_type VARCHAR(20) NOT NULL,
    sender_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (thread_id) REFERENCES chat_threads(id)
);

CREATE TABLE support_tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    subject VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'abierto',
    priority VARCHAR(20) NOT NULL DEFAULT 'media',
    assigned_user_id INT NULL,
    created_by_type VARCHAR(20) NOT NULL DEFAULT 'client',
    created_by_id INT NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    closed_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (assigned_user_id) REFERENCES users(id)
);

CREATE TABLE support_ticket_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT NOT NULL,
    sender_type VARCHAR(20) NOT NULL,
    sender_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (ticket_id) REFERENCES support_tickets(id)
);


CREATE TABLE invoice_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(12,2) NOT NULL,
    total DECIMAL(12,2) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id)
);

CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT NOT NULL,
    monto DECIMAL(12,2) NOT NULL,
    fecha_pago DATE NOT NULL,
    metodo VARCHAR(50) NOT NULL,
    referencia VARCHAR(150) NULL,
    comprobante VARCHAR(255) NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id)
);

CREATE TABLE purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    supplier_id INT NOT NULL,
    reference VARCHAR(100) NULL,
    purchase_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pendiente',
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
    tax DECIMAL(12,2) NOT NULL DEFAULT 0,
    total DECIMAL(12,2) NOT NULL DEFAULT 0,
    sii_document_type VARCHAR(50) NULL,
    sii_document_number VARCHAR(50) NULL,
    sii_receiver_rut VARCHAR(50) NULL,
    sii_receiver_name VARCHAR(150) NULL,
    sii_receiver_giro VARCHAR(150) NULL,
    sii_receiver_activity_code VARCHAR(50) NULL,
    sii_receiver_address VARCHAR(255) NULL,
    sii_receiver_commune VARCHAR(100) NULL,
    sii_receiver_city VARCHAR(100) NULL,
    sii_tax_rate DECIMAL(5,2) NOT NULL DEFAULT 19,
    sii_exempt_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
);

CREATE TABLE purchase_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    purchase_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    unit_cost DECIMAL(12,2) NOT NULL DEFAULT 0,
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (purchase_id) REFERENCES purchases(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE pos_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    user_id INT NOT NULL,
    opening_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    closing_amount DECIMAL(12,2) NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'abierto',
    opened_at DATETIME NOT NULL,
    closed_at DATETIME NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NULL,
    pos_session_id INT NULL,
    channel VARCHAR(20) NOT NULL DEFAULT 'venta',
    numero VARCHAR(50) NOT NULL,
    sale_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pagado',
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
    tax DECIMAL(12,2) NOT NULL DEFAULT 0,
    total DECIMAL(12,2) NOT NULL DEFAULT 0,
    sii_document_type VARCHAR(50) NULL,
    sii_document_number VARCHAR(50) NULL,
    sii_receiver_rut VARCHAR(50) NULL,
    sii_receiver_name VARCHAR(150) NULL,
    sii_receiver_giro VARCHAR(150) NULL,
    sii_receiver_activity_code VARCHAR(50) NULL,
    sii_receiver_address VARCHAR(255) NULL,
    sii_receiver_commune VARCHAR(100) NULL,
    sii_receiver_city VARCHAR(100) NULL,
    sii_tax_rate DECIMAL(5,2) NOT NULL DEFAULT 19,
    sii_exempt_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (pos_session_id) REFERENCES pos_sessions(id)
);

CREATE TABLE sale_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_id INT NOT NULL,
    product_id INT NULL,
    service_id INT NULL,
    quantity INT NOT NULL DEFAULT 0,
    unit_price DECIMAL(12,2) NOT NULL DEFAULT 0,
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (sale_id) REFERENCES sales(id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
);

CREATE TABLE sale_payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_id INT NOT NULL,
    method VARCHAR(50) NOT NULL,
    amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (sale_id) REFERENCES sales(id)
);

CREATE TABLE email_templates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    body_html MEDIUMTEXT NOT NULL,
    type VARCHAR(20) NOT NULL DEFAULT 'cobranza',
    created_by INT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE email_queue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NULL,
    template_id INT NULL,
    subject VARCHAR(150) NOT NULL,
    body_html MEDIUMTEXT NOT NULL,
    type VARCHAR(20) NOT NULL DEFAULT 'cobranza',
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    scheduled_at DATETIME NOT NULL,
    tries INT NOT NULL DEFAULT 0,
    last_error TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (template_id) REFERENCES email_templates(id)
);

CREATE TABLE email_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NULL,
    type VARCHAR(20) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    body_html MEDIUMTEXT NOT NULL,
    status VARCHAR(20) NOT NULL,
    error TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NULL,
    `key` VARCHAR(100) NOT NULL,
    value MEDIUMTEXT NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NULL,
    title VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    type VARCHAR(20) NOT NULL,
    read_at DATETIME NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE commercial_briefs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    contact_name VARCHAR(150) NULL,
    contact_email VARCHAR(150) NULL,
    contact_phone VARCHAR(50) NULL,
    service_summary VARCHAR(150) NULL,
    expected_budget DECIMAL(12,2) NULL,
    desired_start_date DATE NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'nuevo',
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

CREATE TABLE sales_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    brief_id INT NULL,
    order_number VARCHAR(50) NOT NULL,
    order_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pendiente',
    total DECIMAL(12,2) NOT NULL,
    currency VARCHAR(10) NOT NULL DEFAULT 'CLP',
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (brief_id) REFERENCES commercial_briefs(id)
);

CREATE TABLE service_renewals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    service_id INT NULL,
    renewal_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pendiente',
    amount DECIMAL(12,2) NOT NULL,
    currency VARCHAR(10) NOT NULL DEFAULT 'CLP',
    reminder_days INT NOT NULL DEFAULT 15,
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
);

CREATE TABLE audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NULL,
    user_id INT NOT NULL,
    action VARCHAR(50) NOT NULL,
    entity VARCHAR(50) NOT NULL,
    entity_id INT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE INDEX idx_clients_status ON clients(status);
CREATE UNIQUE INDEX idx_clients_portal_token ON clients(portal_token);
CREATE INDEX idx_services_status ON services(status);
CREATE INDEX idx_services_due_date ON services(due_date);
CREATE INDEX idx_invoices_estado ON invoices(estado);
CREATE INDEX idx_invoices_numero ON invoices(numero);
CREATE INDEX idx_email_queue_status ON email_queue(status);
CREATE UNIQUE INDEX idx_settings_key_company ON settings(company_id, `key`);
CREATE UNIQUE INDEX idx_user_companies_unique ON user_companies(user_id, company_id);
CREATE INDEX idx_product_families_company ON product_families(company_id);
CREATE INDEX idx_product_subfamilies_company ON product_subfamilies(company_id);
CREATE INDEX idx_products_company ON products(company_id);
CREATE INDEX idx_products_supplier ON products(supplier_id);
CREATE INDEX idx_purchases_company ON purchases(company_id);
CREATE INDEX idx_sales_company ON sales(company_id);
CREATE INDEX idx_pos_sessions_company_user ON pos_sessions(company_id, user_id);

INSERT INTO roles (name, created_at, updated_at) VALUES
('admin', NOW(), NOW());

INSERT INTO companies (name, rut, email, created_at, updated_at) VALUES
('GoCreative', '', 'contacto@gocreative.cl', NOW(), NOW());

INSERT INTO users (company_id, name, email, password, role_id, created_at, updated_at) VALUES
(1, 'E Isla', 'eisla@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 1, NOW(), NOW());

INSERT INTO user_companies (user_id, company_id, created_at) VALUES
(1, 1, NOW());

CREATE TABLE hr_departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description VARCHAR(255) NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE hr_positions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description VARCHAR(255) NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE hr_contract_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description VARCHAR(255) NULL,
    max_duration_months INT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE hr_health_providers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    provider_type VARCHAR(20) NOT NULL DEFAULT 'fonasa',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE hr_pension_funds (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE hr_work_schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    weekly_hours INT NOT NULL DEFAULT 45,
    start_time TIME NULL,
    end_time TIME NULL,
    lunch_break_minutes INT NOT NULL DEFAULT 60,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE hr_payroll_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    item_type VARCHAR(20) NOT NULL DEFAULT 'haber',
    taxable TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE hr_employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    department_id INT NULL,
    position_id INT NULL,
    health_provider_id INT NULL,
    pension_fund_id INT NULL,
    rut VARCHAR(50) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    nationality VARCHAR(100) NULL,
    birth_date DATE NULL,
    civil_status VARCHAR(50) NULL,
    email VARCHAR(150) NULL,
    phone VARCHAR(50) NULL,
    address VARCHAR(255) NULL,
    hire_date DATE NOT NULL,
    termination_date DATE NULL,
    health_provider VARCHAR(100) NULL,
    health_plan VARCHAR(150) NULL,
    pension_fund VARCHAR(100) NULL,
    pension_rate DECIMAL(5,2) NOT NULL DEFAULT 10.00,
    health_rate DECIMAL(5,2) NOT NULL DEFAULT 7.00,
    unemployment_rate DECIMAL(5,2) NOT NULL DEFAULT 0.60,
    dependents_count INT NOT NULL DEFAULT 0,
    payment_method VARCHAR(50) NULL,
    bank_name VARCHAR(100) NULL,
    bank_account_type VARCHAR(50) NULL,
    bank_account_number VARCHAR(50) NULL,
    qr_token VARCHAR(100) NULL,
    face_descriptor TEXT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'activo',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (department_id) REFERENCES hr_departments(id),
    FOREIGN KEY (position_id) REFERENCES hr_positions(id),
    FOREIGN KEY (health_provider_id) REFERENCES hr_health_providers(id),
    FOREIGN KEY (pension_fund_id) REFERENCES hr_pension_funds(id)
);

CREATE TABLE hr_contracts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    employee_id INT NOT NULL,
    contract_type_id INT NULL,
    department_id INT NULL,
    position_id INT NULL,
    schedule_id INT NULL,
    start_date DATE NOT NULL,
    end_date DATE NULL,
    salary DECIMAL(12,2) NOT NULL,
    weekly_hours INT NOT NULL DEFAULT 45,
    status VARCHAR(20) NOT NULL DEFAULT 'vigente',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (employee_id) REFERENCES hr_employees(id),
    FOREIGN KEY (contract_type_id) REFERENCES hr_contract_types(id),
    FOREIGN KEY (department_id) REFERENCES hr_departments(id),
    FOREIGN KEY (position_id) REFERENCES hr_positions(id),
    FOREIGN KEY (schedule_id) REFERENCES hr_work_schedules(id)
);

CREATE TABLE hr_attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    employee_id INT NOT NULL,
    date DATE NOT NULL,
    check_in TIME NULL,
    check_out TIME NULL,
    worked_hours DECIMAL(5,2) NULL,
    overtime_hours DECIMAL(5,2) NOT NULL DEFAULT 0,
    absence_type VARCHAR(100) NULL,
    notes VARCHAR(255) NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (employee_id) REFERENCES hr_employees(id)
);

CREATE TABLE hr_payrolls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    employee_id INT NOT NULL,
    period_start DATE NOT NULL,
    period_end DATE NOT NULL,
    base_salary DECIMAL(12,2) NOT NULL,
    bonuses DECIMAL(12,2) NOT NULL DEFAULT 0,
    other_earnings DECIMAL(12,2) NOT NULL DEFAULT 0,
    other_deductions DECIMAL(12,2) NOT NULL DEFAULT 0,
    taxable_income DECIMAL(12,2) NOT NULL DEFAULT 0,
    pension_deduction DECIMAL(12,2) NOT NULL DEFAULT 0,
    health_deduction DECIMAL(12,2) NOT NULL DEFAULT 0,
    unemployment_deduction DECIMAL(12,2) NOT NULL DEFAULT 0,
    total_deductions DECIMAL(12,2) NOT NULL DEFAULT 0,
    net_pay DECIMAL(12,2) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'borrador',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (employee_id) REFERENCES hr_employees(id)
);

CREATE TABLE hr_payroll_lines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    payroll_id INT NOT NULL,
    payroll_item_id INT NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (payroll_id) REFERENCES hr_payrolls(id),
    FOREIGN KEY (payroll_item_id) REFERENCES hr_payroll_items(id)
);

CREATE TABLE accounting_accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    code VARCHAR(50) NOT NULL,
    name VARCHAR(150) NOT NULL,
    type VARCHAR(30) NOT NULL,
    level INT NOT NULL DEFAULT 1,
    parent_id INT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (parent_id) REFERENCES accounting_accounts(id)
);

CREATE TABLE accounting_periods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    period VARCHAR(20) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'abierto',
    closed_at DATETIME NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE accounting_journals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    entry_number VARCHAR(50) NOT NULL,
    entry_date DATE NOT NULL,
    description VARCHAR(255) NULL,
    source VARCHAR(20) NOT NULL DEFAULT 'manual',
    status VARCHAR(20) NOT NULL DEFAULT 'borrador',
    created_by INT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

CREATE TABLE accounting_journal_lines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    journal_id INT NOT NULL,
    account_id INT NOT NULL,
    line_description VARCHAR(255) NULL,
    debit DECIMAL(12,2) NOT NULL DEFAULT 0,
    credit DECIMAL(12,2) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (journal_id) REFERENCES accounting_journals(id),
    FOREIGN KEY (account_id) REFERENCES accounting_accounts(id)
);

CREATE TABLE tax_periods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    period VARCHAR(20) NOT NULL,
    iva_debito DECIMAL(12,2) NOT NULL DEFAULT 0,
    iva_credito DECIMAL(12,2) NOT NULL DEFAULT 0,
    remanente DECIMAL(12,2) NOT NULL DEFAULT 0,
    total_retenciones DECIMAL(12,2) NOT NULL DEFAULT 0,
    impuesto_unico DECIMAL(12,2) NOT NULL DEFAULT 0,
    status VARCHAR(20) NOT NULL DEFAULT 'pendiente',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE tax_withholdings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    period_id INT NULL,
    type VARCHAR(50) NOT NULL,
    base_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    rate DECIMAL(5,2) NOT NULL DEFAULT 0,
    amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (period_id) REFERENCES tax_periods(id)
);

CREATE TABLE honorarios_documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    provider_name VARCHAR(150) NOT NULL,
    provider_rut VARCHAR(50) NULL,
    document_number VARCHAR(50) NOT NULL,
    issue_date DATE NOT NULL,
    gross_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    retention_rate DECIMAL(5,2) NOT NULL DEFAULT 13,
    retention_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    net_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    status VARCHAR(20) NOT NULL DEFAULT 'pendiente',
    paid_at DATE NULL,
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE fixed_assets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(100) NULL,
    acquisition_date DATE NOT NULL,
    acquisition_value DECIMAL(12,2) NOT NULL DEFAULT 0,
    depreciation_method VARCHAR(30) NOT NULL DEFAULT 'linea_recta',
    useful_life_months INT NOT NULL DEFAULT 0,
    accumulated_depreciation DECIMAL(12,2) NOT NULL DEFAULT 0,
    book_value DECIMAL(12,2) NOT NULL DEFAULT 0,
    status VARCHAR(20) NOT NULL DEFAULT 'activo',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE bank_accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    bank_name VARCHAR(150) NULL,
    account_number VARCHAR(80) NULL,
    currency VARCHAR(10) NOT NULL DEFAULT 'CLP',
    current_balance DECIMAL(12,2) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE bank_transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    bank_account_id INT NOT NULL,
    transaction_date DATE NOT NULL,
    description VARCHAR(255) NULL,
    type VARCHAR(20) NOT NULL DEFAULT 'deposito',
    amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    balance DECIMAL(12,2) NOT NULL DEFAULT 0,
    reference VARCHAR(150) NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (bank_account_id) REFERENCES bank_accounts(id)
);

CREATE TABLE inventory_movements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    product_id INT NOT NULL,
    movement_date DATE NOT NULL,
    movement_type VARCHAR(20) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    unit_cost DECIMAL(12,2) NOT NULL DEFAULT 0,
    reference_type VARCHAR(50) NULL,
    reference_id INT NULL,
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE document_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(120) NOT NULL,
    color VARCHAR(20) NOT NULL DEFAULT '#6c757d',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    INDEX idx_document_categories_company (company_id),
    CONSTRAINT fk_document_categories_company
        FOREIGN KEY (company_id) REFERENCES companies(id)
        ON DELETE CASCADE
);

CREATE TABLE documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    category_id INT NULL,
    filename VARCHAR(255) NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    file_size INT NOT NULL DEFAULT 0,
    is_favorite TINYINT(1) NOT NULL DEFAULT 0,
    download_count INT NOT NULL DEFAULT 0,
    last_downloaded_at DATETIME NULL,
    deleted_at DATETIME NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    INDEX idx_documents_company (company_id),
    INDEX idx_documents_category (category_id),
    CONSTRAINT fk_documents_company
        FOREIGN KEY (company_id) REFERENCES companies(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_documents_category
        FOREIGN KEY (category_id) REFERENCES document_categories(id)
        ON DELETE SET NULL
);

CREATE TABLE document_shares (
    id INT AUTO_INCREMENT PRIMARY KEY,
    document_id INT NOT NULL,
    user_id INT NOT NULL,
    shared_by_user_id INT NOT NULL,
    created_at DATETIME NOT NULL,
    INDEX idx_document_shares_document (document_id),
    INDEX idx_document_shares_user (user_id),
    CONSTRAINT fk_document_shares_document
        FOREIGN KEY (document_id) REFERENCES documents(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_document_shares_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_document_shares_shared_by
        FOREIGN KEY (shared_by_user_id) REFERENCES users(id)
        ON DELETE CASCADE
);

CREATE TABLE calendar_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    created_by_user_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT NULL,
    event_type VARCHAR(20) NOT NULL DEFAULT 'meeting',
    location VARCHAR(150) NULL,
    start_at DATETIME NOT NULL,
    end_at DATETIME NULL,
    all_day TINYINT(1) NOT NULL DEFAULT 0,
    reminder_minutes INT NULL,
    class_name VARCHAR(100) NOT NULL DEFAULT 'bg-primary-subtle text-primary',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    INDEX idx_calendar_events_company (company_id),
    INDEX idx_calendar_events_start (start_at),
    CONSTRAINT fk_calendar_events_company
        FOREIGN KEY (company_id) REFERENCES companies(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_calendar_events_user
        FOREIGN KEY (created_by_user_id) REFERENCES users(id)
        ON DELETE CASCADE
);

CREATE TABLE calendar_event_documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    document_id INT NOT NULL,
    created_at DATETIME NOT NULL,
    UNIQUE KEY idx_calendar_event_document_unique (event_id, document_id),
    INDEX idx_calendar_event_documents_event (event_id),
    INDEX idx_calendar_event_documents_document (document_id),
    CONSTRAINT fk_calendar_event_documents_event
        FOREIGN KEY (event_id) REFERENCES calendar_events(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_calendar_event_documents_document
        FOREIGN KEY (document_id) REFERENCES documents(id)
        ON DELETE CASCADE
);

CREATE TABLE calendar_event_attendees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at DATETIME NOT NULL,
    UNIQUE KEY idx_calendar_event_attendee_unique (event_id, user_id),
    INDEX idx_calendar_event_attendees_event (event_id),
    INDEX idx_calendar_event_attendees_user (user_id),
    CONSTRAINT fk_calendar_event_attendees_event
        FOREIGN KEY (event_id) REFERENCES calendar_events(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_calendar_event_attendees_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
);
