<?php

include "calendar.php";

display_events_between_months([
    [
        'name' => 'Reunion Client',
        'date' => '20200505',
        'location' => 'Nantes'
        ] ,
        [
        'name' => 'Affinage sprint 2',
        'date' => '20200718',
        'location' => 'Nantes'
        ] ,
        [
        'name' => 'RDV Pro',
        'date' => '20200705',
        'location' => 'Paris'
        ] ,
        [
        'name' => 'Brainstorming',
        'date' => '20190705',
        'location' => 'Lyon'
        ] ,
        [
        'name' => 'Demonstration client',
        'date' => '20200205 ',
        'location' => 'Lille'
        ]        
], '202005', '202007');