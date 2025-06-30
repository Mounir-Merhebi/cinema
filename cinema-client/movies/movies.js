// Function to fetch movies from the backend and display them
async function fetchAndDisplayMovies() {
    const moviesGrid = document.querySelector('.movies-grid');
    const moviesCountElement = document.querySelector('.movies-count');

    // Clear any existing content and show a loading indicator
    moviesGrid.innerHTML = '<p class="text-white text-center col-span-full">Loading movies...</p>';
    moviesCountElement.textContent = 'Showing 0 movies';

    try {
        // Make an AJAX request to your PHP endpoint
        // CRITICAL FIX: Changed URL to point to the correct path if cinema-client and cinema-server are siblings
        // This assumes movies.html is in /cinema-client/ and get_movies.php is in /cinema-server/controllers/
        // If your web server is serving from C:\xampp\htdocs\, then this path works.
        const response = await axios.get('../../cinema-server/controllers/get_movies.php');
        const data = response.data;

        if (data.success && data.movies.length > 0) {
            moviesGrid.innerHTML = ''; // Clear loading message

            data.movies.forEach(movie => {
                // Create a movie card element
                const movieCard = document.createElement('div');
                movieCard.classList.add('movie-card');

                // Sanitize and escape data to prevent XSS (though PHP should also sanitize for DB insertion)
                const title = escapeHTML(movie.title);
                const description = escapeHTML(movie.description);
                const releaseDate = escapeHTML(movie.release_date);
                const rating = escapeHTML(movie.rating);
                const posterUrl = escapeHTML(movie.poster_url);
                const cast = escapeHTML(movie.cast);
                const trailerLink = escapeHTML(movie.trailer_link);

                // Populate the movie card with data
                movieCard.innerHTML = `
                    <div class="movie-poster" style="background-image: url('${posterUrl}');"></div>
                    
                    <div class="movie-header">
                        <div class="movie-title">${title}</div>
                        <div class="movie-meta">
                            <span class="movie-rating">★ ${rating}</span>
                            <span class="movie-release-date">${releaseDate}</span>
                        </div>
                    </div>
                    
                    <div class="movie-description">
                        ${description}
                    </div>
                    
                    <a href="${trailerLink}" class="trailer-link" target="_blank">🎥 Watch Trailer</a>
                    
                    <div class="cast-section">
                        <div class="cast-title">Cast</div>
                        <div class="cast-text">${cast}</div>
                    </div>
                `;
                moviesGrid.appendChild(movieCard);
            });

            moviesCountElement.textContent = `Showing ${data.movies.length} movies`;

        } else if (data.success && data.movies.length === 0) {
            moviesGrid.innerHTML = '<p class="text-white text-center col-span-full">No movies found in the database.</p>';
            moviesCountElement.textContent = 'Showing 0 movies';
        } else {
            console.error('Error fetching movies:', data.message || 'Unknown error');
            moviesGrid.innerHTML = '<p class="text-red-500 text-center col-span-full">Failed to load movies. Please try again later.</p>';
            moviesCountElement.textContent = 'Error loading movies';
        }
    } catch (error) {
        console.error('AJAX request failed:', error);
        moviesGrid.innerHTML = '<p class="text-red-500 text-center col-span-full">Network error or server issue. Failed to load movies.</p>';
        moviesCountElement.textContent = 'Error loading movies';
    }
}

// Simple HTML escaping function to prevent XSS
function escapeHTML(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

// Call the function when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', fetchAndDisplayMovies);
