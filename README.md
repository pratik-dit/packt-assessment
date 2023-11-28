# Packt Assessment

###### Install and Run Meilisearch locally ######

curl -L https://install.meilisearch.com | sh

# Run Meilisearch
./meilisearch

-- when you start meilisearch server then it will run on port "7700" and also generate one `MEILISEARCH_KEY`.

Copy `MEILISEARCH_KEY` key that generated when you start meilisearch and add into `.env` file.
Use `MEILISEARCH_HOST` port that generated when you start meilisearch and add into `.env` file.

# run meilisearch again with master key by using below command
./meilisearch --master-key 8Sc7TtGaS7ZtJWu5vh0LD6s3gU2gV0KJJfcY0sNLErY


###### Setup Project ######

- `composer install`
- create new `.env` file and copy content from `.env.example` and update database credential
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`
- `npm install`
- `php artisan scout:import "App\Models\Book"`  (import all of our book records into Meilisearch)
- `php artisan scout:sync-index-settings`   (update scout config)
- `npm run dev`
- `php artisan serve`

-- http://localhost:7700/  (In Meilisearch dashboard, you can see list of books record)

###### Admin Login Credentials ######

# Email: admin@gmail.com
# Password: 123123123


###### Meilisearch dashboard screenshot #####
-- https://prnt.sc/fKD3hq2VwTa2  (List of Books record)