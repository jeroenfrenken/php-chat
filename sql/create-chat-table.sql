CREATE TABLE chats(
    id  INTEGER PRIMARY KEY UNIQUE NOT NULL,
    owner_id INTEGER NOT NULL,
    recipient_id INTEGER NOT NULL,
    FOREIGN KEY(owner_id) REFERENCES users(id),
    FOREIGN KEY (recipient_id) REFERENCES users(id)
);
