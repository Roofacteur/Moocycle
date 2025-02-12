USE bd_moocycle;
INSERT INTO tbl_vaches (nom, numero_collier, numero_oreille, date_prochaine_chaleur, date_derniere_chaleur, date_insemination, date_naissance, nombre_lactation)
VALUES 
('Valeriane', 31, '120.1576.5091.9', '0000-00-00', '2025-01-12', '0000-00-00', '2020-11-29', 2),
('Doudoune', 42, '120.1097.6625.5', '0000-00-00', '2024-02-12', '0000-00-00', '2013-11-14', 9),
('Fionna', 25, '120.1576.5069.8', '0000-00-00', '2025-03-12', '0000-00-00', '2020-09-12', 2),
('Carotte', 72, '120.1220.5544.2', '0000-00-00', '2025-04-12', '0000-00-00', '2015-12-17', 7),
('Doreen', 88, '120.1495.4401.1', '0000-00-00', '2025-05-12', '0000-00-00', '2015-12-17', 7),
('Valomer', 57, '120.1220.5563.3', '0000-00-00', '2025-06-12', '0000-00-00', '2016-04-21', 6);


INSERT INTO tbl_races (nom)
VALUES ("Holstein"),
    ("Charolaise"),
    ("Limousine"),
    ("Normande"),
    ("Montbéliarde"),
    ("Salers"),
    ("Tarentaise"),
    ("Aubrac"),
    ("Brune des Alpes"),
    ("Vosgienne"),
    ("Gasconne"),
    ("Parthenaise"),
    ("Rouge Flamande"),
    ("Pie Rouge"),
    ("Abondance"),
    ("Simmental"),
    ("Hereford"),
    ("Angus"),
    ("Jersey"),
    ("Guernesey"),
    ("Blonde d'Aquitaine"),
    ("Bleue du Nord"),
    ("Pie Noire Bretonne"),
    ("Maine-Anjou"),
    ("Galloway"),
    ("Dexter"),
    ("Highland"),
    ("Bazadaise"),
    ("Shorthorn"),
    ("Devon"),
    ("Longhorn"),
    ("Red Poll"),
    ("Beefmaster"),
    ("Brahman"),
    ("Santa Gertrudis"),
    ("Nelore"),
    ("Gir"),
    ("Sahiwal"),
    ("Tharparkar");
INSERT INTO tbl_racevache (num_tblVache, num_tblRace)
VALUES (1, 5), (2, 5), (3,4), (4,4), (5, 4), (6,3);
INSERT INTO tbl_logs (date, insemination, num_tblVache)
VALUES
('2025-01-15', false, 1),
('2025-02-20', false, 2),
('2025-03-10', false, 3),
('2025-04-05', false, 4),
('2025-05-12', false, 5),
('2025-06-18', false, 6),
('2025-02-02', false, 1);