DELETE FROM categories WHERE Super = '0';
DELETE FROM categories;

INSERT INTO categories (CID,Super,Name) VALUES (1, 0, 'Alles mögliche');

INSERT INTO categories (CID,Super,Name) VALUES (2, 1, 'Witze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (3, 2, 0, 'Alkoholwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (4, 2, 0, 'Antiwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (5, 2, 0, 'Arztwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (6, 2, 0, 'Beamtenwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (7, 2, 0, 'Blondinenwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (8, 2, 0, 'DDR Witze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (9, 2, 0, 'Donald Trump');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (10, 2, 0, 'Dummhausen');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (11, 2, 0, 'Elternwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (12, 2, 0, 'Fiese Witze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (13, 2, 0, 'Flachwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (14, 2, 0, 'Frauenwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (15, 2, 0, 'Fritzchen');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (16, 2, 0, 'Fußballwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (17, 2, 0, 'Gamer Witze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (18, 2, 0, 'Häschenwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (19, 2, 0, 'Kinderwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (20, 2, 0, 'Kurzwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (21, 2, 0, 'Männerwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (22, 2, 0, 'Musikerwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (23, 2, 0, 'Nationenwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (24, 2, 0, 'Ostfriesenwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (25, 2, 0, 'Politikwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (26, 2, 0, 'Polizeiwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (27, 2, 0, 'Schülerwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (28, 2, 0, 'Schwarzer Humor');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (29, 2, 0, 'Studentenwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (30, 2, 0, 'Tier Witze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (31, 2, 0, 'Unanständige Witze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (32, 2, 0, 'Veganer Witze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (33, 2, 0, 'Witze');

INSERT INTO categories (CID,Super,Name) VALUES (34, 1, 'Lustiges');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (35, 34, 0, 'Alle Kinder...');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (36, 34, 0, 'Chuck Norris');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (37, 34, 0, 'Deine Mutter Witze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (38, 34, 0, 'Die letzten Worte...');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (39, 34, 0, 'Dieser Moment, wenn...');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (40, 34, 0, 'Illuminati confirmed');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (41, 34, 0, 'Lustige Abkürzungen');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (42, 34, 0, 'Lustige Chats');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (43, 34, 0, 'Lustige Fails');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (44, 34, 0, 'Lustige Ortsnamen');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (45, 34, 0, 'Lustige Pornotitel');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (46, 34, 0, 'Personenwitze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (47, 34, 0, 'Scherzfragen');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (48, 34, 0, 'Wenn mir langweilig ist...');

INSERT INTO categories (CID,Super,Name) VALUES (49, 1, 'Geschichten und Gruseliges');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (50, 49, 0, 'Creepypasta');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (51, 49, 0, 'Fanfiction');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (52, 49, 0, 'Geschichten');

INSERT INTO categories (CID,Super,Name) VALUES (53, 1, 'Zitate');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (54, 53, 0, 'Buchzitate');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (55, 53, 0, 'Filmzitate');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (56, 53, 0, 'Serienzitate');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (57, 53, 0, 'Zitate');

INSERT INTO categories (CID,Super,Name) VALUES (58, 1, 'Sprüche');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (59, 58, 0, 'Anmachsprüche');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (60, 58, 0, 'Fiese Sprüche');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (61, 58, 0, 'Kontersprüche');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (62, 58, 0, 'Sprüche');

INSERT INTO categories (CID,Super,Name) VALUES (63, 1, 'Sonstiges');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (64, 63, 0, 'Freundschaft');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (65, 63, 0, 'Pranks');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (66, 63, 0, 'Reime');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (67, 63, 0, 'Romantik');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (68, 63, 0, 'Zungenbrecher');

INSERT INTO categories (CID,Super,Name) VALUES (69, 1, 'Diskussion');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (70, 69, 0, 'Anime');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (71, 69, 0, 'Beichtstuhl');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (72, 69, 0, 'Film');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (73, 69, 0, 'Lebenshilfe');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (74, 69, 0, 'Musik');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (75, 69, 0, 'Rätsel');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (76, 69, 0, 'Serien');

INSERT INTO categories (CID,Super,Name) VALUES (77, 1, 'Fakten und Wissenswertes');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (78, 77, 0, 'Dumme Gesetze');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (79, 77, 0, 'Fakt ist...');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (80, 77, 0, 'Horrorfakten');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (81, 77, 0, 'Lifehacks');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (82, 77, 0, 'Mythen - Wahr oder Falsch');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (83, 77, 0, 'Schlagzeile');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (84, 77, 0, 'Unnützes Wissen');

INSERT INTO categories (CID,Super,Name) VALUES (85, 1, 'Vorschläge');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (86, 85, 0, 'Kategorievorschläge');
INSERT INTO categories (CID,Parent,Super,Name) VALUES (87, 85, 0, 'Verbesserungsvorschläge');
