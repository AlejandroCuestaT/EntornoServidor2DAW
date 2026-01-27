CREATE DATABASE IF NOT EXISTS inmobiliaria;
USE inmobiliaria;


CREATE USER IF NOT EXISTS 'web'@'localhost' IDENTIFIED BY '1234';
GRANT SELECT, INSERT, UPDATE, DELETE ON inmobiliaria.* TO 'web'@'localhost';

CREATE TABLE IF NOT EXISTS noticias (
    id int(5) NOT NULL AUTO_INCREMENT,
    titulo varchar(100) NOT NULL DEFAULT '',
    texto text NOT NULL,
    categoria enum('promociones','ofertas','costas') NOT NULL DEFAULT 'promociones',
    fecha date DEFAULT NULL,
    imagen varchar(100) DEFAULT NULL,
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS votos;

CREATE TABLE IF NOT EXISTS votos (
    id tinyint(3) unsigned NOT NULL auto_increment,
    votosSi int(10) unsigned NOT NULL default '0', 
    votosNo int(10) unsigned NOT NULL default '0', 
    PRIMARY KEY (id)
) ENGINE=InnoDB;

INSERT INTO votos (id, votosSi, votosNo) VALUES (1, 49, 12);

INSERT INTO noticias (titulo, texto, categoria, fecha, imagen) VALUES
('Piso con vistas a la Giralda', 'Exclusiva propiedad en el corazón de Sevilla, techos altos y balcones de forja.', 'promociones', '2023-05-12', NULL),
('Estudio minimalista en la costa', 'A solo 50 metros del agua, ideal para fines de semana. Bajo mantenimiento.', 'costas', '2023-05-15', NULL),
('Liquidación: Local en bruto', 'Espacio diáfano de 120m2. Ideal para cualquier tipo de negocio o almacén.', 'ofertas', '2023-05-18', NULL),
('Adosado con solárium privado', 'Urbanización con 3 piscinas y amplias zonas verdes. Muy luminoso.', 'promociones', '2023-05-20', 'adosado2.jpg'),
('Apartamento con encanto rústico', 'Vigas de madera originales y suelos de barro cocido. Zona muy tranquila.', 'ofertas', '2023-05-22', NULL),
('Chalet con vistas a la montaña', 'Parcela de 1000m2 con árboles frutales y zona de barbacoa.', 'promociones', '2023-05-25', NULL),
('Piso para estudiantes', 'Cuatro dormitorios, dos baños y cocina amplia. Cerca de paradas de metro.', 'ofertas', '2023-05-28', NULL),
('Bajo con patio interior', 'Patio de 25 metros cuadrados, ideal para mascotas. Edificio con pocos vecinos.', 'promociones', '2023-06-01', NULL),
('Villa mediterránea', 'Arquitectura clásica, gran porche y acceso privado a la playa.', 'costas', '2023-06-03', 'villa3.jpg'),
('Oportunidad: Loft reformado', 'Antigua nave transformada en vivienda de lujo. Estilo neoyorquino.', 'ofertas', '2023-06-05', NULL),
('Nueva promoción: Edificio Aurora', 'Viviendas sostenibles con placas solares y aerotermia instalada.', 'promociones', '2023-06-08', NULL),
('Apartamento en puerto deportivo', 'Vistas a los yates, terraza amplia y plaza de parking incluida.', 'costas', '2023-06-10', 'puerto1.jpg'),
('Piso céntrico con trastero', 'Reformado hace dos años, aire acondicionado en todas las estancias.', 'ofertas', '2023-06-12', NULL),
('Dúplex con vistas al campo', 'Zona residencial muy familiar con colegios y parques cercanos.', 'promociones', '2023-06-15', NULL),
('Casa de pescadores rehabilitada', 'En el casco antiguo, a pasos del mar. Decoración marinera incluida.', 'costas', '2023-06-18', NULL),
('Local adaptado para clínica', 'Cumple con todas las normativas, tres consultas y sala de espera.', 'ofertas', '2023-06-20', NULL),
('Piso con terraza acristalada', 'Disfruta de la terraza tanto en invierno como en verano. Vistas despejadas.', 'promociones', '2023-06-22', NULL),
('Bungalow en planta baja', 'Sin escaleras, acceso adaptado y piscina comunitaria justo enfrente.', 'costas', '2023-06-25', NULL),
('Atención inversores: Piso alquilado', 'Venta con inquilino solvente, rentabilidad desde el primer día.', 'ofertas', '2023-06-28', NULL),
('Residencial con club social', 'Gimnasio, sauna y salón para eventos disponible para propietarios.', 'promociones', '2023-07-01', NULL),
('Ático con jacuzzi', 'Terraza privada con jacuzzi y zona de chill-out. Máxima privacidad.', 'costas', '2023-07-03', 'atico_lujo.jpg'),
('Piso económico en la periferia', 'Bien comunicado por autovía, ideal para primera vivienda.', 'ofertas', '2023-07-05', NULL),
('Casa de campo con piscina', 'Entorno rural a 15 minutos de la ciudad. Ideal para teletrabajar.', 'promociones', '2023-07-08', NULL),
('Estudio en zona turística', 'Licencia vacacional en trámite. Gran potencial de ingresos en verano.', 'costas', '2023-07-10', NULL),
('Bajada de precio: Local comercial', 'Antes 120.000€, ahora 95.000€. Liquidación por jubilación.', 'ofertas', '2023-07-12', NULL),
('Piso con cocina office', 'Cocina de 20 metros con isla central, ideal para amantes de la cocina.', 'promociones', '2023-07-15', NULL),
('Apartamento con vistas al faro', 'Zona protegida, tranquilidad absoluta y puestas de sol increíbles.', 'costas', '2023-07-18', NULL),
('Oficina diáfana en centro técnico', 'Suelo técnico, fibra óptica y seguridad privada en el edificio.', 'ofertas', '2023-07-20', NULL),
('Casa unifamiliar con sótano', 'Sótano de 80m2 preparado como sala de juegos y cine.', 'promociones', '2023-07-22', NULL),
('Piso reformado con domótica', 'Persianas eléctricas, luces inteligentes y control de temperatura por voz.', 'promociones', '2023-07-25', NULL),
('Ático en pleno centro', 'Espectacular ático con terraza de 40 metros cuadrados y vistas a la catedral.', 'promociones', '2023-01-10', NULL),
('Apartamento en primera línea', 'Salida directa a la playa, 2 dormitorios y piscina comunitaria.', 'costas', '2023-01-12', 'playa1.jpg'),
('Chalet independiente en Aljarafe', 'Gran jardín propio, 4 dormitorios y club social con piscina.', 'promociones', '2023-01-15', NULL),
('Estudio para inversores', 'Alta rentabilidad demostrable, ideal para alquiler turístico o estudiantes.', 'ofertas', '2023-01-18', NULL),
('Duplex con encanto', 'Situado en edificio rehabilitado, techos altos y vigas de madera vista.', 'promociones', '2023-01-20', 'duplex.jpg'),
('Piso reformado en Triana', 'Cerca del río, totalmente equipado y listo para entrar a vivir.', 'ofertas', '2023-01-22', NULL),
('Parcela urbanizable', 'Terreno de 500m2 en zona en expansión, ideal para construir tu propia casa.', 'promociones', '2023-01-25', NULL),
('Bungalow con vistas al mar', 'Ubicado en urbanización privada con vigilancia 24 horas.', 'costas', '2023-01-28', 'bungalow.jpg'),
('Local comercial céntrico', 'Gran escaparate a calle peatonal, mucha visibilidad y paso de gente.', 'ofertas', '2023-02-01', NULL),
('Loft de diseño', 'Estilo industrial, espacios abiertos y mucha luz natural.', 'promociones', '2023-02-05', 'loft.jpg'),
('Villa de lujo en Marbella', 'Piscina infinita, gimnasio privado y cine en casa.', 'costas', '2023-02-08', 'marbella.jpg'),
('Piso económico para reformar', 'Gran oportunidad para crear la vivienda de tus sueños desde cero.', 'ofertas', '2023-02-10', NULL),
('Adosado con patio andaluz', 'Vivienda tradicional con todas las comodidades modernas.', 'promociones', '2023-02-12', NULL),
('Apartamento vacacional', 'Rentabilidad asegurada en la zona de la Costa del Sol.', 'costas', '2023-02-15', NULL),
('Oficina en zona de negocios', 'Amueblada y con todos los servicios incluidos, lista para trabajar.', 'ofertas', '2023-02-18', NULL),
('Piso familiar con garaje', 'Tres dormitorios amplios, plaza de garaje y trastero incluidos.', 'promociones', '2023-02-20', NULL),
('Cabaña de madera cerca del mar', 'Entorno natural privilegiado, ideal para desconectar.', 'costas', '2023-02-22', 'cabana.jpg'),
('Bajada de precio: Piso en el centro', 'Urgente vender por traslado, excelente ubicación.', 'ofertas', '2023-02-25', NULL),
('Nueva fase: Residencial Sol', 'Viviendas de 2 y 3 dormitorios con zonas comunes de lujo.', 'promociones', '2023-02-28', NULL),
('Apartamento con solárium', 'Disfruta del sol todo el año en tu propia terraza privada.', 'costas', '2023-03-02', NULL),
('Piso con balcón al parque', 'Vistas despejadas y zona muy tranquila para vivir.', 'promociones', '2023-03-05', NULL),
('Liquidación de activos', 'Lote de trasteros y plazas de garaje a precios imbatibles.', 'ofertas', '2023-03-08', NULL),
('Chalet con olivos', 'Finca rústica con vivienda legalizada y pozo propio.', 'promociones', '2023-03-10', NULL),
('Estudio moderno en la costa', 'A pocos metros del paseo marítimo, amueblado con gusto.', 'costas', '2023-03-12', NULL),
('Casa palacio para hotel', 'Edificio histórico con muchas posibilidades de negocio.', 'ofertas', '2023-03-15', NULL),
('Piso cerca de la universidad', 'Ideal para estudiantes, totalmente reformado.', 'promociones', '2023-03-18', NULL),
('Residencial con pistas de pádel', 'Viviendas modernas con instalaciones deportivas incluidas.', 'promociones', '2023-03-20', NULL),
('Vivienda con acceso a cala', 'Privacidad total en una de las mejores zonas de la costa.', 'costas', '2023-03-22', NULL),
('Descuento del 10% este mes', 'Promoción especial para las últimas unidades en venta.', 'ofertas', '2023-03-25', NULL),
('Bajo con jardín privado', 'Sensación de vivir en una casa pero con servicios de comunidad.', 'promociones', '2023-03-28', NULL),
('Piso con vistas a la bahía', 'Despierta cada mañana viendo el mar desde tu ventana.', 'costas', '2023-04-01', 'bahia.jpg'),
('Inversión: Edificio completo', 'Seis viviendas y local, rentabilidad neta del 7%.', 'ofertas', '2023-04-04', NULL),
('Piso de lujo con domótica', 'Controla toda tu casa desde el móvil, eficiencia energética A.', 'promociones', '2023-04-07', NULL),
('Apartamento junto al faro', 'Zona emblemática y muy tranquila, ideal para jubilación.', 'costas', '2023-04-10', NULL),
('Oferta: Garajes en zona centro', 'Plazas amplias y de fácil acceso.', 'ofertas', '2023-04-12', NULL),
('Casa de pueblo reformada', 'Mantiene la esencia con acabados de alta calidad.', 'promociones', '2023-04-15', NULL),
('Residencial con piscina climatizada', 'Disfruta del baño también en invierno.', 'promociones', '2023-04-18', NULL),
('Piso en zona de moda', 'Cerca de restaurantes y zonas de ocio.', 'ofertas', '2023-04-20', NULL),
('Estudio con vistas al puerto', 'Pequeño pero funcional, ideal para una persona.', 'costas', '2023-04-22', NULL),
('Dúplex con dos terrazas', 'Diferentes orientaciones para tener sol todo el día.', 'promociones', '2023-04-25', NULL),
('Ocasión: Local para oficina', 'Muy luminoso, ideal para profesionales liberales.', 'ofertas', '2023-04-28', NULL),
('Chalet con huerto propio', 'Espacio para cultivar tus propias verduras.', 'promociones', '2023-05-01', NULL),
('Piso con cocina de isla', 'Diseño moderno y abierto al salón.', 'promociones', '2023-05-04', NULL),
('Apartamento con aire centralizado', 'Olvídate del calor este verano.', 'costas', '2023-05-07', NULL),
('Última unidad disponible', 'Precio rebajado para cerrar la promoción.', 'ofertas', '2023-05-10', NULL);