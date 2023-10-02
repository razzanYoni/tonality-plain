INSERT INTO users (username, password, is_admin) VALUES 
('admin', 'admin', true),
('user1', 'user', false),
('user2', 'user', false)
;

INSERT INTO albums (album_name, release_date, genre, artist, cover_url) VALUES 
('album1', NOW(), 'genre1', 'artist1', 'cover1'),
('album2', NOW(), 'genre2', 'artist2', 'cover2'),
('album3', NOW(), 'genre3', 'artist3', 'cover3')
;

INSERT INTO playlists (user_id, playlist_name, description, cover_url) VALUES 
(1, 'playlist1', 'description1', 'cover1'),
(2, 'playlist2', 'description2', 'cover2'),
(3, 'playlist3', 'description3', 'cover3')
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
(3, 3),
(4, 1)
;
