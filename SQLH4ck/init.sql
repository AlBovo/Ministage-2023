DROP TABLE IF EXISTS `users`; -- Drop the table if it already exists
CREATE TABLE users (
    id INTEGER AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);
INSERT INTO users (username, password) VALUES ('admin', '1LG4bB1BB0n3T1V3d3');
INSERT INTO users (username, password) VALUES ('paolo', 'skillIssueFortissima');
INSERT INTO users (username, password) VALUES ('olimpiadi', 'cybersecurity');
INSERT INTO users (username, password) VALUES ('pippo', 'pluto');
INSERT INTO users (username, password) VALUES ('cecca', 'Z3r0Asp3tt4t1v3!?');

DROP TABLE IF EXISTS `notes`; -- Drop the table if it already exists
CREATE TABLE notes (
    user_id INTEGER NOT NULL,
    title VARCHAR(20) NOT NULL,
    content VARCHAR(300) NOT NULL
);
INSERT INTO notes (user_id, title, content) VALUES (1, 'Flag', 'flag{N0w-Y0u-Kn0W-h0W_T0/H4ck/4-D4t4b4s3}');
INSERT INTO notes (user_id, title, content) VALUES (2, 'Domande da fare', 'Adesso che hai letto questo messaggio devi chiedere a Paolo come si implementa un treap');
INSERT INTO notes (user_id, title, content) VALUES (3, 'Migliori Olimpiadi', 'Le migliori olimpiadi sono quelle di Olicyber (mi ha obbligato il gabibbo a scriverlo)');
INSERT INTO notes (user_id, title, content) VALUES (4, 'Crimini di Guerra', 'Io (Pippo) e il mio amico Pluto abbiamo commesso molteplici crimini di guerra in Vietnam e Corea');
INSERT INTO notes (user_id, title, content) VALUES (5, 'Zero Aspettative', '<iframe style="border-radius:12px" src="https://open.spotify.com/embed/track/1mVeGyonJ7nIJt0lNdeEUr?utm_source=generator" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>');