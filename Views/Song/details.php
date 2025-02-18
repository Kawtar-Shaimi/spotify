<?php require_once __DIR__ . '/../layout/main.php'; ?>

<div class="bg-gradient-to-b from-[#1DB954] to-spotify-dark min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-[#181818] rounded-lg shadow-xl overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Song Cover -->
                    <div class="w-full md:w-1/3">
                        <div class="relative group">
                            <img src="<?php echo htmlspecialchars($song->image_url); ?>" 
                                 alt="<?php echo htmlspecialchars($song->title); ?>" 
                                 class="w-full aspect-square object-cover rounded-lg shadow-2xl">
                            <button id="playButton" class="absolute bottom-4 right-4 bg-spotify-green p-4 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11v11.78a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Song Info -->
                    <div class="flex-1">
                        <span class="text-sm font-medium text-spotify-green">CHANSON</span>
                        <h1 class="text-4xl font-bold text-white mt-2 mb-4">
                            <?php echo htmlspecialchars($song->title); ?>
                        </h1>
                        <p class="text-gray-400 text-lg mb-6">
                            Par <a href="/spotify/artist/<?php echo $song->artist_id; ?>" class="text-white hover:underline">
                                <?php echo htmlspecialchars($song->artist); ?>
                            </a>
                            • <?php echo htmlspecialchars($song->category); ?>
                        </p>

                        <!-- Audio Player -->
                        <div class="mb-8">
                            <audio id="audioPlayer" class="w-full" controls>
                                <source src="<?php echo htmlspecialchars($song->audio_url); ?>" type="audio/mpeg">
                                Votre navigateur ne supporte pas l'élément audio.
                            </audio>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-4">
                            <button id="likeButton" class="flex items-center gap-2 bg-transparent border border-gray-600 text-white font-bold py-3 px-6 rounded-full hover:border-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                J'aime
                            </button>
                            <button id="addToPlaylistButton" class="flex items-center gap-2 bg-transparent border border-gray-600 text-white font-bold py-3 px-6 rounded-full hover:border-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Ajouter à la playlist
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="mt-8 pt-8 border-t border-gray-800">
                    <h2 class="text-xl font-bold text-white mb-4">À propos de cette chanson</h2>
                    <p class="text-gray-400">
                        <?php echo nl2br(htmlspecialchars($song->description)); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add to Playlist Modal -->
<div id="playlistModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-[#282828] p-6 rounded-lg w-96">
        <h3 class="text-white text-xl font-bold mb-4">Ajouter à la playlist</h3>
        <div class="max-h-96 overflow-y-auto">
            <?php foreach ($playlists as $playlist): ?>
                <button class="w-full text-left px-4 py-3 text-gray-300 hover:bg-[#333333] rounded-md transition-colors"
                        onclick="addToPlaylist(<?php echo $song->id; ?>, <?php echo $playlist->id; ?>)">
                    <?php echo htmlspecialchars($playlist->name); ?>
                </button>
            <?php endforeach; ?>
        </div>
        <button id="closeModalButton" class="mt-4 w-full bg-spotify-green text-black font-bold py-2 rounded-full hover:bg-[#1ed760] transition-colors">
            Fermer
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const audioPlayer = document.getElementById('audioPlayer');
    const playButton = document.getElementById('playButton');
    const likeButton = document.getElementById('likeButton');
    const addToPlaylistButton = document.getElementById('addToPlaylistButton');
    const playlistModal = document.getElementById('playlistModal');
    const closeModalButton = document.getElementById('closeModalButton');

    // Play button functionality
    playButton.addEventListener('click', function() {
        if (audioPlayer.paused) {
            audioPlayer.play();
        } else {
            audioPlayer.pause();
        }
    });

    // Like button functionality
    likeButton.addEventListener('click', function() {
        fetch(`/spotify/song/<?php echo $song->id; ?>/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        });
    });

    // Playlist modal functionality
    addToPlaylistButton.addEventListener('click', function() {
        playlistModal.classList.remove('hidden');
        playlistModal.classList.add('flex');
    });

    closeModalButton.addEventListener('click', function() {
        playlistModal.classList.add('hidden');
        playlistModal.classList.remove('flex');
    });
});

function addToPlaylist(songId, playlistId) {
    fetch('/spotify/song/playlist/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            song_id: songId,
            playlist_id: playlistId
        })
    });
}
</script>
