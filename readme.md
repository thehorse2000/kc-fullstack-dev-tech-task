# Test task - Course catalog

## TECH used:
1. Alpine JS (via CDN)
2. Tailwindcss

## How to run the project:

```
docker-compose up --build
```
run the migrations at database/migrations

Tailwindcss styles should be compiled but if not: <br>
Navigate to front_end and ```run npm ci``` then ```npm run build```
## Notes
1. I used AlpineJS in this project since it is simple and lightweight, as needed per the requirements. It got the job done, but I definitely would have preferred to use React or Vue. Also, I used the CDN version for AlpineJS as I didn't want to complicate the project, but of course in production apps we should avoid CDNs for security reasons.
2. Due to time limitations, I didn't focus on API security, but if this was a production app, of course, some authentication, rate throttling, and other security techniques must be implemented.
