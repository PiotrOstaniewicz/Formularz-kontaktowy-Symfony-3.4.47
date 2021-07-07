Formularz kontaktowy Symfony 3.4.47
========================

Zadanie rekrutacyjne.

Treść zadania:
--------
Wymagane pola:
- przedmiotowy produkt - selector z 5 opcjami
- data kontaktu zwrotnego - zakres dat (ograniczony do dni roboczych: pn-pt)
- preferowana godzina kontaktu zwrotnego ograniczona do 8-17
- telefon kontaktowy
- email kontaktowy

Nie wymagane pola:
- treść zapytania

## Instalacja
Ustawienia wysyłki email dla gmail.

app\config\parameters.yml
###zmienić

mailer_transport: smtp

na

mailer_transport: gmail

###ustawić

mailer_user: login

mailer_password: password

app\config\config.yml

wpisać swój email z gmail w miejscu mailer_from_email:""

Ustawienie ilości sekund do momentu umożliwienia ponownego wysłania zgłoszenia

contactFormTimeDelay:
