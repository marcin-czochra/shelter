Treść:
Zadanie polega na utworzeniu nowego projektu we frameworku Laravel.
W nim API pomagającego w zarządzaniu schroniskiem dla kotów.
Aplikacja powinna móc zarządzać kilkoma oddziałami schronisk, kotami i pracownikami.
Należy utworzyć modele dla tych trzech klas obiektów i migracje modeli, które pozwolą na odwzorowanie danych w bazie. Chodzi o samo API.
API powinno być otwarte i publiczne, nie trzeba robić żadnego systemu autoryzacji.

1. Zostały utworzone migracje dla tabel: branches, cats, employees
2. Zostały utworzone modele wraz z relacjami
3. Stworzenie seederów dla tabel 
4. Utworzenie kontrolerów CRUD (index, store, show, update, destroy)
5. Utworzenie Requests z walidacją dla kontrolerów
6. Łapanie wyjątków w metodach
7. Utworzenie podstawowych testów dla kontrolerów
8. Metoda index ma paginację, pozwala na filtrowanie oraz sortowanie wyników

Przykałdowe endpointy dla branches:

Tworzenie nowego oddziału:
curl -X POST -H "Content-Type: application/json" -d '{"name":"Test","location":"Test"}' http://localhost/api/branches

Pobieranie wszystkich oddziałów:
curl http://localhost/api/branches

Pobieranie konkretnego oddziału po id:
curl http://localhost/api/branches/4

Aktualizacja danych oddziału:
curl -X PUT -H "Content-Type: application/json" -d '{"name":"Test","location":"Test"}' http://localhost/api/branches/{id}

Usuwanie oddziału:
curl -X DELETE http://localhost/api/branches/4

Moje środowisko:
WSL 2, Docker, Laravel Sail
