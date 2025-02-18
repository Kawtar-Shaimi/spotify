<?php require_once __DIR__ . '/../layout/main.php'; ?>

<div class="bg-black min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-[#282828] rounded-lg p-8">
                <h1 class="text-3xl font-bold text-white mb-8">Ajouter une nouvelle chanson</h1>

                <form action="/chanson" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <!-- Titre -->
                    <div>
                        <label for="titre" class="block text-sm font-medium text-gray-200 mb-2">
                            Titre de la chanson
                        </label>
                        <input type="text" 
                               id="titre" 
                               name="titre" 
                               required 
                               class="w-full px-4 py-3 bg-[#3E3E3E] text-white border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1DB954] focus:border-transparent transition-all duration-200"
                               placeholder="Entrez le titre de la chanson">
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <label for="categorie" class="block text-sm font-medium text-gray-200 mb-2">
                            Catégorie
                        </label>
                        <select id="categorie" 
                                name="categorie" 
                                required 
                                class="w-full px-4 py-3 bg-[#3E3E3E] text-white border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1DB954] focus:border-transparent transition-all duration-200">
                            <option value="">Sélectionnez une catégorie</option>
                            <option value="pop">Pop</option>
                            <option value="rock">Rock</option>
                            <option value="rap">Rap</option>
                            <option value="jazz">Jazz</option>
                            <option value="classique">Classique</option>
                            <option value="electro">Électro</option>
                            <option value="rnb">R&B</option>
                        </select>
                    </div>

                    <!-- Image de couverture -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-200 mb-2">
                            Image de couverture
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-700 border-dashed rounded-lg">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-400">
                                    <label for="image" class="relative cursor-pointer bg-[#3E3E3E] rounded-md font-medium text-[#1DB954] hover:text-[#1ed760] focus-within:outline-none">
                                        <span class="px-3 py-2 rounded-md">Choisir un fichier</span>
                                        <input id="image" name="image" type="file" accept="image/*" class="sr-only">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-400">
                                    PNG, JPG jusqu'à 5MB
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Fichier audio -->
                    <div>
                        <label for="audio" class="block text-sm font-medium text-gray-200 mb-2">
                            Fichier audio
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-700 border-dashed rounded-lg">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                </svg>
                                <div class="flex text-sm text-gray-400">
                                    <label for="audio" class="relative cursor-pointer bg-[#3E3E3E] rounded-md font-medium text-[#1DB954] hover:text-[#1ed760] focus-within:outline-none">
                                        <span class="px-3 py-2 rounded-md">Choisir un fichier</span>
                                        <input id="audio" name="audio" type="file" accept="audio/*" class="sr-only" required>
                                    </label>
                                </div>
                                <p class="text-xs text-gray-400">
                                    MP3, WAV jusqu'à 10MB
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full bg-[#1DB954] text-black font-bold py-3 px-4 rounded-full hover:bg-[#1ed760] hover:scale-105 transform transition-all duration-200">
                            Ajouter la chanson
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview de l'image
    const imageInput = document.querySelector('#image');
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                alert('L\'image ne doit pas dépasser 5MB');
                this.value = '';
                return;
            }
        }
    });

    // Validation du fichier audio
    const audioInput = document.querySelector('#audio');
    audioInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 10 * 1024 * 1024) {
                alert('Le fichier audio ne doit pas dépasser 10MB');
                this.value = '';
                return;
            }
        }
    });
});
</script>
