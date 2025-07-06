<?php 

class UserService {

    public static function usersToArray($users_db){
        $results = [];

        foreach($users_db as $u){
             $results[] = $u->toArray(); //hence, we decided to iterate again on the articles array and now to store the result of the toArray() which is an array. 
        } 

        return $results;
    }



}