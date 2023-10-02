create table if not exists users
(
    user_id  int unsigned auto_increment primary key,
    username varchar(50)  not null,
    password varchar(255) not null,
    is_admin boolean default false
) character set utf8;

create table if not exists albums
(
    album_id     int unsigned auto_increment primary key,
    album_name   varchar(255) not null,
    release_date date         not null,
    genre        varchar(50)  not null,
    artist       varchar(255) not null,
    cover_url    varchar(255) not null
) character set utf8;

create table if not exists songs
(
    song_id     int unsigned auto_increment primary key,
    album_id    int unsigned not null references albums,
    title       varchar(255) not null,
    artist      varchar(255) not null,
    song_number smallint     not null,
    disc_number smallint,
    duration    integer      not null,
    audio_url   varchar(255) not null
) character set utf8;

create table if not exists playlists
(
    playlist_id   int unsigned auto_increment primary key,
    user_id       int unsigned not null references users,
    playlist_name varchar(50)  not null,
    description   text,
    cover_url     varchar(255) not null
) character set utf8;

create table if not exists appears_on
(
    song_id     int unsigned references songs,
    playlist_id int unsigned references playlists,
    primary key (song_id, playlist_id)
) character set utf8;
