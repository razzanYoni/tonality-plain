create table if not exists users
(
    user_id  serial primary key,
    username varchar(50)  not null,
    password varchar(255) not null,
    is_admin boolean default false
) CHARACTER SET utf8;

create table if not exists albums
(
    album_id     serial primary key,
    album_name   varchar(255) not null,
    release_date date         not null,
    genre        varchar(50)  not null,
    artist       varchar(255) not null,
    cover_url    varchar(255) not null
) CHARACTER SET utf8;

create table if not exists songs
(
    song_id     serial primary key,
    album_id    serial references albums,
    title       varchar(255) not null,
    artist      varchar(255) not null,
    song_number smallint     not null,
    disc_number smallint,
    duration    integer      not null,
    audio_url   varchar(255) not null
) CHARACTER SET utf8;

create table if not exists playlists
(
    playlist_id   serial primary key,
    user_id       varchar(36)  not null references users,
    playlist_name varchar(50)  not null,
    description   text,
    cover_url     varchar(255) not null
) CHARACTER SET utf8;

create table if not exists appears_on
(
    song_id     serial primary key references songs,
    playlist_id serial primary key references playlists
) CHARACTER SET utf8;