# InfluxDB admin CLI

This project is a CLI tool to manage an InfluxDB cluster

## Installation

For now, you have to clone the repository and to run `composer install`.
You can download composer [here](https://getcomposer.org/download/).

## Usage

Once in the project you can run `./influxdb-admin-cli` to have a list of
available commands.

## Credentials

You can create a file `~/.influxdb_admin_cli` to store your credentials. It
looks like this:

```json
{"host":"my_influxdb","user":"admin","password":"p4ssw0rD"}
```

Here is the credentials importance order:

* Specified in command call
* `~/.influxdb_admin_cli` file if exist
* default option provided by the command (prompt password as there is no default value)

## TODO

* Use a .phar to be available to install this tool easily
* Add more & more commands
* Add the possibility to ask new passwords instead of passing it as arguments
* @see composer to be able to selfupdate the command

## License

This tool is released under the MIT License. See the bundled LICENSE file for
details.
