CREATE TABLE users(
    id  INTEGER PRIMARY KEY NOT NULL UNIQUE,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    token TEXT NOT NULL UNIQUE,
    token_created TEXT NOT NULL
);


CREATE TABLE chats(
    id  INTEGER PRIMARY KEY UNIQUE NOT NULL,
    owner_id INTEGER NOT NULL,
    recipient_id INTEGER NOT NULL,
    FOREIGN KEY(owner_id) REFERENCES users(id),
    FOREIGN KEY (recipient_id) REFERENCES users(id)
);

CREATE TABLE messages(
    id INTEGER PRIMARY KEY UNIQUE NOT NULL,
    chat_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    message TEXT NOT NULL,
    FOREIGN KEY(chat_id) REFERENCES chats(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);


