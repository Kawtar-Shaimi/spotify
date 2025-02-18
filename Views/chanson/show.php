<?php require_once __DIR__ . '/../layout/main.php'; ?>

<div class="bg-black min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-gradient-to-b from-[#282828] to-black rounded-xl p-8">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Image de la chanson -->
                    <div class="w-full md:w-1/3">
                        <div class="relative group">
                            <img src="<?php echo $chanson->getImage() ?: '/assets/default-cover.png'; ?>" 
                                 alt="<?php echo htmlspecialchars($chanson->getTitre()); ?>" 
                                 class="w-full aspect-square object-cover rounded-lg shadow-2xl">
                            <button class="play-button absolute bottom-4 right-4 bg-[#1DB954] p-4 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11v11.78a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Informations de la chanson -->
                    <div class="flex-1">
                        <span class="text-sm font-medium text-gray-400">Chanson</span>
                        <h1 class="text-4xl font-bold text-white mt-2 mb-4">
                            <?php echo htmlspecialchars($chanson->getTitre()); ?>
                        </h1>
                        <p class="text-gray-400 text-lg mb-6">
                            Par <span class="text-white"><?php echo htmlspecialchars($chanson->getArtiste()); ?></span>
                            • Catégorie: <span class="text-white"><?php echo htmlspecialchars($chanson->getCategorie()); ?></span>
                        </p>

                        <!-- Actions -->
                        <div class="flex items-center gap-4">
                            <button class="like-button bg-[#1DB954] text-black font-bold py-3 px-6 rounded-full hover:bg-[#1ed760] transition-colors flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                J'aime
                            </button>
                            <button class="add-to-playlist-button bg-transparent border border-gray-400 text-white font-bold py-3 px-6 rounded-full hover:border-white transition-colors flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Ajouter à la playlist
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section des playlists -->
            <div id="playlist-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-[#282828] p-6 rounded-lg w-96">
                    <h3 class="text-white text-xl font-bold mb-4">Ajouter à la playlist</h3>
                    <div class="max-h-96 overflow-y-auto">
                        <!-- Liste des playlists à remplir dynamiquement -->
                    </div>
                    <button class="mt-4 w-full bg-[#1DB954] text-black font-bold py-2 rounded-full hover:bg-[#1ed760] transition-colors">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const likeButton = document.querySelector('.like-button');
    const addToPlaylistButton = document.querySelector('.add-to-playlist-button');
    const playlistModal = document.querySelector('#playlist-modal');

    likeButton.addEventListener('click', function() {
        const chansonId = '<?php echo $chanson->getIdChanson(); ?>';
        fetch(`/chanson/${chansonId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ action: 'like' })
        });
    });

    addToPlaylistButton.addEventListener('click', function() {
        playlistModal.classList.remove('hidden');
    });

    playlistModal.querySelector('button').addEventListener('click', function() {
        playlistModal.classList.add('hidden');
    });
});
</script>
