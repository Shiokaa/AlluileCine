USE AlluileCine;

INSERT INTO
    movies (
        title,
        description,
        genre,
        director,
        casting,
        duration,
        cover_image,
        release_date
    )
VALUES
    (
        'Anaconda',
        'Une équipe de tournage s\'aventure dans la forêt amazonienne et se retrouve traquée par un serpent géant.',
        'Action, Horreur',
        'Luis Llosa',
        'Jennifer Lopez, Ice Cube, Jon Voight',
        89,
        'anaconda.jpg',
        '1997-04-11'
    ),
    (
        'Interstellar',
        'Un groupe d\'explorateurs utilise une faille spatio-temporelle pour repousser les limites humaines et partir à la conquête des distances astronomiques dans un voyage interstellaire.',
        'Science-fiction, Drame',
        'Christopher Nolan',
        'Matthew McConaughey, Anne Hathaway, Jessica Chastain',
        169,
        'interstellar.jpg',
        '2014-11-05'
    ),
    (
        'Jujutsu Kaisen 0',
        'Yuta Okkotsu, un lycéen nerveux, s\'inscrit dans la mystérieuse école d\'exorcisme de Tokyo sous la tutelle de Satoru Gojo.',
        'Animation, Action',
        'Sunghoo Park',
        'Megumi Ogata, Kana Hanazawa, Mikako Komatsu',
        105,
        'jujutsu_kaisen.jpg',
        '2021-12-24'
    ),
    (
        'Scream 7',
        'Le nouveau chapitre de la franchise slasher emblématique.',
        'Horreur, Thriller',
        'Christopher Landon',
        'Neve Campbell, Courteney Cox',
        120,
        'scream_7.jpg',
        '2025-10-31'
    ),
    (
        'Zootopie 2',
        'Le duo de choc Judy et Nick se retrouve pour de nouvelles enquêtes au cœur de la métropole animalière.',
        'Animation, Aventure',
        'Byron Howard',
        'Ginnifer Goodwin, Jason Bateman',
        100,
        'zootopie_2.jpg',
        '2025-11-26'
    ),
    (
        'The Tank',
        'Après avoir hérité d\'une propriété côtière abandonnée, une famille libère accidentellement une créature ancienne qui terrorisait la région depuis des générations.',
        'Horreur, Thriller',
        'Scott Walker',
        'Luciane Buchanan, Matt Whelan',
        100,
        'the_tank.jpg',
        '2023-04-25'
    ),
    (
        'Twisted',
        'Une inspectrice de police dont les ex-petits amis sont assassinés devient la principale suspecte de l\'enquête.',
        'Thriller, Policier',
        'Philip Kaufman',
        'Ashley Judd, Samuel L. Jackson',
        97,
        'twisted.jpg',
        '2004-02-27'
    ),
    (
        'Primate',
        'Un documentaire saisissant sur la vie des primates dans leur habitat naturel.',
        'Documentaire',
        'Inconnu',
        'Narrateur inconnu',
        90,
        'primate.jpg',
        '2024-01-01'
    ),
    (
        'Hamnet',
        'L\'histoire de la courte vie du fils de Shakespeare, Hamnet, et l\'impact de sa mort sur la famille.',
        'Drame, Historique',
        'Chloé Zhao',
        'Paul Mescal, Jessie Buckley',
        120,
        'hamnet.jpg',
        '2025-01-01'
    ),
    (
        'David',
        'L\'histoire biblique du roi David, de berger à monarque légendaire.',
        'Action, Historique',
        'Inconnu',
        'Inconnu',
        110,
        'david.jpg',
        '2025-01-01'
    );

INSERT INTO
    users (fullname, email, password_hash, role)
VALUES
    (
        'Admin Alluile',
        'admin@alluilecine.fr',
        'password123',
        'admin'
    ),
    (
        'Jean Dupont',
        'jean.dupont@email.com',
        'password123',
        'user'
    ),
    (
        'Sophie Martin',
        'sophie.martin@email.com',
        'password123',
        'user'
    ),
    (
        'Lucas Bernard',
        'lucas.bernard@email.com',
        'password123',
        'user'
    );

INSERT INTO
    rooms (name, capacity)
VALUES
    ('Salle 1 - Le Grand Rex', 50),
    ('Salle 2 - Jupiter', 30),
    ('Salle 3 - VIP Lounge', 10);

-- Sièges pour la Salle 1 (ID 1)
INSERT INTO
    seats (id, room_id, number)
VALUES
    (1, 1, 1),
    (2, 1, 2),
    (3, 1, 3),
    (4, 1, 4),
    (5, 1, 5);

-- Sièges pour la Salle 2 (ID 2)
INSERT INTO
    seats (id, room_id, number)
VALUES
    (6, 2, 1),
    (7, 2, 2),
    (8, 2, 3),
    (9, 2, 4),
    (10, 2, 5);

-- Sièges pour la Salle 3 (ID 3)
INSERT INTO
    seats (id, room_id, number)
VALUES
    (11, 3, 1),
    (12, 3, 2),
    (13, 3, 3),
    (14, 3, 4),
    (15, 3, 5);

INSERT INTO
    sessions (movie_id, room_id, start_time, start_day)
VALUES
    -- Film 1 joue dans la Salle 1 à 14h
    (1, 1, '2023-11-25 14:00:00', '2023-11-25'),
    -- Film 1 joue dans la Salle 1 à 18h
    (1, 1, '2023-11-25 18:00:00', '2023-11-25'),
    -- Film 2 joue dans la Salle 2 (plus petite)
    (2, 2, '2023-11-25 20:30:00', '2023-11-25'),
    -- Film 3 joue dans la Salle VIP
    (3, 3, '2023-11-26 21:00:00', '2023-11-26');

-- Jean réserve pour la Session 1 (Salle 1) -> Il prend le siège 1 (qui est dans la salle 1)
INSERT INTO
    reservations (user_id, session_id, seat_id)
VALUES
    (2, 1, 1);

-- Sophie réserve aussi pour la Session 1 (Salle 1) -> Elle prend le siège 2
INSERT INTO
    reservations (user_id, session_id, seat_id)
VALUES
    (3, 1, 2);

-- Lucas réserve pour la Session 3 (Salle 2) -> Il doit prendre un siège de la salle 2 (ex: ID 6)
INSERT INTO
    reservations (user_id, session_id, seat_id)
VALUES
    (4, 3, 6);

-- Jean revient le lendemain pour la Session 4 (Salle VIP) -> Il prend le siège 11
INSERT INTO
    reservations (user_id, session_id, seat_id)
VALUES
    (2, 4, 11);