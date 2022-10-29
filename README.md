## Search History task

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- .env file is discarded from gitignore. So please run migration and seeding command.

php artisan migrate

php artisan db:seed

- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Pattern matching procedure

- First, get the length of text and pattern.
- Outer loop from 0 to (text length - pattern length), because no need to check above the subtract length coz no pattern match will be found further. Initially let match will be found, so $mis_match=true.
- Inner loop from 0 to pattern length, here will decide pattern match situation in text. If any character does not match with text(tada($i=0)/ adad($i=1)/ dada), set $mis_match 'true' and break from the inner loop. Here, check from $i+$j=$i(text)+each index of pattern i.e $text[$i+$j] = tada/ adad/ dada.
- No break means successful compeltion, so pattern matched in text and $found variable incremented.
