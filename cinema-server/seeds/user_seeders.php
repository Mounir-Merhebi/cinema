<?php
require("../connection/connection.php");
require("../models/User.php");

$users = [
    [
        'fullname' => 'Mounir Merhebi',
        'email' => 'mounirmerhebi21@gmail.com',
        'mobile_number' => '70209607',
        'password' => password_hash('password123', PASSWORD_DEFAULT),
        'date_of_birth' => '2002-06-30',
        'communication_prefs' => "email",
        'membership_level' => 'Gold',
        'age_verified' => 1
    ],
    [
        'fullname' => 'Maryam Mouslimany',
        'email' => 'marwammouslimany17@gmail.com',
        'mobile_number' => '81305964',
        'password' => password_hash('password456', PASSWORD_DEFAULT),
        'date_of_birth' => '2010-05-8',
        'communication_prefs' => "sms",
        'membership_level' => 'Silver',
        'age_verified' => 0
    ]
];

foreach ($users as $user) {
    $newUsers = User::create($mysqli, $user);
}
