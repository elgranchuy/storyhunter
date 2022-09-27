Steps to initialize project.

- Create a mysql database locally named storyhunter
- Rename .env.example file to .env inside your project root and fill the database information
- Run composer install
- Run php artisan key:generate
- Run php artisan migrate
- Run php artisan passport:install
- Run php artisan serve


Available endpoints:

Public:

GET: `/` Returns a welcome message

POST: `/register` Register new user

POST: `/login` Login user


Protected:

GET: `/users/{id}` Show specified user data

GET: `/threads/{user_id}` Returns threads belonging to the specified user

POST: `/threads` Stores a new thread

PATCH: `/threads/{id}` Updates a thread. (It only takes an array of tag ids and saves it to the thread)


GET: `/messages/{thread_id}` Returns messages belonging to the specified thread

POST: `/messages` Stores a new message


GET: `/tags` Returns a list of available tags

GET: `/tags/{id}` Returns a list of threads that have the specified tag

POST: `/tags` Stores a new tag
