# Colvin Message Logger 💐 🪴
Colvin Message Logger is a composer package 📦 where you could find multiple logging processors to use along with [the Colvin Common Domain Package](https://github.com/TheColvinCo/common-domain-php) .

## Table of Contents

- [Colvin Message Logger 💐 🪴](#colvin-common-domain------)
    * [Installation ⚒️](#installation-%EF%B8%8F)
    * [Usage 👩‍💻](#usage-)
        + [Application](#application)
        + [Domain 🌼](#domain-)
        + [Infrastructure 🏗️](#infrastructure-%EF%B8%8F)
    * [Contributing 🤝](#contributing-)

## Installation ⚒️

Simply run `composer req colvin/message-logger-php`. Note you have to be at least in PHP 8 (we are modern people, yup).

## Usage 👩‍💻

We have divided this package in two different folders. 
- A `DependencyInjection` folder where we can find the Symfony `CompilerPassInterface` implementation.
- A `Processors` folder, split in 3 subdirectories: **Domain**, **Infrastructure** and **Serializer**.

### Domain 🌼

Once again, here we can find the big things. We have different Processors to each type of the messages part: Exceptions, MessageData, Context and OccurredOn.

### Infrastructure 🏗️

As in every Infrastructure HA folder, here we try to manage the relation with external dependencies. We are implementing here the Hostname Processor, as we understand it as an external dependency that may change in the future.

## Contributing 🤝
Pull requests are more than welcome!. For major changes, please open an issue first to discuss what you would like to change.

Please remember to update tests as appropriate.
