Generate QR codes from a CSV
===============

Your CSV should be in the format:
Firstname, Lastname, Email, ID number

To run the generator:
$ php bin/attendize_qr.php

The folder called /qr will be filled with two QR codes per CSV row. One will be the ID number for each person, the other will be a vCard that when scanned will provide the full name and email address of the person.
