create table if not exists users
(
    user_id  int unsigned auto_increment,
    username varchar(50)  not null,
    password varchar(255) not null,
    is_admin boolean default false,
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
    album_id    int unsigned not null,
    title       varchar(255) not null,
    artist      varchar(255) not null,
    song_number smallint     not null,
    disc_number smallint,
    duration    int          not null,
    audio_url   varchar(255) not null,
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
