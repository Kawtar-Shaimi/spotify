<?php require_once __DIR__ . '/../layout/main.php'; ?>

<div class="bg-spotify-dark min-h-screen p-8">
    <div class="container mx-auto max-w-2xl">
        <div class="bg-[#181818] rounded-lg shadow-xl p-8">
            <h1 class="text-3xl font-bold text-white mb-8">Créer une nouvelle playlist</h1>

            <form action="/spotify/playlist" method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Nom -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-200 mb-2">
                        Nom de la playlist
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           required 
                           class="w-full px-4 py-3 bg-[#2a2a2a] text-white border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-transparent transition-all"
                           placeholder="Ma super playlist">
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-200 mb-2">
                        Description
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4" 
                              class="w-full px-4 py-3 bg-[#2a2a2a] text-white border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-transparent transition-all"
                              placeholder="Décrivez votre playlist..."></textarea>
                </div>

                <!-- Visibilité -->
                <div>
                    <label class="block text-sm font-medium text-gray-200 mb-2">
                        Visibilité
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" 
                                   name="visibility" 
                                   value="public" 
                                   checked 
                                   class="text-spotify-green focus:ring-spotify-green">
                            <span class="ml-2 text-white">Publique</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" 
                                   name="visibility" 
                                   value="private" 
                                   class="text-spotify-green focus:ring-spotify-green">
                            <span class="ml-2 text-white">Privée</span>
                        </label>
                    </div>
                </div>

                <!-- Image de couverture -->
                <div>
                    <label for="cover" class="block text-sm font-medium text-gray-200 mb-2">
                        Image de couverture (optionnel)
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-700 border-dashed rounded-lg">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-400">
                                <label for="cover" class="relative cursor-pointer bg-[#2a2a2a] rounded-md font-medium text-spotify-green hover:text-[#1ed760] focus-within:outline-none">
                                    <span class="px-3 py-2 rounded-md">Choisir un fichier</span>
                                    <input id="cover" name="cover" type="file" accept="image/*" class="sr-only">
                                </label>
                            </div>
                            <p class="text-xs text-gray-400">
                                PNG, JPG jusqu'à 5MB
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-spotify-green text-black font-bold py-3 px-4 rounded-full hover:bg-[#1ed760] transition-all">
                        Créer la playlist
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview de l'image
    const coverInput = document.querySelector('#cover');
    coverInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                alert('L\'image ne doit pas dépasser 5MB');
                this.value = '';
                return;
            }
        }
    });
});
</script>
