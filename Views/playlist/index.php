<?php
// Get the current user's playlists
$user_playlists = $playlists ?? [];
?>

<div class="p-8 max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Mes Playlists</h1>
        <a href="/playlist/create" 
           class="bg-spotify-green text-white px-6 py-2 rounded-full hover:bg-opacity-90 transition-colors duration-200 flex items-center gap-2">
            <i class="fas fa-plus"></i>
            Créer une playlist
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        <?php foreach ($user_playlists as $playlist): ?>
            <div class="bg-spotify-light rounded-lg overflow-hidden transition-transform duration-200 hover:-translate-y-1">
                <div class="aspect-square bg-spotify-dark flex items-center justify-center">
                    <?php if ($playlist->getImage()): ?>
                        <img src="<?php echo htmlspecialchars($playlist->getImage()); ?>" 
                             alt="Playlist cover"
                             class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="text-spotify-green text-5xl">
                            <i class="fas fa-music"></i>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="p-4">
                    <h3 class="text-white font-medium truncate">
                        <?php echo htmlspecialchars($playlist->getTitre()); ?>
                    </h3>
                    <p class="text-spotify-gray text-sm mt-1">
                        <?php echo count($playlist->getChansons()); ?> chansons
                    </p>
                    
                    <div class="flex items-center gap-2 mt-4">
                        <a href="/playlist/<?php echo $playlist->getId(); ?>" 
                           class="flex-1 bg-spotify-green text-white py-2 rounded-full hover:bg-opacity-90 transition-colors duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-play"></i>
                            Écouter
                        </a>
                        <a href="/playlist/edit/<?php echo $playlist->getId(); ?>" 
                           class="p-2 text-spotify-gray hover:text-white bg-spotify-dark/50 rounded-full transition-colors duration-200">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="/playlist/delete/<?php echo $playlist->getId(); ?>" 
                              method="POST" 
                              class="inline">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <button type="submit" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette playlist ?')"
                                    class="p-2 text-spotify-gray hover:text-red-500 bg-spotify-dark/50 rounded-full transition-colors duration-200">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if (empty($user_playlists)): ?>
            <div class="col-span-full bg-spotify-light rounded-lg p-12 text-center">
                <div class="text-spotify-green text-5xl mb-4">
                    <i class="fas fa-music"></i>
                </div>
                <p class="text-spotify-gray mb-4">Vous n'avez pas encore de playlist</p>
                <a href="/playlist/create" 
                   class="inline-block bg-spotify-green text-white px-6 py-2 rounded-full hover:bg-opacity-90 transition-colors duration-200">
                    Créer ma première playlist
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
