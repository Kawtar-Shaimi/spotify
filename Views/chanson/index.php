<?php require_once __DIR__ . '/../layout/main.php'; ?>

<div class="bg-black min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-white">Toutes les Chansons</h1>
            <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'artist'): ?>
                <a href="/chanson/create" class="bg-[#1DB954] text-black font-bold py-2 px-4 rounded-full hover:bg-[#1ed760] transition-colors">
                    Ajouter une chanson
                </a>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($chansons as $chanson): ?>
                <div class="bg-[#282828] p-4 rounded-lg hover:bg-[#2a2a2a] transition-all duration-300">
                    <div class="relative group">
                        <img src="<?php echo $chanson->getImage() ?: '/assets/default-cover.png'; ?>" 
                             alt="<?php echo htmlspecialchars($chanson->getTitre()); ?>" 
                             class="w-full aspect-square object-cover rounded-md mb-4">
                        <button class="play-button absolute bottom-2 right-2 bg-[#1DB954] p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11v11.78a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                            </svg>
                        </button>
                    </div>
                    <h3 class="text-white font-semibold text-lg mb-1">
                        <?php echo htmlspecialchars($chanson->getTitre()); ?>
                    </h3>
                    <p class="text-gray-400 text-sm">
                        <?php echo htmlspecialchars($chanson->getArtiste()); ?>
                    </p>
                    <div class="mt-4 flex justify-between items-center">
                        <button class="like-button text-gray-400 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                        <button class="add-to-playlist-button text-gray-400 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestionnaire pour les boutons like
    document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', function() {
            const chansonId = this.closest('.chanson-card').dataset.id;
            fetch(`/chanson/${chansonId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ action: 'like' })
            });
        });
    });

    // Gestionnaire pour les boutons de lecture
    document.querySelectorAll('.play-button').forEach(button => {
        button.addEventListener('click', function() {
            // Logique de lecture à implémenter
        });
    });
});
</script>
