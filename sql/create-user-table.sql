CREATE TABLE users(
    id  INTEGER PRIMARY KEY NOT NULL UNIQUE,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    token TEXT NOT NULL UNIQUE,
    token_created TEXT NOT NULL
);
