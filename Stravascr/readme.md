The goal, at its simplest is, connecting to Strava's API and pulling latest activities onto my website. Here is an outline of the current process in Python:
I use the Requests library to connect to Strava as a popular Python library. Other options include Strava's Python library: Stravalib. I felt I would learn more by using Requests, but both are good options.
Strava uses OAuth2 for authentication. Once a refresh token is gained (for more info: https://developers.strava.com/docs/getting-started/), a short-lived access-token can be aquired.
Each time an access token is gained, there is the chance that the refresh token may update. Only the latest refresh token can be used. I chose to store all tokens into a PostgreSQL database. 
I use the psycopg2 library to connect to the database. A next step is to move this to a .gitignore file. 
