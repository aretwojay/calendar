<?php

function sort_by_date(array &$events)
{
    $sort = [];
    foreach ($events as $key => $event) {
        $sort[$key] = strtotime($event['date']);
    }
    array_multisort($sort, SORT_ASC, $events);
}

//Step 1
function display_event(array $event)
{
    if (isset($event['name']) && isset($event['date']) && isset($event['location'])) {
        $name = $event['name'];
        $date = date('d-m-Y', strtotime($event['date']));
        $location = $event['location'];
        echo "The \"$name\" event will take place on $date in $location" . PHP_EOL;
    }
}    

//Step 2
function display_events_by_month(array $events)
{
    sort_by_date($events);
    
    foreach ($events as $key => $event) {
        if ($key === 0 || $key > 0 
        && date("Y-m", strtotime($events[$key - 1]["date"])) != date("Y-m", strtotime($event['date'])))
        {
            $date = date('Y-m', strtotime($event['date']));
            echo $date . PHP_EOL;
        }
        echo "  "; 
        display_event($event);
    }
}

//Step 3
function display_events_between_months(array $events, string $dateBegin, string $dateEnd)
{
    $time_begin = date("Y-m", strtotime($dateBegin."01"));
    $time_end = date("Y-m", strtotime($dateEnd."01"));
    sort_by_date($events);

    foreach ($events as $key => $event) {
        $time = date("Y-m", strtotime($event["date"]));
        if ($time < $time_begin)
        {
            unset($events[$key]);
        }
    }
    display_events_by_month($events);
}

//Step 4
function display_calendar(array $events, string $dateBegin, string $dateEnd)
{
    $weekdays = ['Mon',
        'Tue',
        'Wed',
        'Thu',
        'Fri',
        'Sat',
        'Sun'
    ];

    $first_of_month = strtotime($dateBegin."01");
    $time_end = date("Y-m", strtotime($dateEnd."01"));
    $month = date("m", $first_of_month);
    $year = date("Y", $first_of_month);
    $week = date("W", $first_of_month);
    $amount_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    $time = new DateTime();
    $time->setISODate($year, $week);

    //en-tete de chaque mois
    echo (date("M Y", $first_of_month)) . PHP_EOL . implode("  ", $weekdays) . PHP_EOL;

    for ($i = 1; $i <= 42; $i++){
        $date_to_search = $time->format('Ymd');
        $key = array_search($date_to_search, array_column($events, 'date'));
        (gettype($key) == 'integer') ? $key = 1 : $key = 0;

        echo "  ". $key . "  ";
        //a la fin d'une semaine, une nouvelle ligne
        if ($i % 7 == 0)
        {
            echo PHP_EOL;
        }
        //si la derniere semaine est du mois suivant, on stoppe la boucle
        if ($time->format("m") > $month && $time->format("w") == 0)
        {
            break;
        }
        $time->add(new DateInterval('P1D'));
    }
    //appel recursif tant qu'on arrive pas à la date de fin
    if ($time_end >= $time->format('Y-m'))
    {
        echo PHP_EOL;
        display_calendar($events, $time->format("Ym"), $dateEnd);
    }
    
}
