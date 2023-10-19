CREATE TABLE IF NOT EXISTS users (
    id INTEGER AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);
INSERT INTO users (username, password) VALUES ('admin', '1LG4bB1BB0n3T1V3d3');
INSERT INTO users (username, password) VALUES ('paolo', 'skillIssueFortissima');
INSERT INTO users (username, password) VALUES ('olimpiadi', 'cybersecurity');
INSERT INTO users (username, password) VALUES ('pippo', 'pluto');

/*
CREATE TABLE IF NOT EXISTS notes (
    id INTEGER AUTO_INCREMENT,
    user_id INTEGER NOT NULL,
    title VARCHAR(10) NOT NULL,
    content VARCHAR(200) NOT NULL,
    PRIMARY KEY (id)
);
INSERT INTO notes (user_id, title, content) VALUES (0, 'Flag', 'flag{N0w-Y0u-Kn0W-h0W_T0/H4ck/4-D4t4b4s3}');
*/