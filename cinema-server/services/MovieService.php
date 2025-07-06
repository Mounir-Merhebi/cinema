<?php 

class MovieService {

    public static function moviesToArray($movies_db){
        $results = [];

        foreach($movies_db as $m){
             $results[] = $m->toArray(); //hence, we decided to iterate again on the articles array and now to store the result of the toArray() which is an array. 
        } 

        return $results;
    }



}