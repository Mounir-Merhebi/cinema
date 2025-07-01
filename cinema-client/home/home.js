// Function to fetch movies from the backend and display them on the homepage
async function fetchAndDisplayHomeMovies() {
    const moviesGrid = document.querySelector('.movies-grid');
    

    // Clear any existing content and show a loading indicator
    moviesGrid.innerHTML = '<p class="text-white text-center col-span-full">Loading movies...</p>';

    try {
           const response = await axios.get('../../cinema-server/controllers/get_movies.php');
        const data = response.data;

        if (data.success && data.movies.length > 0) {
            moviesGrid.innerHTML = ''; // Clear loading message

            data.movies.forEach(movie => {
                // Create a movie card element
                const movieCard = document.createElement('div');
                movieCard.classList.add('movie-card');

                // Sanitize and escape data to prevent XSS
                const title = escapeHTML(movie.title);
                const description = escapeHTML(movie.description);
                const releaseDate = escapeHTML(movie.release_date);
                const rating = escapeHTML(movie.rating);
                // Use a placeholder if posterUrl is empty or invalid
                const posterUrl = movie.poster_url && movie.poster_url.trim() !== ''
                                  ? escapeHTML(movie.poster_url)
                                  : 'https://placehold.co/400x600/0f0f23/ffffff?text=No+Poster'; // Placeholder image

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
                    
                    <a href="${trailerLink}" class="trailer-link" target="_blank">🎥 Watch Trailer</a>
                    
                    <div class="cast-section">
                        <div class="cast-title">Cast</div>
                        <div class="cast-text">${cast}</div>
                    </div>
                `;
                // Description can be conditionally added if needed, or directly included if always present
                // Adding a check for description length to prevent huge blocks of text
                if (description.length > 0) {
                    movieCard.querySelector('.cast-section').insertAdjacentHTML('beforebegin', `<div class="movie-description">${description}</div>`);
                }

                moviesGrid.appendChild(movieCard);
            });

        } else if (data.success && data.movies.length === 0) {
            moviesGrid.innerHTML = '<p class="text-white text-center col-span-full">No movies found in the database.</p>';
        } else {
            console.error('Error fetching movies:', data.message || 'Unknown error');
            moviesGrid.innerHTML = '<p class="text-red-500 text-center col-span-full">Failed to load movies. Please try again later.</p>';
        }
    } catch (error) {
        console.error('AJAX request failed:', error);
        moviesGrid.innerHTML = '<p class="text-red-500 text-center col-span-full">Network error or server issue. Failed to load movies.</p>';
    }
}

// Simple HTML escaping function to prevent XSS
function escapeHTML(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

// Call the function when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', fetchAndDisplayHomeMovies);