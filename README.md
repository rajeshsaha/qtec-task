## Search History task

- db name qtec-task
- .env file is discarded from gitignore. So please run migration and seeding command.

	php artisan migrate

	php artisan db:seed

- I have added an array of today, yesterday, last week and last month random dates in factory. So after seeding, will be able to filter the search history records by all criteria.
- Didn't consider user registration process, so user=ip address of client.
- As it is demo task, db logic currently in controller not in repositroy.
- ***Added link of /task2 in search history view page.


## Pattern matching procedure

- First, get the length of text and pattern.
- Outer loop from 0 to (text length - pattern length), because no need to check above the subtract length coz no pattern match will be found further. Initially let match will be found, so $mis_match=true.
- Inner loop from 0 to pattern length, here will decide pattern match situation in text. If any character does not match with text(tada($i=0)/ adad($i=1)/ dada), set $mis_match 'true' and break from the inner loop. Here, check from $i+$j=$i(text)+each index of pattern i.e $text[$i+$j] = tada/ adad/ dada.
- No break means successful compeltion, so pattern matched in text and $found variable incremented.
