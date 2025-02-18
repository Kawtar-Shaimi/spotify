<?php require_once __DIR__ . '/../layout/main.php'; ?>

<div class="bg-spotify-dark min-h-screen p-8">
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-white">Toutes les Chansons</h1>
            <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'artist'): ?>
                <a href="/spotify/song/upload" class="bg-spotify-green text-black font-bold py-2 px-4 rounded-full hover:bg-[#1ed760] transition-colors">
                    Ajouter une chanson
                </a>
            <?php endif; ?>
        </div>

        <!-- Search and Filter -->
        <div class="mb-8">
            <div class="flex gap-4">
                <input type="text" 
                       placeholder="Rechercher une chanson..." 
                       class="flex-1 px-4 py-2 bg-[#2a2a2a] text-white rounded-full focus:outline-none focus:ring-2 focus:ring-spotify-green">
                <select class="px-4 py-2 bg-[#2a2a2a] text-white rounded-full focus:outline-none focus:ring-2 focus:ring-spotify-green">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category->id); ?>">
                            <?php echo htmlspecialchars($category->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Songs Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($songs as $song): ?>
                <div class="bg-[#181818] p-4 rounded-lg hover:bg-[#282828] transition-all duration-300">
                    <div class="relative group">
                        <img src="<?php echo htmlspecialchars($song->image_url); ?>" 
                             alt="<?php echo htmlspecialchars($song->title); ?>" 
                             class="w-full aspect-square object-cover rounded-md mb-4">
                        <button class="play-button absolute bottom-2 right-2 bg-spotify-green p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11v11.78a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                            </svg>
                        </button>
                    </div>
                    <h3 class="text-white font-semibold text-lg mb-1">
                        <a href="/spotify/song/<?php echo $song->id; ?>" class="hover:underline">
                            <?php echo htmlspecialchars($song->title); ?>
                        </a>
                    </h3>
                    <p class="text-gray-400 text-sm">
                        <?php echo htmlspecialchars($song->artist); ?>
                    </p>
                    <div class="mt-4 flex justify-between items-center">
                        <button class="like-button text-gray-400 hover:text-white transition-colors" data-id="<?php echo $song->id; ?>">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                        <button class="add-to-playlist-button text-gray-400 hover:text-white transition-colors" data-id="<?php echo $song->id; ?>">
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
    // Handle like button clicks
    document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', function() {
            const songId = this.dataset.id;
            fetch(`/spotify/song/${songId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            });
        });
    });

    // Handle play button clicks
    document.querySelectorAll('.play-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            // Add play functionality
        });
    });

    // Handle search input
    const searchInput = document.querySelector('input[type="text"]');
    let timeout = null;
    searchInput.addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            // Add search functionality
        }, 500);
    });

    // Handle category filter
    const categorySelect = document.querySelector('select');
    categorySelect.addEventListener('change', function() {
        // Add filter functionality
    });
});
</script>
