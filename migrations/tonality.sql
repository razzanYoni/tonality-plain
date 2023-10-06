create table if not exists users
(
    user_id  int unsigned auto_increment,
    username varchar(50) unique not null,
    password varchar(255) not null,
    is_admin boolean not null default false,
    primary key (user_id)
) character set utf8;

create table if not exists albums
(
    album_id     int unsigned auto_increment,
    album_name   varchar(255) not null,
    release_date date         not null,
    genre        varchar(50)  not null,
    artist       varchar(255) not null,
    cover_url    varchar(255) not null,
    primary key (album_id)
) character set utf8;

create table if not exists songs
(
    song_id     int unsigned auto_increment,
    album_id    int unsigned      not null,
    title       varchar(255)      not null,
    artist      varchar(255)      not null,
    song_number smallint unsigned not null,
    disc_number smallint unsigned,
    duration    int unsigned      not null,
    audio_url   varchar(255)      not null,
    primary key (song_id),
    foreign key (album_id) references albums (album_id)
) character set utf8;

create table if not exists playlists
(
    playlist_id   int unsigned auto_increment,
    user_id       int unsigned not null,
    playlist_name varchar(50)  not null,
    description   text,
    cover_url     varchar(255) not null,
    primary key (playlist_id),
    foreign key (user_id) references users (user_id)
) character set utf8;

create table if not exists appears_on
(
    song_id     int unsigned not null,
    playlist_id int unsigned not null,
    primary key (song_id, playlist_id),
    foreign key (song_id) references songs (song_id),
    foreign key (playlist_id) references playlists (playlist_id)
) character set utf8;


INSERT INTO users (username, password, is_admin) VALUES 
('admin', '$2y$10$RtzpjVTqsEeKl4FRZbVp/OZEMfbr9Jt6SaO6lxQLfbIwnW8kbzgF.', true),
('user', '$2y$10$RtzpjVTqsEeKl4FRZbVp/OZEMfbr9Jt6SaO6lxQLfbIwnW8kbzgF.', false)
;

INSERT INTO albums (album_name, release_date, genre, artist, cover_url) VALUES 
('album1', NOW(), 'genre1', 'artist1', 'cover1'),
('album2', NOW(), 'genre2', 'artist2', 'cover2'),
('album3', NOW(), 'genre3', 'artist3', 'cover3')
;

INSERT INTO playlists (user_id, playlist_name, description, cover_url) VALUES 
(1, 'playlist1', 'description1', 'cover1'),
(2, 'playlist2', 'description2', 'cover2')
;

INSERT INTO songs (album_id, title, artist, song_number, disc_number, duration, audio_url) VALUES 
(1, 'song1', 'artist1', 1, 1, 100, 'audio1'),
(2, 'song2', 'artist2', 1, 1, 200, 'audio2'),
(3, 'song3', 'artist3', 1, 1, 300, 'audio3'),
(3, 'song4', 'artist4', 2, 1, 400, 'audio4')
;

INSERT INTO appears_on (song_id, playlist_id) VALUES 
(1, 1),
(2, 2),
(4, 1)
;
