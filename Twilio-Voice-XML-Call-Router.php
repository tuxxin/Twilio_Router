<?php
/*
----------------------------------------------------------
  /$$$$$$$$ /$$   /$$ /$$   /$$ /$$   /$$ /$$$$$$ /$$   /$$
 |__  $$__/| $$  | $$| $$  / $$| $$  / $$|_  $$_/| $$$ | $$
    | $$   | $$  | $$|  $$/ $$/|  $$/ $$/  | $$  | $$$$| $$
    | $$   | $$  | $$ \  $$$$/  \  $$$$/   | $$  | $$ $$ $$
    | $$   | $$  | $$  >$$  $$   >$$  $$   | $$  | $$  $$$$
    | $$   | $$  | $$ /$$/\  $$ /$$/\  $$  | $$  | $$\  $$$
    | $$   |  $$$$$$/| $$  \ $$| $$  \ $$ /$$$$$$| $$ \  $$
    |__/    \______/ |__/  |__/|__/  |__/|______/|__/  \__/
----------------------------------------------------------
Twilio Voice Call Routing:
Features:
Hours of operation.
Automatic closure on US federal holidays (including floating).
Voicemail during closed hours.
Rings multiple numbers simultaneously.
*/


// Set the content type to XML for Twilio
header("content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8"?>';

// 1. Set Timezone to EST/EDT (America/New_York)
date_default_timezone_set('America/New_York');

// 2. Define Business Hours
$openTime = '09:00';
$closeTime = '17:00';

// Current Date and Time
$now = new DateTime();
$currentTime = $now->format('H:i');
$currentDayOfWeek = $now->format('N'); // 1 (Mon) to 7 (Sun)
$todayStr = $now->format('Y-m-d');
$year = $now->format('Y');

// 3. Define Holidays
$holidayName = false;

// --- A. Fixed Date Holidays ---
$fixedHolidays = [
    'New Year\'s Day'      => "$year-01-01",
    'Juneteenth'           => "$year-06-19",
    'Independence Day'     => "$year-07-04",
    'Veterans Day'         => "$year-11-11",
    'Christmas Day'        => "$year-12-25",
];

foreach ($fixedHolidays as $name => $date) {
    if ($todayStr == $date) {
        $holidayName = $name;
        break;
    }
}

// --- B. Floating Holidays ---
if (!$holidayName) {
    $floatingHolidays = [
        "Martin Luther King Jr.'s Birthday" => (new DateTime("$year-01-01"))->modify('third monday of January'),
        "Presidents' Day"                   => (new DateTime("$year-02-01"))->modify('third monday of February'),
        "Memorial Day"                      => (new DateTime("$year-05-01"))->modify('last monday of May'),
        "Labor Day"                         => (new DateTime("$year-09-01"))->modify('first monday of September'),
        "Columbus Day"                      => (new DateTime("$year-10-01"))->modify('second monday of October'),
        "Thanksgiving Day"                  => (new DateTime("$year-11-01"))->modify('fourth thursday of November'),
    ];

    foreach ($floatingHolidays as $name => $dateObj) {
        if ($todayStr == $dateObj->format('Y-m-d')) {
            $holidayName = $name;
            break;
        }
    }
}

// 4. Logic Control & Response Generation
?>
<Response>
    <?php if ($holidayName): ?>
        <Say voice="alice">
            Thank you for calling Discount Invicta's. 
            Our offices are currently closed in observance of <?php echo $holidayName; ?>. 
            Please leave a message, or visit us at discount invictas dot com. 
            We will reopen during our normal business hours, Monday through Friday, 9 A M to 5 P M Eastern Time.
        </Say>
        <Record playBeep="true" />
    <?php elseif ($currentDayOfWeek >= 6 || $currentTime < $openTime || $currentTime >= $closeTime): ?>
        <Say voice="alice">
            Thank you for calling Discount Invicta's. 
            Our offices are currently closed. 
            Please leave a message, or visit us at discount invictas dot com. 
            Our normal business hours are Monday through Friday, 9 A M to 5 P M Eastern Time.
        </Say>
        <Record playBeep="true" />
    <?php else: ?>
        <Dial>
            <Number>123-4567</Number>
            <Number>123-4568</Number>
        </Dial>
    <?php endif; ?>
</Response>