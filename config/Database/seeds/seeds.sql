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
        'Doug et Griff sont amis d''enfance et partagent depuis toujours un objectif un peu fou : réaliser leur propre remake d''Anaconda en plein cœur de l''Amazonie. Mais le rêve vire rapidement au cauchemar lorsqu''un véritable serpent géant fait son apparition et transforme leur plateau déjà chaotique en un piège mortel. Le film qu''ils mourraient d''envie de faire… va vraiment devenir mortel !',
        'Aventure, Comédie, Horreur',
        'Tom Gormican',
        'Jack Black, Paul Rudd, Steve Zahn, Thandiwe Newton, Daniela Melchior',
        100,
        'https://image.tmdb.org/t/p/w500/5EbKjIowNw5yExzrhvu231GFVCf.jpg',
        '2025-12-24'
    ),
    (
        'Interstellar',
        'Dans un futur proche, face à une Terre exsangue, un groupe d''explorateurs utilise un vaisseau interstellaire pour franchir un trou de ver permettant de parcourir des distances jusque‐là infranchissables. Leur but : trouver un nouveau foyer pour l''humanité.',
        'Aventure, Drame, Science-Fiction',
        'Christopher Nolan',
        'Matthew McConaughey, Anne Hathaway, Michael Caine, Jessica Chastain, Casey Affleck',
        169,
        'https://image.tmdb.org/t/p/w500/1pnigkWWy8W032o9TKDneBa3eVK.jpg',
        '2014-11-05'
    ),
    (
        'Jujutsu Kaisen 0',
        'Lorsqu''il était enfant, Yuta Okkotsu a vu son amie Rika Orimoto perdre la vie dans un terrible accident. Depuis, Rika vient hanter Yuta qui a même souhaité sa propre mort après avoir souffert des années de cette malédiction. Jusqu''au jour où le plus puissant des exorcistes, Satoru Gojo, l''accueille dans l''école d''exorcisme de Tokyo. Tandis que Yuta trouve enfin un nouveau sens à sa vie, une menace plane sur le monde. En effet, quelqu''un projette de déchaîner un millier de malédictions sur Shinjuku et Kyoto pour exterminer tous les non-exorcistes…',
        'Animation, Action, Fantastique',
        '박성후',
        '緒方恵美, Kana Hanazawa, Yūichi Nakamura, Takahiro Sakurai, Mikako Komatsu',
        105,
        'https://image.tmdb.org/t/p/w500/jW4OW6ySAtP40BzUWgVmsApqyaS.jpg',
        '2021-12-24'
    ),
    (
        'Scream 7',
        'Lorsqu''un nouveau Ghostface surgit dans la paisible ville où Sidney Prescott a reconstruit sa vie, ses pires cauchemars refont surface. Alors que sa fille devient la prochaine cible, Sidney n''a d''autre choix que de reprendre le combat. Déterminée à protéger les siens, elle doit alors affronter les démons de son passé pour tenter de mettre fin une bonne fois pour toutes au bain de sang.',
        'Horreur, Mystère, Crime',
        'Kevin Williamson',
        'Neve Campbell, Courteney Cox, Isabel May, Jasmin Savoy Brown, Mason Gooding',
        114,
        'https://image.tmdb.org/t/p/w500/5LjnIdBqsGKftMuFmDQytkTeNOG.jpg',
        '2026-02-25'
    ),
    (
        'Zootopie 2',
        'Judy Hopps et Nick Wilde explorent à nouveau Zootopie, entre mystères, rires et rencontres inattendues. À travers chaque rue et chaque instant, ils découvrent que l''amitié et la curiosité transforment le quotidien en moments magiques.',
        'Animation, Comédie, Aventure, Familial, Mystère',
        'Jared Bush',
        'Ginnifer Goodwin, Jason Bateman, Ke Huy Quan, Fortune Feimster, Andy Samberg',
        108,
        'https://image.tmdb.org/t/p/w500/hBI7Wrps6tDjhEzBxJgoPLhbmT1.jpg',
        '2025-11-26'
    ),
    (
        'The Tank',
        'Front de l''Est, 1943 : l''équipage d''un char Tigre allemand se voit confier une dangereuse mission loin derrière les lignes de front âprement disputées. Durant leur traversée de ce no man''s land, ils doivent affronter l''ennemi ainsi que leurs propres démons.',
        'Guerre, Action, Drame',
        'Dennis Gansel',
        'Laurence Rupp, David Schütter, Sebastian Urzendowsky, Leonard Kunz, Yoran Leicher',
        117,
        'https://image.tmdb.org/t/p/w500/s8rCTOHsyM9vylRtpuQocVNQ5wO.jpg',
        '2025-09-18'
    ),
    (
        'Twisted',
        'Deux milléniaux gagnent rapidement de l''argent en louant d''incroyables appartements new-yorkais qui ne leur appartiennent pas à des personnes qui ne se doutent pas qu''elles se font escroquer. L''arnaque fonctionne à merveille jusqu''à ce qu''ils tombent sur un propriétaire d''appartement qui cache un sombre secret et qui retourne la situation à leur détriment.',
        'Horreur, Thriller',
        'Darren Lynn Bousman',
        'Djimon Hounsou, Lauren LaVera, Mia Healey, Neal McDonough, Alicia Witt',
        93,
        'https://image.tmdb.org/t/p/w500/AkRiuvV7R46xfMqUJWKyJ1fuSXh.jpg',
        '2026-02-06'
    ),
    (
        'Primate',
        'Au lieu de rimer avec plages et retrouvailles, le retour de Lucy sur son île tropicale natale tourne au cauchemar lorsque le chimpanzé de la famille, d''une intelligence exceptionnelle, sombre dans une frénésie enragée. La nuit se mue alors en un chaos terrifiant. En l''absence de son père et sans aucun secours possible, ce paradis devient une prison et Lucy et ses amis doivent affronter un prédateur mortel en qui ils avaient autrefois toute confiance.',
        'Horreur, Thriller',
        'Johannes Roberts',
        'Johnny Sequoyah, Jessica Alexander, Troy Kotsur, Victoria Wyant, Gia Hunter',
        89,
        'https://image.tmdb.org/t/p/w500/HtXHAH4PQjpw2RLsIrHGbeng1n.jpg',
        '2026-01-01'
    ),
    (
        'Hamnet',
        'Angleterre, 1580. Un professeur de latin fauché, fait la connaissance d''Agnes, jeune femme à l''esprit libre. Fascinés l''un par l''autre, ils entament une liaison fougueuse avant de se marier et d''avoir trois enfants. Tandis que Will tente sa chance comme dramaturge à Londres, Agnes assume seule les tâches domestiques. Lorsqu''un drame se produit, le couple, autrefois profondément uni, vacille. Mais c''est de leur épreuve commune que naîtra l''inspiration d''un chef d''œuvre universel.',
        'Drame, Romance, Histoire',
        'Chloé Zhao',
        'Jessie Buckley, Paul Mescal, Emily Watson, Joe Alwyn, Jacobi Jupe',
        125,
        'https://image.tmdb.org/t/p/w500/slwXcH3iTRUe9ywOa4teTSzAGeB.jpg',
        '2025-11-26'
    ),
    (
        'David',
        'Des chants du cœur de sa mère aux murmures d''un Dieu fidèle, l''histoire de David commence dans une dévotion silencieuse. Lorsque le géant Goliath se lève pour terroriser une nation, un jeune berger armé uniquement d''une fronde, de quelques pierres et d''une foi inébranlable s''avance. Poursuivi par le pouvoir et animé par un but précis, son parcours met à l''épreuve les limites de la loyauté, de l''amour et du courage, et culmine dans une bataille qui ne vise pas seulement la couronne, mais aussi l''âme d''un royaume.',
        'Animation, Familial, Drame',
        'Phil Cunningham',
        'Brandon Engman, Brian Stivale, Shahar Taboch, Aaron Tavaler, Hector',
        109,
        'https://image.tmdb.org/t/p/w500/bESlrLOrsQ9gKzaGQGHXKOyIUtX.jpg',
        '2025-12-14'
    ),
    (
        'Avatar : De feu et de cendres',
        'Après la mort de Neteyam, Jake et Neytiri affrontent leur chagrin tout en faisant face au Peuple des Cendres, une tribu Na''vi redoutable menée par le fougueux Varang, alors que le conflit sur Pandora s''intensifie et qu''une nouvelle quête morale s''amorce.',
        'Science-Fiction, Aventure, Fantastique',
        'James Cameron',
        'Sam Worthington, Zoe Saldaña, Sigourney Weaver, Stephen Lang, Oona Chaplin',
        198,
        'https://image.tmdb.org/t/p/w500/5BnOt0PRymp5mXuoKv1unQ9x8I8.jpg',
        '2025-12-17'
    ),
    (
        'Avatar',
        'Un marine paraplégique, envoyé sur la lune Pandora pour une mission unique, est tiraillé entre suivre ses ordres et protéger le monde qu''il considère dorénavant comme le sien.',
        'Action, Aventure, Fantastique, Science-Fiction',
        'James Cameron',
        'Sam Worthington, Zoe Saldaña, Sigourney Weaver, Stephen Lang, Michelle Rodriguez',
        166,
        'https://image.tmdb.org/t/p/w500/v5Y8pVwJK68SKQQ1GRbIB1hkPDy.jpg',
        '2009-12-16'
    ),
    (
        'GOAT : Rêver plus haut',
        'Will est un petit bouc avec de grands rêves. Lorsqu''il décroche une chance inespérée de rejoindre la ligue professionnelle de "roarball", un sport ultra-intense réservé aux bêtes les plus rapides et féroces, il entend bien saisir l''opportunité. Problème : ses nouveaux coéquipiers ne sont pas vraiment ravis d''avoir un "petit" dans l''équipe. Mais Will est prêt à tout pour changer les règles du jeu.',
        'Animation, Comédie, Familial, Action',
        'Tyree Dillihay',
        'Caleb McLaughlin, Gabrielle Union, Stephen Curry, Aaron Pierre, Nicola Coughlan',
        100,
        'https://image.tmdb.org/t/p/w500/9wwbYnU3HfAYqdjbFMhy2a8HYvr.jpg',
        '2026-02-11'
    ),
    (
        'Venom',
        'Des symbiotes débarquent sur la Terre, parmi eux, Venom, qui va s''allier avec Eddie Brock. De son côté, un puissant scientifique tente de faire évoluer l''humanité avec les symbiotes, le duo d''anti‐héros va devoir tout faire pour l''arrêter !',
        'Science-Fiction, Action',
        'Ruben Fleischer',
        'Tom Hardy, Michelle Williams, Riz Ahmed, Scott Haze, Reid Scott',
        112,
        'https://image.tmdb.org/t/p/w500/vVusHIRlyyFVS42XnqZso2wGKr.jpg',
        '2018-09-28'
    );

INSERT INTO
    users (fullname, email, password_hash, role)
VALUES
    (
        'Admin Alluile',
        'admin@alluilecine.fr',
        '$2y$10$ZftpH7UUfDxCEpyMAsk67u8Ed6Y.sv9q.8jNyGKQiSl4qWWZRdgnW',
        'admin'
    ),
    (
        'Jean Dupont',
        'jean.dupont@email.com',
        '$2y$10$ZftpH7UUfDxCEpyMAsk67u8Ed6Y.sv9q.8jNyGKQiSl4qWWZRdgnW',
        'user'
    ),
    (
        'Sophie Martin',
        'sophie.martin@email.com',
        '$2y$10$ZftpH7UUfDxCEpyMAsk67u8Ed6Y.sv9q.8jNyGKQiSl4qWWZRdgnW',
        'user'
    ),
    (
        'Lucas Bernard',
        'lucas.bernard@email.com',
        '$2y$10$ZftpH7UUfDxCEpyMAsk67u8Ed6Y.sv9q.8jNyGKQiSl4qWWZRdgnW',
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
