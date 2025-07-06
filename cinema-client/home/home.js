
async function fetchAndDisplayHomeMovies() {
    const moviesGrid = document.querySelector('.movies-grid');
    
    moviesGrid.innerHTML = '<p class="text-white text-center col-span-full">Loading movies...</p>';

    try {
           const response = await axios.get('http://localhost/cinema/get_movies');
        const data = response.data;

        if (data.success && data.movies.length > 0) {
            moviesGrid.innerHTML = ''; 

            data.movies.forEach(movie => {
                const movieCard = document.createElement('div');
                movieCard.classList.add('movie-card');
                const title = escapeHTML(movie.title);
                const description = escapeHTML(movie.description);
                const releaseDate = escapeHTML(movie.release_date);
                const rating = escapeHTML(movie.rating);
                const posterUrl = movie.poster_url && movie.poster_url.trim() !== ''
                                  ? escapeHTML(movie.poster_url)
                                  : 'https://placehold.co/400x600/0f0f23/ffffff?text=No+Poster'; // Placeholder image

                const cast = escapeHTML(movie.cast);
                const trailerLink = escapeHTML(movie.trailer_link);
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

function escapeHTML(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}
document.addEventListener('DOMContentLoaded', fetchAndDisplayHomeMovies);