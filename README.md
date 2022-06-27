# urlhasher

# TransIP coding exercise

For this exercise you are entirely free to choose how to fill in the technical implementation details.
The exercise consists of:
- A PHP CLI tool that executes hashing on a remote file (http for example) and fetches the result,
with error handling and optionally a retry mechanism.

## Exercise
The CLI client should calculate a hash on files which should be given as a parameter and return this
data. The CLI client should accept one file location parameter, on which it calculates a hash.

As a user you should be able to call the PHP CLI client with the URLs as command line arguments.

For example:

`php bin/urlhasher http://speed.transip.nl/10mb.bin`

## CLI client
For the PHP command line application we would like to see you use composer and the CLI
components of the symfony framework.
It is important for us to see how you structure your project and if it is up to the newer PHP
standards. Content wise it is import for us:
- To see how you seperate hashing logic from the CLI logic;
- Use object oriented way of solving this exercise;
- How you handle errors and report them back to the user.

## Bonus
As a bonus you could introduce one of the following things:
- Unit tests on your code
- Explanation of the choices you made in a `README.md` file
- Allow users to specify more than one remote file for hashing

---------------------------------------------------------------------------------------------------------------------------------

## USAGE:
from the application directory use the command
`php bin/console app:hash <url>[mandatory] <url-2>...<url-n>`
for example
`php bin/console app:  http://speed.transip.nl/10mb.bin`
`php bin/console app:  http://speed.transip.nl/10mb.bin http://speed.transip.nl/random-10mb.bin`


# Testing
to run all tests:
`php bin/phpunit`

## Explanation of the choices

Other than symfony I used symfony/console.
the informations on how to create and develop a console interface in Symfony were obtained from https://symfony.com/doc/current/components/console/

# Structure of the application
the application is made mainly of 3 files:
- First File src/Command/HashCommand.php

this file is basically where the command is defined to the console and where the execution happens. This file does not have any code regarding the download and hashing of the file, altrough you will find there the management of retries when an error happens.

There are 2 main features that are worth noticing here, The first is the optional retry that is asked to the user if one (or more) downloads fail (by including Symfony\ConfirmationQuestion), the second feature is the (bonus) multiple remote file hashing.

This was made by setting the argument to IS_ARRAY and cycling the downloadfile method for each url present. if even one of the urls gives a problem the application asks the user to retry as requested by the exercise.


- Second File src/Service/FileDownloader

INPUT: String $url, FileClass $file (used as Data Transfer Object)

this is where the downloading of the file happens. For this I am using HttpClientInterface so I can let Symfony handle the download of the file before hashing it. I did chose a default hashing of "md5", however implementing a different hashing method added maybe via parameter would be simple.

- The third file is src/Entity/FileStorage.php

This file creates a class for a file object that is instanced in HashCommand.php and sent to FileDownloader where it is populated with data that is verified for the retry mechanism.

Using a file object allowed me to totally separate the HashCommand structure from the FileDownloader because I could change totally FileDownloader (maybe by using the php Curl method) and as long as I return the file objects with the data needed, there is no need to change anything inside HashCommand.
