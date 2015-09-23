BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
CALSCALE:GREGORIAN
BEGIN:VEVENT
UID:<?php echo uniqid()  . "\n"; ?>
DTSTART:<?php echo $this->formatDate($event->Date . ' ' . $event->Time) . "\n"; ?>
DTEND:<?php echo $this->formatDate($event->Date . ' ' . $event->Time, '+1 hour') . "\n"; ?>
DTSTAMP:<?php echo $this->formatDate(date('Y-m-d H:i:s', time())) . "\n"; ?>
LOCATION:<?php echo $this->escapeString($event->Location) . "\n"; ?>
DESCRIPTION:<?php echo $this->escapeString($event->Description) . "\n"; ?>
URL:<?php echo $this->escapeString($event->Link) . "\n"; ?>
SUMMARY:<?php echo $this->escapeString($event->Name) . "\n"; ?>
TZID: Europe/Stockholm 
END:VEVENT
END:VCALENDAR