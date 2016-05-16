<?php
# Konfiguracijska datoteka za definiranje prave pristupa stranicama koje uklju�uju korisnik.php
# Samo korisnici iz tablice system_users koji imaju neku od sljede�ih razina
# �e mo�i pristupati stranicama. To je kolona user_level u tablici system_users.
# Varijabla level_login mora biti zapisana u format razina razmak razina npr. 4 5 2 i definira sve korisnike koji imaju pravo pristupa na te stranice
# Dodavanje novih korisnika i operatera te izmjenu postoje�ih mogu raditi samo admin i superadmin stoga razine pristupa u ovaj direktoriji trebaju niti samo 10 i 11
$level_login = "10 11"; 
?>