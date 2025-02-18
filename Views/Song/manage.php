<?php require_once __DIR__ . '/../layout/main.php'; ?>

<div class="bg-spotify-dark min-h-screen p-8">
    <div class="container mx-auto">
        <div class="bg-[#181818] rounded-lg shadow-xl p-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-white">Gérer vos chansons</h1>
                <a href="/spotify/song/upload" class="bg-spotify-green text-black font-bold py-2 px-4 rounded-full hover:bg-[#1ed760] transition-colors">
                    Ajouter une chanson
                </a>
            </div>

            <!-- Filter and Search -->
            <div class="mb-8">
                <div class="flex gap-4">
                    <input type="text" 
                           id="searchInput"
                           placeholder="Rechercher dans vos chansons..." 
                           class="flex-1 px-4 py-2 bg-[#2a2a2a] text-white rounded-full focus:outline-none focus:ring-2 focus:ring-spotify-green">
                    <select id="categoryFilter" 
                            class="px-4 py-2 bg-[#2a2a2a] text-white rounded-full focus:outline-none focus:ring-2 focus:ring-spotify-green">
                        <option value="">Toutes les catégories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category->id); ?>">
                                <?php echo htmlspecialchars($category->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Songs Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-gray-400 border-b border-gray-800">
                            <th class="pb-4 px-4">Titre</th>
                            <th class="pb-4 px-4">Catégorie</th>
                            <th class="pb-4 px-4">Vues</th>
                            <th class="pb-4 px-4">Likes</th>
                            <th class="pb-4 px-4">Date d'ajout</th>
                            <th class="pb-4 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($songs as $song): ?>
                            <tr class="border-b border-gray-800 hover:bg-[#282828] transition-colors">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <img src="<?php echo htmlspecialchars($song->image_url); ?>" 
                                             alt="" 
                                             class="w-10 h-10 rounded">
                                        <div>
                                            <div class="text-white font-medium">
                                                <?php echo htmlspecialchars($song->title); ?>
                                            </div>
                                            <div class="text-sm text-gray-400">
                                                <?php echo htmlspecialchars($song->duration); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-gray-400">
                                    <?php echo htmlspecialchars($song->category); ?>
                                </td>
                                <td class="py-4 px-4 text-gray-400">
                                    <?php echo number_format($song->views); ?>
                                </td>
                                <td class="py-4 px-4 text-gray-400">
                                    <?php echo number_format($song->likes); ?>
                                </td>
                                <td class="py-4 px-4 text-gray-400">
                                    <?php echo date('d/m/Y', strtotime($song->created_at)); ?>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <a href="/spotify/song/edit/<?php echo $song->id; ?>" 
                                           class="text-spotify-green hover:text-[#1ed760] transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <button onclick="deleteSong(<?php echo $song->id; ?>)" 
                                                class="text-red-500 hover:text-red-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-[#282828] p-6 rounded-lg w-96">
        <h3 class="text-white text-xl font-bold mb-4">Confirmer la suppression</h3>
        <p class="text-gray-400 mb-6">Êtes-vous sûr de vouloir supprimer cette chanson ? Cette action est irréversible.</p>
        <div class="flex justify-end gap-4">
            <button onclick="closeDeleteModal()" 
                    class="px-4 py-2 text-white bg-transparent border border-gray-600 rounded-full hover:border-white transition-colors">
                Annuler
            </button>
            <button id="confirmDeleteButton"
                    class="px-4 py-2 text-white bg-red-500 rounded-full hover:bg-red-600 transition-colors">
                Supprimer
            </button>
        </div>
    </div>
</div>

<script>
let songIdToDelete = null;

function deleteSong(songId) {
    songIdToDelete = songId;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
    songIdToDelete = null;
}

document.getElementById('confirmDeleteButton').addEventListener('click', function() {
    if (songIdToDelete) {
        fetch(`/spotify/song/${songIdToDelete}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            }
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    }
    closeDeleteModal();
});

// Search functionality
const searchInput = document.getElementById('searchInput');
let searchTimeout = null;
searchInput.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        // Add search functionality
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
            const title = row.querySelector('td:first-child').textContent.toLowerCase();
            if (title.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }, 300);
});

// Category filter
const categoryFilter = document.getElementById('categoryFilter');
categoryFilter.addEventListener('change', function() {
    const category = this.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
        if (!category || row.querySelector('td:nth-child(2)').textContent.toLowerCase() === category) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
