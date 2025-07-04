<?php
// Ensure this path is correct relative to Movie.php's location
// If Movie.php is in 'models/' and Model.php is in 'models/', then it's just 'Model.php'
// If Model.php is in the parent directory of 'models/', then it would be '../Model.php'
// Based on your previous C:\xampp\htdocs\Cinema\cinema-server\models\Movie.php,
// and C:\xampp\htdocs\Cinema\cinema-server\Model.php, this implies Model.php is one level up.
require_once("Model.php");
 // Assuming Model.php is one directory up from Movie.php

class Movie extends Model {

    private int $id;
    private string $title;
    private string $description;
    private string $release_date;
    private float $rating;
    private string $poster_url;
    private string $cast;
    private string $trailer_link;
    
    protected static string $table = "movies";

    public function __construct(array $data) {
        $this->id = $data["id"] ?? 0;
        $this->title = $data["title"] ?? '';
        $this->description = $data["description"] ?? '';
        $this->release_date = $data["release_date"] ?? '';
        $this->rating = $data["rating"] ?? 0.0;
        $this->poster_url = $data["poster_url"] ?? '';
        $this->cast = $data["cast"] ?? '';
        $this->trailer_link = $data["trailer_link"] ?? '';
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getDescription(): string { return $this->description; }
    public function getReleaseDate(): string { return $this->release_date; }
    public function getRating(): float { return $this->rating; }
    public function getPosterUrl(): string { return $this->poster_url; }
    public function getCast(): string { return $this->cast; }
    public function getTrailerLink(): string { return $this->trailer_link; }

    // Setters
    public function setTitle(string $title): void { $this->title = $title; }
    public function setDescription(string $description): void { $this->description = $description; }
    public function setReleaseDate(string $release_date): void { $this->release_date = $release_date; }
    public function setRating(float $rating): void { $this->rating = $rating; }
    public function setPosterUrl(string $poster_url): void { $this->poster_url = $poster_url; }
    public function setCast(string $cast): void { $this->cast = $cast; }
    public function setTrailerLink(string $trailer_link): void { $this->trailer_link = $trailer_link; }

    
    public function toArray(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'release_date' => $this->release_date,
            'rating' => $this->rating,
            'poster_url' => $this->poster_url,
            'cast' => $this->cast,
            'trailer_link' => $this->trailer_link
        ];
    }
}