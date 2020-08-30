<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 90vh;
            }

            .full-width {
                width: 200vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <textarea class="position-ref full-height full-width flex-center">Steps to run the environment:
                    - $HOME/.composer/vendor/bin path should be in $PATH in order to run `composer`
                    - Clone/Copy the project from github
                    - Install packages by running: `composer install` in the project folder
                    - run: `cp .env.example .env` to generate the env file
                        - Ive put in .env.sample the ID and SECRET that PASSPORT uses to generate personal tokens. Its not a good practice to put that info in a file that is tracked by the version control, but, since this is a test, and in order to avoid you the hassle of running the passport install, go to the oauth_clients table, and copy-paste that information into the .env file
                    - by default it tries to use a database called `laravel`
                        - Ive built a command to create the database: `php artisan db:create {dbname}`. Ive got some issues while doing this, if the .env var 'DB_DATABASE' is not empty
                        - Or you create the database manually
                        - Update the DB_xxx related .env vars with the correct connection information
                    - to execute migrations and run the db seeds run: `php artisan migrate && php artisan db:seed`
                    - at this point:
                        - the `users` table should have the 100 users created with the seeder/faker. Default password for all users is: `password`
                        - the oauth_clients should have one row with the same information in the .env file
                    - to get the api up and running run: `php artisan serve`. This will start the http server listening on port 8000
                    - http://localhost:8000/api/documentation will open a swagger component with the documentation of the api. All the endpoints are documented there and you can test them too, as an alternative to Postman
                    - Any change in the .env variables needs to re-start the web server
                
                Users:
                    - I've added an `enabled` field to the `users` table. While this field is `true`(1). The user can login and send/read notifications.
                    - I've created a command to disable users. While a user is disabled won't be able to login or to send/read notifications. All access_tokens are revoked
                    - I've created a command to enable users. When a user is enabled all revoked tokens are not restored
                    - To purge `oauth_access_tokens` table from revoked and expired tokens run: `php artisan passport:purge`. This command can be added to a cron job to execute this task periodically.
                
                Notifications
                    - When a user access the /notification or /notification/{id} endpoints, only the notifications sent to the current user will be visible. This means that one user will not be able to see notifications sent to another user.
                    - When creating a notification, a `Title` and a `Message` are mandatory.
                    - When accesing /notification the `Message` won't be visible, only the `Title`
                    - When accesing /notification/{id} the `Title` and `Message` will be visible, and the notification will be marked as `read`
                
                Extra
                    - There is an endpoint /extra/info that will retrieve information from YELP. It massages the information and returns:
                        - Bussiness that are `opened`, have a rating >= 4 in Miami, Florida
                        - For each business it will return:
                            - Name, Rating, Google Maps link, Address, Phone, Categories, Services</textarea>
            </div>
        </div>
    </body>
</html>
