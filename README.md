# True9 Coding Test

## Introduction

I have decided to use Laravel to solve this test for the fact that it allows fairly fast scaffolding for new applications and the assumption that in a real-life scenario, a similar application would likely be much more extensive. On a side note - if I was to build an API that truly only provides a single endpoint as requested for the tech test, I would probably go with Python and FastAPI over popular PHP frameworks.

## Setup / Installation

Pre-requisites:

- Create a copy of ``.env.example`` and name it ``.env`` 
- Run ``composer install``
- Run ``php artisan key:generate`` in the project root

There's no database or other external dependencies, so it's actually that straightforward.

There's two options to run the application locally:

Navigate to the project directory after checking it out (via terminal/console) and then run the development server from there (requires php8.2 to be installed on the machine this command is executed on):

````bash
php artisan serve
````
Environment will run on http://127.0.0.1:8000

Or, alternatively, you can use Docker and spin up the necessary containers by running:

````bash
docker compose up -d
````
Environment will run on http://localhost/

## Tests

The assignment is shipped with unit, feature and integration tests created with PHPUnit.

You can run these by executing ``php artisan test`` (about 11 tests).

I have also started integrating Dusk for browser automation testing - but while this should technically run out of the box, I had to make some amends on my machine to get them to work fine. Since these tests involve browser drivers etc they can be a little more prone to errors and I cannot guarantee these work out of the box for everyone (you can still see the test code etc, and I'm happy to discuss this in more detail during a debrief)

You can run these by executing ``php artisan dusk``.

## Code Notes

I have created a Service in app/Services/ to handle the date calculations to allow for separation of concerns, splitting of business logic from controllers, and also to increase testability.

As a little bonus I have integrated an external API that provides bank holidays for the UK - to include calculations where payment dates fall into bank holidays. I haven't gone as far though, to introduce a dropdown/option to define with nation the dates are generated for (i.e. England, Scotland) - this would probably have gone a little too far :-)


